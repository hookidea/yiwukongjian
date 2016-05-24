<?php
namespace Admin\Controller;

use Think\Controller;

class GoodController extends Controller
{
    protected function _initialize ()
    {
        $users = session('user');
        $action_name = strtolower(ACTION_NAME);

        if (!isset($users['good_' . $action_name])) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'您没有权限执行此操作！']);
            } else {
                $this->error('您没有权限执行此操作！', null, 1);
            }
        }
    }

    public function getList ()
    {
        $keyword = I('get.keyword');
        $cat_id = I('get.cat_id');
        $pagesize = C('ADMIN_PAGESIZE');
        $goods = D('Good');

        if (!I('get.p')) $_GET['p'] = 1;

        if (IS_POST && !$keyword) $this->error('请输入你要搜索的关键字！', null, 1);

        $page = new \Org\Util\Page($pagesize);

        $sort = I('get.sort');
        // 使用MySQL进行排序，实时，效率低，消耗高
        if (in_array($sort, ['shop_price', 'good_sn', 'good_id', 'add_time', 'good_number']) || ((empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword)) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            if (I('get.delete')) {
                $where = ['is_delete'=>1];
            } else {
                $where = ['is_delete'=>0];
            }

            if ($cat_id) $where['cat_id'] = $cat_id;
            if (I('get.lift')) $where['is_lift'] = 1;
            if (I('get.check')) $where['is_check'] = 0;

            $list = $goods->where($where)->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else { // 使用Sphinx进行排序，效率高，消耗低

            $sphinx = new \Org\Util\Sphinx;

            if ($cat_id) $sphinx->setFilter('cat_id', [$cat_id]);
            if ($sort != 'is_delete') {
                $is_delete = I('get.delete') ? 1 : 0;
                $sphinx->setFilter('is_delete', [$is_delete]);
            }

            if (I('get.lift')) $sphinx->setFilter('is_lift', [1]);
            if (isset($_GET['check'])) $sphinx->setFilter('is_check', [0]);

            if (substr($sort, 0, 3) == 'is_') {
                $status = strtolower(I('get.order')) == 'asc' ? 0 : 1;
                $sphinx->setFilter($sort, [$status]);
            }

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'goods');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $list = $goods->where(['good_id'=>['in', $in]])->select();
        }

        $this->categoryList = D('Category')->order('grade desc')->select();

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function edit ()
    {
        if (IS_GET) {

            $good = D('Good');
            $row = $good->where(['cat_id'=>I('get.cat_id')])->limit(1)->select();
            $this->row = $row[0];
            $this->display();

        } else {
            $good = D('Good'); // 实例化User对象
            // 根据表单提交的POST数据创建数据对象
            if($good->create()){
                $result = $good->where(['cat_id' => I('get.cat_id')])->save(); // 写入数据到数据库
                if($result){
                    // 如果主键是自动增长型 成功后返回值就是最新插入的值
                    $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);
                } else {
                    $this->ajaxReturn(['status'=>0, 'info'=>'未作修改！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$good->getError()]);
            }

        }

    }

    public function add ()
    {
        // 权限验证

        if (IS_GET) {

            $this->display();

        } elseif(IS_POST) {

            $good = D('good'); // 实例化User对象
            // 根据表单提交的POST数据创建数据对象
            if($good->create()){
                $result = $good->add(); // 写入数据到数据库
                if($result){
                    // 如果主键是自动增长型 成功后返回值就是最新插入的值
                    $this->ajaxReturn(['status'=>1, 'info'=>'添加成功！']);
                } else {
                    $this->ajaxReturn(['status'=>0, 'info'=>'添加失败！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$good->getError()]);
            }

        }

    }

    public function delete ()
    {
        $good = D('Good');

        $good_id = I('good_id');
        $is_delete = I('current') ? 0 : 1;

        if (empty($good_id)) $this->ajaxReturn(['status'=>2, 'info'=>'没有指定要操作的商品ID！']);

        if (IS_GET) {
            $result = $good->where(['good_id' => $good_id])->save(['is_delete' => $is_delete]);
        } else {
            $result = $good->where(['good_id' => ['in', $good_id]])->save(['is_delete' => $is_delete]);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    public function check ()
    {
        $good = D('Good');

        if (IS_GET) {
            $current = I('get.current') ? 0 : 1;
            $result = $good->where(['good_id' => I('get.good_id')])->save(['is_check' => $current]);
        } else {
            $result = $good->where(['good_id' => ['in', I('post.good_id')]])->save(['is_check' => 1]);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    public function onsale ()
    {
        $good = D('Good');

        if (IS_GET) {
            $current = I('get.current') ? 0 : 1;
            $result = $good->where(['good_id' => I('get.good_id')])->save(['is_on_sale' => $current]);
        } else {
            $result = $good->where(['good_id' => ['in', I('post.good_id')]])->save(['is_on_sale' => 0]);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    public function promote ()
    {
        $good = D('Good');

        $current = I('get.current') ? 0 : 1;
        $result = $good->where(['good_id' => I('get.good_id')])->save(['is_promote' => $current]);
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

    public function lift ()
    {
        $good = D('Good');

        if (IS_GET) {
            $current = I('get.current') ? 0 : 1;
            $result = $good->where(['good_id' => I('get.good_id')])->save(['is_lift' => $current]);
        } else {
            $result = $good->where(['good_id' => ['in', I('post.good_id')]])->save(['is_lift' => 0]);
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
    }

}
