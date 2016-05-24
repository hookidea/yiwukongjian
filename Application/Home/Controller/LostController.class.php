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
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
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

    /**
     * 查看某个用户的求购
     */
    public function getUserList ()
    {
        $lost = D('Lost');
        $comment = D('Comment');
        $keyword = I('get.keyword');

        $g_user_id = I('get.user_id');
        $s_user_id = session('user.user_id');
        if ($g_user_id) {
            $user_id = $g_user_id;
            $this->flag = $g_user_id == $s_user_id ? true : false;
        } else {
            $user_id = $s_user_id;
            $this->flag = true;
        }
        // $flag=true看自己的，=false看别人的

        $page = new \Org\Util\Page(C('LOST_PAGE_NUM'), false);

        if (!$keyword) {
            // lost_id的降序，本身就含有add_time的意义

            if (!$this->flag) {  // 查看别人的
                $lostList = $lost->query('select a.*,b.save_path from (select * from losts where user_id = ' . $user_id . ' and add_time between ' . strtotime('-1 month') . ' and ' . time() . ' and is_full = 0 limit ' . $page->limit . ') as a left join images as b on a.user_id = b.user_id order by a.lost_id');
            } else {
                $lostList = $lost->query('select a.*,b.save_path from (select * from losts where user_id = ' . $user_id . ' limit ' . $page->limit . ') as a left join images as b on a.user_id = b.user_id order by a.lost_id');
            }
            if (!$lostList) {  // 没有
                if (!$this->flag) { // 查看别人的
                    $this->display('getOutUserList');
                } else {
                    $this->display();
                }
                exit;
            }

            $in = [];
            for ($x=0, $len_x=count($lostList); $x<$len_x; $x++) {
                $in[] = $lostList[$x]['lost_id'];
            }

        } else {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_full', [0]);
            $sphinx->SetFilterRange('stop_time', time(), strtotime('-' . C('LOST_TIME') . ' month'));
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'losts');

            if (!isset($result['matches'])) {
                if (!$this->flag) { // 查看别人的
                    $this->display('getOutUserList');
                } else {
                    $this->display();
                }
                exit;
            }

            $in = array_keys($result['matches']);

            $lostList = $lost->query('select a.*,b.save_path from (select * from losts where lost_id in (' . implode(',', $in) . ')) as a left join images as b on a.user_id = b.user_id order by a.lost_id');

            if (!$lostList) {  // 没有
                $this->display();
                exit;
            }
        }

        $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where lost_id in (' . implode(',', $in) . ') order by lost_id desc) as c left join images as d on c.user_id=d.user_id');

        $commentList = [];
        for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
            $commentList[$tmpList[$i]['lost_id']][] = $tmpList[$i];
        }

        $this->commentList = $commentList;
        $this->page = $page->show($lostList);
        $this->lostList = $lostList;

        if (!$this->flag) { // 查看别人的
            $this->display('getOutUserList');
        } else {
            $this->display();
        }
    }

    public function getList ()
    {
        $pagesize = C('GOOD_PAGE_NUM');
        $lost = D('Lost');
        $comment = D('Comment');
        $keyword = I('get.keyword');
        $lost_id = I('get.lost_id');

            $page = new \Org\Util\Page(C('GOOD_PAGE_NUM'), false);

        if (!$keyword) {

            // 取得发布人的头像位置和
            if ($lost_id) {
                $lostList = $lost->query('select a.*,b.save_path from (select * from losts where lost_id = ' . $lost_id . ') as a left join images as b on a.user_id = b.user_id where add_time > ' . strtotime('-' . C('LOST_TIME') . ' month') . ' and add_time < ' . time() . ' order by a.lost_id desc');
            } else {
                // lost_id的降序，本身就含有add_time的意义
                $lostList = $lost->query('select a.*,b.save_path from (select * from losts where is_full = 0 limit ' . $page->limit . ') as a left join images as b on a.user_id = b.user_id where add_time > ' . strtotime('-' . C('LOST_TIME') . ' month') . ' and add_time < ' . time() . ' order by a.lost_id desc');
            }


            if (!$lostList) {  // 没有
                $this->display();
                exit;
            }

            $in = [];
            for ($x=0, $len_x=count($lostList); $x<$len_x; $x++) {
                $in[] = $lostList[$x]['lost_id'];
            }
        } else {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_full', [0]);
            $sphinx->SetFilterRange('add_time', strtotime('-' . C('LOST_TIME') . ' month'), time());
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'losts');

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $lostList = $lost->query('select a.*,b.save_path from (select * from losts where lost_id in (' . implode(',', $in) . ')) as a left join images as b on a.user_id = b.user_id order by a.lost_id desc');

            if (!$lostList) {  // 没有
                $this->display();
                exit;
            }

        }

        $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where lost_id in (' . implode(',', $in) . ') order by lost_id desc) as c left join images as d on c.user_id=d.user_id');
        $commentList = [];
        for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
            $commentList[$tmpList[$i]['lost_id']][] = $tmpList[$i];
        }

        $this->commentList = $commentList;
        $this->page = $page->show($lostList);
        $this->lostList = $lostList;
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
                        $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！', 'href'=>'/Lost/getList']);
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
                        $this->ajaxReturn(['status'=>1, 'info'=>'添加成功！', 'href'=>'/Lost/getList']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>'添加失败！']);
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
