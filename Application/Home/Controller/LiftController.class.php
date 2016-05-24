<?php
namespace Home\Controller;

use Think\Controller;

class LiftController extends Controller
{
    public function test () 
    {
        session('user', array_merge(['user_id' => 3, 'user_name' => 'hersere'], []));
        print_r($_SESSION);
    }

    
    /**
     * 举报一个商品
     */
    public function liftGood() {

        $good_id = I('post.good_id');
        if (!$good_id) $this->ajaxReturn(['status'=>2, 'info'=>'没有指明要举报的商品！', 'href'=>false]);

        $lift = D('Lift');
        $user_id = session('user.user_id');

        if ($lift->where(['good_id' => $good_id,  'user_id' => $user_id])->find()) {
            $this->ajaxReturn(['status'=>2, 'info'=>'您已经举报过该商品！', 'href'=>false]);
        }   

        $result = $lift->add(['user_id' => $user_id, 'user_name' => session('user.user_name'), 'add_time' => time(), 'good_id' => $good_id]);
        D('Good')->where(['good_id' => $good_id])->setField('is_lift', 1);

        if($result){
            $this->ajaxReturn(['status'=>1, 'info'=>'举报成功！', 'href'=>false]);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'举报失败！', 'href'=>false]);
        }
    }
}