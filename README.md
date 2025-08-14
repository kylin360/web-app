# WebAPP

一个基于 PHP Yii2 + Vue3 构建的

## 📋 项目简介


## 🛠 技术架构

本项目采用前后端分离架构，使用现代化技术栈构建高性能、可扩展的跨境电商分析平台。

### 前端技术栈

基于 [pure-admin-thin](https://github.com/pure-admin/pure-admin-thin) 模板构建：

| 技术 | 版本 | 说明 |
|------|------|------|
| **Vue.js** | 3.5.x | 渐进式框架，Composition API |
| **TypeScript** | 5.8.x | 类型安全的 JavaScript |
| **Vite** | 7.0.x | 新一代前端构建工具 |
| **Element Plus** | 2.10.x | Vue 3 UI 组件库 |
| **Pinia** | 3.0.x | 现代状态管理库 |
| **Vue Router** | 4.5.x | 官方路由管理器 |
| **Echarts** | 5.6.x | 数据可视化图表库 |
| **Axios** | 1.11.x | HTTP 客户端 |
| **Tailwind CSS** | 4.1.x | 原子化 CSS 框架 |

### 后端技术栈

基于 [Yii2 Framework](https://github.com/yiisoft/yii2) 构建：

| 技术 | 版本 | 说明 |
|------|------|------|
| **PHP** | 7.4+ | 现代 PHP 版本 |
| **Yii2** | 2.0.42+ | 高性能 PHP 框架 |
| **MySQL** | 5.7+ | 主数据库 |
| **Redis** | 7.x | 缓存 & 会话存储 |
| **MongoDB** | 5.x | 文档数据库（可选） |
| **Nginx** | 1.25+ | Web 服务器 |

### 开发 & 运维工具

| 工具 | 用途 |
|------|------|
| **Docker** | 容器化部署 |
| **Docker Compose** | 多容器编排 |
| **Composer** | PHP 依赖管理 |
| **PNPM** | Node.js 包管理 |
| **Git** | 版本控制 |
| **Adminer** | 数据库管理 |
| **MailHog** | 邮件测试 |

## 🚀 快速体验




## 🚀 快速开始

### 📋 环境要求

| 组件 | 最低版本 | 推荐版本 | 说明 |
|------|----------|----------|------|
| **操作系统** | Windows 10 / macOS 10.15 / Ubuntu 18.04 | 最新稳定版 | 支持主流操作系统 |
| **Docker** | 20.10+ | 最新版 | 容器化运行环境 |
| **内存** | 4GB | 8GB+ | 保证应用流畅运行 |
| **存储空间** | 10GB | 20GB+ | 包含镜像和数据存储 |



### ⚡ 一键安装（推荐）

#### 🐧 Linux/macOS 用户
```bash
# 克隆项目
git clone <repository-url>
cd web-app

# 运行安装脚本
chmod +x install.sh
./install.sh
```

#### 🪟 Windows 用户
```cmd
# 克隆项目后双击运行
install.bat
```

#### 📝 安装脚本功能
- 🔍 检查 Docker 运行环境
- 📁 创建必要目录和配置文件  
- 🔨 构建和启动所有容器服务
- 📦 安装 PHP 和前端项目依赖
- 🗄️ 初始化数据库和执行迁移
- ✅ 验证所有 PHP 扩展安装状态

### 🔧 手动安装部署

#### 1. 📥 克隆项目
```bash
git clone <https://github.com/kylin360/web-app.git>
cd web-app
```

#### 2. ⚙️ 环境配置
```bash
# 复制环境变量配置文件
cp .env.example .env

# 根据需要编辑环境变量
# vim .env
```

#### 3. 🐳 启动 Docker 服务
```bash
# 启动所有容器服务
docker-compose up -d

# 查看服务运行状态
docker-compose ps

# 查看服务日志
docker-compose logs -f [service_name]
```

#### 4. ✅ 验证安装
```bash
# 检查 PHP 扩展安装状态
docker-compose exec backend php check_extensions.php

# 进入后端容器进行调试
docker-compose exec backend bash

# 进入前端容器
docker-compose exec frontend bash
```


### 🛠️ 开发模式安装

如果需要进行开发调试，可选择手动安装方式：

#### 后端开发环境
```bash
cd backend
composer install
cp config/db.example.php config/db.php
# 配置数据库连接信息
./yii migrate
./yii serve
```

#### 前端开发环境  
```bash
cd frontend
pnpm install
pnpm run dev
```

### 常用开发命令

```bash
# 进入开发容器
docker-compose exec backend bash
docker-compose exec frontend bash

# 查看服务状态
docker-compose ps

# 查看日志
docker-compose logs -f [service_name]

# 重启服务
docker-compose restart [service_name]
```

## 🚀 生产部署

### 环境配置
生产环境部署请修改 `.env` 文件中的关键配置：

```bash
# 生产环境配置示例
YII_ENV=prod
YII_DEBUG=0
MYSQL_PASSWORD=your_secure_password
JWT_SECRET=your_jwt_secret_key
EXCHANGE_RATE_API_KEY=your_api_key
```

### 安全建议
- 🔑 修改默认数据库密码
- 🔐 配置 HTTPS SSL 证书  
- 🔒 设置复杂的 JWT 密钥
- 🛡️ 配置防火墙规则
- 📝 定期备份数据库

## 🤝 贡献指南

欢迎参与项目贡献！请遵循以下流程：

1. **Fork** 项目到个人账户
2. **创建分支** `git checkout -b feature/新功能`  
3. **提交代码** `git commit -m 'feat: 添加新功能'`
4. **推送分支** `git push origin feature/新功能`
5. **创建 Pull Request**

详细的开发规范请参考 **[开发指南](docs/development.md)**。

## 📄 许可证

本项目基于 **MIT 许可证** 开源 - 详情请查看 [LICENSE](LICENSE) 文件

## 📞 联系我们

| 联系方式 | 地址 |
|----------|------|
| 🏠 **项目主页** | [GitHub Repository](https://github.com/kylin360/web-app) |
| 🐛 **问题反馈** | [GitHub Issues](https://github.com/kylin360/web-app/issues) |
| 💬 **功能讨论** | [GitHub Discussions](https://github.com/kylin360/web-app/wiki) |
| 📧 **邮件联系** | developer@bangzone.net |

## 🙏 致谢

感谢以下优秀的开源项目：

| 项目 | 说明 |
|------|------|
| [Vue.js](https://vuejs.org/) | 渐进式 JavaScript 框架 |
| [Yii2 Framework](https://www.yiiframework.com/) | 高性能 PHP 框架 |
| [Element Plus](https://element-plus.org/) | Vue 3 UI 组件库 |
| [pure-admin](https://github.com/pure-admin/pure-admin-thin) | Vue 管理后台模板 |
| [Docker](https://www.docker.com/) | 容器化平台 |

---

<div align="center">

**⭐ 如果这个项目对你有帮助，请给我们一个 Star ⭐**

Made with ❤️ by [Development Team]

</div>
