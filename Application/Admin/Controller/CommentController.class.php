<?php
namespace Admin\Controller;

use Think\Controller;

class CommentController extends Controller
{
    protected function _initialize ()
    {
        if (!session('user.comment_manage')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'您没有权限执行此操作！']);
            } else {
                $this->error('您没有权限执行此操作！', null, 1);
            }
        }
    }

    public function getList ()
    {
        $pagesize = C('ADMIN_PAGESIZE');

        $keyword = I('get.keyword');

        $comment = D('Comment');

        if (!I('get.p')) $_GET['p'] = 1;

        if (IS_POST && !$keyword) $this->error('请输入你要搜索的关键字！', null, 1);

        $page = new \Org\Util\Page($pagesize);

        $sort = I('get.sort');
        // 使用MySQL进行排序，实时，效率低，消耗高
        if ($sort == 'add_time' || (empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword & in_array($sort, ['add_time'])) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $list = $comment->limit($page->limit)->order($sort . ' ' . $order)->relation(true)->select();

        } else {// 使用Sphinx进行排序，效率高，消耗低
            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'comments');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $list = $comment->where(['comment_id'=>['in', $in]])->relation(true)->select();
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }


    public function delete ()
    {

        $comment = D('Comment');

        $comment_id = I('comment_id');

        if (empty($comment_id)) $this->ajaxReturn(['status'=>2, 'info'=>'没有指定要删除的评论ID！']);

        if (IS_GET) {
            $result = $comment->where(['comment_id' => $comment_id])->delete();
        } else {
            $result = $comment->where(['comment_id' => ['in', $comment_id]])->delete();
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }


}
