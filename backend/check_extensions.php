<?php
/**
 * PHP扩展检查脚本
 * 用于验证所有必需的PHP扩展是否正确安装
 */

echo "=== PHP扩展检查报告 ===\n";
echo "PHP版本: " . PHP_VERSION . "\n";
echo "操作系统: " . PHP_OS . "\n";
echo "时间: " . date('Y-m-d H:i:s') . "\n\n";

// 必需的扩展列表
$required_extensions = [
    // 核心扩展
    'pdo_mysql' => 'MySQL数据库支持',
    'mbstring' => '多字节字符串处理',
    'gd' => '图像处理',
    'zip' => 'ZIP文件处理',
    'intl' => '国际化支持',
    'curl' => 'HTTP请求',
    'openssl' => '加密支持',
    'json' => 'JSON处理',
    
    // 缓存扩展
    'redis' => 'Redis缓存支持',
    'memcached' => 'Memcached缓存支持',
    'apcu' => 'APCu缓存支持',
    
    // 数据库扩展
    'mongodb' => 'MongoDB支持',
    
    // 图像处理扩展
    'imagick' => 'ImageMagick图像处理',
    
    // 其他扩展
    'yaml' => 'YAML解析',
    'amqp' => 'RabbitMQ消息队列',
    'ssh2' => 'SSH2支持',
    'xdebug' => '调试支持',
    'opcache' => 'OPcache优化',
];

// 可选的扩展列表
$optional_extensions = [
    'soap' => 'SOAP Web服务',
    'xsl' => 'XSLT转换',
    'tidy' => 'HTML清理',
    'bz2' => 'Bzip2压缩',
    'readline' => '命令行编辑',
    'snmp' => 'SNMP网络管理',
    'edit' => '命令行编辑',
    'sqlite3' => 'SQLite数据库',
    'pspell' => '拼写检查',
    'ldap' => 'LDAP目录服务',
    'sodium' => '现代加密',
    'gmp' => '大数运算',
    'imap' => 'IMAP邮件',
];

echo "=== 必需扩展检查 ===\n";
$required_missing = [];
foreach ($required_extensions as $ext => $description) {
    if (extension_loaded($ext)) {
        echo "✅ {$ext}: {$description}\n";
    } else {
        echo "❌ {$ext}: {$description} - 未安装\n";
        $required_missing[] = $ext;
    }
}

echo "\n=== 可选扩展检查 ===\n";
foreach ($optional_extensions as $ext => $description) {
    if (extension_loaded($ext)) {
        echo "✅ {$ext}: {$description}\n";
    } else {
        echo "⚠️  {$ext}: {$description} - 未安装\n";
    }
}

echo "\n=== 扩展详细信息 ===\n";
foreach ($required_extensions as $ext => $description) {
    if (extension_loaded($ext)) {
        echo "\n--- {$ext} ---\n";
        if (function_exists('phpversion')) {
            $version = phpversion($ext);
            if ($version) {
                echo "版本: {$version}\n";
            }
        }
        
        // 特殊扩展信息
        switch ($ext) {
            case 'gd':
                $info = gd_info();
                echo "支持的格式: " . implode(', ', array_keys(array_filter($info))) . "\n";
                break;
                
            case 'redis':
                if (class_exists('Redis')) {
                    echo "Redis类可用\n";
                }
                break;
                
            case 'mongodb':
                if (class_exists('MongoDB\Driver\Manager')) {
                    echo "MongoDB驱动可用\n";
                }
                break;
                
            case 'opcache':
                if (function_exists('opcache_get_status')) {
                    $status = opcache_get_status();
                    if ($status) {
                        echo "OPcache已启用\n";
                        echo "内存使用: " . round($status['memory_usage']['used_memory'] / 1024 / 1024, 2) . "MB\n";
                    }
                }
                break;
        }
    }
}

echo "\n=== 系统信息 ===\n";
echo "内存限制: " . ini_get('memory_limit') . "\n";
echo "最大执行时间: " . ini_get('max_execution_time') . "秒\n";
echo "上传最大文件大小: " . ini_get('upload_max_filesize') . "\n";
echo "POST最大大小: " . ini_get('post_max_size') . "\n";
echo "时区: " . ini_get('date.timezone') . "\n";

echo "\n=== 检查结果 ===\n";
if (empty($required_missing)) {
    echo "🎉 所有必需扩展都已安装！\n";
    echo "PHP环境配置完成，可以正常使用。\n";
} else {
    echo "⚠️  以下必需扩展未安装:\n";
    foreach ($required_missing as $ext) {
        echo "   - {$ext}\n";
    }
    echo "\n请检查Docker构建过程或联系系统管理员。\n";
}

echo "\n=== 扩展总数统计 ===\n";
$loaded_extensions = get_loaded_extensions();
echo "已加载扩展总数: " . count($loaded_extensions) . "\n";
echo "必需扩展总数: " . count($required_extensions) . "\n";
echo "已安装必需扩展: " . (count($required_extensions) - count($required_missing)) . "\n";
echo "安装成功率: " . round((count($required_extensions) - count($required_missing)) / count($required_extensions) * 100, 2) . "%\n";
