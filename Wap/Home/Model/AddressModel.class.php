<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-12 21:52:30
 */
namespace Home\Model;
use Think\Model;

class AddressModel extends Model{

    protected $tableName = 'addresss';

    protected $_validate = array(
        array('user_id', 'number', '用户ID为空/格式错误', 1, null, 1),
        array('address_name', '1,20', '收货人姓名长度必须要在1-20个字符之间', 1, 'length'),
        array('address_location', '1,130', '收货地址长度必须要在1-130个字符之间', 1, 'length'),
        array('qq', '1,12', 'QQ号码格式不正确', 2, 'length'),
        array('phone', '1,12', '手机号码格式不正确', 2, 'length'),
        array('is_default', '0,1', '举报状态选择非法！', 2, in),
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证

}