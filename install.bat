@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion

echo 🚀 跨境电商计算器 - 环境安装脚本
echo ==================================

REM 检查Docker是否安装
docker --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker未安装，请先安装Docker Desktop
    echo 访问: https://docs.docker.com/desktop/install/windows/
    pause
    exit /b 1
)

REM 检查Docker Compose是否安装
docker-compose --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Docker Compose未安装，请先安装Docker Compose
    echo 访问: https://docs.docker.com/compose/install/
    pause
    exit /b 1
)

echo ✅ Docker环境检查通过

REM 创建环境配置文件
if not exist .env (
    echo 📝 创建环境配置文件...
    copy env.example .env >nul
    echo ✅ 环境配置文件已创建: .env
    echo ⚠️  请根据需要编辑 .env 文件中的配置
) else (
    echo ✅ 环境配置文件已存在
)

REM 创建必要的目录
echo 📁 创建必要的目录...
if not exist database\mysql mkdir database\mysql
if not exist database\mongodb mkdir database\mongodb
if not exist logs\php mkdir logs\php
if not exist logs\nginx mkdir logs\nginx
if not exist uploads mkdir uploads
if not exist cache mkdir cache

echo ✅ 目录创建完成

REM 构建并启动服务
echo 🐳 构建并启动Docker服务...
docker-compose build --no-cache

echo 🚀 启动所有服务...
docker-compose up -d

REM 等待服务启动
echo ⏳ 等待服务启动...
timeout /t 30 /nobreak >nul

REM 检查服务状态
echo 🔍 检查服务状态...
docker-compose ps

REM 安装PHP依赖
echo 📦 安装PHP依赖...
docker-compose exec backend composer install --no-interaction --optimize-autoloader

REM 运行数据库迁移
echo 🗄️  运行数据库迁移...
docker-compose exec backend php yii migrate --interactive=0

REM 检查PHP扩展
echo 🔍 检查PHP扩展...
docker-compose exec backend php check_extensions.php

REM 安装前端依赖
echo 📦 安装前端依赖...
docker-compose exec frontend npm install

echo.
echo 🎉 安装完成！
echo ==================================
echo 🌐 前端应用: http://localhost:3000
echo 🔧 后端API: http://localhost:8000
echo 🗄️  数据库管理: http://localhost:8080 (phpMyAdmin)
echo 🔴 Redis管理: http://localhost:8081 (Redis Commander)
echo 📧 邮件测试: http://localhost:8025 (MailHog)
echo 📊 监控面板: http://localhost:8082 (Adminer)
echo.
echo 📚 查看日志: docker-compose logs -f
echo 🛑 停止服务: docker-compose down
echo 🔄 重启服务: docker-compose restart
echo.
echo 💡 提示: 首次访问可能需要等待几分钟让服务完全启动
echo ==================================

pause
