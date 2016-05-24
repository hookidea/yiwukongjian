<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-01 15:05:37
 */
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model{

    protected $tableName = 'roles';

    protected $_validate = array(
        array('role_name','1,10','角色名必须在 1 - 10 字符间！', 0, 'length'), //默认情况下用正则进行验证
    );
}