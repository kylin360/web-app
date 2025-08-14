<?php

use yii\db\Migration;

/**
 * 创建角色菜单关联表
 * 
 * 角色与菜单的多对多关联关系，用于前端菜单权限控制
 */
class m240814_120700_create_role_menus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role_menus}}', [
            'id' => $this->bigPrimaryKey()->unsigned()->comment('ID'),
            'role_id' => $this->bigInteger()->unsigned()->notNull()->comment('角色ID'),
            'menu_id' => $this->bigInteger()->unsigned()->notNull()->comment('菜单ID'),
            'granted_by' => $this->bigInteger()->unsigned()->comment('授权人ID'),
            'granted_at' => $this->dateTime()->comment('授权时间'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT="角色菜单关联表"');

        // 创建索引
        $this->createIndex('idx_role_id', '{{%role_menus}}', 'role_id');
        $this->createIndex('idx_menu_id', '{{%role_menus}}', 'menu_id');
        $this->createIndex('idx_granted_by', '{{%role_menus}}', 'granted_by');
        
        // 创建唯一索引，防止重复授权
        $this->createIndex('uk_role_menu', '{{%role_menus}}', ['role_id', 'menu_id'], true);

        // 创建外键约束
        $this->addForeignKey(
            'fk_rm_role',
            '{{%role_menus}}',
            'role_id',
            '{{%roles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_rm_menu',
            '{{%role_menus}}',
            'menu_id',
            '{{%menus}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_rm_granted_by',
            '{{%role_menus}}',
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
        $this->dropForeignKey('fk_rm_granted_by', '{{%role_menus}}');
        $this->dropForeignKey('fk_rm_menu', '{{%role_menus}}');
        $this->dropForeignKey('fk_rm_role', '{{%role_menus}}');
        $this->dropTable('{{%role_menus}}');
    }
}
