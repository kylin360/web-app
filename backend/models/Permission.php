<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Permission model
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $tenant_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Permission extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_MENU = 'menu';
    const TYPE_BUTTON = 'button';
    const TYPE_API = 'api';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permissions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type'], 'required'],
            [['tenant_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            [['name'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['type', 'in', 'range' => [self::TYPE_MENU, self::TYPE_BUTTON, self::TYPE_API]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '权限名称',
            'description' => '权限描述',
            'type' => '权限类型',
            'tenant_id' => '租户ID',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取权限类型列表
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_MENU => '菜单权限',
            self::TYPE_BUTTON => '按钮权限',
            self::TYPE_API => 'API权限',
        ];
    }

    /**
     * 获取状态列表
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => '禁用',
            self::STATUS_ACTIVE => '启用',
        ];
    }
}
