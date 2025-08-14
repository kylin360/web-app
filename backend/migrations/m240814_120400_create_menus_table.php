<?php

use yii\db\Migration;

/**
 * 创建菜单表
 * 
 * 前端菜单展示控制，与权限表分离，专门用于菜单渲染
 */
class m240814_120400_create_menus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menus}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('菜单ID'),
            'parent_id' => $this->bigInteger()->unsigned()->defaultValue(0)->comment('父菜单ID, 0表示顶级菜单'),
            'menu_name' => $this->string(100)->notNull()->comment('菜单名称'),
            'menu_code' => $this->string(100)->notNull()->comment('菜单编码'),
            'menu_path' => $this->string(255)->comment('菜单路径'),
            'component' => $this->string(255)->comment('前端组件路径'),
            'icon' => $this->string(50)->comment('菜单图标'),
            'redirect' => $this->string(255)->comment('重定向路径'),
            'meta_json' => $this->json()->comment('菜单元数据(JSON格式)'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('排序号'),
            'is_show' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('是否显示: 0-不显示, 1-显示'),
            'is_cache' => $this->tinyInteger()->defaultValue(0)->comment('是否缓存: 0-不缓存, 1-缓存'),
            'is_affix' => $this->tinyInteger()->defaultValue(0)->comment('是否固定在标签页: 0-否, 1-是'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态: 0-禁用, 1-正常'),
            'tenant_code' => $this->string(50)->defaultValue('system')->comment('租户编码, system表示系统级菜单'),
            'permission_code' => $this->string(100)->comment('关联的权限编码'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="菜单信息表"');

        // 创建索引
        $this->createIndex('idx_menu_code', '{{%menus}}', 'menu_code');
        $this->createIndex('idx_parent_id', '{{%menus}}', 'parent_id');
        $this->createIndex('idx_tenant_code', '{{%menus}}', 'tenant_code');
        $this->createIndex('idx_permission_code', '{{%menus}}', 'permission_code');
        $this->createIndex('idx_status', '{{%menus}}', 'status');

        $this->createIndex('idx_sort_order', '{{%menus}}', 'sort_order');
        $this->createIndex('idx_tenant_menu', '{{%menus}}', ['tenant_code', 'menu_code']);

        // 创建外键约束
        $this->addForeignKey(
            'fk_menu_tenant',
            '{{%menus}}',
            'tenant_code',
            '{{%tenants}}',
            'tenant_code',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_menu_permission',
            '{{%menus}}',
            'permission_code',
            '{{%permissions}}',
            'permission_code',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_menu_permission', '{{%menus}}');
        $this->dropForeignKey('fk_menu_tenant', '{{%menus}}');
        $this->dropTable('{{%menus}}');
    }
}
