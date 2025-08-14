## 🚀 项目概述

这是一个基于 Yii2 框架开发的多租户跨境计算系统后端 API，提供完整的用户认证、权限管理和业务功能支持。

## ✨ 主要特性

- **多租户架构**: 支持多租户数据隔离和管理
- **JWT 认证**: 基于 Bearer Token 的无状态认证
- **RBAC 权限控制**: 基于角色的访问控制
- **RESTful API**: 标准的 REST API 设计
- **CORS 支持**: 跨域资源共享支持
- **数据库迁移**: 完整的数据库结构管理

## 🏗️ 系统架构

### 核心模块

1. **用户管理模块**
   - 用户注册、登录、登出
   - 用户信息管理
   - 密码加密存储

2. **租户管理模块**
   - 租户创建和管理
   - 租户状态控制
   - 租户配置管理

3. **角色权限模块**
   - 角色管理
   - 权限管理
   - 用户角色分配
   - 角色权限分配

4. **认证授权模块**
   - JWT Token 生成和验证
   - Bearer 认证
   - 权限检查

## 📁 目录结构

```
backend/
├── commands/           # 控制台命令
│   └── InitController.php  # 系统初始化
├── config/            # 配置文件
│   ├── api.php        # API 应用配置
│   ├── db.php         # 数据库配置
│   └── params.php     # 参数配置
├── controllers/        # 控制器
│   ├── base/          # 基础控制器
│   │   ├── RestController.php   # REST 控制器基类
│   │   └── AuthController.php   # 认证控制器基类
│   └── v1/            # API 版本 1
│       └── UserController.php   # 用户管理控制器
├── forms/             # 表单模型
│   └── LoginForm.php  # 登录表单
├── models/            # 数据模型
│   ├── User.php       # 用户模型
│   ├── Tenant.php     # 租户模型
│   ├── Role.php       # 角色模型
│   ├── Permission.php # 权限模型
│   ├── UserRole.php   # 用户角色关联
│   └── RolePermission.php # 角色权限关联
├── migrations/        # 数据库迁移
└── web/              # Web 入口
    └── api.php        # API 入口脚本
```

## 🗄️ 数据库设计

### 核心表结构

1. **tenants** - 租户表
   - 租户基本信息
   - 租户状态和配置

2. **users** - 用户表
   - 用户基本信息
   - 密码哈希和认证令牌

3. **roles** - 角色表
   - 角色定义
   - 角色描述

4. **permissions** - 权限表
   - 权限定义
   - 权限类型和描述

5. **user_roles** - 用户角色关联表
6. **role_permissions** - 角色权限关联表

## 🔐 认证流程

### 用户登录

1. 用户提交用户名、密码和租户编码
2. 系统验证租户有效性
3. 验证用户凭据
4. 生成 JWT Token
5. 返回用户信息和访问令牌

### API 访问

1. 客户端在请求头中添加 `Authorization: Bearer {token}`
2. 系统验证 Token 有效性
3. 检查用户权限
4. 执行相应操作

## 🚀 快速开始

### 环境要求

- PHP >= 7.4
- MySQL >= 5.7
- Redis >= 4.0
- Composer

### 安装步骤

1. **克隆项目**
   ```bash
   git clone <repository-url>
   cd yii-app/backend
   ```

2. **安装依赖**
   ```bash
   composer install
   ```

3. **配置数据库**
   ```bash
   cp config/db.php.example config/db.php
   # 编辑数据库连接信息
   ```

4. **运行数据库迁移**
   ```bash
   ./yii migrate/up
   ```

5. **初始化系统数据**
   ```bash
   ./yii init
   ```

6. **启动服务**
   ```bash
   php -S localhost:8000 -t web
   ```

### 默认账户

- **用户名**: admin
- **密码**: admin123
- **租户编码**: system

## 📡 API 接口

### 认证接口

- `POST /v1/user/login` - 用户登录
- `POST /v1/user/register` - 用户注册
- `POST /v1/user/logout` - 用户登出
- `GET /v1/user/profile` - 获取用户信息
- `POST /v1/user/update` - 更新用户信息

### 请求示例

#### 用户登录
```bash
curl -X POST http://localhost:8000/v1/user/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "admin123",
    "tenant_code": "system"
  }'
```

#### 带认证的请求
```bash
curl -X GET http://localhost:8000/v1/user/profile \
  -H "Authorization: Bearer {your-token}"
```

## 🔧 开发指南

### 添加新控制器

1. 继承 `RestController` 或 `AuthController`
2. 实现相应的 action 方法
3. 在 `config/api.php` 中添加路由规则

### 添加新模型

1. 继承 `ActiveRecord`
2. 定义表名和验证规则
3. 实现关联关系

### 权限控制

使用 `checkPermission()` 方法检查用户权限：

```php
protected function actionCreate()
{
    $this->checkPermission('user.create');
    // 执行创建逻辑
}
```

## 🧪 测试

### 运行测试
```bash
# 单元测试
./vendor/bin/codecept run unit

# 功能测试
./vendor/bin/codecept run functional

# 所有测试
./vendor/bin/codecept run
```

## 📝 更新日志

### v1.0.0 (2024-08-14)
- 初始版本发布
- 多租户架构支持
- JWT 认证系统
- RBAC 权限控制
- 完整的用户管理功能

## 🤝 贡献指南

1. Fork 项目
2. 创建功能分支
3. 提交更改
4. 推送到分支
5. 创建 Pull Request

## 📄 许可证

本项目采用 MIT 许可证 - 查看 [LICENSE](LICENSE.md) 文件了解详情。

## 📞 联系方式

如有问题或建议，请联系开发团队。
