<?php

use yii\db\Migration;

/**
 * 创建权限表
 * 
 * 权限管理系统，支持树形结构的权限组织
 */
class m240814_120300_create_permissions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%permissions}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('权限ID'),
            'parent_id' => $this->bigInteger()->unsigned()->defaultValue(0)->comment('父权限ID, 0表示顶级权限'),
            'permission_name' => $this->string(100)->notNull()->comment('权限名称'),
            'permission_code' => $this->string(100)->notNull()->unique()->comment('权限编码'),
            'permission_type' => $this->tinyInteger()->notNull()->comment('权限类型: 1-模块, 2-菜单, 3-按钮, 4-接口'),
            'resource_path' => $this->string(255)->comment('资源路径(如URL)'),
            'method' => $this->string(10)->comment('HTTP方法: GET,POST,PUT,DELETE等'),
            'description' => $this->string(200)->comment('权限描述'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('排序号'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态: 0-禁用, 1-正常'),
            'is_system' => $this->tinyInteger()->defaultValue(0)->comment('是否系统权限: 0-否, 1-是'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="权限信息表"');

        // 创建索引
        $this->createIndex('idx_permission_code', '{{%permissions}}', 'permission_code');
        $this->createIndex('idx_parent_id', '{{%permissions}}', 'parent_id');
        $this->createIndex('idx_permission_type', '{{%permissions}}', 'permission_type');
        $this->createIndex('idx_resource_path', '{{%permissions}}', 'resource_path');
        $this->createIndex('idx_status', '{{%permissions}}', 'status');
        $this->createIndex('idx_sort_order', '{{%permissions}}', 'sort_order');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%permissions}}');
    }
}
