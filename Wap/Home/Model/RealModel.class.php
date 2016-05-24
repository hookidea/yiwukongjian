<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   拓少
 * @Last Modified time: 2016-04-11 14:48:21
 */
namespace Home\Model;
use Think\Model\RelationModel;

class RealModel extends RelationModel{

    protected $tableName = 'reals';

    protected $_validate = array(
        array('user_id', 'number', '用户ID为空/非法', 1),
        array('real_name', '1,20', '姓名长度必须在1 - 20个字符', 1, 'length'),
        array('real_number', '1,18', '号码必须是1 - 18位整数！', 1, 'length'),
        array('real_location', '1,50', '地址必须是1 - 50个字符！', 1, 'length'),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('is_full', '0,1', '完成状态选择错误！', 2, 'in'),
        array('is_edit', '0,1', '编辑状态选择错误！', 2, 'in'),
    );

    protected $_link = array(
        'User' => array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'    => 'User',
            'foreign_key'   => 'user_id',    // 关联字段
            'mapping_name'  => 'data',
                    ),
                     );
}