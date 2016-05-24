<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-04 09:05:44
 */
namespace Admin\Model;
use Think\Model\RelationModel;

class CommentModel extends RelationModel{

    protected $tableName = 'comments';

    protected $_validate = array(
        // array('role_name','1,10','角色名必须在 1 - 10 字符间！', 0, 'length'), //默认情况下用正则进行验证
    );

    protected $_link = array(
        'Good' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Good',
            'foreign_key'   => 'good_id',    // 关联字段
            'mapping_name'  => 'data',
            'mapping_fields'=> 'good_name',
                    ),
                     );
}