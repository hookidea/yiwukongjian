<?php

/**
 * @Author: hookidea
 * @Role:
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-05-01 13:30:19
 */
namespace Home\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel{

    protected $tableName = 'users';

    protected $_validate = array(
        array('role_id', 'number', '角色ID选择错误', 2, 'length'),
        array('user_name', '1,20', '用户名必须是4—11位的英文字母或数字', 1, 'length', 1),
        array('user_name', '', '用户名已存在！', 1, 'unique', 1),
        array('user_name', '/^\w*$/i', '用户名必须是4—11位的英文字母或数字', 1, 'regex', 1),
        array('password', '6,20', '密码长度必须在6 - 20字符间', 1, 'length', 1),  // 新增时
        array('password', '6,20', '密码长度必须在6 - 20字符间', 2, 'length', 2),  // 修改时不为空
        array('repassword', 'password', '两次密码输入不一致', 1, 'confirm', 1),   // 新增时
        array('repassword', 'password', '两次密码输入不一致', 2, 'confirm', 2),   // 修改时不为空
        array('email', 'email', '邮箱格式不正确！', 1, null, 1),
        array('seal_stop', 'number', '封号结束时间必须为时间戳', 2),
        array('is_check', '0,1', '邮箱验证状态选择错误！', 2, 'in'),
        array('is_delete', '0,1', '删除状态选择错误！', 2, 'in'),
        array('is_seal', '0,1', '封号状态选择错误！', 2, 'in'),
        array('is_real', '0,1', '实名状态选择错误！', 2, 'in'),
    );

    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    protected $_link = array(
        'Role' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Role',
            'foreign_key'   => 'role_id',    // 关联字段
            'mapping_name'  => 'role',
                    ),
        'Real' => array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'Real',
            'foreign_key'   => 'user_id',    // 关联字段
            'mapping_name'  => 'real',
                    ),
                     );
}
