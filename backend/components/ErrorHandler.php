<?php

namespace app\components;

use Yii;
use yii\base\UserException;
use yii\web\ErrorHandler as BaseErrorHandler;
use yii\web\HttpException;
use yii\web\Response;

class ErrorHandler extends BaseErrorHandler
{
  protected function convertExceptionToArray($exception)
  {
    $statusCode = 500;
    $message = 'Internal Server Error';
    $errors = null;

    if ($exception instanceof HttpException) {
      $statusCode = $exception->statusCode;
      $message = $exception->getMessage() ?: $message;
    } elseif ($exception instanceof UserException) {
      $message = $exception->getMessage();
    }

    if (method_exists($exception, 'getErrors')) {
      $errors = $exception->getErrors();
    }

    $data = [
      'success' => false,
      'code' => $statusCode,
      'message' => $message,
      'errors' => $errors,
      'path' => Yii::$app->request->getUrl(),
      'timestamp' => time(),
    ];

    if (YII_DEBUG) {
      $data['exception'] = [
        'name' => get_class($exception),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'stack' => explode("\n", $exception->getTraceAsString()),
      ];
    }

    return $data;
  }

  public function renderException($exception)
  {
    $response = Yii::$app->getResponse();
    $response->format = Response::FORMAT_JSON;

    $data = $this->convertExceptionToArray($exception);
    $response->statusCode = $data['code'] ?? 500;
    $response->data = $data;
    $response->send();
  }
}


