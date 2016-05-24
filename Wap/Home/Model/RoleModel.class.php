<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   拓少
 * @Last Modified time: 2016-04-11 14:37:58
 */
namespace Home\Model;
use Think\Model;

class RoleModel extends Model{

    protected $tableName = 'roles';

    protected $_validate = array(
        array('role_name','1,10','角色名必须在1 - 10字符间！', 0, 'length'), //默认情况下用正则进行验证
    );
}