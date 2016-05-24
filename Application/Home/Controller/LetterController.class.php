<?php
namespace Home\Controller;

use Think\Controller;

class LetterController extends Controller
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


    public function showLetter ()
    {
        $letter = D('Letter');
        $page = new \Org\Util\Page(C('LETTER_PAGE_NUM'), false);

        $list = $letter->where(['raply_id' => session('user.user_id')])->order('is_read asc,add_time desc')->limit($page->limit)->select();

        // 必须提前，不然会多出一个被设置为已读
        $this->page = $page->show($list);
        $this->list = $list;
        if (!empty($list)) $this->_setRead($list);

        $this->notReadLetter = $this->getNotReadLetter();
        $this->notReadOrderInfo = R('Message/getNotReadOrderInfo');
        $this->notReadSwitchInfo = R('Message/getNotReadSwitchInfo');
        $this->notReadSystemInfo = R('Message/getNotReadSystemInfo');
        $this->notReadCommentInfo = R('Message/getNotReadCommentInfo');
        $this->display();
    }

    /**
     * 分析，得到要设置为已读的ID值，并把他们全部设为已读
     * @return [type] [description]
     */
    private function _setRead ($list)
    {
        $ids = [];
        for ($i=0, $len=count($list); $i<$len; $i++) {
            $ids[] = $list[$i]['letter_id'];
        }
        D('Letter')->where(['letter_id' => ['in', $ids]])->save(['is_read' => 1]);
    }

    /**
     * 获取未读私信的总数
     * @return number     未读私信的总数
     */
    public function getNotReadLetter ()
    {
        return D('Letter')->where(['raply_id' => session('user.user_id'), 'is_read' => 0])->count();
    }

    /**
     * 发送一个私信
     */
    public function addLetter ()
    {
        if (IS_GET) {
            $content = $this->fetch('Letter/form');
            $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);
        } else {
            $_POST['user_id'] = session('user.user_id');
            $_POST['user_name'] = session('user.user_name');

            if (I('raply_id') == session('user.user_id')) {
                $this->ajaxReturn(['status'=>2, 'info'=>'不能够给自己发私信！！', 'href'=>false]);
            }

            $letter = D('Letter');
            if($letter->create(null, 1)){

                $letter_id = $letter->add();

                if (!$letter_id) $this->ajaxReturn(['status'=>2, 'info'=>'私信发送失败！']);

                $this->ajaxReturn(['status'=>1, 'info'=>'私信发送成功！', 'href' => false]);

            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$letter->getError()]);
            }
        }
    }

}
