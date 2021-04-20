# laravel_quick_admin

## 背景

起这个项目的初衷是，对于一个后台管理系统，登陆、注销、权限管理等都是些公用的模块，完全可以封装成一个基础项目，每次新的项目基于基础项目上开发即可，节约时间，提高开发效率。

## 功能模块

- 登陆
- 找回密码
- 修改密码
- 注销
- 管理员管理
- 权限管理
- 角色管理
- 支持多语言

## 代码模块

- route
- controller
- service
- model
- log
- request
- Repository  (关于这个仁者见仁智者见智吧,本项目弃用repository设计模式)

## 项目搭建

比较简单，主要以下几步

1. `composer install`
2. 修改`.env`文件相关配置
3. 执行`laravel_quick_admin/laravel_quick_admin.sql`文件中的sql语句
4. 登陆信息：账号：1234@qq.com  密码：1234
5. 创建数据库 `crm`，名称随意，不过跟下面的保持一致。
追加：
1. 如果报 `api prodiver` 错误，在 `.env` 中增加 `API_PREFIX=api`
2. 报错说没有 `key`，执行 `php artisan key:generate`
3. 项目后台首页路由为 /admin，自带的登录注册无法正常使用


## 注意点
因为博主用的数据库是mariadb，创建时间和更新时间的默认值为current_timestamp(),如果你是mysql的话，应该修改为CURRENT_TIMESTAMP 
对于 `mysql` 数据库，`laravel_quick_admin1.sql` 文件为替换过的 `mysql`可用的迁移文件， 然后使用 数据库软件 导入，或者在项目下执行 `mysql -uroot -p crm < ./laravel_quick_admin1.sql` ，`root` 为数据库用户，`crm` 为数据库名。命令行执行可能会报错，不顾数据跟表已经被导入了。

## 展望

后续会更新出一版 前后端分离的基础后台框架，敬请期待。

## 感谢

laravel -- 艺术家最爱的框架

H-ui -- 轻量级前端框架


## 个人博客地址
https://tsmliyun.github.io/


