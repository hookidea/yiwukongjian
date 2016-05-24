<?php

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 13:45:22
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-01 16:10:48
 */
namespace Admin\Model;
use Think\Model;

class CategoryModel extends Model{

    protected $tableName = 'categorys';

    protected $_validate = array(
        array('cat_name','1,6','角色名必须在 1 - 6 字符间！', 0, 'length'),
        array('cat_desc','1,30','分类描述必须在 1 - 30 字符间！', 0, 'length'),
        array('grade','1,32767','显示排名必须是数字，且在 1 - 32767 之间！', 0, 'between'),
    );
}