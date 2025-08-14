<?php
/**
 * PHP扩展功能测试脚本
 * 测试各个扩展的基本功能是否正常
 */

echo "=== PHP扩展功能测试 ===\n";
echo "时间: " . date('Y-m-d H:i:s') . "\n\n";

$tests = [];

// 测试GD扩展
if (extension_loaded('gd')) {
    try {
        $image = imagecreate(100, 100);
        if ($image) {
            $tests['gd'] = ['status' => '✅', 'message' => 'GD扩展功能正常'];
            imagedestroy($image);
        } else {
            $tests['gd'] = ['status' => '❌', 'message' => 'GD扩展无法创建图像'];
        }
    } catch (Exception $e) {
        $tests['gd'] = ['status' => '❌', 'message' => 'GD扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['gd'] = ['status' => '❌', 'message' => 'GD扩展未安装'];
}

// 测试Redis扩展
if (extension_loaded('redis')) {
    try {
        $redis = new Redis();
        $tests['redis'] = ['status' => '✅', 'message' => 'Redis扩展功能正常'];
    } catch (Exception $e) {
        $tests['redis'] = ['status' => '❌', 'message' => 'Redis扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['redis'] = ['status' => '❌', 'message' => 'Redis扩展未安装'];
}

// 测试MongoDB扩展
if (extension_loaded('mongodb')) {
    try {
        if (class_exists('MongoDB\Driver\Manager')) {
            $tests['mongodb'] = ['status' => '✅', 'message' => 'MongoDB扩展功能正常'];
        } else {
            $tests['mongodb'] = ['status' => '❌', 'message' => 'MongoDB类不可用'];
        }
    } catch (Exception $e) {
        $tests['mongodb'] = ['status' => '❌', 'message' => 'MongoDB扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['mongodb'] = ['status' => '❌', 'message' => 'MongoDB扩展未安装'];
}

// 测试Memcached扩展
if (extension_loaded('memcached')) {
    try {
        if (class_exists('Memcached')) {
            $tests['memcached'] = ['status' => '✅', 'message' => 'Memcached扩展功能正常'];
        } else {
            $tests['memcached'] = ['status' => '❌', 'message' => 'Memcached类不可用'];
        }
    } catch (Exception $e) {
        $tests['memcached'] = ['status' => '❌', 'message' => 'Memcached扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['memcached'] = ['status' => '❌', 'message' => 'Memcached扩展未安装'];
}

// 测试APCu扩展
if (extension_loaded('apcu')) {
    try {
        if (function_exists('apcu_store') && function_exists('apcu_fetch')) {
            $tests['apcu'] = ['status' => '✅', 'message' => 'APCu扩展功能正常'];
        } else {
            $tests['apcu'] = ['status' => '❌', 'message' => 'APCu函数不可用'];
        }
    } catch (Exception $e) {
        $tests['apcu'] = ['status' => '❌', 'message' => 'APCu扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['apcu'] = ['status' => '❌', 'message' => 'APCu扩展未安装'];
}

// 测试Imagick扩展
if (extension_loaded('imagick')) {
    try {
        if (class_exists('Imagick')) {
            $tests['imagick'] = ['status' => '✅', 'message' => 'Imagick扩展功能正常'];
        } else {
            $tests['imagick'] = ['status' => '❌', 'message' => 'Imagick类不可用'];
        }
    } catch (Exception $e) {
        $tests['imagick'] = ['status' => '❌', 'message' => 'Imagick扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['imagick'] = ['status' => '❌', 'message' => 'Imagick扩展未安装'];
}

// 测试YAML扩展
if (extension_loaded('yaml')) {
    try {
        if (function_exists('yaml_parse')) {
            $tests['yaml'] = ['status' => '✅', 'message' => 'YAML扩展功能正常'];
        } else {
            $tests['yaml'] = ['status' => '❌', 'message' => 'YAML函数不可用'];
        }
    } catch (Exception $e) {
        $tests['yaml'] = ['status' => '❌', 'message' => 'YAML扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['yaml'] = ['status' => '❌', 'message' => 'YAML扩展未安装'];
}

// 测试AMQP扩展
if (extension_loaded('amqp')) {
    try {
        if (class_exists('AMQPConnection')) {
            $tests['amqp'] = ['status' => '✅', 'message' => 'AMQP扩展功能正常'];
        } else {
            $tests['amqp'] = ['status' => '❌', 'message' => 'AMQP类不可用'];
        }
    } catch (Exception $e) {
        $tests['amqp'] = ['status' => '❌', 'message' => 'AMQP扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['amqp'] = ['status' => '❌', 'message' => 'AMQP扩展未安装'];
}

// 测试SSH2扩展
if (extension_loaded('ssh2')) {
    try {
        if (function_exists('ssh2_connect')) {
            $tests['ssh2'] = ['status' => '✅', 'message' => 'SSH2扩展功能正常'];
        } else {
            $tests['ssh2'] = ['status' => '❌', 'message' => 'SSH2函数不可用'];
        }
    } catch (Exception $e) {
        $tests['ssh2'] = ['status' => '❌', 'message' => 'SSH2扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['ssh2'] = ['status' => '❌', 'message' => 'SSH2扩展未安装'];
}

// 测试OPcache扩展
if (extension_loaded('opcache')) {
    try {
        if (function_exists('opcache_get_status')) {
            $tests['opcache'] = ['status' => '✅', 'message' => 'OPcache扩展功能正常'];
        } else {
            $tests['opcache'] = ['status' => '❌', 'message' => 'OPcache函数不可用'];
        }
    } catch (Exception $e) {
        $tests['opcache'] = ['status' => '❌', 'message' => 'OPcache扩展测试失败: ' . $e->getMessage()];
    }
} else {
    $tests['opcache'] = ['status' => '❌', 'message' => 'OPcache扩展未安装'];
}

// 输出测试结果
echo "=== 功能测试结果 ===\n";
foreach ($tests as $ext => $result) {
    echo "{$result['status']} {$ext}: {$result['message']}\n";
}

// 统计结果
$total = count($tests);
$success = count(array_filter($tests, function($test) {
    return strpos($test['status'], '✅') !== false;
}));
$failed = $total - $success;

echo "\n=== 测试统计 ===\n";
echo "总测试数: {$total}\n";
echo "成功: {$success}\n";
echo "失败: {$failed}\n";
echo "成功率: " . round(($success / $total) * 100, 2) . "%\n";

if ($failed > 0) {
    echo "\n⚠️  有 {$failed} 个扩展测试失败，请检查安装配置。\n";
} else {
    echo "\n🎉 所有扩展功能测试通过！\n";
}

echo "\n=== 扩展版本信息 ===\n";
foreach ($tests as $ext => $result) {
    if (strpos($result['status'], '✅') !== false) {
        $version = phpversion($ext);
        if ($version) {
            echo "{$ext}: {$version}\n";
        }
    }
}
