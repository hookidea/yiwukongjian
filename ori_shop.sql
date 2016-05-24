create database shop charset utf8;

use shop;

set names utf8;

-- bugs
create table bugs(
bug_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
content varchar(200) not null default '',
add_time int unsigned not null default 0,
is_full tinyint(1) unsigned not null default 0,
key(user_id)
)engine=myisam charset=utf8;

-- 操作记录表
create table handles(
handle_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
id int unsigned not null default 0,
action char(4) not null default '',
controller char(4) not null default '',
add_time int unsigned not null default 0,
key(user_id)
)engine=myisam charset=utf8;
-- 可根据用户ID查看其所有操作

-- 交换表
create table switchs(
switch_id int unsigned primary key auto_increment not null,
switch_sn char(15) not null default '',
user_good_id int unsigned not null default 0,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
raply_good_id int unsigned not null default 0,
raply_id int unsigned not null default 0,
raply_name char(20) not null default '',
num smallint unsigned not null default 1,
address_location char(130) not null default '',
address_name char(20) not null default '',
phone char(12) not null default '',
qq char(12) not null default '',
add_time int unsigned not null default 0,
status tinyint not null default 0,
unique key(switch_sn),
key(user_id),
key(raply_id)
)engine=myisam charset=utf8;
-- 状态：0、等待对方同意，1、对方同意，2、对方拒绝，3、已完成

-- 私信
create table letters(
letter_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
raply_id int unsigned not null default 0,
raply_name char(20) not null default '',
content varchar(100) not null default '',
add_time int unsigned not null default 0,
is_read tinyint(1) unsigned not null default 0,
key(user_id),
key(raply_id),
key(is_read)
)engine=myisam charset=utf8;

-- insert into letters values(null, 5, 'aaaaaa', 4, 'kaituo', '私信1', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信2', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信3', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信4', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信4', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信5', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信6', 1460348298, 0),(null, 5, 'aaaaaa', 4, 'kaituo', '私信7', 1460348298, 0);

-- 系统通知
create table messages(
message_id int unsigned primary key auto_increment not null,
title char(20) not null default '',
user_id int unsigned not null default 0,
user_name char(20) not null default '',
content varchar(100) not null default '',
add_time int unsigned not null default 0,
is_read tinyint(1) unsigned not null default 0,
type tinyint(1) unsigned not null default 0,
url varchar(100) not null default '',
key(user_id),
key(is_read),
key(type)
)engine=myisam charset=utf8;
-- type，1：系统消息，2：订单消息
-- insert into messages values(null, '订单消息1', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息2', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息3', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息4', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息5', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息6', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息7', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 0, 2, 'http://www.baidu.com'),(null, '订单消息8', 5, 'aaaaaa', '您的账号于2016年04月11日 09:45:43登录，如非本人操作，请尽快修改登录密码', 1460360116, 1, 2, 'http://www.baidu.com');

-- 收货地址表
create table addresss(
address_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
address_name char(20) not null default '',
address_location char(130) not null default '',
phone char(12) not null default '',
qq char(12) not null default '',
is_default tinyint(1) unsigned not null default 0,
key(user_id)
)engine=myisam charset=utf8;

-- insert into addresss values(null, 5, '默认', '广州工贸', '234234242', '34234234', 0),(null, 5, '默认', '广州工贸', '234234242', '34234234', 0),(null, 5, '默认', '广州工贸', '234234242', '34234234', 0),(null, 5, '默认', '广州工贸', '234234242', '34234234', 0),(null, 5, '默认', '广州工贸', '234234242', '34234234', 0);

-- 分类表
create table categorys(
cat_id smallint unsigned primary key auto_increment not null,
cat_name char(6) not null default '',
cat_desc char(30) not null default '',
grade smallint unsigned not null default 0,
add_time int unsigned not null default 0,
is_show tinyint(1) unsigned not null default 0
)engine=myisam charset=utf8;

