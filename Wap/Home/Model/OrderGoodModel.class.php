<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-11 19:26:16
 */
namespace Home\Model;
use Think\Model;

class OrderGoodModel extends Model{

    protected $tableName = 'order_goods';

    protected $_validate = array(
        array('good_id', 'number', '商品ID格式为空/错误', 0),
        array('order_id', 'number', '订单ID格式为空/错误', 0),
        array('num', 'number', '购买的商品数量格式为空/错误', 0),
        array('price', 'is_numeric', '商品价格格式为空/错误', 0, 'function'), 
    );
}