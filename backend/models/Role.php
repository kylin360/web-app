<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Role model
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $tenant_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['tenant_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '角色名称',
            'description' => '角色描述',
            'tenant_id' => '租户ID',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取租户
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::class, ['id' => 'tenant_id']);
    }

    /**
     * 获取用户角色
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::class, ['role_id' => 'id']);
    }

    /**
     * 获取角色权限
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::class, ['role_id' => 'id']);
    }
}
