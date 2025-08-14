<?php

use yii\db\Migration;
use yii\helpers\Security;

/**
 * 初始化基础数据
 * 
 * 包括系统基础权限、角色、菜单和超级管理员账户
 */
class m240814_120800_init_basic_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. 初始化基础权限
        $this->initPermissions();
        
        // 2. 初始化基础角色
        $this->initRoles();
        
        // 3. 初始化基础菜单
        $this->initMenus();
        
        // 4. 初始化超级管理员
        $this->initSuperAdmin();
        
        // 5. 初始化系统管理员
        $this->initSystemAdmin();
        
        // 6. 分配权限给角色
        $this->assignPermissionsToRoles();
        
        // 7. 分配菜单给角色
        $this->assignMenusToRoles();
    }

    /**
     * 初始化系统权限
     */
    private function initPermissions()
    {
        $permissions = [
            // 系统管理模块
            ['id' => 1, 'parent_id' => 0, 'permission_name' => '系统管理', 'permission_code' => 'system', 'permission_type' => 1, 'sort_order' => 1],
            ['id' => 101, 'parent_id' => 1, 'permission_name' => '用户管理', 'permission_code' => 'system:user', 'permission_type' => 2, 'resource_path' => '/system/user', 'sort_order' => 1],
            ['id' => 10101, 'parent_id' => 101, 'permission_name' => '查看用户', 'permission_code' => 'system:user:view', 'permission_type' => 3, 'resource_path' => '/api/users', 'method' => 'GET'],
            ['id' => 10102, 'parent_id' => 101, 'permission_name' => '新增用户', 'permission_code' => 'system:user:create', 'permission_type' => 3, 'resource_path' => '/api/users', 'method' => 'POST'],
            ['id' => 10103, 'parent_id' => 101, 'permission_name' => '编辑用户', 'permission_code' => 'system:user:update', 'permission_type' => 3, 'resource_path' => '/api/users/*', 'method' => 'PUT'],
            ['id' => 10104, 'parent_id' => 101, 'permission_name' => '删除用户', 'permission_code' => 'system:user:delete', 'permission_type' => 3, 'resource_path' => '/api/users/*', 'method' => 'DELETE'],
            
            ['id' => 102, 'parent_id' => 1, 'permission_name' => '角色管理', 'permission_code' => 'system:role', 'permission_type' => 2, 'resource_path' => '/system/role', 'sort_order' => 2],
            ['id' => 10201, 'parent_id' => 102, 'permission_name' => '查看角色', 'permission_code' => 'system:role:view', 'permission_type' => 3, 'resource_path' => '/api/roles', 'method' => 'GET'],
            ['id' => 10202, 'parent_id' => 102, 'permission_name' => '新增角色', 'permission_code' => 'system:role:create', 'permission_type' => 3, 'resource_path' => '/api/roles', 'method' => 'POST'],
            ['id' => 10203, 'parent_id' => 102, 'permission_name' => '编辑角色', 'permission_code' => 'system:role:update', 'permission_type' => 3, 'resource_path' => '/api/roles/*', 'method' => 'PUT'],
            ['id' => 10204, 'parent_id' => 102, 'permission_name' => '删除角色', 'permission_code' => 'system:role:delete', 'permission_type' => 3, 'resource_path' => '/api/roles/*', 'method' => 'DELETE'],
            
            ['id' => 103, 'parent_id' => 1, 'permission_name' => '权限管理', 'permission_code' => 'system:permission', 'permission_type' => 2, 'resource_path' => '/system/permission', 'sort_order' => 3],
            ['id' => 10301, 'parent_id' => 103, 'permission_name' => '查看权限', 'permission_code' => 'system:permission:view', 'permission_type' => 3, 'resource_path' => '/api/permissions', 'method' => 'GET'],
            ['id' => 10302, 'parent_id' => 103, 'permission_name' => '新增权限', 'permission_code' => 'system:permission:create', 'permission_type' => 3, 'resource_path' => '/api/permissions', 'method' => 'POST'],
            ['id' => 10303, 'parent_id' => 103, 'permission_name' => '编辑权限', 'permission_code' => 'system:permission:update', 'permission_type' => 3, 'resource_path' => '/api/permissions/*', 'method' => 'PUT'],
            ['id' => 10304, 'parent_id' => 103, 'permission_name' => '删除权限', 'permission_code' => 'system:permission:delete', 'permission_type' => 3, 'resource_path' => '/api/permissions/*', 'method' => 'DELETE'],
            
            ['id' => 104, 'parent_id' => 1, 'permission_name' => '菜单管理', 'permission_code' => 'system:menu', 'permission_type' => 2, 'resource_path' => '/system/menu', 'sort_order' => 4],
            ['id' => 10401, 'parent_id' => 104, 'permission_name' => '查看菜单', 'permission_code' => 'system:menu:view', 'permission_type' => 3, 'resource_path' => '/api/menus', 'method' => 'GET'],
            ['id' => 10402, 'parent_id' => 104, 'permission_name' => '新增菜单', 'permission_code' => 'system:menu:create', 'permission_type' => 3, 'resource_path' => '/api/menus', 'method' => 'POST'],
            ['id' => 10403, 'parent_id' => 104, 'permission_name' => '编辑菜单', 'permission_code' => 'system:menu:update', 'permission_type' => 3, 'resource_path' => '/api/menus/*', 'method' => 'PUT'],
            ['id' => 10404, 'parent_id' => 104, 'permission_name' => '删除菜单', 'permission_code' => 'system:menu:delete', 'permission_type' => 3, 'resource_path' => '/api/menus/*', 'method' => 'DELETE'],

            // 租户管理模块
            ['id' => 105, 'parent_id' => 1, 'permission_name' => '租户管理', 'permission_code' => 'system:tenant', 'permission_type' => 2, 'resource_path' => '/system/tenant', 'sort_order' => 5],
            ['id' => 10501, 'parent_id' => 105, 'permission_name' => '查看租户', 'permission_code' => 'system:tenant:view', 'permission_type' => 3, 'resource_path' => '/api/tenants', 'method' => 'GET'],
            ['id' => 10502, 'parent_id' => 105, 'permission_name' => '新增租户', 'permission_code' => 'system:tenant:create', 'permission_type' => 3, 'resource_path' => '/api/tenants', 'method' => 'POST'],
            ['id' => 10503, 'parent_id' => 105, 'permission_name' => '编辑租户', 'permission_code' => 'system:tenant:update', 'permission_type' => 3, 'resource_path' => '/api/tenants/*', 'method' => 'PUT'],
            ['id' => 10504, 'parent_id' => 105, 'permission_name' => '删除租户', 'permission_code' => 'system:tenant:delete', 'permission_type' => 3, 'resource_path' => '/api/tenants/*', 'method' => 'DELETE'],

            // 业务功能模块
            ['id' => 2, 'parent_id' => 0, 'permission_name' => '业务管理', 'permission_code' => 'business', 'permission_type' => 1, 'sort_order' => 2],
            ['id' => 201, 'parent_id' => 2, 'permission_name' => '首页', 'permission_code' => 'business:dashboard', 'permission_type' => 2, 'resource_path' => '/dashboard', 'sort_order' => 1],
        ];

        foreach ($permissions as $permission) {
            $this->insert('{{%permissions}}', array_merge($permission, [
                'status' => 1,
                'is_system' => 1,
            ]));
        }
    }

    /**
     * 初始化系统角色
     */
    private function initRoles()
    {
        $roles = [
            ['id' => 1, 'role_name' => '超级管理员', 'role_code' => 'super_admin', 'description' => '系统超级管理员，拥有所有权限', 'is_system' => 1, 'sort_order' => 1],
            ['id' => 2, 'role_name' => '系统管理员', 'role_code' => 'system_admin', 'description' => '系统管理员，负责系统维护', 'is_system' => 1, 'sort_order' => 2],
            ['id' => 3, 'role_name' => '租户管理员', 'role_code' => 'tenant_admin', 'description' => '租户管理员，管理租户内用户和权限', 'is_system' => 0, 'sort_order' => 3],
            ['id' => 4, 'role_name' => '普通用户', 'role_code' => 'user', 'description' => '普通用户，基础业务权限', 'is_system' => 0, 'sort_order' => 4],
        ];

        foreach ($roles as $role) {
            $this->insert('{{%roles}}', array_merge($role, [
                'status' => 1,
                'tenant_code' => 'system',
            ]));
        }
    }

    /**
     * 初始化系统菜单
     */
    private function initMenus()
    {
        $menus = [
            // 主菜单
            ['id' => 1, 'parent_id' => 0, 'menu_name' => '首页', 'menu_code' => 'dashboard', 'menu_path' => '/dashboard', 'component' => 'views/welcome/index', 'icon' => 'ep:home-filled', 'sort_order' => 1, 'permission_code' => 'business:dashboard'],
            ['id' => 2, 'parent_id' => 0, 'menu_name' => '系统管理', 'menu_code' => 'system', 'menu_path' => '/system', 'icon' => 'ri:settings-3-line', 'sort_order' => 2, 'permission_code' => 'system'],

            // 系统管理子菜单
            ['id' => 201, 'parent_id' => 2, 'menu_name' => '用户管理', 'menu_code' => 'system_user', 'menu_path' => '/system/user', 'component' => 'views/system/user/index', 'icon' => 'ri:user-line', 'sort_order' => 1, 'permission_code' => 'system:user'],
            ['id' => 202, 'parent_id' => 2, 'menu_name' => '角色管理', 'menu_code' => 'system_role', 'menu_path' => '/system/role', 'component' => 'views/system/role/index', 'icon' => 'ri:admin-line', 'sort_order' => 2, 'permission_code' => 'system:role'],
            ['id' => 203, 'parent_id' => 2, 'menu_name' => '权限管理', 'menu_code' => 'system_permission', 'menu_path' => '/system/permission', 'component' => 'views/system/permission/index', 'icon' => 'ri:lock-line', 'sort_order' => 3, 'permission_code' => 'system:permission'],
            ['id' => 204, 'parent_id' => 2, 'menu_name' => '菜单管理', 'menu_code' => 'system_menu', 'menu_path' => '/system/menu', 'component' => 'views/system/menu/index', 'icon' => 'ri:menu-line', 'sort_order' => 4, 'permission_code' => 'system:menu'],
            ['id' => 205, 'parent_id' => 2, 'menu_name' => '租户管理', 'menu_code' => 'system_tenant', 'menu_path' => '/system/tenant', 'component' => 'views/system/tenant/index', 'icon' => 'ri:building-line', 'sort_order' => 5, 'permission_code' => 'system:tenant'],
        ];

        foreach ($menus as $menu) {
            $meta = [
                'title' => $menu['menu_name'],
                'icon' => $menu['icon'] ?? '',
                'showLink' => true,
                'rank' => $menu['sort_order'],
            ];
            
            $this->insert('{{%menus}}', array_merge($menu, [
                'meta_json' => json_encode($meta, JSON_UNESCAPED_UNICODE),
                'status' => 1,
                'tenant_code' => 'system',
            ]));
        }
    }

    /**
     * 初始化超级管理员账户
     */
    private function initSuperAdmin()
    {
        // 创建超级管理员用户
        $this->insert('{{%users}}', [
            'id' => 1,
            'username' => 'root',
            'full_name' => '超级管理员',
            'email' => 'root@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('Yxt123456'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString(40),
            'status' => 1,
            'tenant_code' => 'system',
        ]);

        // 分配超级管理员角色
        $this->insert('{{%user_roles}}', [
            'user_id' => 1,
            'role_id' => 1, // 超级管理员角色
            'tenant_code' => 'system',
            'assigned_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 初始化系统管理员账户
     */
    private function initSystemAdmin()
    {
        // 创建系统管理员用户
        $this->insert('{{%users}}', [
            'id' => 2,
            'username' => 'system_admin',
            'full_name' => '系统管理员',
            'email' => 'admin@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString(40),
            'status' => 1,
            'tenant_code' => 'system',
        ]);

        // 分配系统管理员角色
        $this->insert('{{%user_roles}}', [
            'user_id' => 2,
            'role_id' => 2, // 系统管理员角色
            'tenant_code' => 'system',
            'assigned_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 分配权限给角色
     */
    private function assignPermissionsToRoles()
    {
        // 超级管理员拥有所有权限
        $permissions = $this->db->createCommand('SELECT id FROM {{%permissions}}')->queryColumn();
        foreach ($permissions as $permissionId) {
            $this->insert('{{%role_permissions}}', [
                'role_id' => 1, // 超级管理员角色
                'permission_id' => $permissionId,
                'granted_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // 系统管理员拥有系统管理权限
        $systemPermissions = $this->db->createCommand('SELECT id FROM {{%permissions}} WHERE permission_code LIKE "system:%" OR permission_code = "system"')->queryColumn();
        foreach ($systemPermissions as $permissionId) {
            $this->insert('{{%role_permissions}}', [
                'role_id' => 2, // 系统管理员角色
                'permission_id' => $permissionId,
                'granted_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // 普通用户拥有基础权限
        $basicPermissions = $this->db->createCommand('SELECT id FROM {{%permissions}} WHERE permission_code IN ("business:dashboard")')->queryColumn();
        foreach ($basicPermissions as $permissionId) {
            $this->insert('{{%role_permissions}}', [
                'role_id' => 4, // 普通用户角色
                'permission_id' => $permissionId,
                'granted_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * 分配菜单给角色
     */
    private function assignMenusToRoles()
    {
        // 超级管理员拥有所有菜单
        $menus = $this->db->createCommand('SELECT id FROM {{%menus}}')->queryColumn();
        foreach ($menus as $menuId) {
            $this->insert('{{%role_menus}}', [
                'role_id' => 1, // 超级管理员角色
                'menu_id' => $menuId,
                'granted_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // 系统管理员拥有系统管理菜单
        $systemMenus = $this->db->createCommand('SELECT id FROM {{%menus}} WHERE menu_code IN ("dashboard", "system", "system_user", "system_role", "system_permission", "system_menu", "system_tenant")')->queryColumn();
        foreach ($systemMenus as $menuId) {
            $this->insert('{{%role_menus}}', [
                'role_id' => 2, // 系统管理员角色
                'menu_id' => $menuId,
                'granted_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // 普通用户只有首页菜单
        $basicMenus = $this->db->createCommand('SELECT id FROM {{%menus}} WHERE menu_code = "dashboard"')->queryColumn();
        foreach ($basicMenus as $menuId) {
            $this->insert('{{%role_menus}}', [
                'role_id' => 4, // 普通用户角色
                'menu_id' => $menuId,
                'granted_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%role_menus}}');
        $this->delete('{{%role_permissions}}');
        $this->delete('{{%user_roles}}');
        $this->delete('{{%users}}', ['username' => 'admin']);
        $this->delete('{{%users}}', ['username' => 'system_admin']);
        $this->delete('{{%menus}}');
        $this->delete('{{%roles}}');
        $this->delete('{{%permissions}}');
    }
}
