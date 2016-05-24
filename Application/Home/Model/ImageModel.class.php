<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-17 11:03:15
 */
namespace Home\Model;
use Think\Model\RelationModel;

class ImageModel extends RelationModel{

    protected $tableName = 'images';

    protected $_validate = array(
    );
    // 0 存在字段就验证(默认), 1 必须验证, 2 值不为空的时候验证
    protected $_link = array(
                     );

    protected $_auto = array(
    );
}