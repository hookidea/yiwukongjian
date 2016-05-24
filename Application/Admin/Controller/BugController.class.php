<?php
namespace Admin\Controller;

use Think\Controller;

class BugController extends Controller
{
    protected function _initialize ()
    {
        $users = session('user');
        if (!isset($users['bug_manage'])) {
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

        $bug = M()->table('bugs');

        if (!I('get.p')) $_GET['p'] = 1;

        $page = new \Org\Util\Page($pagesize);

        $sort = I('get.sort');
        // 使用MySQL进行排序，实时，效率低，消耗高
        if ($sort == 'add_time' || (empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            if ($is_full = I('get.is_full')) {
                $bug->where(['is_full' => $is_full]);
            }
            if ($user_id = I('get.user_id')) $bug->where(['user_id' => $user_id]);

            $list = $bug->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else {// 使用Sphinx进行排序，效率高，消耗低
            $sphinx = new \Org\Util\Sphinx;

            if ($user_id = I('get.user_id')) {
                $sphinx->setFilter('user_id', [$user_id]);
            }
            if ($is_full = I('get.is_full')) {
                $sphinx->setFilter('is_full', [$is_full]);
            }

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'bugs');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $list = $bug->where(['bug_id' => ['in', $in]])->select();
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function setFull ()
    {
        $bug = M()->table('bugs');
        if (IS_GET) {
            $bug->where(['bug_id' => I('get.bug_id')])->save(['is_full' => 1]);
        } else {
            $bug->where(['bug_id' => ['in', I('post.bug_id')]])->save(['is_full' => 1]);
        }
        $bug->where(['bug_id' => ['in', I('post.bug_id')]])->save(['is_full' => 1]);
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    public function delete ()
    {
        $bug = M()->table('bugs');
        if (IS_GET) {
            $bug->where(['bug_id' => I('get.bug_id')])->delete();
        } else {
            $bug->where(['bug_id' => ['in', I('post.bug_id')]])->delete();
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }



}
