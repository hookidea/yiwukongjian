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
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
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

    public function getList ()
    {
        $beg = D('Beg');
        $comment = D('Comment');
        $keyword = I('get.keyword');
        $beg_id = I('get.beg_id');

        $page = new \Org\Util\Page(C('BEG_PAGE_NUM'), false);

        if (!$keyword) {
            if ($beg_id) {
                $begList = $beg->query('select a.*,b.save_path from (select * from begs where beg_id = ' . $beg_id . ') as a left join images as b on a.user_id = b.user_id order by a.beg_id');
            } else {
                // beg_id的降序，本身就含有add_time的意义
                $begList = $beg->query('select a.*,b.save_path from (select * from begs where stop_time > ' . time() . ' and is_full = 0 limit ' . $page->limit . ') as a left join images as b on a.user_id = b.user_id order by a.beg_id');
            }

            if (!$begList) {  // 没有
                $this->display();
                exit;
            }

            $in = [];
            for ($x=0, $len_x=count($begList); $x<$len_x; $x++) {
                $in[] = $begList[$x]['beg_id'];
            }
        } else {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_full', [0]);
            $sphinx->SetFilterRange('stop_time', time(), strtotime('-' . C('BEG_TIME') . ' month'));
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'begs');

            $total = $result['total'];

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $begList = $beg->query('select a.*,b.save_path from (select * from begs where beg_id in (' . implode(',', $in) . ')) as a left join images as b on a.user_id = b.user_id order by a.beg_id');

            if (!$begList) {  // 没有
                $this->display();
                exit;
            }
        }

        $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where beg_id in (' . implode(',', $in) . ') order by beg_id desc) as c left join images as d on c.user_id=d.user_id');
        $commentList = [];
        for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
            $commentList[$tmpList[$i]['beg_id']][] = $tmpList[$i];
        }

        $this->commentList = $commentList;
        $this->page = $page->show($begList);
        $this->begList = $begList;
        $this->display();
    }


    /**
     * 查看某个用户的求购
     */
    public function getUserList ()
    {
        $beg = D('Beg');
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

        $page = new \Org\Util\Page(C('BEG_PAGE_NUM'), false);

        if (!$keyword) {
            // beg_id的降序，本身就含有add_time的意义

            if (!$this->flag) {  // 查看别人的
                $begList = $beg->query('select a.*,b.save_path from (select * from begs where user_id = ' . $user_id . ' and stop_time > ' . time() . ' and is_full = 0 limit ' . $page->limit . ') as a left join images as b on a.user_id = b.user_id order by a.beg_id');
            } else {
                $begList = $beg->query('select a.*,b.save_path from (select * from begs where user_id = ' . $user_id . ' limit ' . $page->limit . ') as a left join images as b on a.user_id = b.user_id order by a.beg_id');
            }

            if (!$begList) {  // 没有
                if (!$this->flag) { // 查看别人的
                    $this->display('getOutUserList');
                } else {
                    $this->display();
                }
                exit;
            }

            $in = [];
            for ($x=0, $len_x=count($begList); $x<$len_x; $x++) {
                $in[] = $begList[$x]['beg_id'];
            }

        } else {

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_full', [0]);
            $sphinx->SetFilterRange('stop_time', time(), strtotime('-' . C('BEG_TIME') . ' month'));
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'begs');

            $total = $result['total'];

            if (!isset($result['matches'])) {
                if (!$this->flag) { // 查看别人的
                    $this->display('getOutUserList');
                } else {
                    $this->display();
                }
                exit;
            }

            $in = array_keys($result['matches']);

            $begList = $beg->query('select a.*,b.save_path from (select * from begs where beg_id in (' . implode(',', $in) . ')) as a left join images as b on a.user_id = b.user_id order by a.beg_id');

            if (!$begList) {  // 没有
                $this->display();
                exit;
            }
        }

        $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where beg_id in (' . implode(',', $in) . ') order by beg_id desc) as c left join images as d on c.user_id=d.user_id');

        $commentList = [];
        for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
            $commentList[$tmpList[$i]['beg_id']][] = $tmpList[$i];
        }

        $this->commentList = $commentList;
        $this->page = $page->show($begList);
        $this->begList = $begList;

        if (!$this->flag) { // 查看别人的
            $this->display('getOutUserList');
        } else {
            $this->display();
        }
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
                $_POST['stop_time'] = strtotime('+' . C('BEG_TIME') . ' month');
            } else {
                $stop_time = strtotime($stop_time);
                if ($stop_time === false) $this->ajaxReturn(['status'=>2, 'info'=>'您输入的日期不合法！']);

                $stop_time = $stop_time > strtotime('+' . C('BEG_TIME') . ' month') ? strtotime('+' . C('BEG_TIME') . ' month') : $stop_time;

                $_POST['stop_time'] = $stop_time;
            }

            if (I('post.edit')) {  // 编辑
                if ($beg->create(null, 2)) {
                    $id = $beg->where(['beg_id'=>I('post.beg_id')])->save();
                    if ($id >= 0) {
                        $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！', 'href'=>'/Beg/getList']);
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
                        $this->ajaxReturn(['status'=>1, 'info'=>'发布成功！', 'href'=>'/Beg/getList']);
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
