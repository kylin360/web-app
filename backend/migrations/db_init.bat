@echo off
echo ====================================
echo      数据库初始化脚本
echo ====================================

echo.
echo 正在执行数据库迁移...

REM 执行所有迁移文件
php yii migrate --interactive=0

if %errorlevel% == 0 (
    echo.
    echo ====================================
    echo      数据库初始化完成！
    echo ====================================
    echo.
    echo 系统初始账户信息：
    echo.
    echo 超级管理员：
    echo 用户名: admin
    echo 密码: admin123
    echo 邮箱: admin@example.com
    echo.
    echo 系统管理员：
    echo 用户名: system_admin
    echo 密码: system123
    echo 邮箱: system_admin@example.com
    echo.
    echo 请在生产环境中修改默认密码！
    echo ====================================
) else (
    echo.
    echo ====================================
    echo      数据库初始化失败！
    echo ====================================
    echo 请检查数据库连接配置和错误信息
)

pause
