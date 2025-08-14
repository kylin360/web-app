# 跨境电商计算器

一个基于 PHP Yii2 + Vue3 构建的现代化跨境电商智能分析工具，专为中国制造业向跨境电商转型而设计。

## 📋 项目简介

跨境电商计算器提供了完整的电商业务分析解决方案，集成多币种计算、实时汇率转换、成本分析、利润预测等核心功能，帮助跨境电商从业者做出数据驱动的决策。

### ✨ 主要特性

- 🚀 **多币种支持** - 实时汇率转换，支持全球主要货币
- 📊 **智能分析** - 基于历史数据的成本分析和利润预测  
- 🌍 **市场洞察** - 主流跨境电商平台数据整合
- 📱 **响应式设计** - 完美适配桌面端和移动端
- 🔒 **企业级安全** - 完善的数据加密和权限控制
- 📈 **实时监控** - 汇率波动和市场变化智能提醒
- 🐳 **容器化部署** - Docker 一键部署，环境一致性保障

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

### 在线演示
- 🌐 **演示地址**: [在线体验](http://demo.example.com) 

### 默认账户信息
#### 管理员
- 👤 **用户名**: admin
- 🔑 **密码**: admin123
- 📧 **邮箱**: admin@example.com
- 🎯 **权限**: 系统管理模块权限

#### 操作员  
- 👤 **用户名**: test
- 🔑 **密码**: test123
- 📧 **邮箱**: test@example.com
- 🎯 **权限**: 用户操作模块权限

> ⚠️ **安全提醒**: 生产环境部署后请立即修改默认密码！

### 核心功能预览
- 💱 **智能汇率** - 实时汇率监控和预警
- 💰 **成本计算** - 精准的成本分析工具  
- 📈 **利润分析** - 多维度利润率计算
- 🌍 **市场洞察** - 竞品分析和趋势预测
- 📊 **数据报告** - 专业的分析报告生成

## 📚 项目文档

详细的技术文档和开发指南，请参考以下文档：

| 文档 | 说明 |
|------|------|
| 📖 **[快速开始](docs/quick-start.md)** | 5分钟快速部署指南 |
| 🎯 **[功能模块](docs/features.md)** | 详细功能介绍和使用说明 |
| 🗄️ **[数据库设计](docs/database.md)** | 数据库表结构和设计文档 |
| 🔧 **[PHP扩展](docs/php-extensions.md)** | PHP扩展配置和使用说明 |
| 👨‍💻 **[开发指南](docs/development.md)** | 开发规范和最佳实践 |

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
cd yii-app

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
git clone <repository-url>
cd yii-app
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

#### 5. 🌐 访问应用

| 服务 | 地址 | 说明 |
|------|------|------|
| 🎨 **前端应用** | http://localhost:3000 | Vue3 用户界面 |
| 🔧 **后端 API** | http://localhost | Yii2 API 服务 |
| 🗄️ **数据库管理** | http://localhost:8082 | Adminer 管理界面 |
| 📧 **邮件测试** | http://localhost:8025 | MailHog 邮件调试 |

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

## 🛠️ 开发环境

如需进行二次开发，请参考 **[开发指南](docs/development.md)** 了解详细的开发规范、代码标准和调试技巧。

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
| 🏠 **项目主页** | [GitHub Repository](#) |
| 🐛 **问题反馈** | [GitHub Issues](#) |
| 💬 **功能讨论** | [GitHub Discussions](#) |
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
