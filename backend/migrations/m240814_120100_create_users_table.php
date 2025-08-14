<?php

use yii\db\Migration;

/**
 * 创建用户表
 * 
 * 支持多租户的用户管理系统
 */
class m240814_120100_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('用户ID'),
            'username' => $this->string(50)->notNull()->unique()->comment('用户名'),
            'full_name' => $this->string(50)->comment('姓名'),
            'email' => $this->string(100)->comment('邮箱'),
            'phone' => $this->string(20)->comment('手机号'),
            'avatar' => $this->string(255)->comment('头像URL'),
            'auth_key' => $this->string(32)->comment('认证密钥'),
            'password_hash' => $this->string(255)->notNull()->comment('密码哈希'),
            'password_reset_token' => $this->string(255)->comment('密码重置令牌'),
            'verification_token' => $this->string(255)->comment('邮箱验证令牌'),
            'access_token' => $this->string(255)->comment('访问令牌'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态: 0-禁用, 1-正常, 2-待验证'),
            'last_login_time' => $this->dateTime()->comment('最后登录时间'),
            'last_login_ip' => $this->string(45)->comment('最后登录IP'),
            'login_count' => $this->integer()->defaultValue(0)->comment('登录次数'),
            'tenant_code' => $this->string(50)->defaultValue('system')->comment('租户编码, system表示系统级用户'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')->comment('更新时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="用户信息表"');

        // 创建索引
        $this->createIndex('idx_username', '{{%users}}', 'username');
        $this->createIndex('idx_email', '{{%users}}', 'email');
        $this->createIndex('idx_phone', '{{%users}}', 'phone');
        $this->createIndex('idx_tenant_code', '{{%users}}', 'tenant_code');
        $this->createIndex('idx_status', '{{%users}}', 'status');
        $this->createIndex('idx_tenant_username', '{{%users}}', ['tenant_code', 'username']);

        // 创建外键约束
        $this->addForeignKey(
            'fk_user_tenant',
            '{{%users}}',
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
        $this->dropForeignKey('fk_user_tenant', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
