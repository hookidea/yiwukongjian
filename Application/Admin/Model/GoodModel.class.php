<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-05 18:44:01
 */
namespace Admin\Model;
use Think\Model\RelationModel;

class GoodModel extends RelationModel{

    protected $tableName = 'goods';

    protected $_validate = array(
        array('role_name','1,10','角色名必须在 1 - 10 字符间！', 0, 'length'), //默认情况下用正则进行验证
    );

    protected $_link = array(
        'Category' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Category',
            'foreign_key'   => 'cat_id',    // 关联字段
            'mapping_name'  => 'data',
            'mapping_fields'=> 'cat_id,cat_name',
                    ),
        'Comment' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Comment',
            'foreign_key'   => 'good_id',    // 关联字段
            'mapping_name'  => 'data',
            'mapping_fields'=> 'user_id,user_name,raply_id,raply_name,content,add_time',
                     )
        );
}