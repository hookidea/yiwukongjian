<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-18 22:05:21
 */
namespace Home\Model;
use Think\Model\RelationModel;

class LostModel extends RelationModel{

    protected $tableName = 'losts';

    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    protected $_validate = array(
        array('lost_title', '1,60', '标题长度必须要在1-60个字符之间', 1, 'length'),
        array('lost_desc', '1,150', '描述长度必须要在1-150个字符之间', 1, 'length'),
        array('user_id', 'number', '发布人ID为空/非法', 1),
        array('user_name', '1,20', '发布者用户名长度必须要在1-20个字符之间', 1, 'length'),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('is_full', '0,1', '招领完成状态选择非法！', 2, in),
    );

    // protected $_link = array(
    //     'Image' => array(
    //         'mapping_type'  => self::HAS_ONE,
    //         'class_name'    => 'Image',
    //         'foreign_key'   => 'user_id',    // 关联字段
    //         'mapping_name'  => 'data',
    //         'as_fields'=> 'save_path',
    //                  )
    //     );
}