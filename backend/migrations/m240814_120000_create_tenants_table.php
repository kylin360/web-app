<?php

use yii\db\Migration;

/**
 * 创建租户表
 * 
 * 多租户系统的核心表，用于隔离不同租户的数据
 */
class m240814_120000_create_tenants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tenants}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('租户ID'),
            'tenant_code' => $this->string(50)->notNull()->unique()->comment('租户编码(唯一标识)'),
            'tenant_name' => $this->string(100)->notNull()->comment('租户名称'),
            'tenant_release' => $this->string(50)->notNull()->comment('租户版本'),
            'contact_person' => $this->string(50)->comment('联系人'),
            'contact_phone' => $this->string(20)->comment('联系电话'),
            'contact_email' => $this->string(100)->comment('联系邮箱'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态: 0-禁用, 1-正常'),
            'is_enabled' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('是否启用: 0-否, 1-是'),
            'expire_time' => $this->dateTime()->comment('过期时间'),
            'config_json' => $this->json()->comment('租户配置信息'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="租户信息表"');

        // 创建索引
        $this->createIndex('idx_tenant_code', '{{%tenants}}', 'tenant_code');
        $this->createIndex('idx_status', '{{%tenants}}', 'status');

        // 插入系统默认租户（用于系统级管理员）
        $this->insert('{{%tenants}}', [
            'tenant_code' => 'system',
            'tenant_name' => '系统默认租户',
            'tenant_release' => '1.0.0',
            'contact_person' => '系统管理员',
            'status' => 1,
            'is_enabled' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tenants}}');
    }
}
