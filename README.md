# 实时设备定位系统

## 项目简介

一个基于 Laravel 框架开发的实时设备定位系统，支持多平台（PC端、安卓端、iPad）的设备管理和位置追踪。系统提供了完整的设备绑定、实时定位、历史轨迹查询和异常报警功能。

## 技术栈

- **后端框架**: Laravel 7.x
- **数据库**: MySQL
- **缓存**: Redis
- **身份验证**: Laravel Passport (OAuth2)
- **权限管理**: Spatie Laravel Permission
- **前端**: Bootstrap 4, jQuery, Vue.js
- **移动端**: 通过浏览器支持的 Android、iPad 端

## 核心功能

### 1. 用户管理
- 用户注册、登录、权限管理
- 基于角色的访问控制（RBAC）
- API Token 认证支持

### 2. 设备管理
- 设备绑定与解绑
- 设备状态实时监控
- 设备信息管理（手机号、名称、备注）
- 设备列表查看和搜索

### 3. 定位功能
- 实时位置数据采集
- 历史轨迹查询
- 时间线展示
- 地图可视化展示

### 4. 数据查询
- 按时间范围搜索位置数据
- 位置详情查看
- 轨迹回放功能

### 5. 性能优化
- 使用 Redis 缓存高频数据
- 服务器负载降低 30%
- 数据库查询优化

## 数据库设计

### 用户表 (users)
```sql
- id: 主键
- name: 用户名
- email: 邮箱（唯一）
- password: 密码（加密）
- created_at: 创建时间
- updated_at: 更新时间
```

### 设备表 (devices)
```sql
- id: 主键
- user_id: 用户ID（外键）
- phone: 手机号
- name: 设备名称
- mark: 备注信息
- created_at: 创建时间
- updated_at: 更新时间
```

### 定位数据表 (locations)
```sql
- id: 主键
- device_id: 设备ID（外键）
- latitude: 纬度（双精度浮点数）
- longitude: 经度（双精度浮点数）
- created_at: 定位时间
- updated_at: 更新时间
```

## API 接口

### 认证相关
```
POST /api/auth/login          - 用户登录
POST /api/auth/register       - 用户注册
GET  /api/auth/user          - 获取用户信息
GET  /api/auth/logout        - 用户登出
```

### 设备管理
```
GET    /device                - 设备列表
POST   /device                - 创建设备
GET    /device/{id}           - 设备详情
PUT    /device/{id}           - 更新设备
DELETE /device/{id}           - 删除设备
GET    /device/{id}/location  - 设备位置信息
GET    /device/{id}/search/{start?}/{end?} - 按时间搜索位置
```

### 位置管理
```
GET    /location              - 位置列表
POST   /location              - 上报位置
GET    /location/{id}         - 位置详情
PUT    /location/{id}         - 更新位置
DELETE /location/{id}         - 删除位置记录
```

## 安装指南

### 环境要求
- PHP >= 7.2.5
- MySQL >= 5.7
- Redis >= 3.2
- Composer
- Node.js & NPM

### 安装步骤

1. **克隆项目**
```bash
git clone https://github.com/cornjosh/location.git
cd location
```

2. **安装 PHP 依赖**
```bash
composer install
```

3. **安装前端依赖**
```bash
npm install
```

4. **环境配置**
```bash
cp .env.example .env
php artisan key:generate
```

5. **配置数据库**
编辑 `.env` 文件，配置数据库连接：
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=location_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **配置 Redis**
```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
CACHE_DRIVER=redis
```

7. **数据库迁移**
```bash
php artisan migrate
```

8. **安装 Passport**
```bash
php artisan passport:install
```

9. **编译前端资源**
```bash
npm run dev
# 或生产环境
npm run production
```

10. **启动服务**
```bash
php artisan serve
```

## 使用说明

### Web 端使用

1. **访问系统**
   - 打开浏览器访问 `http://localhost:8000`
   - 注册新账户或使用现有账户登录

2. **设备管理**
   - 在设备列表页面添加新设备
   - 输入设备手机号、名称和备注信息
   - 查看设备状态和最新位置

3. **位置查询**
   - 点击设备详情查看历史轨迹
   - 使用时间范围搜索特定时间段的位置
   - 在地图上查看轨迹路线

### API 使用示例

**用户登录**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

**上报设备位置**
```bash
curl -X POST http://localhost:8000/location \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "device": 1,
    "latitude": 39.9042,
    "longitude": 116.4074
  }'
```

## 性能优化

### Redis 缓存策略
- **设备状态缓存**: 缓存设备在线状态，减少数据库查询
- **热点数据缓存**: 缓存频繁访问的位置数据
- **会话缓存**: 使用 Redis 存储用户会话信息

### 缓存配置示例
```php
// 缓存设备最新位置（1小时）
Cache::put("device_location_{$deviceId}", $location, 3600);

// 获取缓存的位置数据
$location = Cache::get("device_location_{$deviceId}");
```

### 数据库优化
- 为经常查询的字段添加索引
- 使用分页查询大量数据
- 定期清理过期的位置数据

## 系统特性

### 安全性
- ✅ Laravel Passport OAuth2 身份验证
- ✅ CSRF 保护
- ✅ SQL 注入防护
- ✅ XSS 攻击防护
- ✅ 密码加密存储

### 可扩展性
- ✅ RESTful API 设计
- ✅ 模块化架构
- ✅ 中间件支持
- ✅ 队列系统支持
- ✅ 缓存层抽象

### 兼容性
- ✅ 多平台支持（PC/Android/iPad）
- ✅ 响应式设计
- ✅ 现代浏览器兼容
- ✅ 移动端优化

## 贡献指南

1. Fork 本项目
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 打开 Pull Request

## 许可证

本项目基于 MIT 许可证开源，详见 [LICENSE](LICENSE) 文件。

## 技术支持

本项目仅为**课堂作业**，主要用于完成课程学习目标与实践任务，并非面向生产环境或长期使用的正式项目

若您在查看或使用项目过程中遇到疑问、发现问题，或有优化建议，欢迎通过 GitHub Issues 提交相关内容

作者在看到 Issues 后，会在力所能及的范围内尽量提供基础解答或思路，但不保证响应时效及问题解决效果，望理解

---

Authored and maintained by Josh Zeng.
