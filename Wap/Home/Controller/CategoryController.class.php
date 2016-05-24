<?php
namespace Home\Controller;

use Think\Controller;

class CategoryController extends Controller
{
    public function getList ()
    {
        $list = D('Category')->field('cat_id,cat_name')->where(['is_show' => 1])->order('grade desc')->select();
        $this->list = $list;
        $this->display();
    }

    
}