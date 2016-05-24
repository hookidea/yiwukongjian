<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-16 11:27:24
 */
namespace Home\Model;
use Think\Model;

class OrderModel extends Model{

    protected $tableName = 'order_infos';

    protected $_validate = array(
        array('order_sn', '', '订单SN号不唯一', 1, 'unique', 1),
        array('order_sn', '1,15', '订单SN号长度必须在1-15个字符内', 1, 'length'),
        array('user_id', 'number', '买家ID为空/格式错误', 1),
        array('user_name', '1,20', '买家用户名长度必须在1 - 20个字符之间', 1, 'length'),
        array('seller_id', 'number', '卖家ID格式为空/错误', 1),
        array('seller_name', '1,20', '卖家用户名长度必须在1 - 20个字符之间', 1, 'length'),
        array('address_location', '1,130', '收货地址长度必须在1 - 130个字符之间', 1, 'length'),
        array('address_name', '1,20', '收货人姓名长度必须在1 - 20个字符之间', 1, 'length'),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('total_price', 'is_numeric','订单金额为空/格式错误', 1, 'function'), 
        array('status', 'number', '订单状态为空/格式错误', 1),
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

}