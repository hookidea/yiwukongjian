<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-25 18:05:09
 */
namespace Admin\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel{

    protected $tableName = 'users';

    protected $_validate = array(
        array('user_name', '4,20', '用户名长度必须在 4 - 20 字符之间！', 0, 'length'),
        array('user_name', '', '用户名已存在！', 0, 'unique', 1),
        array('password', '6,20', '密码长度必须在 6 - 20 字符间！', 0, 'length', 1),  // 新增时
        array('password', '6,20', '密码长度必须在 6 - 20 字符间！', 2, 'length', 2),  // 修改时不为空
        array('repassword', 'password', '两次密码输入不一致！', 0, 'confirm', 1),     // 新增时
        array('repassword', 'password', '两次密码输入不一致！', 2, 'confirm', 2),     // 修改时不为空
        array('email', 'email', '邮箱格式不正确！', 2),
        array('seal_stop', 'number', '封号时间必须为时间戳', 2),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('intro', '1,50', '个人简介长度必须在1 - 50字符之间', 2, 'length'),
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
            'as_fields'     => 'role_name',
                    ),
        'Real' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Real',
            'foreign_key'   => 'user_id',    // 关联字段
            'mapping_name'  => 'data',
                    ),
                     );
}