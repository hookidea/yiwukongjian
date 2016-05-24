<?php
namespace Home\Controller;

use Think\Controller;

class OrderController extends Controller
{
    private $_data = []; // 用来保存发送信息需要的数据

    protected function _initialize ()
    {
        if (!session('user')) { // 指定允许的操作
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到登陆界面...', '/User/login', 2);
            }
        }
    }

    /**
     * 查看订单
     */
    public function showOrder ()
    {
        $pagesize = C('ORDER_PAGE_NUM');

        $order = D('Order');
        $user_id = session('user.user_id');

        $page = new \Org\Util\Page($pagesize, false);

        if (($keyword = I('get.keyword'))) {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'orders');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $order_ids = array_keys($result['matches']);
            $orderList = $order->where(['order_id' => ['in', $order_ids]])->select();

        } else {
            if (!($order_id = I('get.order_id'))) { // 没有指定订单ID

                if (I('get.type')) { // 查看卖家订单，默认是买家订单
                    $this->notFull = $order->where(['seller_id' => $user_id])->count();
                    $order->where(['seller_id' => $user_id]);
                } else { // 买家订单
                    $this->notFull = $order->where(['user_id' => $user_id])->count();
                    $order->where(['user_id' => $user_id]);
                }

                $order = $this->_switchType($order, I('get.timeType'));  // 查看指定时间的订单


                $orderList = $order->order('status asc,add_time desc')->select();

            } else { // 指定订单ID
                $orderList = $order->where(['order_id' => $order_id])->select();
            }

            $order_ids = [];

            for ($i=0, $len=count($orderList); $i<$len; $i++) {
                $order_ids[] = $orderList[$i]['order_id'];
            }
        }

        $goodList = [];
        for ($i=0, $len=count($order_ids); $i<$len; $i++) {
            $goodList[] = $order->query('select g.good_id,g.num,s.thumb_img,s.good_name from (select good_id,num from order_goods where order_id=' . $order_ids[$i] . ') as g left join goods as s on g.good_id=s.good_id');
        }

        $this->page = $page->show($orderList);
        $this->goodList = $goodList;
        $this->orderList = $orderList;
        $this->display();
    }

    private function _switchType ($order, $timeType)
    {
        switch ($timeType) {
            case 1: // 3个月内
                $order->where(['add_time' => ['gt', strtotime('-3 month')]]);
                break;
            case 2: // 今年内
                $order->where(['add_time' => ['gt', mktime(0, 0, 0, 1, 1, date('Y'))]]);
                break;
            case 3: // 去年内
                $order->where(['add_time' => ['between', [mktime(0, 0, 0, 1, 1, date('Y')-1), mktime(0, 0, 0, 12, 31, date('Y')-1)]]]);
                break;
            case 4: // 前年内
                $order->where(['add_time' => ['between', [mktime(0, 0, 0, 1, 1, date('Y')-2), mktime(0, 0, 0, 12, 31, date('Y')-2)]]]);
                break;
            case 5: // 大前年内
                $order->where(['add_time' => ['between', [mktime(0, 0, 0, 1, 1, date('Y')-3), mktime(0, 0, 0, 12, 31, date('Y')-3)]]]);
                break;
            case 6: // 大前年之前的
                $order->where(['add_time' => ['lt', mktime(0, 0, 0, 1, 1, date('Y')-3)]]);
                break;
            default: // 默认3个月内
                $order->where(['add_time' => ['gt', strtotime('-3 month')]]);
                break;

        }
        return $order;
    }


    /**
     * 修改订单的状态为已完成
     */
    public function fullOrder ()
    {
        $order_id = I('post.order_id');
        $order = D('Order');

        if (empty($order_id))  $this->ajaxReturn(['status'=>2, 'info'=>'没有提供要完成的订单ID']);

        $user_id = $order->where(['order_id' => $order_id])->getField('user_id');
        if ($user_id != session('user.user_id')) $this->ajaxReturn(['status'=>2, 'info'=>'非法操作！']);

        if (D('Order')->where(['order_id' => $order_id])->save(['status' => 1])) {
            $this->ajaxReturn(['status'=>1, 'info'=>'订单状态修改成功']);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'订单状态修改失败']);
        }
    }


}
