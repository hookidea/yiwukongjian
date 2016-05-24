# 依赖
- PHP(v5.4以上)、MySQL、Memcached、Coreseek(Sphinx中文版)

- 导入数据库文件：
    + ori_shop.sql（只包含数据表结构）
    + data.sql（包含 数据表结果 + 数据）
    
- Coreseek 使用根目录的 `csft.conf` 作为配置文件，建立索引并启动 Coreseek

***

# 项目说明

### 项目描述：

- 该项目起源于学校举行的毕业设计大赛，该项目作为参赛作品，并在赛后进行正式线上运营；
- 项目目标在于，提供一个具有发布、浏览、购买、管理商品等功能的商城平台；
- 项目价值在于，对一些闲置物品、废弃物品价值的二次开发，达到其价值的最大化；
- 同时，平台也作为一个校园微商平台使用，让校园微商们更合理的利用其校园资源来发展自身。

### 项目技术：

- 　数据库：MySQL；
- 后端方面：选用 PHP 作为后端开发语言，兼容 v5.4 以上，并选用PHP框架 ThinkPHP(v3.2.3)；
- 前端方面：使用 HTML + CSS + JavaScript，以及 Jquery ＋ HTML5 的一些新特性完成；
- 技术亮点：使用 Sphinx 的中文版 Coreseek 加强了中文检索，提高搜索体验；
- 终端适配：适配了电脑端、移动端两个版本，并实现了终端自动识别、两个版本之间的无缝切换；
- 运营方面：具备完善的权限管理、完备的管理选项，方便运营人员进行网站运营管理；
- 缓存优化：使用 静态缓存、Memcached 等技术进行了缓存优化；
- SEO优化：使用URL重写和一些常用SEO优化进行了优化；
- 安全方面：对一些网络常见的攻击方式，如 XSS、CSRF、SQL注入 等做了一定的防护措施。

### 项目临时演示IP地址：[易物空间](http://42.96.143.133)

***