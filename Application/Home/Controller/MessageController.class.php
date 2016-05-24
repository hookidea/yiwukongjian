<?php
namespace Home\Controller;

use Think\Controller;

class MessageController extends Controller
{
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
     * 查看消息
     */
    public function showMessage ()
    {
        // 1：系统消息，2：订单消息，3：商品交换
        $type = I('get.type');
        if (!$type) $type =  1;
        $message = D('Message');

        $page = new \Org\Util\Page(C('MESSAGE_PAGE_NUM'), false);

        $list = $message->where(['user_id' => session('user.user_id'), 'type' => $type])->order('is_read asc,add_time desc')->limit($page->limit)->select();

        // 必须提前，不然会多出一个被设置为已读
        $this->page = $page->show($list);
        $this->list = $list;
        if (!empty($list)) $this->_setRead($list);

        $this->notReadLetter = R('Letter/getNotReadLetter');
        $this->notReadOrderInfo = $this->getNotReadOrderInfo();
        $this->notReadSystemInfo = $this->getNotReadSystemInfo();
        $this->notReadSwitchInfo = $this->getNotReadSwitchInfo();
        $this->notReadCommentInfo = $this->getNotReadCommentInfo();
        $this->display();
    }

    /**
     * 分析，得到要设置为已读的ID值，并把他们全部设为已读
     */
    private function _setRead ($list)
    {
        $ids = [];
        for ($i=0, $len=count($list); $i<$len; $i++) {
            $ids[] = $list[$i]['message_id'];
        }
        D('Message')->where(['message_id' => ['in', $ids]])->save(['is_read' => 1]);
    }

    /**
     * 获取未读私信的总数
     * @return number     未读私信的总数
     */
    public function getNotReadSwitchInfo ()
    {
        return D('Message')->where(['user_id' => session('user.user_id'), 'type' => 3, 'is_read' => 0])->count();
    }


    /**
     * 获取系统消息的未读数量
     * @return number 系统信息的未读数量
     */
    public function getNotReadSystemInfo ()
    {
        return D('Message')->where(['user_id' => session('user.user_id'), 'type' => 1, 'is_read' => 0])->count();
    }

    /**
     * 获取订单消息的未读数量
     * @return number 订单信息的未读数量
     */
    public function getNotReadOrderInfo ()
    {
        return D('Message')->where(['user_id' => session('user.user_id'), 'type' => 2, 'is_read' => 0])->count();
    }

    /**
     * 获取回复消息的未读数量
     * @return number 订单信息的未读数量
     */
    public function getNotReadCommentInfo ()
    {
        return D('Message')->where(['user_id' => session('user.user_id'), 'type' => 5, 'is_read' => 0])->count();
    }

    public function addCommentMess ($data)
    {
        $insert['title'] = '回复提醒';
        $insert['type'] = 5;
        $insert['add_time'] = time();

        if ($data['raply_id']) {
            $msg = '评论';
            $insert['user_id'] = $data['raply_id'];
            $insert['user_name'] = $data['raply_name'];
        } else {
            if (isset($data['good_id'])) {
                $insert['user_id'] = $data['good_user_id'];
                $insert['user_name'] = $data['good_user_name'];
                $msg = '商品';
            } elseif (isset($data['beg_id'])) {
                $insert['user_id'] = $data['beg_user_id'];
                $insert['user_name'] = $data['beg_user_name'];
                $msg = '求购';
            } elseif (isset($data['lost_id'])) {
                $insert['user_id'] = $data['lost_user_id'];
                $insert['user_name'] = $data['lost_user_name'];
                $msg = '招领';
            }
        }

        $insert['content'] = '用户 “ <b> ' . $data['user_name'] . ' </b> ” 对您的' . $msg . '回复了，立即去看看？';

        if (isset($data['good_id'])) {
            $insert['url'] = '/Good/showGood/good_id/' . $data['good_id'];
        } elseif (isset($data['beg_id'])) {
            $insert['url'] = '/Beg/getList/beg_id/' . $data['beg_id'];
        } elseif (isset($data['lost_id'])) {
            $insert['url'] = '/Lost/getList/lost_id/' . $data['lost_id'];
        }

        $message = D('Message');
        $message->add($insert);
    }

    /**
     * 发送交换消息
     */
    public function addSwitchMess ($data)
    {
        $base['title'] = '商品交换提醒';
        $base['type'] = 3;
        $base['add_time'] = time();
        if (!isset($data)) $data['status'] = 0;
        $one = $two = $base;

        switch ($data['status']) {
            case 0:
                $one['content'] = '用户 “ <b> ' . $data['user_name'] . ' </b> ” 申请与您的商品<b>' . $data['raply_good_name'] . '</b>做商品交换，立即去看看？';
                $two['content'] = '您的商品交换申请提交成功，我们已经通知对方，请耐心等待对方处理！';
                break;
            case 1:
                $one['content'] = '您已同意用户 “ <b>' . $data['user_name'] . '</b> ” 与您的商品<b>' . $data['raply_good_name'] . '</b>做商品交换！';
                $two['content'] = '您的商品交换申请已被对方同意，请尽快与对方联系，商量商品对接问题！';
                break;
            case 2:
                $one['content'] = '您已拒绝用户 “ <b>' . $data['user_name'] . '</b> ” 与您的商品<b>' . $data['raply_good_name'] . '</b>做商品交换！';
                $two['content'] = '您的商品交换申请已被对方拒绝！';
                break;
            case 3:
                $one['content'] = '您的交换 “ <b>' . $data['switch_sn'] . '</b> ” 已完成！';
                $two['content'] = '您的交换 “ <b>' . $data['switch_sn'] . '</b> ” 已完成！';
                break;
        }

        $one['user_id'] = $data['raply_id'];
        $one['user_name'] = $data['raply_name'];
        $one['url'] = '/Switch/showSwitch/type/1/switch_id/' . $data['switch_id'];

        $two['user_id'] = $data['user_id'];
        $two['user_name'] = $data['user_name'];
        $two['url'] = '/Switch/showSwitch/type/0/switch_id/' . $data['switch_id'];

        $insert[] = $one;
        $insert[] = $two;

        $message = D('Message');
        $message->addAll($insert);
    }

    /**
     * 发送订单消息
     */
    public function addOrderMess ($data)
    {
        $message = D('Message');

        $base['user_id'] = $data[0]['user_id'];
        $base['user_name'] = $data[0]['user_name'];
        $base['type'] = 2;
        $base['title'] = '订单提醒';
        $base['add_time'] = time();
        $base['url'] = '/Order/showOrder/order_id/' . $data[0]['order_id'];

        for ($i=0, $len=count($data); $i<$len; $i++) {
            $one = $two = $base;
            $one['user_id'] = $data[0]['user_id'];
            $one['user_name'] = $data[0]['user_name'];
            $one['title'] = '下单提醒';
            $two['title'] = '商品被购买提醒';
            $two['user_id'] = $data[0]['seller_id'];
            $two['user_name'] = $data[0]['seller_name'];

            $one['content'] = '您于' . date('Y-m-d H:i:s', $data[$i]['add_time']) . '提交了新订单，订单总金额为￥' . $data[$i]['total_price'] . '元';
            $two['content'] = '您的商品于' . date('Y-m-d H:i:s', $data[$i]['add_time']) . '被用户'.$data[0]['user_name'].'所购买，订单总金额为￥' . $data[$i]['total_price'] . '元';
            $insert[] = $one;
            $insert[] = $two;
            $message->addAll($insert);
        }

    }

}
