<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-03 21:02:46
 */
namespace Admin\Model;
use Think\Model\RelationModel;

class RealModel extends RelationModel{

    protected $tableName = 'reals';

    protected $_validate = array(
        array('real_name', '1,20', '实名名称必须在 1 - 20 个字符！', 1, 'length'),
        array('real_number', 'number', '实名号码必须是 1 - 18 位整数！', 1),
        array('real_number', '1,18', '实名号码必须是 1 - 18 位整数!!！', 1, 'length'),
        array('real_location', '1,50', '实名地址必须是 1 - 50 个字符！', 1, 'length'),
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