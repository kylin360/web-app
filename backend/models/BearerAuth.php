<?php

namespace app\models;

use Yii;
use yii\web\UnauthorizedHttpException;
use yii\filters\auth\HttpBearerAuth as BaseBearerAuth;

class BearerAuth extends BaseBearerAuth
{
  public function authenticate($user, $request, $response)
  {
    $authHeader = $request->getHeaders()->get('Authorization');
    if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
      $token = $matches[1];
      $identity = $user->loginByAccessToken($token, gettype($this));
      if ($identity === null) {
        $this->handleFailure($response);
      }
      return $identity;
    }
    throw new UnauthorizedHttpException('Authorization header not found');
  }

  public function handleFailure($response)
  {
    Yii::$app->response->setStatusCode(401);
    Yii::$app->response->data = [
      'success' => false,
      'message' => 'Invalid or expired token',
      'code' => 'UNAUTHORIZED'
    ];
    Yii::$app->response->send();
  }
}