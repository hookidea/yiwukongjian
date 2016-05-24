<?php
namespace Admin\Controller;

use Think\Controller;

class SystemController extends Controller
{
    protected function _initialize ()
    {
        if (!session('user.system_manage')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'您没有权限执行此操作！']);
            } else {
                $this->error('您没有权限执行此操作！', null, 1);
            }
        }
    }

    public function configManage()
    {
        if (IS_GET) {
            $this->display();
        } else {
            $name = strtoupper(I('post.name'));
            $value = I('post.value');

            $rs = setConfig($name, $value);
            $rs = setConfig($name, $value, './Wap/Common/Conf/config.php');
            // exec('rm -rf ./Application/Runtime/common~runtime.php');
            // exec('rm -rf ./Wap/Runtime/common~runtime.php');

            $this->ajaxReturn(['status' => $rs]);
        }
    }

    public function voidManage ()
    {
        if (IS_GET) {
            $this->display();
        } else {
            switch (strtolower(I('post.name'))) {
                case 'sphinx_cache':
                    exec('/usr/local/coreseek/bin/indexer --config /usr/local/coreseek/etc/csft.conf --all --rotate');
                    break;
                case 'rm_tmp_image':
                    exec('rm -rf ./Uploads/Tmp/*');
                    break;
                case 'rm_pc_runtime':
                    exec('rm -rf ./Application/Runtime/*');
                    break;
                case 'rm_wap_runtime':
                    exec('rm -rf ./Wap/Runtime/*');
                    break;
            }
            $this->ajaxReturn(['status' => 1]);
        }
    }

    public function systemInfo ()
    {
        phpinfo();
    }

    public function getHandle ()
    {
        $pagesize = C('ADMIN_PAGESIZE');

        $keyword = I('get.keyword');

        $handle = M()->table('handles');

        if (!I('get.p')) $_GET['p'] = 1;

        if (IS_POST && !$keyword) $this->error('请输入你要搜索的关键字！', null, 1);

        $sort = I('get.sort');

        $page = new \Org\Util\Page($pagesize);

        // 使用MySQL进行排序，实时，效率低，消耗高
        if ($sort == 'add_time' || (empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword & in_array($sort, ['add_time'])) {

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $user_id = I('get.user_id');
            if ($user_id) $handle->where(['user_id' => $user_id]);

            $list = $handle->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else { // 使用Sphinx进行排序，效率高，消耗低

            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);
            $result = $sphinx->query($keyword, 'handles');
            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $list = $handle->where(['handle_id' => ['in', $in]])->select();
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }


}
