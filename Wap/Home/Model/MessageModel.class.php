<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-11 19:34:25
 */
namespace Home\Model;
use Think\Model;

class MessageModel extends Model{

    protected $tableName = 'messages';

    protected $_validate = array(
        array('user_id', 'number', '用户ID为空/非法', 1),
        array('user_name', '1,20', '用户名长度必须在1 - 20字符间', 1, 'length'),
        array('title', '1,20', '消息标题必须在1 - 20字符间！', 1, 'length'),
        array('content', '1,100', '内容长度必须在1 - 100字符间', 1, 'length'),
        array('type', 'number', '消息类型选择错误！', 1),
        array('is_read', '0,1', '消息阅读状态选择错误！', 2, 'in'),
    );
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );
}