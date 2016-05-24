<?php
namespace Home\Controller;

use Think\Controller;

class CommentController extends Controller
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

    public function add ()
    {
        $comment = D('Comment');

        $_POST['user_id'] = session('user.user_id');
        $_POST['user_name'] = session('user.user_name');

        if($comment->create(null, 1)){

            $comment_id = $comment->add();
            R('Message/addCommentMess', [I('post.')]); // 发送评论消息

            if (!$comment_id) $this->ajaxReturn(['status'=>2, 'info'=>'未知错误，评论失败！']);

            $this->ajaxReturn(['status'=>1, 'info'=>'评论成功！']);

        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>$comment->getError()]);
        }
    }




}
