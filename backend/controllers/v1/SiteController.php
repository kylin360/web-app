<?php

namespace app\controllers\v1;


use app\forms\LoginForm;
use app\controllers\base\RestController;
/**
 * 站点控制器
 */
class SiteController extends RestController
{
    /**
     * API 信息
     */
    public function actionIndex()
    {
        return $this->successResponse([
            'name' => '跨境电商计算器 API',
            'version' => '1.0.0',
            'description' => '跨境电商计算器后端 RESTful API 服务',
            'endpoints' => [
                'auth' => [
                    'POST /v1/users/login' => '用户登录',
                    'POST /v1/users/logout' => '用户登出',
                    'POST /v1/users/refresh' => '刷新 Token',
                ]
            ],
            'authentication' => 'Bearer Token (JWT)',
            'rate_limit' => '100 requests per minute',
        ], 'API 信息获取成功');
    }

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

    public function actionOptions()
    {
        return $this->successResponse(null, 'Options request successful');
    }
}
