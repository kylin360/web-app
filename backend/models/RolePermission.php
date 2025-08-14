<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * RolePermission model
 *
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property string $created_at
 */
class RolePermission extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role_permissions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'permission_id'], 'required'],
            [['role_id', 'permission_id'], 'integer'],
            [['created_at'], 'safe'],
            [['role_id', 'permission_id'], 'unique', 'targetAttribute' => ['role_id', 'permission_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => '角色ID',
            'permission_id' => '权限ID',
            'created_at' => '创建时间',
        ];
    }

    /**
     * 获取角色
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * 获取权限
     */
    public function getPermission()
    {
        return $this->hasOne(Permission::class, ['id' => 'permission_id']);
    }
}
