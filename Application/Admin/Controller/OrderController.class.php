<?php
namespace Admin\Controller;

use Think\Controller;

class OrderController extends Controller
{
    protected function _initialize ()
    {
        if (!session('user.order_manage')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'您没有权限执行此操作！']);
            } else {
                $this->error('您没有权限执行此操作！', null, 1);
            }
        }
    }

    public function getList ()
    {

        $pagesize = C('ADMIN_PAGESIZE');

        $keyword = I('get.keyword');
        $keyword = $keyword ? $keyword : I('get.keyword');

        $orderModel = D('Order');

        if (!I('get.p')) $_GET['p'] = 1;

        if (IS_POST && !$keyword) $this->error('请输入你要搜索的关键字！', null, 1);

        $page = new \Org\Util\Page($pagesize);

        $sort = I('get.sort');

        // 使用MySQL进行排序，实时，效率低，消耗高
        if (in_array($sort, ['total_price', 'order_id', 'add_time', 'status']) || ((empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword)) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $list = $orderModel->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else { // 使用Sphinx进行排序，效率高，消耗低
            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'orders');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $list = $orderModel->where(['order_id'=>['in', $in]])->select();
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    /**
     * 查看订单
     */
    public function showOrder ()
    {
        $pagesize = C('GOOD_PAGE_NUM');

        $order = D('Order');
        $user_id = session('user.user_id');
        $order_id = I('get.order_id');

        $orderList = $order->where(['order_id' => $order_id])->select();


        $order_ids = [];

        for ($i=0, $len=count($orderList); $i<$len; $i++) {
            $order_ids[] = $orderList[$i]['order_id'];
        }

        $goodList = [];
        for ($i=0, $len=count($order_ids); $i<$len; $i++) {
            $goodList[] = $order->query('select g.good_id,g.num,s.thumb_img,s.good_name from (select good_id,num from order_goods where order_id=' . $order_ids[$i] . ') as g left join goods as s on g.good_id=s.good_id');
        }

        $this->goodList = $goodList;
        $this->orderList = $orderList;
        $this->display();
    }

}
