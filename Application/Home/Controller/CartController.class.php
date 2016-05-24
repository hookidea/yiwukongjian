<?php
namespace Home\Controller;

use Think\Controller;

class CartController extends Controller
{
    public function showCart()
    {
        $cart = session('cart');
        if ($result = $this->getTotal()) {
            $this->result = $result;
        }
        $this->display();
    }

    public function getTotalNum ()
    {
        $cart = session('cart');

        return count($cart);
    }

    /**
     * Ajax获取购物车商品总价
     * @return float  购物车商品总价
     */
    public function getAjaxTotal ()
    {
        $get = I('get.');
        $selects = $get['selects'];
        $good_ids = $get['good_ids'];
        $nums = $get['num'];
        $shop_prices = $get['shop_prices'];
        $promote_prices = $get['promote_prices'];
        $is_promotes = $get['is_promotes'];
        // print_r($get);
        $total = 0;
        $shop_price_total = 0;
        for ($i=0, $len=count($selects); $i<$len; $i++) {
            $key = array_search($selects[$i], $good_ids);

            $price = 1 == $is_promotes[$key] ? $promote_prices[$key] : $shop_prices[$key];
            $shop_price_total += $shop_prices[$key] * $nums[$key];
            $total += $nums[$key] * $price;

        }
        // 节省的钱
        $sheng = $shop_price_total - $total;

        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！', 'total' => $total, 'sheng' => $sheng]);
    }

    /**
     * 获取购物车商品总价
     * @return float  购物车商品总价
     */
    public function getTotal ()
    {
        $cart = session('cart');
        if (empty($cart)) return false;

        $in = array_keys($cart);
        $list = D('Good')->where(['good_id' => ['in', $in]])->select();

        $total = 0;
        $shop_price_total = 0;
        for ($i=0, $len=count($list); $i<$len; $i++) {
            $good_id = $list[$i]['good_id'];
            $shop_price = $list[$i]['shop_price'];
            $promote_price = $list[$i]['promote_price'];
            $num = $cart[$good_id];
            $shop_price_total += $shop_price * $num;
            $price = $list[$i]['is_promote'] > 0 ? $promote_price : $shop_price;
            $total += $num * $price;
            $list[$i]['total'] = $num * $price;  // 每件商品的总价
            $list[$i]['num'] = $num;             // 每件商品的购买的数量
        }
        // 节省的钱
        $sheng = $shop_price_total - $total;
        if (IS_AJAX) {
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！', 'total' => $total]);
        } else {
            return ['total' => $total, 'list' => $list, 'shop_price_total' => $shop_price_total, 'sheng' => $sheng];
        }
    }

    /**
     * 把商品添加到购物车
     */
    public function add()
    {

        $good_id = I('post.good_id');
        if (!$good_id) $this->ajaxReturn(['status'=>2, 'info'=>'缺失商品ID！']);

        $num = I('post.num');

        $cart = session('cart');

        $sheng = D('Good')->where(['good_id'=>$good_id])->getField('good_number');

        $set = $cart[$good_id] + $num; // 要设置的数量，当前购物车里的数量 + 当前要添加的

        if ($set <= $sheng) {
            session('cart.' . $good_id, $set);
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！', 'href' => false]);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'操作失败，库存不足！', 'sheng'=>$sheng]);
        }
        
    }

    public function delCart ($good_ids)
    {
        for ($i=0, $len=count($good_ids); $i<$len; $i++) {
            session('cart.' . $good_ids[$i], null);
        }
        
    }

    /**
     * 删除购物车多个商品
     */
    public function del()
    {
        session('cart.' . I('post.good_id'), null);
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    /**
     * 删除购物车多个商品
     */
    public function delMul()
    {
        $good_ids = I('post.selects');
        for ($i=0, $len=count($good_ids); $i<$len; $i++) {
            session('cart.' . $good_ids[$i], null);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    /**
     * 购物车单个商品数量+1
     * @param  number $good_id 商品ID
     */
    public function inc($good_id=null)
    {
        $good_id = I('post.good_id') ? I('post.good_id') : $good_id;
        if (!$good_id) $this->ajaxReturn(['status'=>2, 'info'=>'缺失商品ID！']);
        $total = session('cart.' . $good_id) + 1;
        $info = D('Good')->where(['good_id'=>$good_id])->field('good_number,shop_price,is_promote,promote_price')->find();

        $yu = $info['good_number'] - $total;

        $price = $info['is_promote'] ? $info['promote_price'] : $info['shop_price'];
        $total_price = $total * $price;

        if ($yu < 0) {
            $this->ajaxReturn(['status'=>2, 'info'=>'操作失败，库存不足！', 'sheng' => $info['good_number']]);
        } else {
            session('cart.' . $good_id, $total);
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！', 'total' => $total_price, 'href' => false]);
        }
        
        
    }

    /**
     * 购物车单个商品数量-1
     * @param  number $good_id 商品ID
     */
    public function dec($good_id)
    {
        $good_id = I('post.good_id') ? I('post.good_id') : $good_id;
        if (!$good_id) $this->ajaxReturn(['status'=>2, 'info'=>'缺失商品ID！']);
        $total = session('cart.' . $good_id) - 1;
        if ($total < 1) {
            $this->del($good_id);
        } else {
            $info = D('Good')->where(['good_id'=>$good_id])->field('good_number,shop_price,is_promote,promote_price')->find();
            $price = $info['is_promote'] ? $info['promote_price'] : $info['shop_price'];
            $total_price = $total * $price;
            session('cart.' . $good_id, $total++);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！', 'total' => $total_price, 'href' => false]);
    }

    
}