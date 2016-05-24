<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-14 07:15:15
 */
namespace Home\Model;
use Think\Model;

class LetterModel extends Model{

    protected $tableName = 'letters';

    protected $_validate = array(
        array('user_id', 'number', '用户ID为空/非法', 1),
        array('user_name', '1,20', '用户名不能为空且长度必须在1 - 20字符间', 1, 'length'),
        array('raply_id', 'number', '私信必须要有被回复者ID/非法', 1),
        array('raply_name', '1,100', '私信必须要有被回复者NAME', 1, 'length'),
        array('content', '1,100', '私信内容不能为空且长度必须在1 - 100字符间', 1, 'length'),
        array('is_read', '0,1', '私信阅读状态选择错误！', 2, 'in'),
    );
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );
}