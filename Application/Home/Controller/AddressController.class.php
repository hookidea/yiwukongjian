<?php
namespace Home\Controller;

use Think\Controller;

class AddressController extends Controller
{
    protected function _initialize ()
    {

        if (!session('user')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
            }
        }
    }

    public function del () {
        $address_id = I('post.address_id');
        if (D('Address')->where(['address_id' => $address_id])->delete()) {
            $this->ajaxReturn(['status'=>1, 'info'=>'删除成功！']);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'删除失败！']);
        }

    }

    public function add ()
    {
        $address = D('Address');
        $_POST['user_id'] = session('user.user_id');
        if($address->create(null, 1)){
            $address_id = $address->add();
            if ($address_id) {
                $this->ajaxReturn(['status'=>1, 'info'=>'添加成功！']);
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>'添加失败！']);
            }
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>$address->getError()]);
        }
    }

    public function edit ()
    {
        $address = D('Address');

        if($address->create(null, 2)){
            $address_id = $address->where(['address_id' => I('post.address_id')])->save();
            if ($address_id) {
                $this->ajaxReturn(['status'=>1, 'info'=>'保存成功！']);
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>'保存失败！']);
            }
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>$address->getError()]);
        }
    }

    public function getForm ()
    {
        $content = $this->fetch('form');
        $this->ajaxReturn(['status'=>1, 'content'=>$content]);
    }

    public function setAddress ()
    {
        $address = D('Address');
        $address->where(['user_id' => session('user.user_id'), 'is_default' => 1])->setField('is_default', 0);
        if ($address->where(['address_id' => I('post.address_id')])->setField('is_default', 1) >= 0) {
            $this->ajaxReturn(['status'=>1, 'info'=>'设置成功！']);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'设置失败！']);
        }
    }

    public function getAddress ()
    {
        return D('Address')->where(['user_id' => session('user.user_id')])->order('is_default desc')->select();
    }


}
