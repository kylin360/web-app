<?php

use yii\db\Migration;

/**
 * 创建角色表
 * 
 * 支持多租户的角色权限管理系统
 */
class m240814_120200_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%roles}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('角色ID'),
            'role_name' => $this->string(50)->notNull()->comment('角色名称'),
            'role_code' => $this->string(50)->notNull()->unique()->comment('角色编码'),
            'description' => $this->string(200)->comment('角色描述'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态: 0-禁用, 1-正常'),
            'tenant_code' => $this->string(50)->defaultValue('system')->comment('租户编码, system表示系统级角色'),
            'is_system' => $this->tinyInteger()->defaultValue(0)->comment('是否系统角色: 0-否, 1-是'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('排序号'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="角色信息表"');

        // 创建索引
        $this->createIndex('idx_role_code', '{{%roles}}', 'role_code');
        $this->createIndex('idx_tenant_code', '{{%roles}}', 'tenant_code');
        $this->createIndex('idx_status', '{{%roles}}', 'status');
        $this->createIndex('idx_tenant_role', '{{%roles}}', ['tenant_code', 'role_code']);

        // 创建外键约束
        $this->addForeignKey(
            'fk_role_tenant',
            '{{%roles}}',
            'tenant_code',
            '{{%tenants}}',
            'tenant_code',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_role_tenant', '{{%roles}}');
        $this->dropTable('{{%roles}}');
    }
}
