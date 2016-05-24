<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-17 20:21:53
 */
namespace Home\Model;
use Think\Model\RelationModel;

class CommentModel extends RelationModel{

    protected $tableName = 'comments';

    protected $_validate = array(
        array('beg_id', 'number', 'beg_id字段值为空/非法', 2),
        array('good_id', 'number', 'good_id字段值为空/非法', 2),
        array('lost_id', 'number', 'lost_id字段值为空/非法', 2),
        array('user_id', 'number', '评论必须要有回复者ID', 2),
        array('user_name', '1,100', '评论必须要有回复者NAME', 2, 'length'),
        array('raply_id', 'number', '评论必须要有被回复者ID/非法', 2),
        array('raply_name', '1,100', '评论必须要有被回复者NAME', 2, 'length'),
        array('content', '1,100', '评论长度必须在1 - 100字符间！', 1, 'length'),
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证
    protected $_link = array(
        'Beg' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Image',
            'foreign_key'   => 'user_id',    // 关联字段
            'mapping_name'  => 'data',
            'as_fields'=> 'save_path',
                    ),
                     );

    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );
}