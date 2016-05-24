<?php
namespace Home\Controller;

use Think\Controller;

class RealController extends Controller
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
     * 提交认证申请
     */
    public function add ()
    {
        if (IS_GET) {
            $this->display();
        } else {
            $real = D('Real');
            $_POST['user_id'] = session('user.user_id');

            if($real->create(null, 1)){
                $real_id = $real->add();
                if ($real_id) {
                    $this->ajaxReturn(['status'=>1, 'info'=>'提交认证成功！', 'href' => 'backReload']);
                } else {
                    $this->ajaxReturn(['status'=>2, 'info'=>'提交认证失败！', 'href' => 'backReload']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$real->getError()]);
            }
        }

    }
}
