<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-18 22:05:16
 */
namespace Home\Model;
use Think\Model\RelationModel;

class BegModel extends RelationModel{

    protected $tableName = 'begs';

    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
        array('update_time', 'time', 2, 'function'),
    );

    protected $_validate = array(
        array('beg_title', '1,60', '名称/标题长度必须要在1-60个字符之间', 1, 'length'),
        array('beg_desc', '1,150', '描述长度必须要在1-150个字符之间', 1, 'length'),
        array('user_id', 'number', '发布人ID为空/非法', 1),
        array('user_name', '1,20', '发布人用户名必须要在1-20个字符之间', 1, 'length'),
        array('price', '0,99999', '价格必须是0.00-99999.00之间', 0, 'between'),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('address', '1,150', '商品名长度必须要在1-150个字符之间', 1, 'length'),
        array('stop_time', 'number', '求购结束时间为空/格式错误', 1),
        array('is_full', '0,1', '完成状态选择非法！', 2, in),
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证
    // protected $_link = array(
    //     // 'Image' => array(
    //     //     'mapping_type'  => self::HAS_ONE,
    //     //     'class_name'    => 'Image',
    //     //     'foreign_key'   => 'user_id',    // 关联字段
    //     //     'mapping_name'  => 'data',
    //     //     'as_fields'=> 'save_path',
    //     //              )
    //     // );
}