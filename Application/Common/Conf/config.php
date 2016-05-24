<?php
return array(
	//'配置项'=>'配置值'
    //数据库配置信息
    'DB_TYPE'     => 'mysql',    // 数据库类型
    'DB_HOST'     => '127.0.0.1',// 服务器地址
    'DB_NAME'     => 'shop',     // 数据库名
    'DB_USER'     => 'root',     // 用户名
    'DB_PWD'      => 'i&mkaimi', // 密码
    'DB_PORT'     => 3306,       // 端口
    'DB_PARAMS'   => array(),    // 数据库连接参数
    'DB_PREFIX'   => '',         // 数据库表前缀
    'DB_CHARSET  '=> 'utf8',     // 字符集

    'DB_DEBUG'    =>      false,     // 数据库调试模式 开启后可以记录SQL日志
    'SHOW_PAGE_TRACE'      =>  false,
    'URL_CASE_INSENSITIVE' => false,     // 区分大小写
    'DB_FIELDS_CACHE'      => true,      // 数据库字段缓存
    'SESSION_PREFIX'       => 'shop',    // ssession前缀

    'DEFAULT_FILTER'       => 'filterFunc',

    // 数据缓存配置
    'DATA_CACHE_PREFIX'    => 'shop',     // 缓存前缀
    'DATA_CACHE_TYPE'      => 'Memcached', // 缓存类型
    'DATA_CACHE_TIME'      => 3600*24*100,// 缓存有效期
    'MEMCACHED_SERVER'      => [
        ['127.0.0.1', 11211],
    ],

    'EMAIL_ACCOUNT'        => [
            ['email' => 'parstore@163.com', 'password' => '12ecodlnpjpxbf17', 'server' => 'smtp.163.com'],
            ['email' => 'parstore@126.com', 'password' => '12ecodlnpjpxbf17', 'server' => 'smtp.126.com'],
            ['email' => 'parstore@qq.com', 'password' => 'fcchjncdzwrtdgcf', 'server' => 'smtp.qq.com'],
            // ['email' => 'parstore@yeah.net', 'password' => '12ecodlnpjpxbf17', 'server' => 'smtp.yeah.net'],
    ],

    'IMAGE_SIZE'           =>         7,     // 图片上传限制大小，MB为单位

    'HOME_REGISTER_ON'     =>               true,       //　关闭/开启注册功能
    'HOME_LOGIN_ON'        =>                            true,        //　关闭/开启登陆功能
    'CHECK_ISSUE_GOOD'     =>     false,     // 是否开启发布商品审核功能
    'REAL_ISSUE_GOOD'      => false,     // 是否开启发布商品实名功能

    'ADMIN_PAGESIZE'       =>      8,         // Admin分组一页显示的条数
    'WAP_INDEX_NUM'        =>   8,             // WAP版首页每种类型显示的个数
    'GOOD_PAGE_NUM'        =>           8,         // PC版商品一页显示条数
    'WAP_GOOD_PAGE_NUM'        =>           8,         // WAP版商品一页显示条数
    'COMMENT_PAGE_NUM'        =>           8,         // PC版商品评论一页显示条数
    'WAP_COMMENT_PAGE_NUM'        =>           8,         // WAP版商品评论一页显示条数
    'BEG_PAGE_NUM'        =>           8,         // PC版求购一页显示条数
    'WAP_BEG_PAGE_NUM'        =>           8,         // WAP版求购一页显示条数
    'LOST_PAGE_NUM'        =>           8,         // PC版招领一页显示条数
    'WAP_LOST_PAGE_NUM'        =>           8,         // WAP版招领一页显示条数
    'ORDER_PAGE_NUM'        =>           8,         // PC版订单一页显示条数
    'WAP_ORDER_PAGE_NUM'        =>           8,         // WAP版订单一页显示条数
    'MESSAGE_PAGE_NUM'     =>    30,        // PC版消息显示的条数
    'WAP_MESSAGE_PAGE_NUM'     =>    15,        // WAP版消息显示的条数
    'LETTER_PAGE_NUM'     =>    30,        // PC版私信显示的条数
    'WAP_LETTER_PAGE_NUM'      =>  15,        // WAP版私信显示的条数
    'COLLECT_PAGE_NUM'     =>    20,        // PC版收藏显示的条数
    'WAP_COLLECT_PAGE_NUM'      =>  20,        // WAP版收藏显示的条数

    'BEG_TIME'      =>  1,        // 求购有效期，单位：月
    'LOST_TIME'      =>  1,        // 招领有效期，单位：月
    'HEAD_IMG_SIZE'        =>   180,       // 用户图像裁剪大小，宽高1:1


    'TOKEN_ON' => false, // 是否开启令牌验证 默认关闭
    'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称,默认为__hash__
    'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET' => true, //令牌验证出错后是否重置令牌 默认为true

);
