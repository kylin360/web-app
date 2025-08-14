<?php

// 定义应用类型
define('YII_APP_TYPE', 'api');
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// 加载 Yii 框架
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// 加载配置
$config = require __DIR__ . '/../config/api.php';

// 创建应用实例并运行
(new yii\web\Application($config))->run();
