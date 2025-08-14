<?php

namespace app\controllers\base;

use Yii;


use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\rest\Controller;

class RestController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'contentNegotiator' => [
        'class' => 'yii\filters\ContentNegotiator',
        'formats' => [
          'application/json' => Response::FORMAT_JSON,
        ],
      ],
      'verbFilter' => [
        'class' => VerbFilter::class,
        'actions' => $this->verbs(),
      ],
    ];
  }

  /**
   * 默认的 HTTP 动词限制。子类可按需覆写。
   */
  protected function verbs()
  {
    return [
      'index' => ['GET'],
      'view' => ['GET'],
      'create' => ['POST'],
      // 兼容实际使用中常见的 POST 更新
      'update' => ['PUT', 'PATCH', 'POST'],
      'delete' => ['DELETE'],
      'options' => ['OPTIONS'],
    ];
  }

  /**
   * 成功响应
   */
  protected function successResponse($data = null, $message = 'Success', $code = 200)
  {
    Yii::$app->response->statusCode = $code;
    return [
      'success' => true,
      'data' => $data,
      'message' => $message,
      'timestamp' => time(),
    ];
  }

  /**
   * 错误响应
   */
  protected function errorResponse($message = '', $code = 400, $errors = null)
  {
    Yii::$app->response->statusCode = $code;
    $errors = $errors ? array_values($errors) : [];
    $message = $message ?: $errors[0][0] ?? 'Error';
    return [
      'success' => false,
      'message' => $message,
      'errors' => $errors,
      'timestamp' => time(),
    ];
  }

  /**
   * 检查权限
   */
  protected function checkPermission($permission)
  {
    if (!Yii::$app->user->can($permission)) {
      throw new ForbiddenHttpException('Access denied');
    }
  }

  /**
   * 获取当前用户ID
   */
  protected function getCurrentUserId()
  {
    return Yii::$app->user->id;
  }

  /**
   * 获取当前租户代码
   */
  protected function getCurrentTenantCode()
  {
    // 从 JWT token 或请求头中获取租户信息
    $tenantCode = Yii::$app->request->headers->get('X-Tenant-Code');
    return $tenantCode ?: 'system';
  }

  /**
   * OPTIONS 请求处理（用于 CORS）
   */
  public function actionOptions()
  {
    Yii::$app->response->statusCode = 200;
    return $this->successResponse();
  }
}
