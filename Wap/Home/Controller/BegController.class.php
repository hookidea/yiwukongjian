<?php
namespace Home\Controller;

use Think\Controller;

class BegController extends Controller
{
    protected function _initialize ()
    {
        if (!in_array(strtolower(ACTION_NAME), ['getlist']) && !session('user')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到登陆界面...', '/User/login', 2);
            }
        }
    }

    /**
     * 完成求购
     */
    public function fullBeg()
    {
        $user_id = session('user.user_id');
        if (!$user_id) $this->error('抱歉，您还没有登陆，正在跳转到首页！', '/index.php/Home', 2);
        $beg = D('Beg');
        $num = $beg->where(['beg_id'=>I('post.beg_id'), 'user_id'=>$user_id])->save(['is_full'=>1]);
        if (0 == $num) {
            $this->ajaxReturn(['status'=>2, 'info'=>'操作失败！']);
        } else {
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
        }
    }

    /**
     * 查看某个用户的求购
     */
    public function getUserList ()
    {
        $pagesize = C('WAP_BEG_PAGE_NUM');
        $keyword = I('get.keyword');
        $beg = D('Beg');
        $page = new \Org\Util\Page($pagesize, false);

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

        if (!$keyword) {

            $where['user_id'] = $user_id;
            if (!$this->flag) {  // 查看别人的
                $where['stop_time'] = ['gt', time()];
                $where['is_full'] = 0;
            }

            $begList = $beg->where($where)->limit($page->limit)->order('beg_id desc')->select();

            if (!$begList) {  // 没有
                $this->display();
                exit;
            }
        } else {
            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('user_id', [$user_id]);
            if (!$this->flag) {  // 查看别人的
                $sphinx->SetFilterRange('stop_time', time(), strtotime('+' . C('BEG_TIME') . ' month'));
                $sphinx->setFilter('is_full', [0]);
            }

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'begs');

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $begList = $beg->where(['beg_id' => ['in', $in]])->order('beg_id desc')->select();
        }

        $this->page = $page->show($begList);
        $this->list = $begList;
        $this->display();
    }

    /**
     * 查看所有人的
     */
    public function getList ()
    {
        $pagesize = C('WAP_BEG_PAGE_NUM');
        $keyword = I('get.keyword');
        $beg = D('Beg');
        $page = new \Org\Util\Page($pagesize, false);

        if (!$keyword) {

            $where = ['is_full' => 0, 'stop_time' => ['gt', time()]];
            $begList = $beg->where($where)->limit($page->limit)->order('beg_id desc')->select();

            if (!$begList) {  // 没有
                $this->display();
                exit;
            }

        } else {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_full', [0]);
            $sphinx->SetFilterRange('stop_time', time(), strtotime('+' . C('BEG_TIME') . ' month'));
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            if ($user_id)  $sphinx->setFilter('user_id', [$user_id]);

            $result = $sphinx->query($keyword, 'begs');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $begList = $beg->where(['beg_id' => ['in', $in]])->order('beg_id desc')->select();
        }

        $this->page = $page->show($begList);
        $this->list = $begList;
        $this->display();
    }


    /**
     * 发布求购
     * @return json 操作结果
     */
    public function issue ()
    {
        if (IS_GET) {
            $this->display();
        } else {
            $beg = D('Beg');
            $_POST['user_id'] = session('user.user_id');
            $_POST['user_name'] = session('user.user_name');

            if (empty(I('post.qq')) && empty(I('post.phone'))) {
                $this->ajaxReturn(['status'=>2, 'info'=>'QQ/手机必须选择一种！']);
            } else {
                if (empty(I('post.phone'))) unset($_POST['phone']);
                if (empty(I('post.qq'))) unset($_POST['qq']);
            }

            $stop_time = I('post.stop_time');
            if ('' == $stop_time) {
                $_POST['stop_time'] = strtotime('+1 month');
            } else {
                $stop_time = strtotime($stop_time);
                if ($stop_time === false) $this->ajaxReturn(['status'=>2, 'info'=>'您输入的日期不合法！']);
                $stop_time = $stop_time > mktime('+3 month') ? mktime('+3 month') : $stop_time;
                $_POST['stop_time'] = $stop_time;
            }

            if (I('post.edit')) {  // 编辑
                if ($beg->create(null, 2)) {
                    $id = $beg->where(['beg_id'=>I('post.beg_id')])->save();
                    if ($id >= 0) {
                        $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>'修改失败！']);
                    }
                } else {
                    $this->ajaxReturn(['status'=>2, 'info'=>$beg->getError()]);
                }
            } else { // 添加
                if ($beg->create(null, 1)) {
                    $id = $beg->add();
                    if ($id > 0) {
                        $this->ajaxReturn(['status'=>1, 'info'=>'发布成功！', 'href' => '/Beg/getList']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>'发布失败！']);
                    }
                } else {
                    $this->ajaxReturn(['status'=>2, 'info'=>$beg->getError()]);
                }
            }


        }

    }

    /**
     * 获取编辑表单
     */
    public function edit ()
    {
        $beg = D('Beg');

        $this->row = $beg->where(['beg_id'=>I('get.beg_id')])->find();
        $this->display();

    }


}
