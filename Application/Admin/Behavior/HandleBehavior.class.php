<?php
namespace Admin\Behavior;

/**
 * @Author: hookidea
 * @Role: 
 * @Date:   2016-04-01 08:20:06
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-04-25 23:34:20
 */

/**
 * 用来记录Admin后台的操作记录
 */
class HandleBehavior {
    // 行为扩展的执行入口必须是run
    public function run(&$params){
        $handle = M()->table('handles');
        $action = strtolower(ACTION_NAME);

        switch (strtolower(CONTROLLER_NAME)) {
            case 'user':
                $id = I('user_id');
                $action_names = ['check' => '审核', 'real' => '实名', 'delete' => '删除', 'seal' => '封号', 'edit' => '编辑', 'add' => '添加'];
                $controller_name = '用户';
                
                break;
            case 'good':
                $id = I('good_id');
                $action_names = ['check' => '审核', 'delete' => '删除', 'add' => '添加', 'onsale' => '上/下架',  'promote' => '促销', 'lift' => '举报'];
                $controller_name = '商品';
                
                break;
            case 'comment':
                $id = I('comment_id');
                $action_names = ['delete' => '删除'];
                $controller_name = '评论';

                break;
            case 'category':
                $id = I('cat_id');
                $action_names = ['edit' => '编辑', 'hiddenshow' => '隐藏显示', 'add' => '添加'];
                $controller_name = '分类';

                break;
            case 'role':
                $id = I('role_id');
                $action_names = ['edit' => '编辑', 'delete' => '删除', 'add' => '添加'];
                $controller_name = '角色';

                break;
        }
        $action_name = $action_names[$action];
        if ($action_name) {
            if ($id) {
                if (is_array($id)) {
                    for ($i=0, $len=count($id); $i<$len; $i++) {
                        $insert = ['id' => $id[$i], 'controller' => $controller_name, 'action' => $action_names[$action], 'add_time' => time(), 'user_id' => session('user.user_id'), 'user_name' => session('user.user_name')];
                        $handle->add($insert);
                    }
                } else {
                    $insert = ['id' => $id, 'controller' => $controller_name, 'action' => $action_names[$action], 'add_time' => time(), 'user_id' => session('user.user_id'), 'user_name' => session('user.user_name')];
                    $handle->add($insert);
                }
                
            }
        }

    }
}