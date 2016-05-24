<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

    public function index ()
    {
        $good = D('Good');
        $num = C('WAP_INDEX_NUM');

        $where = ['is_delete' => 0, 'is_on_sale' => 1, 'good_number' => ['gt', 0]];

        if (C('CHECK_ISSUE_GOOD')) $where['is_check'] = 1;

        $timeList = $good->field('is_promote,user_name,user_id,good_id,shop_price,promote_price,good_name,thumb_img')->where($where)->order('add_time desc')->limit($num)->select();

        $salesList = $good->field('is_promote,user_name,user_id,good_id,shop_price,promote_price,good_name,thumb_img')->where($where)->order('sales_num desc')->limit($num)->select();

        $this->timeList = $timeList;
        $this->salesList = $salesList;
        $this->display();
    }

    public function article ()
    {
        $this->display();
    }

}
