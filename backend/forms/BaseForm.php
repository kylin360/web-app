<?php

namespace app\forms;


use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\HttpException;

class BaseForm extends Model
{
  /**
   * 重写 load 方法，确保它能正确地将 POST 数据赋值给模型属性
   * 
   * @param array $data 要加载的数据
   * @param string|null $formName 表单名称
   * @return bool 是否成功加载数据
   */
  public function load($data, $formName = null)
  {
    $scope = $formName === null ? $this->formName() : $formName;

    if (empty($data)) {
      return true;
    }

    // 如果数据中包含表单名称，则使用它
    if ($scope !== '' && isset($data[$scope])) {
      $data = $data[$scope];
    }

    // 遍历数据，将值赋值给模型属性
    foreach ($data as $name => $value) {
      if (in_array($name, $this->attributes())) {
        $this->$name = $value;
      }
    }

    return true;
  }

  /**
   * 从模型中导入错误信息到表单
   * 
   * @param ActiveRecord $model 数据模型
   * @return $this
   */
  public function importErrors($model)
  {
    if ($model->hasErrors()) {
      $this->addErrors($model->getErrors());
    }
    return $this;
  }

  /**
   * 保存模型数据
   * 
   * @param ActiveRecord $model 数据模型
   * @param array $attributes 要保存的属性，默认为空数组表示保存所有属性
   * @return bool 是否保存成功
   */
  public function saveModel($model, $attributes = [])
  {
    // 验证表单
    if (!$this->validate()) {
      return false;
    }

    // 给模型赋值
    if (empty($attributes)) {
      // 获取模型所有可赋值的属性
      $modelAttributes = $model->attributes();
      foreach ($this->attributes() as $attribute) {
        if (in_array($attribute, $modelAttributes) && isset($this->$attribute)) {
          $model->$attribute = $this->$attribute;
        }
      }
    } else {
      // 只赋值指定的属性
      foreach ($attributes as $attribute) {
        if (isset($this->$attribute)) {
          $model->$attribute = $this->$attribute;
        }
      }
    }

    // // 保存模型并处理错误
    // if (!$model->save()) {
    //     $this->importErrors($model);
    //     return false;
    // }

    return true;
  }

  /**
   * 统一处理表单错误，记录日志
   * 
   * @return array 所有错误信息
   */
  public function getFormErrors()
  {
    $errors = $this->getErrors();

    // 在调试模式下记录错误
    if (YII_DEBUG && !empty($errors)) {
      Yii::error(
        '表单验证错误: ' . json_encode($errors, JSON_UNESCAPED_UNICODE),
        get_called_class()
      );
    }

    return $errors;
  }

  /**
   * 加载数据并验证，如果有错误则直接抛出异常
   * 
   * @param array $data 要加载的数据
   * @param string|null $formName 表单名称
   * @param int $statusCode HTTP错误状态码
   * @return bool 验证是否通过
   * @throws HttpException 当验证失败时抛出异常
   */
  public function loadData($data, $formName = null, $statusCode = 422)
  {
    if (!$this->load($data, $formName) || !$this->validate()) {
      $this->throwValidationException($statusCode);
    }

    return true;
  }

  /**
   * 抛出验证错误异常
   * 
   * @param int $statusCode HTTP错误状态码
   * @throws HttpException 包含验证错误信息的异常
   */
  public function throwValidationException($statusCode = 422)
  {
    $errors = $this->getFormErrors();

    if (!empty($errors)) {
      $errorMessage = '数据验证失败: ' . json_encode($errors, JSON_UNESCAPED_UNICODE);
      throw new HttpException($statusCode, $errorMessage);
    }
  }
}