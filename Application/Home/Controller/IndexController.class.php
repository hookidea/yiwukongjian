<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index ()
    {
        $good = D('Good');
        $category = D('Category');

        switch (I('get.sort')) {
            case '1':
                $sort = 'sales_num';  // 销量
                break;
            default:
                $sort = 'add_time';  // 销量
                break;
        }

        $order = I('get.order');
        if(!$order) $order = 'desc';

        $where = ['is_delete'=>0, 'is_on_sale'=>1, 'good_number' => ['gt', 0]];
        if (C('CHECK_ISSUE_GOOD')) $where['is_check'] = 1;

        $page = new \Org\Util\Page(C('GOOD_PAGE_NUM'), false);

        $list = $good->where($where)->limit($page->limit)->order($sort . ' ' . $order)->select();

        $this->cateList = $category->order('grade desc')->select();
        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function article()
    {
        $this->display();
    }

}
