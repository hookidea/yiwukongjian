<?php
namespace Home\Controller;

use Think\Controller;

class BugController extends Controller
{
    /**
     * 发送一个反馈
     */
    public function add ()
    {
        if (IS_GET) {
            $content = $this->fetch('Bug/form');
            $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);
        } else {
            $data['user_id'] = session('user.user_id') ? session('user.user_id') : 0;
            $data['user_name'] = session('user.user_name') ? session('user.user_name') : 0;
            $data['content'] = I('post.content');
            $data['add_time'] = time();

            $bug = M()->table('bugs');
            $bug_id = $bug->add($data);

            $bug_id ? $this->ajaxReturn(['status'=>1, 'info'=>'反馈成功！']) : $this->ajaxReturn(['status'=>2, 'info'=>'反馈失败！']);

        }
    }

}
