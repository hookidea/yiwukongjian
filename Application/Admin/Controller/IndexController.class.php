<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    protected function _initialize ()
    {
        if (!session('user.login_bg')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'您没有权限执行此操作！']);
            } else {
                $this->error('您没有权限执行此操作！', '/Index/index', 1);
            }
        }
    }

    public function index()
    {
        $this->display();
    }


}
