<?php
namespace Home\Controller;

use Think\Controller;

class SwitchController extends Controller
{
    protected function _initialize ()
    {
        if (!session('user')) { // 指定允许的操作
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 1);
            }
        }
    }

    public function match ()
    {
        $keyword = I('get.good_name');
        $pagesize = 4;

        $good = D('Good');

        $sphinx = new \Org\Util\Sphinx;


        $sphinx->setFilter('is_delete', [0]);
        $sphinx->setFilter('is_switch', [1]);
        $sphinx->setFilter('is_on_sale', [1]);
        $sphinx->SetFilterRange('good_number', 1, 99999);
        $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);

        if (!$keyword) { // 非AJAX

            $good_id = I('get.good_id');

            $user_id = session('user.user_id');


            if ($good_id) { // 指明了要拿去交换的商品,即从商品详情入口进入

                $raplyGood = D('Good')->where(['good_id' => $good_id, 'is_delete' => 0, 'is_on_sale' => 1])->field('good_number,thumb_img,good_name,shop_price,promote_price,is_promote,good_id,user_name,is_switch,user_id,switch')->find();

                if ($raplyGood['user_id'] === $user_id) {
                    $this->error('不能够与自己发布的商品做交换！', null, 1);
                }
                if (!$raplyGood['is_switch']) {
                    $this->error('该商品不支持换购！', null, 1);
                }
                if ($raplyGood['good_number'] < 1) {
                    $this->error('该商品库存不足已完成交换！', null, 1);
                }

                $sphinx->setFilter('user_id', [$user_id]);

                $good_ids = [];
                $total = 0;

                // 匹配商品名称
                $result = $sphinx->query($raplyGood['good_name'], 'goods');
                $total += $result['total'];
                if ($total > 0) $good_ids = array_merge($good_ids, array_keys($result['matches']));

                // 匹配“我的交换”信息
                $result = $sphinx->query($raplyGood['switch'], 'goods');

                if (isset($result['matches'])) {
                    $total += $result['total'];
                    $good_ids = array_merge($good_ids, array_keys($result['matches']));
                }

                if ($good_ids) {
                    $where = ['good_id' => ['in', $good_ids]];
                } else {
                    $this->info = '提示：无法匹配到最佳结果，已显示为您的所有商品';
                    $where = ['user_id' => $user_id, 'is_switch' => 1, 'is_delete' => 0, 'is_on_sale' => 1, 'good_number' => ['gt', 0]];
                    $good->limit($pagesize*(I('get.p', 1)-1) . ',' . $pagesize);
                }

                $userList = $good->where($where)->select();

                $this->raplyGood = $raplyGood;

            } else { // 从桌面按钮入口进入

                $userList = D('Good')->where(['user_id' => $user_id, 'is_switch' => 1, 'is_delete' => 0, 'is_on_sale' => 1, 'good_number' => ['gt', 0]])->order('add_time desc')->select();
            }

            $this->userList = $userList;
            $this->display();

        } else { // AJAX

            $price = I('get.price');
            $float = I('get.float') ? I('get.float') : 30;
            if (I('get.keyword')) $keyword = I('get.keyword'); // 输入了关键字


            if (!$keyword || !$price) { // 没有输入关键字
                $this->ajaxReturn(['status' => 2, 'info' => '没有选择要匹配的商品', 'href' => false]);
            }

            $price_start = $price - $float < 0 ? 0 : $price - $float;
            $price_end = $price + $float;

            $sphinx->SetFilterFloatRange('shop_price', $price_start, $price_end);
            $sphinx->SetFilterRange('good_number', 1, 99999);
            $sphinx->SetFilter('user_id', [session('user.user_id')], true); // 拒绝匹配的
            $sphinx->SetFilter('is_switch', [1]);
            $result = $sphinx->query($keyword, 'goods');

            if ($result['total'] < 1) { // 没有匹配到结果
                $this->ajaxReturn(['status' => 2, 'info' => '抱歉，没有匹配到符合条件的商品，尝试修改一下关键字/价格浮动范围？', 'href' => false, 'time' => 900]);
            }

            $good_ids = array_keys($result['matches']);

            $raplyList = $good->where(['good_id' => ['in', $good_ids]])->select();

            $str = '';
            for ($i=0, $len=count($raplyList); $i<$len; $i++) {
                $price = $raplyList[$i]['is_promote'] ? $raplyList[$i]['promote_price'] : $raplyList[$i]['shop_price'];
                $str .= '<li _user_id="' . $raplyList[$i]['user_id'] . '" _user_name="' . $raplyList[$i]['user_name'] . '"  _good_id="' . $raplyList[$i]['good_id'] . '">
                    <img src="' . $raplyList[$i]['thumb_img'] . '" alt="' . $raplyList[$i]['good_name'] . '">
                    <div class="desc">
                        <a href="/' . $raplyList[$i]['good_id'] . '.html"><div class="good_name">' . $raplyList[$i]['good_name'] . '</div></a>
                        <div class="rmb-matches">￥' . $price . '</div>
                    </div></li>';
            }

            $this->ajaxReturn(['status' => 1, 'info' => '获取匹配成功', 'content' => $str]);
        }
    }

    public function create ()
    {
        $_POST['switch_sn'] = $this->createSN();

        // 其他数据的验证交给模型自动验证
        if (!$_POST['phone'] && !$_POST['qq']) {
            $this->ajaxReturn(['status'=>2, 'info'=>'联系方式不能为空！']);
        }
        $_POST['user_id'] = session('user.user_id');
        $_POST['user_name'] = session('user.user_name');

        $list = D('Good')->field('is_on_sale,is_check,good_name,good_number')->where(['good_id' => ['in', [I('post.user_good_id'), I('post.raply_good_id')]]])->select();

        if (($rs = $this->_createCheckGood($list, I('post.num'))) !== true) $this->ajaxReturn($rs);

        $switch = D('Switch');

        if ($switch->create()) {

            if ($result = $switch->add()) {
                $_POST['switch_id'] = $result;
                R('Message/addSwitchMess', [$_POST]);
                $this->ajaxReturn(['status' => 1, 'info' => '商品交换请求提交成功，等待对方的同意！', 'href' => '/Switch/showSwitch/switch_id/' . $result]);
            } else {
                $this->ajaxReturn(['status' => 2, 'info' => '商品交换请求提交失败！']);
            }

        } else {
            $this->ajaxReturn(['status' => 2, 'info' => $switch->getError()]);
        }

    }

    /**
     * 负责回滚事物并返回结果给客户端
     */
    private function _rollback ($switch, $msg='交换失败，请刷新页面后再试！') 
    {
        $switch->rollback();
        $switch->ajaxReturn(['status'=>2, 'info'=> $msg]);
    }

    /**
     * 交换结算界面
     */
    public function accounts ()
    {
        $user_id = session('user.user_id');
        $post = I('post.');
        $raply_id = $post['raply_id'];
        $raply_name = $post['raply_name'];
        $raply_good_id = $post['raply_good_id'];
        $user_good_id = $post['user_good_id'];
        $num = $post['num'] + 0;
        $good = D('Good');

        $goodList = $good->field('user_id,good_name,user_name,shop_price,promote_price,good_number,is_check,is_promote,good_id,thumb_img,is_on_sale')->where(['good_id' => ['in', [$user_good_id, $raply_good_id]]])->select();
        // 注意：MySQL的in查询不是说"in(1, 2)"，返回的数据就是(1,2)排序的，MySQL会自动排序返回的

        if (($rs = $this->_createCheckGood($goodList, I('post.num'))) !== true) $this->error($rs['info']);

        $this->num = $num;
        $this->userGood = $goodList[0]['user_id'] == $user_id ? $goodList[0] : $goodList[1];
        $this->raplyGood = $goodList[0]['user_id'] != $user_id ? $goodList[0] : $goodList[1];
        $this->addressList = A('Address')->getAddress();

        $this->display();
    }

    /**
     * 创建一个交换商品SN
     * @param  [type] $good [description]
     * @return [type]       [description]
     */
    private function createSN ()
    {
        $switch = D('Switch');
        do{
            $switch_sn = 'S' . date('YmdH') . rand(1111, 9999);
        }while($switch->where(['switch_sn' => $switch_sn])->count());
        return $switch_sn;
    }

    /**
     * 查看交换订单
     */
    public function showSwitch ()
    {
        $pagesize = C('ORDER_PAGE_NUM');

        $switch = D('Switch');

        $user_id = session('user.user_id');

        $page = new \Org\Util\Page($pagesize, false);

        if (($keyword = I('get.keyword'))) {

            $sphinx = new \Org\Util\Sphinx;
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'switchs');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $switch_ids = array_keys($result['matches']);
            $switchList = $switch->where(['switch_id' => ['in', $switch_ids]])->select();

        } else {
            if (!($switch_id = I('get.switch_id'))) {

                if (I('get.type')) { // 查看被动交换
                    $this->notFull = $switch->where(['raply_id' => $user_id, 'status' => ['in', [0, 1]]])->count();
                    $switch->where(['raply_id' => $user_id]);
                } else { // 主动交换
                    $this->notFull = $switch->where(['user_id' => $user_id, 'status' => ['in', [0, 1]]])->count();
                    $switch->where(['user_id' => $user_id]);
                }

                $status = I('get.status') ? 1 : 0; // 0：未完成，1：已完成
                $switch->where(['status' => $status]);

                $switch = $this->_switchType($switch, I('get.timeType'));  // 查看指定时间的交换
                $switchList = $switch->order('status asc,add_time desc')->select();

            } else {
                $switchList = $switch->where(['switch_id' => $switch_id])->select();
            }
        }

        $good = D('Good');

        $goodList = [];

        for ($i=0, $len=count($switchList); $i<$len; $i++) {
            $tmp = $good->where(['good_id' => ['in', [$switchList[$i]['user_good_id'], $switchList[$i]['raply_good_id']]]])->select();
            if ($switchList[$i]['user_good_id'] > $switchList[$i]['raply_good_id']) {
                $goodList[] = array_reverse($tmp);
            } else {
                $goodList[] = $tmp;
            }

        }

        $this->page = $page->show($switchList);
        $this->goodList = $goodList;
        $this->switchList = $switchList;
        $this->display();
    }

    /**
     * 更新交换状态
     */
    public function changeSwitchStatus ()
    {
        $switch_id = I('post.switch_id');
        $status = I('post.status'); // 状态：0、等待对方同意，1、对方同意，2、对方拒绝，3、已完成
        if (empty($switch_id))  $this->ajaxReturn(['status'=>2, 'info'=>'没有提供要完成的交换编号ID']);
        $user_id = session('user.user_id');

        $switch = D('Switch');
        $row = $switch->where(['switch_id' => $switch_id])->find();

        switch ($status) {
            case 1: // 同意
                if ($user_id != $row['raply_id']) $this->ajaxReturn(['status'=>2, 'info'=>'操作非法！']);

                if (($rs = $this->_agreeCheckGood($switch_id)) !== true) $this->ajaxReturn($rs);

                // 更新status
                if (!$switch->where(['switch_id' => $switch_id])->save(['status' => 1])) {
                    $this->ajaxReturn(['status'=>2, 'info'=>'同意失败！']);
                }

                // 问题：订单是下了，但库存不一定就有，不能保证库存的有效性和准确性
                if (!A('Good')->delNumber([$row['user_good_id'], $row['raply_good_id']], $row['num'])) {
                    // 扣除库存执行失败
                    $switch->ajaxReturn(['status'=>2, 'info'=> '同意失败，请刷新页面后再试！']);
                }

                break;
            case 2: // 拒绝
                if ($user_id != $row['raply_id']) $this->ajaxReturn(['status'=>2, 'info'=>'操作非法！']);

                if (!$switch->where(['switch_id' => $switch_id])->save(['status' => 2])) {
                    $this->ajaxReturn(['status'=>2, 'info'=>'操作失败！']);
                }
                break;
            case 3: // 完成
                if ($user_id != $row['user_id']) $this->ajaxReturn(['status'=>2, 'info'=>'操作非法！']);

                if (!$switch->where(['switch_id' => $switch_id])->save(['status' => 3])) {
                    $this->ajaxReturn(['status'=>2, 'info'=>'操作失败！']);
                }
                break;
        }
        $row['status'] = $status;
        A('Message/addSwitchStatusMess', [$row]);
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    /**
     * 同意交换时的检查
     * @param  [type] $switch_id [description]
     * @return [type]            [description]
     */
    private function _agreeCheckGood ($switch_id)
    {
        $info = D('Switch')->where(['switch_id' => $switch_id])->find();
        $goodList = D('Good')->field('user_id,good_name,is_check,good_number,is_on_sale')->where(['good_id' => ['in', [$info['user_good_id'], $info['raply_good_id']]]])->select();
        if (($rs = $this->_createCheckGood($goodList, $info['num'])) !== true) $this->ajaxReturn($rs);
        return true;
    }

    /**
     * 结束 + 下单时的检查
     * @return [type] [description]
     * if (($rs = $this->_createCheckGood($list, I('post.num'))) !== true) $this->ajaxReturn($rs);
     */
    private function _createCheckGood ($list, $num)
    {
        $on = C('CHECK_ISSUE_GOOD');
        $user_id = session('user.user_id');

        if ($list[0]['user_id'] == $user_id && $list[1]['user_id'] == $user_id) return ['status' => 2, 'info' => '抱歉，您所交换的商品　' . mb_substr($list[$i]['good_name'], 0, 15, 'UTF-8') . '...　是您自己的商品'];

        for ($i=0, $len=count($list); $i<$len; $i++) {

            if ($on && 1 != $list[$i]['is_check']) return ['status' => 2, 'info' => '抱歉，您所交换的商品　' . mb_substr($list[$i]['good_name'], 0, 15, 'UTF-8') . '...　未经审核，暂时不能被交换'];

            if ($list[$i]['good_number'] < $num) return ['status' => 2, 'info' => '抱歉，您所交换的商品　' . mb_substr($list[$i]['good_name'], 0, 15, 'UTF-8') . '...　库存不足'];

            if (1 != $list[$i]['is_on_sale']) return ['status' => 2, 'info' => '抱歉，您所交换的商品　' . mb_substr($list[$i]['good_name'], 0, 15, 'UTF-8') . '...　未上架'];
        }
        return true;
    }

    /**
     * 修改订单的状态为已完成
     */
    public function fullSwitch ()
    {
        $switch_id = I('post.switch_id');
        if (empty($switch_id))  $this->ajaxReturn(['status'=>2, 'info'=>'没有指明要完成的交换订单']);

        $switch = D('Switch');

        $user_id = $switch->where(['switch_id' => $switch_id])->getField('user_id');
        if ($user_id != session('user.user_id')) $this->ajaxReturn(['status'=>2, 'info'=>'非法操作！']);

        if ($switch->where(['switch_id' => $switch_id])->save(['status' => 1])) {
            $this->ajaxReturn(['status'=>1, 'info'=>'状态修改成功']);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'状态修改失败']);
        }
    }

    private function _switchType ($switch, $timeType)
    {
        switch ($timeType) {
            case 1: // 3个月内
                $switch->where(['add_time' => ['gt', strtotime('-3 month')]]);
                break;
            case 2: // 今年内
                $switch->where(['add_time' => ['gt', mktime(0, 0, 0, 1, 1, date('Y'))]]);
                break;
            case 3: // 去年内
                $switch->where(['add_time' => ['between', [mktime(0, 0, 0, 1, 1, date('Y')-1), mktime(0, 0, 0, 12, 31, date('Y')-1)]]]);
                break;
            case 4: // 前年内
                $switch->where(['add_time' => ['between', [mktime(0, 0, 0, 1, 1, date('Y')-2), mktime(0, 0, 0, 12, 31, date('Y')-2)]]]);
                break;
            case 5: // 大前年内
                $switch->where(['add_time' => ['between', [mktime(0, 0, 0, 1, 1, date('Y')-3), mktime(0, 0, 0, 12, 31, date('Y')-3)]]]);
                break;
            case 6: // 大前年之前的
                $switch->where(['add_time' => ['lt', mktime(0, 0, 0, 1, 1, date('Y')-3)]]);
                break;
            default: // 默认3个月内
                $switch->where(['add_time' => ['gt', strtotime('-3 month')]]);
                break;

        }
        return $switch;
    }

}
