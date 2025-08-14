<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    
    // JWT 配置
    'jwtSecret' => 'cross-border-calc-jwt-secret-key-2025',
    'jwtExpire' => 86400, // 24小时
    
    // API 配置
    'apiVersion' => '1.0.0',
    'apiRateLimit' => 100, // 每分钟请求限制
    
    // 租户配置
    'defaultTenantCode' => 'system',
    'multiTenantEnabled' => true,
    
    // 文件上传配置
    'uploadPath' => '@webroot/uploads',
    'uploadUrl' => '@web/uploads',
    'maxFileSize' => 10 * 1024 * 1024, // 10MB
    
    // 缓存配置
    'cacheDuration' => 3600, // 1小时
    
    // 分页配置
    'pageSize' => 20,
    'maxPageSize' => 100,
];
