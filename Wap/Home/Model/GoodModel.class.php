<?php

/**
 * @Author: hookidea
 * @Role:
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-05-01 14:50:09
 */
namespace Home\Model;
use Think\Model\RelationModel;

class GoodModel extends RelationModel{

    protected $tableName = 'goods';

    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    protected $_validate = array(
        array('cat_id', '0', '商品必须要有其所属分类', 1, 'notequal'),
        array('cat_id', 'number', '分类选择为空/非法', 1),
        array('good_sn', '', '商品SN号不唯一', 1, 'unique', 1),
        array('good_sn', '1,15', '商品SN号长度必须在1-15个字符内', 1, 'length'),
        array('good_name', '1,60', '商品名长度必须要在1-60个字符之间', 1, 'length'),
        array('good_desc', '1,150', '商品描述长度必须要在1-150个字符之间', 1, 'length'),
        array('user_id', 'number', '用户ID为空/非法', 1),
        array('user_name', '1,20', '用户名长度必须要在1-20个字符之间', 1, 'length'),
        array('shop_price', '0,99999', '价格必须在0.00-99999.00之间', 2, 'between'),
        array('promote_price', '0,99999', '促销价格必须在0.00-99999.00之间', 2, 'between'),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('keywords', '1,30', '商品关键字必须要在1-30个字符之间', 2, 'length'),
        array('is_new', '0,1', '新品/二手选择非法！', 2, in),
        array('is_delete', '0,1', '删除状态选择非法！', 2, in),
        array('is_on_sale', '0,1', '上架状态选择非法！', 2, in),
        array('is_check', '0,1', '审核状态选择非法！', 2, in),
        array('is_chaffer', '0,1', '可刀/不可刀状态选择非法！', 222, in),
        array('is_promote', '0,1', '促销状态选择非法！', 2, in),
        array('is_lift', '0,1', '举报状态选择非法！', 2, in),
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证
    protected $_link = array(
        'Comment' => array(
            'mapping_type'  => self::HAS_MANY,
            'class_name'    => 'Comment',
            'foreign_key'   => 'good_id',    // 关联字段
            'mapping_name'  => 'data',
            'mapping_fields'=> 'good_id,user_id,user_name,raply_id,raply_name,content,add_time',
                     )
        );
}
