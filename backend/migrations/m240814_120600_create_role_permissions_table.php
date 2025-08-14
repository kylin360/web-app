<?php

use yii\db\Migration;

/**
 * 创建角色权限关联表
 * 
 * 角色与权限的多对多关联关系
 */
class m240814_120600_create_role_permissions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role_permissions}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('ID'),
            'role_id' => $this->bigInteger()->unsigned()->notNull()->comment('角色ID'),
            'permission_id' => $this->bigInteger()->unsigned()->notNull()->comment('权限ID'),
            'granted_by' => $this->bigInteger()->unsigned()->comment('授权人ID'),
            'granted_at' => $this->dateTime()->comment('授权时间'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="角色权限关联表"');

        // 创建索引
        $this->createIndex('idx_role_id', '{{%role_permissions}}', 'role_id');
        $this->createIndex('idx_permission_id', '{{%role_permissions}}', 'permission_id');
        $this->createIndex('idx_granted_by', '{{%role_permissions}}', 'granted_by');
        
        // 创建唯一索引，防止重复授权
        $this->createIndex('uk_role_permission', '{{%role_permissions}}', ['role_id', 'permission_id'], true);

        // 创建外键约束
        $this->addForeignKey(
            'fk_rp_role',
            '{{%role_permissions}}',
            'role_id',
            '{{%roles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_rp_permission',
            '{{%role_permissions}}',
            'permission_id',
            '{{%permissions}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_rp_granted_by',
            '{{%role_permissions}}',
            'granted_by',
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
        $this->dropForeignKey('fk_rp_granted_by', '{{%role_permissions}}');
        $this->dropForeignKey('fk_rp_permission', '{{%role_permissions}}');
        $this->dropForeignKey('fk_rp_role', '{{%role_permissions}}');
        $this->dropTable('{{%role_permissions}}');
    }
}
