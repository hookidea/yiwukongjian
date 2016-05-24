<?php
namespace Admin\Controller;

use Think\Controller;

class RoleController extends Controller
{
    protected function _initialize ()
    {
        if (!session('user.role_manage')) {
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
        $role = D('Role');
        $page = new \Org\Util\Page($pagesize);

        $list = $role->limit($page->limit)->select();

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function showUser ()
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

            $list = $user->query('select users.*,role_name from users left join roles on users.role_id = roles.role_id where users.role_id = ' . I('get.role_id') . ' and is_delete = ' . $delete . ' order by ' . $sort . ' ' . $order . ' limit ' . $page->limit);
        } else { // 使用Sphinx进行排序，效率高，消耗低

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

            $list = $user->query('select users.*,role_name from users left join roles on users.role_id = roles.role_id where users.user_id in (' . implode(',', $in) . ') and users.role_id = ' . I('get.role_id') . ' limit ' . $page->limit);
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function edit ()
    {
        if (IS_GET) {

            $role_id = I('get.role_id');
            $role = D('Role');
            $row = $role->where(['role_id'=>$role_id])->limit(1)->select();
            $this->row = $row[0];
            $this->display();

        } else {
            $role = D('Role'); // 实例化User对象

            if (!session('user.is_root')) { // 不是ROOT，没有权限设置用户角色
                unset($_POST['is_root']);
            }

            if($role->create()){
                $result = $role->where(['role_id' => I('get.role_id')])->save(); // 写入数据到数据库
                if($result){
                    // 如果主键是自动增长型 成功后返回值就是最新插入的值
                    $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);
                } else {
                    $this->ajaxReturn(['status'=>0, 'info'=>'未作修改！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$role->getError()]);
            }

        }

    }

    public function add ()
    {
        if (IS_GET) {

            $this->display();

        } elseif(IS_POST) {

            $role = D('Role'); // 实例化User对象

            if (!session('user.is_root')) { // 不是ROOT，没有权限设置用户角色
                unset($_POST['is_root']);
            }

            // 根据表单提交的POST数据创建数据对象
            if($role->create()){
                $result = $role->add(); // 写入数据到数据库
                if($result){
                    // 如果主键是自动增长型 成功后返回值就是最新插入的值
                    $this->ajaxReturn(['status'=>1, 'info'=>'添加成功！']);
                } else {
                    $this->ajaxReturn(['status'=>0, 'info'=>'添加失败！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$role->getError()]);
            }

        }

    }

    public function delete ()
    {
        $role = D('Role');
        $result = $role->where(['role_id' => I('get.role_id')])->delete();
        if($result === 1){
            // 如果主键是自动增长型 成功后返回值就是最新插入的值
            $this->ajaxReturn(['status'=>1, 'info'=>'删除成功！']);
        } else {
            $this->ajaxReturn(['status'=>0, 'info'=>'删除失败！']);
        }

    }



}
