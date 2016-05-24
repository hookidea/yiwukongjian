<?php
namespace Home\Controller;

use Think\Controller;

class CollectController extends Controller
{
    protected function _initialize ()
    {
        if (!in_array(strtolower(ACTION_NAME), ['getcollectcount']) && !session('user')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
            }
        }
    }

    /**
     * 收藏的外壳函数，支持同时单个(商品详情)/多个(购物车)收藏，取消单个/多个收藏
     */
    public function collect ()
    {
        $good_id = I('post.good_id');
        $shop_price = I('post.shop_price');
        $good_ids = I('post.selects');
        $shop_prices = I('post.shop_prices');
        $user_id = session('user.user_id');

        $collect = D('Collect');
        $good = D('Good');

        if (empty($shop_price) && empty($shop_prices)) { // 取消收藏

            if (!$good_ids) { // 取消单个收藏

                $collect->where(['good_id' => $good_id, 'user_id' => $user_id])->delete();
                $good->where(['good_id' => $good_id])->setDec('collect_num');

            } else { // 取消多个收藏

                for ($i=0, $len=count($good_ids); $i<$len; $i++) {
                    $collect->where(['good_id' => $good_ids[$i], 'user_id' => $user_id])->delete();
                    $good->where(['good_id' => $good_ids])->setDec('collect_num');
                }
            }
            $this->ajaxReturn(['status'=>1, 'info'=>'取消成功！', 'type' => 2]);

        } else {
            if (!$good_ids) { // 单个收藏

                $result = $collect->where(['good_id' => $good_id, 'user_id' => $user_id])->find();
                if (!$result) $result2 = $this->_collect($good_id, $shop_price);

            } else { // 多个收藏

                for ($i=0, $len=count($good_ids); $i<$len; $i++) {
                    $result = $collect->where(['good_id' => $good_ids[$i], 'user_id' => $user_id])->find();
                    if (!$result) $this->_collect($good_ids[$i], $shop_prices[$i]);
                }

            }

            $this->ajaxReturn(['status'=>1, 'info'=>'收藏成功', 'type' => 1]);
        }

    }

    /**
     * 通过在参数接受每一个收藏需要的，然后插入数据库
     * @param  number $good_id    商品ID
     * @param  [type] $shop_price [description]
     */
    private function _collect ($good_id, $shop_price)
    {
        $collect = D('Collect');
        $_POST['user_id'] = session('user.user_id');
        $_POST['good_id'] = $good_id;
        $_POST['shop_price'] = $shop_price;
        if ($collect->create()) {
            $collect->add();
            D('Good')->where(['good_id' => $good_id])->setInc('collect_num');
            return true;
        } else {
            return $collect->getError();
        }
    }

    /**
     * 获取一个商品被收藏的个数
     * @param  number $good_id 商品ID
     * @return [type]          [description]
     */
    public function getCollectCount ()
    {
        return D('Good')->where(['good_id' => $good_id])->getField('collect_num');
    }

    /**
     * 匹配
     */
    public function matches ()
    {
        $name = I('post.name');
        $price = I('post.price');
        $cat_id = I('post.cat_id');


    }
}
