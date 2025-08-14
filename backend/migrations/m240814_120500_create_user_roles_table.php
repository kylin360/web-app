<?php

use yii\db\Migration;

/**
 * 创建用户角色关联表
 * 
 * 用户与角色的多对多关联关系
 */
class m240814_120500_create_user_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_roles}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->bigInteger()->unsigned()->notNull()->comment('用户ID'),
            'role_id' => $this->bigInteger()->unsigned()->notNull()->comment('角色ID'),
            'tenant_code' => $this->string(50)->notNull()->comment('租户编码'),
            'assigned_by' => $this->bigInteger()->unsigned()->comment('分配人ID'),
            'assigned_at' => $this->dateTime()->comment('分配时间'),
            'expires_at' => $this->dateTime()->comment('过期时间'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="用户角色关联表"');

        // 创建索引
        $this->createIndex('idx_user_id', '{{%user_roles}}', 'user_id');
        $this->createIndex('idx_role_id', '{{%user_roles}}', 'role_id');
        $this->createIndex('idx_tenant_code', '{{%user_roles}}', 'tenant_code');
        $this->createIndex('idx_assigned_by', '{{%user_roles}}', 'assigned_by');
        $this->createIndex('idx_expires_at', '{{%user_roles}}', 'expires_at');
        
        // 创建唯一索引，防止重复分配
        $this->createIndex('uk_user_role_tenant', '{{%user_roles}}', ['user_id', 'role_id', 'tenant_code'], true);

        // 创建外键约束
        $this->addForeignKey(
            'fk_ur_user',
            '{{%user_roles}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_ur_role',
            '{{%user_roles}}',
            'role_id',
            '{{%roles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_ur_tenant',
            '{{%user_roles}}',
            'tenant_code',
            '{{%tenants}}',
            'tenant_code',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_ur_assigned_by',
            '{{%user_roles}}',
            'assigned_by',
            '{{%users}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_ur_assigned_by', '{{%user_roles}}');
        $this->dropForeignKey('fk_ur_tenant', '{{%user_roles}}');
        $this->dropForeignKey('fk_ur_role', '{{%user_roles}}');
        $this->dropForeignKey('fk_ur_user', '{{%user_roles}}');
        $this->dropTable('{{%user_roles}}');
    }
}
