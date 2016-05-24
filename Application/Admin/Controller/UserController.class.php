<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    protected function _initialize ()
    {
        $users = session('user');
        $action_name = strtolower(ACTION_NAME);

        if (!isset($users['user_' . $action_name])) {
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

        $user = D('User');

        if (!I('get.p')) $_GET['p'] = 1;

        $page = new \Org\Util\Page($pagesize);

        $sort = I('get.sort');
        // 使用MySQL进行排序，实时，效率低，消耗高
        if ($sort == 'add_time' || (empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword & in_array($sort, ['add_time', 'seal_stop'])) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $delete = I('get.delete') ? 1 : 0;


            $list = $user->where(['is_delete' => $delete])->relation('Role')->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else {// 使用Sphinx进行排序，效率高，消耗低
            $sphinx = new \Org\Util\Sphinx;

            $is_delete = I('get.delete') ? 1 : 0;
            $sphinx->setFilter('is_delete', [$is_delete]);

            $status = strtolower(I('get.order')) == 'asc' ? 0 : 1;

            if (substr($sort, 0, 3) == 'is_') {
                $sphinx->setFilter($sort, [$status]);
            }

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'users');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $list = $user->query('select users.*,role_name from users inner join roles on users.role_id = roles.role_id where users.user_id in (' . implode(',', $in) . ') limit ' . $page->limit);
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function check ()
    {
        $user = D('User');

        if (IS_GET) {
            $current = I('get.current') ? 0 : 1;
            $result = $user->where(['user_id' => I('get.user_id')])->save(['is_check' => $current]);
        } else {
            $result = $user->where(['user_id' => ['in', I('post.user_id')]])->save(['is_check' => 1]);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);

    }

    public function getNotReal ()
    {
        $pagesize = C('ADMIN_PAGESIZE');

        $keyword = I('get.keyword');

        $user = D('User');

        if (!I('get.p')) $_GET['p'] = 1;

        $sort = I('get.sort');
        // 使用MySQL进行排序，实时，效率低，消耗高
        if ($sort == 'add_time' || (empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword & in_array($sort, ['add_time', 'seal_stop'])) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $delete = I('get.delete') ? 1 : 0;

            $page = new \Org\Util\Page($pagesize);

            $list = $user->query('select a.*,roles.role_name from (select users.*,reals.real_name,reals.real_number,reals.real_location from reals inner join users on reals.user_id = users.user_id where reals.is_full = 0 and users.is_delete = 0 limit ' . $page->limit . ') as a inner join roles on a.role_id = roles.role_id order by ' . $sort . ' ' . $order);

            $this->page = $page->show($list);
        }
        $this->list = $list;
        $this->display();
    }

    /**
     * 通过一个/多个用户的实名请求
     * @return [type] [description]
     */
    public function real ()
    {
        D('User')->where(['user_id' => ['in', I('post.user_id')]])->save(['is_real' => 1]);
        D('Real')->where(['user_id' => ['in', I('post.user_id')]])->save(['is_full' => 1]);
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    public function delete ()
    {
        $user = D('User');

        if (IS_GET) {
            $current = I('get.current') ? 0 : 1;
            $result = $user->where(['user_id' => I('get.user_id')])->save(['is_delete' => $current]);
        } else {
            $result = $user->where(['user_id' => ['in', I('post.user_id')]])->save(['is_delete' => 1]);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    /**
     * 封号
     */
    public function seal ()
    {
        $time = I('get.time');
        if (!empty($time) && ($timestamp = strtotime($time))) {
            $timestamp = strtotime($time);
            $user = D('User');
            $result = $user->where(['user_id' => I('get.user_id')])->save(['is_seal' => 1, 'seal_stop' => $timestamp]);
            if($result){
                $this->ajaxReturn(['status'=>1, 'info'=>'封号成功！结束时间' . date('Y-m-d H:i:s', $timestamp)]);
            } else {
                $this->ajaxReturn(['status'=>0, 'info'=>'封号失败！']);
            }
        } else {
            $this->ajaxReturn(['status'=>0, 'info'=>'无效的时间']);
        }
    }


    public function edit ()
    {
        if (IS_GET) {

            $user_id = I('get.user_id');
            $role = D('Role');
            $user = D('User');
            $row = $user->where(['user_id'=>$user_id])->limit(1)->relation(true)->select();
            $roleList = $role->select();
            $this->row = $row[0];
            $this->roleList = $roleList;
            $this->display();

        } else {
            $user_id = I('get.user_id');
            $user = D('User');

            if (!session('user.is_root')) { // 不是ROOT，没有权限设置用户角色
                unset($_POST['role_id']);
            }

            if (!empty(I('post.password'))) {
                $user->password = password_hash(I('post.password'), PASSWORD_DEFAULT);
            } else {
                unset($_POST['password']);
            }

            if($user->create(null, 2)){
                if (I('post.is_real')) {
                    $real = D('Real');
                    if($real->create(null, 2)){
                        $result = $user->where(['user_id' => $user_id])->save();
                        if ($result === false) $this->ajaxReturn(['status'=>2, 'info'=>'修改基本失败！']);
                        $real->user_id = $user_id;
                        $result = $real->where(['user_id' => $user_id])->save();
                        if ($result === false) $this->ajaxReturn(['status'=>2, 'info'=>'修改实名失败！']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>$real->getError()]);
                    }
                } else {
                    $result = $user->where(['user_id' => $user_id])->save();
                    if ($result === false) $this->ajaxReturn(['status'=>2, 'info'=>'修改基本失败！']);
                }
                $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);

            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$user->getError()]);
            }
        }
    }

    public function add ()
    {
        if (IS_GET) {

            $role = D('Role');
            $roleList = $role->select();
            $this->roleList = $roleList;
            $this->display();

        } else {

            $user = D('User');

            $user_name = I('post.user_name');
            $count = $user->where(['user_name'=>$user_name])->limit(1)->count();
            if ($count) {
                $this->ajaxReturn(['status'=>2, 'info'=>'该用户名已被注册']);
            }

            if (!session('user.is_root')) { // 不是ROOT，没有权限设置用户角色
                unset($_POST['role_id']);
            }

            if($user->create(null, 1)){
                $user->password = password_hash(I('post.password'), PASSWORD_DEFAULT);

                if (I('post.is_real')) {
                    $real = D('Real');
                    if($real->create(null, 1)){
                        $user_id = $user->add();
                        if (!$user_id) $this->ajaxReturn(['status'=>1, 'info'=>'添加失败！']);
                        $real->user_id = $user_id;
                        $real_id = $real->add();
                        if (!$real_id) $this->ajaxReturn(['status'=>1, 'info'=>'添加失败！']);
                    } else {
                        $this->ajaxReturn(['status'=>2, 'info'=>$real->getError()]);
                    }
                } else {
                    $user_id = $user->add();
                    if (!$user_id) $this->ajaxReturn(['status'=>1, 'info'=>'添加失败！']);
                }
                $this->ajaxReturn(['status'=>1, 'info'=>'添加成功！']);

            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$user->getError()]);
            }

        }

    }


}
