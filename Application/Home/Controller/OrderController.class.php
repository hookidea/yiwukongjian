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
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
            }
        }
    }

    /**
     * 结算页面
     */
    public function accounts ()
    {
        $good_ids = I('post.selects');
        $nums = I('post.num');

        $good = D('Good');

        $goodList = A('Good')->getGood($good_ids, 'user_id,good_name,user_name,shop_price,promote_price,good_number,is_promote,good_id,thumb_img,is_on_sale,is_check');

        if (($rs = $this->_createCheckGood($goodList, $nums)) !== true)  $this->error($rs['info']);

        $tmp = $this->_getTotal($goodList, $nums); // 计算总价
        $this->total = $tmp['total'];
        $this->shop_price_total = $tmp['shop_price_total'];
        $this->sheng = $tmp['shop_price_total'] - $tmp['total'];
        $this->groupList = $this->_group($goodList, $nums);
        $this->addressList = A('Address')->getAddress();

        $this->display();
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
                    $this->notFull = $order->where(['seller_id' => $user_id, 'status' => 0])->count();
                    $order->where(['seller_id' => $user_id]);
                } else { // 买家订单
                    $this->notFull = $order->where(['user_id' => $user_id, 'status' => 0])->count();
                    $order->where(['user_id' => $user_id]);
                }

                $order = $this->_switchType($order, I('get.timeType'));  // 查看指定时间的订单

                // 0：未完成，1：全部
                if (!(I('get.status') === 1 || !isset($_GET['status']))) {
                    $order->where(['status' => 0]);
                }

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

    /**
     * 创建一个新订单
     */
    public function create ()
    {
        $good = D('Good');
        $order = D('Order');

        $good_ids = I('post.good_id');
        $nums = I('post.num');

        $goodList = $good->where(['good_id' => ['in', $good_ids]])->field('good_id,user_id,good_name,user_name,shop_price,promote_price,good_number,is_promote,is_on_sale,is_check')->select();


        if (($rs = $this->_createCheckGood($goodList, $nums)) !== true) $this->ajaxReturn($rs);

        $info_data = [];  // 用来保存要插入order_infos表的数据
        $good_data = [];  // 用来保存要插入order_goods表的数据

        $info_data['address_name'] = I('post.address_name');
        $info_data['address_location'] = I('post.address_location');
        $info_data['phone'] = I('post.phone');
        $info_data['qq'] = I('post.qq');
        $info_data['user_id'] = session('user.user_id');
        $info_data['user_name'] = session('user.user_name');
        $info_data['status'] = 0;

        // 其他数据的验证交给模型自动验证
        if (!$info_data['phone'] && !$info_data['qq']) {
            $this->ajaxReturn(['status'=>2, 'info'=>'联系方式不能为空！']);
        }

        $groupList = $this->_group($goodList, $nums);

        $order->startTrans(); // 开启事物

        foreach ($groupList as $k=>$v) { // 插入多个商户的商品
            // 如果某一个订单处理出错，则内部会事物回滚并 ajax 返回失败结果给客户端
            $this->_insertOne($order, $v, $info_data); // 插入单个商户的商品
        }

        $order->commit(); // 执行到这里说明处理成功，则提交事物

        R('Cart/delCart', [$good_ids]); // 从购物车删除已被购买的商品
        R('Message/addOrderMess', [$this->_data]); // 发送订单消息

        $this->ajaxReturn(['status'=>1, 'info'=>'订单提交成功！', 'href'=>'/Order/showOrder']);

    }

    /**
     * 订单插入成功之后，减少库存
     */
    private function _delNumber ($good_id, $num)
    {
        $good = D('Good');
        if (!$good->where(['good_id' => $good_id])->setDec('good_number', $num)) {
            return false;
        }
        return true;
    }

    /**
     * 负责插入一个订单
     */
    private function _insertOne ($order, $one, $info_data)
    {
        $good_ids = array_keys($one);
        $info_data['seller_name'] = $one[$good_ids[0]]['user_name'];
        $info_data['seller_id'] = $one[$good_ids[0]]['user_id'];
        $info_data['order_sn'] = $this->_createSN();
        $info_data['total_price'] = $this->_getOneTotal($one);
        $info_data['add_time'] = time();

        $id = $this->_insertOrder($info_data); // 插入订单基本信息
        if (!$id) { // 插入失败
            $this->_rollback($order);
        }

        $info_data['order_id'] = $id;

        for ($i=0, $len=count($good_ids); $i<$len; $i++) {
            $price = $one[$good_ids[$i]]['is_promote'] ? $one[$good_ids[$i]]['promote_price'] : $one[$good_ids[$i]]['shop_price'];
            $good_data['price'] = $price;
            $good_data['order_id'] = $id;
            $good_data['num'] = $one[$good_ids[$i]]['num'];
            $good_data['good_id'] = $good_ids[$i];

            if (!$this->_insertGood($good_data)) { // 插入订单中的商品
                $this->_rollback($order);
            }
            // 因为商品表不是innodb，所以库存问题不能保证其有效性和准确性
            if (!$this->_delNumber($good_data['good_id'], $good_data['num'])) { // 减少商品库存语句执行失败
                $this->_rollback($order);
            }
            // 1、如果在此处通过查询商品库存，看是否 <0 来判定库存是否足以完成订单，则如果在这两条SQL执行期间(删除库存 -> 查询库存)，另一个用户下单，但库存不足以完成新订单，则这个用户就无辜了，因为其扣除的库存影响了结果，这边查到是负数，则判定为失败，！这是错误的判断！
            // 2、不检查库存，会造成问题：订单是下了，但库存不一定就有，不能保证库存的有效性和准确性
            // if (D('Good')->where(['good_id' => $good_data['good_id']])->getField('good_number') < 0) {
            //     $this->_rollback($order, '订单提交失败，商品库存不足！');
            // }
        }
        $this->_data[] = $info_data;
    }

    /**
     * 负责回滚事物并返回结果给客户端
     */
    private function _rollback ($order, $msg='订单提交失败，请刷新稍后再试！') 
    {
        $order->rollback();
        $order->ajaxReturn(['status'=>2, 'info'=> $msg]);
    }

    /**
     * 把数据插入order_infos表
     */
    private function _insertOrder ($info_data)
    {
        $order = D('Order');
        if ($order->create($info_data, 1)) {
            $id = $order->add($info_data);
            if ($id > 0) {
                return $id;
            }
        }
        return false;
    }

    /**
     * 把数据插入order_goods表
     */
    private function _insertGood ($good_data)
    {
        $order_good = D('OrderGood');
        if ($order_good->create($good_data)) {
            $id = $order_good->add($good_data);
            if ($id > 0) {
                return $id;
            }
        }
        return false;
    }

    /**
     * 把结算中的商品分组
     */
    private function _group ($goodList, $nums)
    {
        $result = [];
        for ($i=0, $len=count($goodList); $i<$len; $i++) {
            $goodList[$i]['num'] = $nums[$i];
            $result[$goodList[$i]['user_id']][$goodList[$i]['good_id']] = $goodList[$i];
        }
        return $result;
    }

    /**
     * 结束 + 下单时的检查
     * @return [type] [description]
     * if (($rs = $this->_createCheckGood($list, I('post.num'))) !== true) $this->ajaxReturn($rs);
     */
    private function _createCheckGood ($list, $nums)
    {
        $on = C('CHECK_ISSUE_GOOD');
        $user_id = session('user.user_id');
        for ($i=0, $len=count($_createCheckGood); $i<$len; $i++) {

            if ($_createCheckGood[$i]['user_id'] == $user_id) return ['status' => 2, 'info' => '抱歉，您所购买的商品　' . mb_substr($_createCheckGood[$i]['good_name'], 0, 15, 'UTF-8') . '...　是您自己的商品'];

            if ($on && 1 != $_createCheckGood[$i]['is_check']) return ['status' => 2, 'info' => '抱歉，您所购买的商品　' . mb_substr($_createCheckGood[$i]['good_name'], 0, 15, 'UTF-8') . '...　未经审核，暂时不能被购买'];

            if ($_createCheckGood[$i]['good_number'] < $nums[$i]) return ['status' => 2, 'info' => '抱歉，您所购买的商品　' . mb_substr($_createCheckGood[$i]['good_name'], 0, 15, 'UTF-8') . '...　库存不足'];

            if (1 != $_createCheckGood[$i]['is_on_sale']) return ['status' => 2, 'info' => '抱歉，您所购买的商品　' . mb_substr($_createCheckGood[$i]['good_name'], 0, 15, 'UTF-8') . '...　未上架'];
        }
        return true;
    }


    /**
     * 获取订单中一个商户商品的总金额
     */
    private function _getOneTotal ($goodList)
    {
        $total = 0;
        foreach ($goodList as $k=>$v) {
            $price = $v['is_promote'] ? $v['promote_price'] : $v['shop_price'];
            $total += $price * $v['num'];
        }
        return $total;
    }

    /**
     * 结算页面的获取总金额
     * @param  [type] $goodList [description]
     * @param  [type] $nums     [description]
     * @return [type]           [description]
     */
    private function _getTotal ($goodList, $nums)
    {
        $total = 0;
        $shop_price_total = 0;
        for ($i=0, $len=count($goodList); $i<$len; $i++) {
            $shop_price_total += $goodList[$i]['shop_price'] * $nums[$i];
            $price = $goodList[$i]['is_promote'] ? $goodList[$i]['promote_price'] : $goodList[$i]['shop_price'];
            $total += $price * $nums[$i];
        }
        return ['total' => $total, 'shop_price_total' => $shop_price_total];
    }

    /**
     * 创建一个商品SN
     * @param  [type] $good [description]
     * @return [type]       [description]
     */
    private function _createSN ()
    {
        $order = D('Order');
        do{
            $order_sn = 'O' . date('YmdH') . rand(1111, 9999);
        }while($order->where(['order_sn' => $order_sn])->count());
        return $order_sn;
    }


}
