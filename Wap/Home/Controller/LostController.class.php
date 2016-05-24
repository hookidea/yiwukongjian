<?php
namespace Home\Controller;

use Think\Controller;

class LostController extends Controller
{
    protected function _initialize ()
    {
        if (!in_array(strtolower(ACTION_NAME), ['getlist']) && !session('user')) { // 指定允许的操作
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到登陆界面...', '/User/login', 2);
            }
        }
    }

    /**
     * 完成招领
     */
    public function fullLost()
    {
        $user_id = session('user.user_id');
        if (!$user_id) $this->error('抱歉，您还没有登陆，正在跳转到首页！', '/index.php/Home', 2);
        $lost = D('Lost');
        $num = $lost->where(['lost_id'=>I('post.lost_id'), 'user_id'=>$user_id])->save(['is_full'=>1]);
        if (0 == $num) {
            $this->ajaxReturn(['status'=>2, 'info'=>'操作失败！']);
        } else {
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
        }
    }

    public function getUserList ()
    {
        $pagesize = C('WAP_LOST_PAGE_NUM');
        $keyword = I('get.keyword');
        $lost = D('Lost');

        $g_user_id = I('get.user_id');
        $g_user_name = I('get.user_name');
        $s_user_id = session('user.user_id');
        $s_user_name = session('user.user_name');
        if ($g_user_id) {
            $user_id = $g_user_id;
            $user_name = $g_user_name;
            $this->flag = $g_user_id == $s_user_id ? true : false;
        } else {
            $user_id = $s_user_id;
            $user_name = $s_user_name;
            $this->flag = true;
        }

        $_GET['user_id'] = $user_id;
        $_GET['user_name'] = $user_name;

        $page = new \Org\Util\Page($pagesize, false);

        if (!$keyword) {

            $where['user_id'] = $user_id;
            if (!$this->flag) { // 看别人的
                $where['is_full'] = 0;
                $where['add_time'] = ['between', [strtotime('-1 month'), time()]];
            }

            $lostList = $lost->where($where)->limit($page->limit)->order('lost_id desc')->select();

            if (!$lostList) {  // 没有
                $this->display();
                exit;
            }
        } else {
            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('user_id', [$user_id]);
            if (!$this->flag) {
                $sphinx->setFilter('is_full', [0]);
                $sphinx->SetFilterRange('add_time', strtotime('-1 month'), time());
            }

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'losts');

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $lostList = $lost->where(['lost_id' => ['in', $in]])->order('lost_id desc')->select();
        }

        $this->page = $page->show($lostList);
        $this->list = $lostList;
        $this->display();
    }

    public function getList ()
    {
        $pagesize = C('WAP_LOST_PAGE_NUM');
        $keyword = I('get.keyword');
        $lost = D('Lost');

        $page = new \Org\Util\Page($pagesize, false);

        if (!$keyword) {

            $where = ['is_full' => 0, 'add_time' => ['between', [strtotime('-1 month'), time()]]];
            $lostList = $lost->where($where)->limit($page->limit)->order('lost_id desc')->select();

            if (!$lostList) {  // 没有
                $this->display();
                exit;
            }

        } else {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_full', [0]);
            $sphinx->SetFilterRange('add_time', strtotime('-1 month'), time());
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);

            $result = $sphinx->query($keyword, 'losts');

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $lostList = $lost->where(['lost_id' => ['in', $in]])->order('lost_id desc')->select();
        }

        $this->page = $page->show($lostList);
        $this->list = $lostList;
        $this->display();
    }

    /**
     * 发布招领
     * @return json 操作结果
     */
    public function issue ()
    {
        if (IS_GET) {
            $this->display();
        } else {
            $lost = D('Lost');
            $_POST['user_id'] = session('user.user_id');
            $_POST['user_name'] = session('user.user_name');

            if (empty(I('post.qq')) && empty(I('post.phone'))) {
                $this->ajaxReturn(['status'=>2, 'info'=>'QQ/手机必须选择一种！']);
            } else {
                if (empty(I('post.phone'))) unset($_POST['phone']);
                if (empty(I('post.qq'))) unset($_POST['qq']);
            }

            if (I('post.edit')) {  // 编辑
                if ($lost->create(null, 2)) {
                    $id = $lost->where(['lost_id'=>I('post.lost_id')])->save();
                    if ($id >= 0) {
                        $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>'修改失败！']);
                    }
                } else {
                    $this->ajaxReturn(['status'=>2, 'info'=>$lost->getError()]);
                }
            } else { // 添加
                if ($lost->create(null, 1)) {
                    $id = $lost->add();
                    if ($id > 0) {
                        $this->ajaxReturn(['status'=>1, 'info'=>'发布成功！', 'href' => '/Lost/getList']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>'发布失败！']);
                    }
                } else {
                    $this->ajaxReturn(['status'=>2, 'info'=>$lost->getError()]);
                }
            }


        }

    }

    /**
     * 获取编辑表单
     */
    public function edit ()
    {
        $lost = D('Lost');

        $this->row = $lost->where(['lost_id'=>I('get.lost_id')])->find();
        $this->display();

    }

}
