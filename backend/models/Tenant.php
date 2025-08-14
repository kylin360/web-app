<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Tenant model
 *
 * @property int $id
 * @property string $tenant_code
 * @property string $tenant_name
 * @property string $tenant_release
 * @property string $contact_person
 * @property string $contact_phone
 * @property string $contact_email
 * @property int $status
 * @property int $is_enabled
 * @property string $expire_time
 * @property string $config_json
 * @property string $created_at
 * @property string $updated_at
 */
class Tenant extends ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tenants}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_code', 'tenant_name', 'tenant_release'], 'required'],
            [['status', 'is_enabled'], 'integer'],
            [['expire_time', 'created_at', 'updated_at'], 'safe'],
            [['config_json'], 'string'],
            [['tenant_code'], 'string', 'max' => 50],
            [['tenant_name'], 'string', 'max' => 100],
            [['tenant_release'], 'string', 'max' => 50],
            [['contact_person'], 'string', 'max' => 50],
            [['contact_phone'], 'string', 'max' => 20],
            [['contact_email'], 'string', 'max' => 100],
            [['tenant_code'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ENABLED],
            ['is_enabled', 'default', 'value' => self::STATUS_ENABLED],
            ['status', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ENABLED]],
            ['is_enabled', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ENABLED]],
            ['contact_email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tenant_code' => '租户编码',
            'tenant_name' => '租户名称',
            'tenant_release' => '租户版本',
            'contact_person' => '联系人',
            'contact_phone' => '联系电话',
            'contact_email' => '联系邮箱',
            'status' => '状态',
            'is_enabled' => '是否启用',
            'expire_time' => '过期时间',
            'config_json' => '配置信息',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取状态列表
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_DISABLED => '禁用',
            self::STATUS_ENABLED => '启用',
        ];
    }

    /**
     * 获取启用状态列表
     */
    public static function getEnabledList()
    {
        return [
            self::STATUS_DISABLED => '否',
            self::STATUS_ENABLED => '是',
        ];
    }

    /**
     * 获取用户
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['tenant_id' => 'id']);
    }

    /**
     * 获取角色
     */
    public function getRoles()
    {
        return $this->hasMany(Role::class, ['tenant_id' => 'id']);
    }

    /**
     * 获取权限
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::class, ['tenant_id' => 'id']);
    }

    /**
     * 检查租户是否有效
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ENABLED && 
               $this->is_enabled == self::STATUS_ENABLED &&
               ($this->expire_time === null || strtotime($this->expire_time) > time());
    }
}