insert into categorys values(null, '文具', '文具描述', 16, 1459484036, 1),(null, '图书', '图书描述', 15, 1459484036, 1),(null, '化妆品', '化妆品描述', 14, 1459484036, 1),(null, '服饰', '服饰描述', 13, 1459484036, 1),(null, '箱包', '箱包描述', 12, 1459484036, 1),(null, '鞋靴', '鞋靴描述', 11, 1459484036, 1),(null, '运动户外', '运动户外描述', 10, 1459484036, 1),(null, '生活用品', '生活用品描述', 9, 1459484036, 1),(null, '电子用品', '电子用品描述', 8, 1459484036, 1),(null, '虚拟物品', '虚拟物品描述', 7, 1459484036, 1),(null, '礼品卡卷', '礼品卡卷', 6, 1459484036, 1),(null, '食品', '食品描述', 5, 1459484036, 1),(null, '特产', '特产描述', 4, 1459484036, 1),(null, '五金', '五金描述', 3, 1459484036, 1),(null, '乐器', '乐器描述', 2, 1459484036, 1),(null, '其它', '其它描述', 1, 1459484036, 1);

-- 友情链接表
-- create table links(
-- link_id smallint unsigned primary key auto_increment not null,
-- link_name char(10) not null default '',
-- url char(100) not null default '',
-- link_desc char(30) not null default '',
-- grade smallint unsigned not null default 0,
-- add_time int unsigned not null default 0,
-- is_show tinyint(1) unsigned not null default 0,
-- is_delete tinyint(1) unsigned not null default 0,
-- key(link_name)
-- )engine=myisam charset=utf8;

-- insert into links values(null, '谷歌', 'http://www.google.com', '谷歌', 1, 1459484512, 1, 0),(null, '亚马逊', 'http://www.z.cn', '亚马逊', 2, 1459484512, 1, 0),(null, '京东', 'http://www.jd.com', '京东', 3, 1459484512, 1, 0),(null, '百度', 'http://www.baidu.com', '百度', 4, 1459484512, 1, 1),(null, '淘宝', 'http://www.taobao.com', '淘宝', 5, 1459484512, 1, 1),(null, '腾讯', 'http://www.qq.com', '腾讯', 6, 1459484512, 1, 1);

-- 角色表
create table roles(
role_id smallint unsigned primary key auto_increment not null,
role_name char(10) not null default '',
is_root tinyint(1) unsigned not null default 0,
login_bg tinyint(1) unsigned not null default 0,
comment_manage tinyint(1) unsigned not null default 0,
good_getlist tinyint(1) unsigned not null default 0,
good_add tinyint(1) unsigned not null default 0,
good_edit tinyint(1) unsigned not null default 0,
good_onsale tinyint(1) unsigned not null default 0,
good_promote tinyint(1) unsigned not null default 0,
good_check tinyint(1) unsigned not null default 0,
good_lift tinyint(1) unsigned not null default 0,
good_delete tinyint(1) unsigned not null default 0,
category_manage tinyint(1) unsigned not null default 0,
user_getlist tinyint(1) unsigned not null default 0,
user_getnotreal tinyint(1) unsigned not null default 0,
user_add tinyint(1) unsigned not null default 0,
user_edit tinyint(1) unsigned not null default 0,
user_check tinyint(1) unsigned not null default 0,
user_real tinyint(1) unsigned not null default 0,
user_seal tinyint(1) unsigned not null default 0,
user_delete tinyint(1) unsigned not null default 0,
role_manage tinyint(1) unsigned not null default 0,
order_manage tinyint(1) unsigned not null default 0,
system_manage tinyint(1) unsigned not null default 0,
bug_manage tinyint(1) unsigned not null default 0
)engine=myisam charset=utf8;

