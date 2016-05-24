<?php

/**
 * @Author: hookidea
 * @Role:
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-30 12:35:27
 */
namespace Home\Model;
use Think\Model\RelationModel;

class CollectModel extends RelationModel{

    protected $tableName = 'collect_goods';

    protected $_validate = array(
        array('user_id', 'number', '用户ID为空/非法', 1),
        array('shop_price', '0,99999', '价格必须在0.00-99999.00之间', 1, 'between'),
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证
    protected $_link = array(
        'Good' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Good',
            'foreign_key'   => 'good_id',    // 关联字段
            'mapping_name'  => 'data',
            'mapping_fields'=> 'good_name,thumb_img',
                    ),

        );

    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

}
