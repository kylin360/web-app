#!/bin/bash

# 跨境电商计算器 - 一键安装脚本
# 适用于 Linux/macOS 系统

set -e

echo "🚀 跨境电商计算器 - 环境安装脚本"
echo "=================================="

# 检查Docker是否安装
if ! command -v docker &> /dev/null; then
    echo "❌ Docker未安装，请先安装Docker"
    echo "访问: https://docs.docker.com/get-docker/"
    exit 1
fi

# 检查Docker Compose是否安装
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose未安装，请先安装Docker Compose"
    echo "访问: https://docs.docker.com/compose/install/"
    exit 1
fi

echo "✅ Docker环境检查通过"

# 创建环境配置文件
if [ ! -f .env ]; then
    echo "📝 创建环境配置文件..."
    cp env.example .env
    echo "✅ 环境配置文件已创建: .env"
    echo "⚠️  请根据需要编辑 .env 文件中的配置"
else
    echo "✅ 环境配置文件已存在"
fi

# 创建必要的目录
echo "📁 创建必要的目录..."
mkdir -p database/mysql
mkdir -p database/mongodb
mkdir -p logs/php
mkdir -p logs/nginx
mkdir -p uploads
mkdir -p cache

# 设置目录权限
echo "🔐 设置目录权限..."
chmod -R 755 uploads
chmod -R 755 cache
chmod -R 755 logs

echo "✅ 目录创建完成"

# 构建并启动服务
echo "🐳 构建并启动Docker服务..."
docker-compose build --no-cache

echo "🚀 启动所有服务..."
docker-compose up -d

# 等待服务启动
echo "⏳ 等待服务启动..."
sleep 30

# 检查服务状态
echo "🔍 检查服务状态..."
docker-compose ps

# 安装PHP依赖
echo "📦 安装PHP依赖..."
docker-compose exec backend composer install --no-interaction --optimize-autoloader

# 运行数据库迁移
echo "🗄️  运行数据库迁移..."
docker-compose exec backend php yii migrate --interactive=0

# 检查PHP扩展
echo "🔍 检查PHP扩展..."
docker-compose exec backend php check_extensions.php

# 安装前端依赖
echo "📦 安装前端依赖..."
docker-compose exec frontend npm install

echo ""
echo "🎉 安装完成！"
echo "=================================="
echo "🌐 前端应用: http://localhost:3000"
echo "🔧 后端API: http://localhost:8000"
echo "🗄️  数据库管理: http://localhost:8080 (phpMyAdmin)"
echo "🔴 Redis管理: http://localhost:8081 (Redis Commander)"
echo "📧 邮件测试: http://localhost:8025 (MailHog)"
echo "📊 监控面板: http://localhost:8082 (Adminer)"
echo ""
echo "📚 查看日志: docker-compose logs -f"
echo "🛑 停止服务: docker-compose down"
echo "🔄 重启服务: docker-compose restart"
echo ""
echo "💡 提示: 首次访问可能需要等待几分钟让服务完全启动"
echo "=================================="
