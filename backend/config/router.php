<?php

return [
    // 用户认证相关规则
    'v1/user/login' => 'v1/user/login',
    'v1/user/register' => 'v1/user/register',
    'v1/user/logout' => 'v1/user/logout',
    'v1/user/profile' => 'v1/user/profile',
    'v1/user/update' => 'v1/user/update',

    // 用户管理规则
    'v1/users' => 'v1/users/index',
    'v1/users/<id:\d+>' => 'v1/users/view',
    'v1/users/create' => 'v1/users/create',
    'v1/users/<id:\d+>/update' => 'v1/users/update',
    'v1/users/<id:\d+>/delete' => 'v1/users/delete',

    // 角色管理规则
    'v1/roles' => 'v1/roles/index',
    'v1/roles/<id:\d+>' => 'v1/roles/view',
    'v1/roles/create' => 'v1/roles/create',
    'v1/roles/<id:\d+>/update' => 'v1/roles/update',
    'v1/roles/<id:\d+>/delete' => 'v1/roles/delete',

    // 权限管理规则
    'v1/permissions' => 'v1/permissions/index',
    'v1/permissions/<id:\d+>' => 'v1/permissions/view',

    // 菜单管理规则
    'v1/menus' => 'v1/menus/index',
    'v1/menus/<id:\d+>' => 'v1/menus/view',

    // 租户管理规则
    'v1/tenants' => 'v1/tenants/index',
    'v1/tenants/<id:\d+>' => 'v1/tenants/view',
];