insert into roles values(null, 'root', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),(null, '普通用户', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- 订单信息表
create table order_infos(
order_id int unsigned primary key auto_increment not null,
order_sn char(15) not null default '',
user_id int unsigned not null default 0,
user_name char(20) not null default '',
seller_id int unsigned not null default 0,
seller_name char(20) not null default '',
total_price  decimal(8,2) not null default 00000.00,
address_location char(130) not null default '',
address_name char(20) not null default '',
phone char(12) not null default '',
qq char(12) not null default '',
add_time int unsigned not null default 0,
unique key(order_sn),
status tinyint not null default 0,
key(user_id),
key(seller_id)
)engine=innodb charset=utf8;
-- status，0：未完成，1：已完成
-- INSERT INTO `order_infos` (`address_name`,`address_location`,`phone`,`qq`,`user_id`,`user_name`,`status`,`seller_name`,`seller_id`,`order_sn`,`total_price`,`add_time`) VALUES ('默','广州工贸','234234242','34234234','5','aaaaaa','1','root','3','G20160411081276','135','1460334170')

-- 订单商品表
create table order_goods(
id int unsigned primary key auto_increment not null,
good_id int unsigned not null default 0,
order_id int unsigned not null default 0,
price decimal(7,2) not null default 00000.00,
num smallint unsigned not null default 1,
key(order_id)
)engine=innodb charset=utf8;

-- 图片表
create table images(
image_id smallint unsigned primary key auto_increment not null,
good_id int unsigned not null default 0,
user_id int unsigned not null default 0,
save_path char(80) not null default '',
key(good_id),
key(user_id)
)engine=myisam charset=utf8;

-- insert into images values(null, 1, '/Public/Img/2.jpg'),(null, 2, '/Public/Img/2.jpg'),(null, 3, '/Public/Img/2.jpg'),(null, 4, '/Public/Img/2.jpg'),(null, 5, '/Public/Img/2.jpg'),(null, 6, '/Public/Img/2.jpg'),(null, 1, '/Public/Img/2.jpg'),(null, 7, '/Public/Img/2.jpg'),(null, 8, '/Public/Img/2.jpg'),(null, 1, '/Public/Img/2.jpg'),(null, 9, '/Public/Img/2.jpg');

-- 邮箱验证表
create table email_verify(
id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
hash char(30) not null default '',
fail_time int unsigned not null default 0,
type tinyint unsigned not null default 0
)engine=myisam charset=utf8;
-- 0、用户验证，1、忘记密码，2、修改邮箱

-- 实名验证表
create table reals(
real_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
real_name varchar(20) not null default '',
real_number varchar(18) not null default '',
real_location varchar(50) not null default '',
add_time int unsigned not null default 0,
phone char(12) not null default '',
qq char(12) not null default '',
is_full tinyint(1) unsigned not null default 0,
key(user_id)
)engine=myisam charset=utf8;

-- insert into reals values(null, 1, '黄某某', '14031470119', '广州市工贸技师学院', 1460102322, '4534545345', '342344423', 1),(null, 1, '黄某某', '14031470119', '广州市工贸技师学院', 1460102322, '4534545345', '342344423', 1),(null, 3, '黄某某', '14031470119', '广州市工贸技师学院', 1460102322, '4534534545', '34234423', 0),(null, 4, '黄某某', '14031470119', '广州市工贸技师学院', 1460102322, '4534534545', '32344423', 0);

-- 用户表
create table users(
user_id int unsigned primary key auto_increment not null,
role_id smallint unsigned not null default 2,
user_name char(20) not null default '',
password char(60) not null default '',
email char(30) not null default '',
add_time int unsigned not null default 0,
seal_stop int unsigned not null default 0,
sales_num int unsigned not null default 0,
is_seal tinyint(1) unsigned not null default 0,
is_check tinyint(1) unsigned not null default 0,
is_delete tinyint(1) unsigned not null default 0,
is_real tinyint(1) unsigned not null default 0,
unique key(user_name),
key(role_id)
)engine=myisam charset=utf8;


-- insert into users values(null, 2, 'herskere', 'herskere', '$2y$10$/55ycv7usO1aNwOH5S8jFODoTgPAsXXhxqmmTAtfOuUOBHNhMHtMK', '791395186@qq.com', 1459424269, 1459424269, 0, 7, '34343434234', '3434334234', '你好，世界', 0, 1, 1, 1),(null, 3, 'hookidea', 'hookidea', '$2y$10$BL4PvvdIyV4OwCZK/m2KL.jciUs6QlMVgecLvm2c1nMvsBb4mGBbK', '791395186@qq.com', 1459424269, 1459424269, 0, 6, '34343434234', '3434334234', '你好，世界', 0, 1, 0, 1),(null, 1,'root', 'root', '$2y$10$/55ycv7usO1aNwOH5S8jFODoTgPAsXXhxqmmTAtfOuUOBHNhMHtMK', '791395186@qq.com', 1459424269, 1459424269, 0, 3, '34343434234', '3434334234', '你好，世界', 0, 1, 0, 1),(null, 2, 'kaituo', 'kaituo', '$2y$10$/55ycv7usO1aNwOH5S8jFODoTgPAsXXhxqmmTAtfOuUOBHNhMHtMK', '791395186@qq.com', 1459424269, 1459424269, 0, 6, '34343434234', '3434334234', '你好，世界', 0, 0, 0, 0);


-- 评论表
create table comments(
comment_id int unsigned primary key auto_increment not null,
good_id int(10) unsigned not null default '0',
beg_id int(10) unsigned not null default '0',
lost_id int(10) unsigned not null default '0',
user_name char(20) not null default '',
user_id int(10) unsigned not null default '0',
raply_name char(20) not null default '',
raply_id int(10) unsigned not null default '0',
content char(100) not null default '',
add_time int(10) unsigned not null default '0',
key(good_id),
key(beg_id),
key(lost_id),
key(user_id)
) engine=myisam default charset=utf8;

-- 商品收藏表
create table collect_goods(
collect_id int unsigned primary key auto_increment not null,
good_id int unsigned not null default 0,
user_id int unsigned not null default 0,
add_time int unsigned not null default 0,
shop_price decimal(7,2) not null default 00000.00,
key(good_id),
key(user_id)
)engine=myisam charset=utf8;


-- 失物招领表
create table losts(
lost_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
lost_title char(60) not null default '',
lost_desc varchar(150) not null default '',
qq char(12) not null default '',
phone char(12) not null default '',
add_time int unsigned not null default 0,
is_full tinyint(1) unsigned not null default 0,
key(user_id),
key(is_full)
)engine=myisam charset=utf8;

-- insert into losts values(null, 1, 'herskere', '[失物]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', '791397199', '', 1460029294, 0),(null, 1, 'herskere', '[求购]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', '791397199', '', 1460029294, 0),(null, 1, 'herskere', '[求购]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', '791397199', '', 1460029294, 0),(null, 1, 'herskere', '[求购]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', '791397199', '', 1460029294, 0),(null, 1, 'herskere', '[求购]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', '791397199', '', 1460029294, 0),(null, 4, 'herskere', '[求购]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', '791397199', '', 1460029294, 0);


-- 求购表
create table begs(
beg_id int unsigned primary key auto_increment not null,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
beg_title char(60) not null default '',
beg_desc varchar(150) not null default '',
price decimal(7,2) unsigned not null default 0.00,
qq char(12) not null default '',
phone char(12) not null default '',
address varchar(130) not null default '',
add_time int unsigned not null default 0,
update_time int unsigned not null default 0,
stop_time int unsigned not null default 0,
is_full tinyint(1) unsigned not null default 0,
key(user_id),
key(is_full)
)engine=myisam charset=utf8;

-- insert into begs values(null, 1, 'herskere', '[求购]求个iphone5或者iphone5c', '我想给我ne5或者iphone5c用用,电池续航和信号好就行.支持移动2g或者4g。', 222, '791397199', '', '广州工贸', 1460029294, 0, 1460099999, 0);

-- 举报商品表
create table lifts(
lift_id int unsigned primary key auto_increment not null,
good_id int unsigned not null default 0,
user_id int unsigned not null default 0,
user_name char(20) not null default '',
add_time int unsigned not null default 0,
key(user_id),
key(good_id)
)engine=myisam charset=utf8;

-- 商品表
create table goods(
good_id int unsigned primary key auto_increment not null,
cat_id smallint unsigned not null default 0,
good_sn char(15) not null default '',
good_name char(60) not null default '',
user_id int unsigned not null default 0,
user_name char(20) not null default '',
shop_price decimal(7,2) unsigned not null default 0.00,
promote_price decimal(7,2) unsigned not null default 0.00,
good_desc varchar(150) not null default '',
good_number smallint unsigned not null default 1,
collect_num int unsigned not null default 0,
thumb_img char(70) not null default '',
qq char(12) not null default '',
phone char(12) not null default '',
add_time int unsigned not null default 0,
is_new tinyint(1) unsigned not null default 1,
is_delete tinyint(1) unsigned not null default 0,
is_check tinyint(1) unsigned not null default 0,
is_on_sale tinyint(1) unsigned not null default 1,
is_chaffer tinyint(1) unsigned not null default 0,
is_promote tinyint(1) unsigned not null default 0,
is_lift tinyint(1) unsigned not null default 0,
is_switch tinyint(1) unsigned not null default 0,
keywords varchar(30) not null default '',
address varchar(130) not null default '',
switch varchar(30) not null default '',
sales_num mediumint unsigned not null default 0,
key(cat_id),
key(good_sn),
key(user_id),
key(user_name),
key(is_delete),
key(is_on_sale)
)engine=myisam charset=utf8;


-- insert into goods values(null, 14, 'DZD000000000001', '测试', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上(联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1),(null, 9, 'DZD000000000002', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486381, 0, 0, 1, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 16),(null, 9, 'DZD000000000003', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486381, 1, 0, 0, 1, 0, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 21),(null, 9, 'DZD000000000004', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486381, 1, 0, 1, 0, 0, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 11),(null, 9, 'DZD000000000005', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 13),(null, 9, 'DZD000000000006', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459186381, 1459486381, 0, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 145),(null, 9, 'DZD000000000007', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459482381, 1459486381, 1, 0, 0, 1, 0, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 341),(null, 9, 'DZD000000000008', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486381, 1, 0, 1, 1, 1, 0, 1, 1,'手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 341),(null, 9, 'DZD000000000009', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 10, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1451186381, 1459486381, 1, 1, 1, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 3341),(null, 9, 'DZD000000000010', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459386381, 1459486381, 1, 0, 1, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 143),(null, 9, 'DZD000000000011', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 160, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459286381, 1459486381, 1, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 3431),(null, 9, 'DZD000000000012', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459483381, 1459486381, 1, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 34351),(null, 9, 'DZD000000000013', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459481381, 1459486381, 1, 1, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1),(null, 9, 'DZD000000000014', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 500, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459482381, 1459486381, 1, 0, 1, 1, 1, 1, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 5451),(null, 9, 'DZD000000000015', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 1, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 10, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486351, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 3421),(null, 9, 'DZD000000000016', 'MacbookPro 13寸 12年版', 1, 'herskere', 350, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 10, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486311, 1459486381, 1, 0, 1, 1, 0, 0, 1, 1, '数码 手机 电脑', '广东省广州市白云区机场路2636号', '鞋子', 4531),(null, 9, 'DZD000000000017', 'MacbookPro 13寸 12年版', 1, 'herskere', 30, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486321, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 二手', '广东省广州市白云区机场路2636号', '鞋子', 1345),(null, 9, 'DZD000000000018', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486281, 1459486381, 0, 0, 1, 0, 1, 0, 1, 1, '数码 手机', '广东省广州市白云区机场路2636号', '鞋子', 1353),(null, 9, 'DZD000000000019', 'MacbookPro 13寸 12年版', 1, 'herskere', 350, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459485381, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1),(null, 9, 'DZD000000000020', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459482381, 1459486381, 0, 1, 1, 1, 1, 0, 1, 1, '数码 手机 二手', '广东省广州市白云区机场路2636号', '鞋子', 1353),(null, 9, 'DZD000000000021', 'MacbookPro 13寸 12年版', 1, 'herskere', 3, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486181, 1459486381, 1, 0, 0, 1, 0, 0, 1, 1, '数码  二手', '广东省广州市白云区机场路2636号', '鞋子', 4531),(null, 9, 'DZD000000000022', 'MacbookPro 13寸 12年版', 1, 'herskere', 35, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 80, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1453486381, 1459486381, 1, 0, 1, 0, 0, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 145),(null, 9, 'DZD000000000023', 'MacbookPro 13寸 12年版', 1, 'herskere', 30, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1453486381, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 451),(null, 9, 'DZD000000000024', 'MacbookPro 13寸 12年版', 1, 'herskere', 35200, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459485381, 1459486381, 0, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1),(null, 9, 'DZD000000000025', 'MacbookPro 13寸 12年版', 1, 'herskere', 3530, 0, '12年暑假买的mbp，可小手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1453486381, 1459486381, 1, 0, 0, 1, 0, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1),(null, 9, 'DZD000000000026', 'MacbookPro 13寸 12年版', 1, 'herskere', 3580, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486384, 1459486381, 1, 0, 1, 1, 1, 0, 1, 1, '手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 153),(null, 9, 'DZD000000000027', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459489381, 1459486381, 1, 0, 1, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 35341),(null, 9, 'DZD000000000028', 'MacbookPro 13寸 12年版', 1, 'herskere', 300, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上(联系我的时候，请说的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486391, 1, 1, 1, 1, 1, 0, 1, 1, '数码 电脑 二手', '广东省广州市白云区机场路6号', '鞋子', 1),(null, 9, 'DZD000000000029', 'MacbookPro 13寸 12年版', 1, 'herskere', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459488381, 1459486381, 1, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1242),(null, 9, 'DZD000000000030', 'MacbookPro 13寸 12年版', 2, 'hookidea', 300, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 13, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459496381, 1459486381, 1, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 43531),(null, 9, 'DZD000000000031', 'MacbookPro 13寸 12年版', 2, 'hookidea', 300, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459476381, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 3531),(null, 9, 'DZD000000000032', 'MacbookPro 13寸 12年版', 2, 'hookidea', 300, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459496381, 1459486381, 1, 0, 1, 1, 1, 1, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 535),(null, 9, 'DZD000000000033', 'MacbookPro 13寸 12年版', 2, 'hookidea', 35030, 1, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 1, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1457486381, 1459486381, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手 电子产品', '广东省广州市白云区机场路2636号', '鞋子', 14543),(null, 9, 'DZD000000000034', 'MacbookPro 13寸 12年版', 2, 'hookidea', 3500, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486387, 1, 0, 1, 1, 0, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 153),(null, 9, 'DZD000000000035', 'MacbookPro 13寸 12年版', 2, 'hookidea', 300, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 100, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486389, 1, 0, 0, 1, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 1),(null, 9, 'DZD000000000036', 'MacbookPro 13寸 12年版', 2, 'hookidea', 350, 0, '12年暑假买的mbp，可小刀。有点划痕。内部无损，可以正常使用。图之后上
-- (联系我的时候，请说明是在校园二手街看见的噢！)', 20, 3, '/Uploads/Images/Good/2016/04/13/550_955169.png', '7788991122', '13800138000', 1459486381, 1459486386, 0, 0, 1, 0, 1, 0, 1, 1, '数码 手机 电脑 二手', '广东省广州市白云区机场路2636号', '鞋子', 13534);
