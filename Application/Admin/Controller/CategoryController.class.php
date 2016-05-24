<?php
namespace Admin\Controller;

use Think\Controller;

class CategoryController extends Controller
{

    protected function _initialize ()
    {
        if (!session('user.category_manage')) {
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

        $category = D('Category');

        if (!I('get.p')) $_GET['p'] = 1;

        if (isset($_GET['keyword']) && empty(I('get.keyword'))) $this->error('请输入你要搜索的关键字！', null, 1);

        $is_show = I('get.is_show', 1);

        $page = new \Org\Util\Page($pagesize);

        $sort = I('get.sort');
        // 使用MySQL进行排序，实时，效率低，消耗高
        if ($sort == 'add_time' || (empty($sort = I('get.sort')) && $sort = 'grade' ) & !$keyword & in_array($sort, ['grade', 'add_time'])) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $list = $category->where(['is_show' => $is_show])->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else {// 使用Sphinx进行排序，效率高，消耗低

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_show', [$is_show]);

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'categorys');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $list = $category->where(['cat_id'=>['in', $in]])->select();
        }

        $this->page = $page->show($list);  // 必须多查一个
        $this->list = $list;
        $this->display();
    }

    public function edit ()
    {
        if (IS_GET) {

            $category = D('Category');
            $row = $category->where(['cat_id'=>I('get.cat_id')])->limit(1)->select();
            $this->row = $row[0];
            $this->display();

        } else {
            $category = D('Category'); // 实例化User对象
            // 根据表单提交的POST数据创建数据对象
            if($category->create()){
                $result = $category->where(['cat_id' => I('get.cat_id')])->save(); // 写入数据到数据库
                if($result){
                    // 如果主键是自动增长型 成功后返回值就是最新插入的值
                    $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);
                } else {
                    $this->ajaxReturn(['status'=>0, 'info'=>'未作修改！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$category->getError()]);
            }

        }

    }

    public function hiddenShow ()
    {
        // 权限控制
        $type = I('get.current') == 1 ? 0 : 1;
        $category = D('Category');
        $result = $category->where(['cat_id' => I('get.cat_id')])->save(['is_show' => $type]);
        if($result){
            // 如果主键是自动增长型 成功后返回值就是最新插入的值
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
        } else {
            $this->ajaxReturn(['status'=>0, 'info'=>'操作失败！']);
        }

    }

    public function add ()
    {
        // 权限验证

        if (IS_GET) {

            $this->display();

        } elseif(IS_POST) {

            $category = D('Category'); // 实例化User对象
            // 根据表单提交的POST数据创建数据对象
            if($category->create()){
                $result = $category->add(); // 写入数据到数据库
                if($result){
                    // 如果主键是自动增长型 成功后返回值就是最新插入的值
                    $this->ajaxReturn(['status'=>1, 'info'=>'添加成功！']);
                } else {
                    $this->ajaxReturn(['status'=>0, 'info'=>'添加失败！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$category->getError()]);
            }

        }

    }


}
