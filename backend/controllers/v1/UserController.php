<?php

namespace app\controllers\v1;


use Yii;
use app\models\User;
use app\models\Tenant;
use app\forms\LoginForm;
use yii\helpers\ArrayHelper;
use app\controllers\base\AuthController;

class UserController extends AuthController
{

  public function behaviors()
  {
    return ArrayHelper::merge(parent::behaviors(), [
      // 如果需要特殊的认证配置，可以在这里添加
      // 目前使用父类的默认配置即可
    ]);
  }

  /**
   * 用户登录
   */
  public function actionLogin()
  {
    $model = new LoginForm();
    $params = $this->request->post();
    // \Yii::info('actionLogin: ' . json_encode($params));
    if ($model->load($params) && $model->validate()) {
      $result = $model->login();
      if ($result) {
        return $this->successResponse($result, '登录成功');
      }
    }

    return $this->errorResponse(null, 400, $model->getErrors());
  }

  /**
   * 用户注册
   */
  public function actionRegister()
  {
    $request = Yii::$app->request;
    $username = $request->post('username');
    $password = $request->post('password');
    $email = $request->post('email');
    $tenant_code = $request->post('tenant_code');

    // 验证必填字段
    if (!$username || !$password || !$email || !$tenant_code) {
      return $this->errorResponse('请填写所有必填字段', 400);
    }

    // 检查租户是否存在且有效
    $tenant = Tenant::findOne(['tenant_code' => $tenant_code, 'status' => 1, 'is_enabled' => 1]);
    if (!$tenant) {
      return $this->errorResponse('租户不存在或已禁用', 400);
    }

    // 检查用户名是否已存在
    if (User::findOne(['username' => $username, 'tenant_id' => $tenant->id])) {
      return $this->errorResponse('用户名已存在', 400);
    }

    // 检查邮箱是否已存在
    if (User::findOne(['email' => $email, 'tenant_id' => $tenant->id])) {
      return $this->errorResponse('邮箱已存在', 400);
    }

    // 创建新用户
    $user = new User();
    $user->username = $username;
    $user->email = $email;
    $user->setPassword($password);
    $user->generateAuthKey();
    $user->generateAccessToken();
    $user->tenant_id = $tenant->id;
    $user->status = User::STATUS_ACTIVE;

    if ($user->save()) {
      return $this->successResponse([
        'user' => [
          'id' => $user->id,
          'username' => $user->username,
          'email' => $user->email,
          'tenant_id' => $user->tenant_id,
        ]
      ], '注册成功');
    }

    return $this->errorResponse('注册失败', 400, $user->getErrors());
  }

  /**
   * 获取当前用户信息
   */
  public function actionProfile()
  {
    /** @var User|null $user */
    $user = Yii::$app->user->identity;
    if (!$user) {
      return $this->errorResponse('用户未登录', 401);
    }

    return $this->successResponse([
      'id' => $user->id,
      'username' => $user->username,
      'email' => $user->email,
      'tenant_id' => $user->tenant_id,
      'created_at' => $user->created_at,
    ]);
  }

  /**
   * 更新用户信息
   */
  public function actionUpdate()
  {
    /** @var User|null $user */
    $user = Yii::$app->user->identity;
    if (!$user) {
      return $this->errorResponse('用户未登录', 401);
    }

    $request = Yii::$app->request;
    $email = $request->post('email');
    $password = $request->post('password');

    if ($email) {
      $user->email = $email;
    }

    if ($password) {
      $user->setPassword($password);
    }

    if ($user->save()) {
      return $this->successResponse(null, '更新成功');
    }

    return $this->errorResponse('更新失败', 400, $user->getErrors());
  }

  /**
   * 用户登出
   */
  public function actionLogout()
  {
    /** @var User|null $user */
    $user = Yii::$app->user->identity;
    if ($user) {
      // 清除访问令牌
      $user->access_token = null;
      $user->save();
    }

    return $this->successResponse(null, '登出成功');
  }
}
