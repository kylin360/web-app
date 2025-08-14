<?php

namespace app\controllers\base;

use app\models\BearerAuth;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class AuthController extends RestController
{
  public function behaviors()
  {
    $behaviors = parent::behaviors();

    // 认证（统一放在 AuthController 层）
    $behaviors['authenticator'] = ArrayHelper::merge(
      $behaviors['authenticator'] ?? [],
      [
        'class' => BearerAuth::class,
        'except' => $this->authExceptActions(),
        'optional' => $this->authOptionalActions(),
      ]
    );

    // 访问控制（默认规则，子类可覆写 accessRules 方法）
    $behaviors['access'] = [
      'class' => AccessControl::class,
      'rules' => $this->accessRules(),
    ];

    return $behaviors;
  }

  /**
   * 免认证动作列表，子类可覆写追加。
   */
  protected function authExceptActions(): array
  {
    return ['login', 'register', 'options'];
  }

  /**
   * 可选认证动作列表，子类可覆写追加。
   */
  protected function authOptionalActions(): array
  {
    return ['index'];
  }

  /**
   * 访问控制规则，子类可覆写定制。
   */
  protected function accessRules(): array
  {
    return [
      [
        'allow' => true,
        'actions' => ['login', 'register', 'options'],
        'roles' => ['?'],
      ],
      [
        'allow' => true,
        'actions' => ['index'],
        'roles' => ['?', '@'],
      ],
      [
        'allow' => true,
        'actions' => ['view', 'create', 'update', 'delete', 'profile', 'logout'],
        'roles' => ['@'],
      ],
    ];
  }
}