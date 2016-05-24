<?php
namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{
    protected function _initialize ()
    {
        if (!in_array(strtolower(ACTION_NAME), ['changepassword', 'email', 'login', 'reg', 'logout', 'getform', 'checkuserexists']) && !session('user')) {
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后再执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
            }
        }
    }

    /**
     * 登陆
     */
    public function login()
    {
        $user = D('User');
        $user_name = I('post.user_name');
        $password = I('post.password');
        if (empty($user_name) || empty($password)) $this->ajaxReturn(['status'=>2, 'info'=>'用户名/不能为空！']);

        $info = $user->where(['user_name'=>$user_name])->field('user_name,user_id,password,role_id,seal_stop,is_delete')->find();

        if (empty($info)) $this->ajaxReturn(['status'=>2, 'info'=>'该用户名未注册']);

        if (password_verify($password, $info['password'])) {

            if ($info['is_delete']) {
                $this->ajaxReturn(['status'=>2, 'info'=>'该账号不可用，已被管理员删除，请重新注册！']);
            }

            if ($info['seal_stop']) {
                if ($info['seal_stop'] > time()) {
                    $this->ajaxReturn(['status'=>2, 'info'=>'封号结束时间：' . date('Y-m-d H:i:s', $info['seal_stop']), 'time' => 3000]);
                }
            }


            $save_path = D('Image')->where(['user_id' => $info['user_id']])->getField('save_path');


            session('user.user_id', $info['user_id']);
            session('user.user_name', $info['user_name']);
            session('user.save_path', $save_path);

            $this->_setRoleSession($info['role_id']); // 获取用户的角色信息，并添加进SESSION

            if (!C('HOME_LOGIN_ON') && !session('user.login_bg')) {
                $this->ajaxReturn(['status'=>2, 'info'=>'抱歉！网站已关闭登陆！']);
            }


            if (I('post.remember')) {
                if (session('user.login_bg')) {
                    cookie(session_name(), session_id(), 0); // 记住我
                } else {
                    cookie(session_name(), session_id(), 3600*24*14); // 记住我
                }

            } else {
                cookie(session_name(), session_id(), 0); // 记住我
            }

            $this->ajaxReturn(['status'=>1, 'info'=>'登陆成功', 'href' => 'backReload']);

        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'密码错误！']);
        }
    }

    /**
     * 获取用户的角色信息，并添加进SESSION
     * @param number $role_id 角色ID
     */
    private function _setRoleSession ($role_id)
    {
        $result = D('Role')->where(['role_id' => $role_id])->find();
        session('user', array_merge(session('user'), (array)$result));
    }

    /**
     * 注册
     */
    public function reg()
    {
        if (!C('HOME_REGISTER_ON')) {
            $this->ajaxReturn(['status'=>2, 'info'=>'抱歉！网站已关闭注册！']);
        }

        $user_name = I('post.user_name');
        $user = D('user');
        $count = $user->where(['user_name'=>$user_name])->count();

        if ($count) {
            $this->ajaxReturn(['status'=>2, 'info'=>'该用户名已被注册']);
        }

        if ($_POST['role_id']) unset($_POST['role_id']);

        $POST['email'] = strtolower($POST['email']);
        $POST['user_name'] = strtolower($POST['user_name']);

        if($user->create($_POST, 1)){

            $user->password = password_hash(I('post.password'), PASSWORD_DEFAULT);

            $user_id = $user->add();
            if (!$user_id) $this->ajaxReturn(['status'=>2, 'info'=>'注册失败！']);
            session('user.user_id', $user_id);
            session('user.user_name', I('post.user_name'));
            session('user.save_path', '/Uploads/Images/Head/0.png');

            if (I('post.remember')) {
                if (session('user.login_bg')) {
                    cookie(session_name(), session_id(), 0); // 记住我
                } else {
                    cookie(session_name(), session_id(), 3600*24*14); // 记住我
                }

            } else {
                cookie(session_name(), session_id(), 0); // 记住我
            }

            D('Image')->add(['user_id' => $user_id, 'save_path' => '/Uploads/Images/Head/0.png']);

            $this->ajaxReturn(['status'=>1, 'info'=>'注册成功！']);

        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>$user->getError()]);
        }

    }

    /**
     * 登出
     */
    public function logout()
    {
        setcookie(session_name(), null);
        session('user', null);
        if (IS_AJAX) {
            $this->ajaxReturn(['status'=>1, 'info'=>'退出成功', 'href'=>'/Index/index']);
        } else {
            $this->success('退出成功', null, 1);
        }

    }

    public function getForm()
    {
        $content = $this->fetch('Public/form');
        $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);
    }

    /**
     * 检查用户是否已实名
     */
    public function checkReal ($user_id=null)
    {
        $id = $user_id ? $user_id : session('user.user_id');
        $user = D('User');
        $info = $user->where(['user_id'=>$id])->find();
        return $info['is_real'];
    }

    public function checkUserExists()
    {
        $user_name = I('get.username');
        $user = D('User');
        $count = $user->where(['user_name'=>$user_name])->count();
        if ($count) {
            $this->ajaxReturn(['status'=>2, 'info'=>'该用户名已被注册']);
        } else {
            $this->ajaxReturn(['status'=>1, 'info'=>'该用户名未被注册']);
        }

    }

    private function getUserInfo($user_id=null)
    {
        $user_id = $user_id ? $user_id : session('user.user_id');
        $save_path = D('Image')->field('email,user_id,user_name')->where(['user_id'=>$user_id])->getField('save_path');
        $info = D('User')->where(['user_id'=>$user_id])->find();
        $info['save_path'] = $save_path;
        return $info;
    }

    /**
     * 查看用户详细资料
     */
    public function showUser(){
        $user_id = I('get.user_id');
        if (!$user_id || $user_id == session('user.user_id')) {
            $this->row = $this->getUserInfo();
            $this->display();
        } else {
            $this->realInfo = D('Real')->where(['user_id'=>$user_id])->find();
            $this->userInfo = D('User')->where(['user_id' => $user_id])->field('add_time,user_name,add_time')->find();
            $this->display('showOutIndex');
        }
    }

    /**
     * 查看用户发布的所有商品
     */
    public function showGood()
    {
        $user_id = I('get.user_id');
        $good = D('Good');

        if (!$user_id || $user_id == session('user.user_id')) {

            $where = ['user_id'=>$user_id, 'is_delete'=>0];

            $page = new \Org\Util\Page(C('GOOD_PAGE_NUM'), false);

            $list = $good->where($where)->order('sales_num desc,add_time desc')->limit($page->limit)->select();

            $this->page = $page->show($list);
            $this->list = $list;
            $this->display();

        } else {

            $where = ['user_id'=>$user_id, 'is_delete'=>0, 'is_on_sale' => 1];

            $page = new \Org\Util\Page(C('GOOD_PAGE_NUM'), false);

            $list = $good->order('sales_num desc,add_time desc')->limit($page->limit)->select();

            $this->page = $page->show($list);
            $this->list = $list;
            $this->display('showOutGood');
        }
    }


    /**
     * 查看用户收藏的所有商品
     */
    public function showCollect()
    {
        $user_id = session('user.user_id');
        $collect = D('Collect');
        $where = ['user_id'=>$user_id];

        $page = new \Org\Util\Page(C('COLLECT_PAGE_NUM'), false);

        $list = $collect->where($where)->order('add_time desc')->relation(true)->limit($page->limit)->select();

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    /**
     * 查看用户发布的所有求购
     */
    public function showBeg()
    {
        $pagesize = C('GOOD_PAGE_NUM');
        $user_id = session('user.user_id');
        $beg = D('Beg');
        $comment = D('Comment');

        $page = new \Org\Util\Page(C('GOOD_PAGE_NUM'), false);

        // beg_id的降序，本身就含有add_time的意义
        // 取得发布人的头像位置和
        $begList = $beg->where(['user_id' => $user_id])->order('is_full asc,beg_id desc')->limit($page->limit)->select();

        if (!$begList) {  // 没有
            $this->display();
            exit;
        }

        $in = [];
        for ($x=0, $len_x=count($begList); $x<$len_x; $x++) {
            $in[] = $begList[$x]['beg_id'];
        }

        $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where beg_id in (' . implode(',', $in) . ')) as c left join images as d on c.user_id=d.user_id');

        $commentList = [];

        for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
            $commentList[$tmpList[$i]['beg_id']][] = $tmpList[$i];
        }

        $this->commentList = $commentList;
        $this->page = $page->show($begList);
        $this->begList = $begList;

        $user_id_get = I('get.user_id');
        if (!$user_id_get || $user_id_get == session('user.user_id')) {
            $this->display();
        } else {
            $this->display('showOutBeg');
        }


    }

    /**
     * 查看用户发布的所有失物
     */
    public function showLost()
    {
        $pagesize = C('GOOD_PAGE_NUM');
        $user_id = session('user.user_id');
        $lost = D('Lost');
        $comment = D('Comment');

        $page = new \Org\Util\Page(C('GOOD_PAGE_NUM'), false);

        // lost_id的降序，本身就含有add_time的意义
        // 取得发布人的头像位置和
        $lostList = $lost->where(['user_id' => $user_id])->order('is_full asc,lost_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();

        if (!$lostList) {  // 没有
            $this->display();
            exit;
        }
        $in = [];
        for ($x=0, $len_x=count($lostList); $x<$len_x; $x++) {
            $in[] = $lostList[$x]['lost_id'];
        }

        $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where lost_id in (' . implode(',', $in) . ')) as c left join images as d on c.user_id=d.user_id');

        $commentList = [];

        for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
            $commentList[$tmpList[$i]['lost_id']][] = $tmpList[$i];
        }

        $this->commentList = $commentList;
        $this->page = $page->show($lostList);
        $this->lostList = $lostList;


        $user_id_get = I('get.user_id');
        if (!$user_id_get || $user_id_get == session('user.user_id')) {
            $this->display();
        } else {
            $this->display('showOutLost');
        }
    }

    /**
     * 查看用户的认证信息
     */
    public function showReal()
    {
        $user_id = session('user.user_id');
        $this->realInfo = D('Real')->where(['user_id'=>$user_id])->find();
        $this->display();
    }

    /**
     * 查看收货地址
     */
    public function showAddress()
    {
        $this->list = D('Address')->where(['user_id' => session('user.user_id')])->order('is_default desc')->select();
        $this->display();
    }

    /**
     * 修改用户头像
     */
    public function editHeadImg ()
    {
        $img = I('post.img');

        if (empty($img)) $this->ajaxReturn(['status'=>2, 'info'=>'您还没有选择图片！']);

        $image = D('Image');
        $user_id = session('user.user_id');

        $sql_img = $image->where(['user_id' => $user_id])->getField('save_path');

        if ($sql_img != '/Uploads/Images/Head/0.png') unlink('.' . $sql_img); // 删除旧的头像

        $savePath = './Uploads/Images/Head/' . $user_id . $img; // 实际保存的位置
        $sqlpath = '/Uploads/Images/Head/' . $user_id . $img;   // 用来存储到数据库中的，给img用的，必须不要`.`

        if (!rename('./Uploads/Tmp/' . $img, $savePath)) {
            $this->ajaxReturn(['status'=>2, 'info'=>'修改失败！']);
        }

        if ($image->where(['user_id' => $user_id])->save(['save_path' => $sqlpath])) {
            session('user.save_path', $sqlpath);
            $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！']);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'修改失败！']);
        }
    }

    /**
     * ajax预上传图片
     */
    public function uploadHead ()
    {
        if (IS_GET) { // 获取表单

            $content = $this->fetch('User/uploadHead');
            $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);

        } elseif (IS_AJAX) { // 临时上传图片

            $path = './Uploads/Tmp/';

            $img = explode(',', I('post.img'));
            $mime = explode(';', explode(':', $img[0])[1])[0];

            if (preg_match('/^image*/i', $mime) === 0) {
                $this->ajaxReturn(['status'=>2, 'info'=>'图片格式不正确！']);
            }

            $ext = explode('/', $mime)[1];

            do{
                $filename = rand('1111111111', '9999999999');
                $filepath = $path . $filename . '.' . $ext;
            }while(file_exists($filepath));

            if (file_put_contents($filepath, base64_decode($img[1]))) {
                $image = new \Think\Image();
                $image->open($filepath);
                $newname = 'H' . $filename . '.' . $ext;
                $tmppath = $path . $newname;

                $head_img_size = C('HEAD_IMG_SIZE');
                $image->thumb($head_img_size, $head_img_size, \Think\Image::IMAGE_THUMB_CENTER)->save($tmppath); // 居中裁剪

                $this->ajaxReturn(['status'=>1, 'info'=>'上传成功！', 'path'=>$newname]);
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>'上传失败！']);
            }

        }

    }

    /**
     * Email处理函数，负责分配具体的处理函数
     * @return [type] [description]
     */
    public function email ()
    {
        $key = I('get.key');
        $id = I('get.id');

        if (!$key || !$id) $this->error('验证链接错误，请您尝试手动复制验证链接，然后使用浏览器打开，而不是直接点击链接进行验证！');

        $row = M()->table('email_verify')->where(['id' => $id])->find();
        if ($row['fail_time'] < time()) $this->error('验证链接已失效，请重新发送验证！');

        if ($row['hash'] == $key) {
            session('tmp_user_id', $row['user_id']);
            switch ($row['type']) {
                case 0: // 验证用户
                    $this->_check();
                    break;
                case 1: // 找回密码
                    $this->_seekPassword();
                    break;
            }
        } else {
            $this->error('验证错误，请重新发送验证！');
        }
    }

    public function changeEmail ()
    {
        if (IS_GET) {
            $content = $this->fetch('User/changeEmail');
            $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);
        } else {
            $password = I('post.password');
            $email = I('post.email');

            if (!$password || !$email) $this->ajaxReturn(['status'=>2, 'info'=>'输入不能为空！', 'href'=>false]);

            $user_id = session('user.user_id');
            if (!$user_id)  $this->ajaxReturn(['status'=>2, 'info'=>'您还没有登陆，不能执行该操作！', 'href'=>false]);

            $user = D('User');
            $password_db = $user->where(['user_id' => $user_id])->getField('password');

            if (password_verify($password, $password_db)) {
                $rs = $user->where(['user_id' => $user_id])->save(['email' => $email, 'is_check' => 0]);

                if ($rs !== false) {

                    R('Email/send', ['email' => $email]);

                    $this->ajaxReturn(['status'=>1, 'info'=>'修改成功！<br/>邮箱激活邮件发送成功，请您于一天之内前往您的邮箱进行激活！']);

                } else {

                    $this->ajaxReturn(['status'=>2, 'info'=>'修改失败！', 'href'=>false]);
                }

            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>'密码错误！', 'href'=>false]);
            }

        }
    }

    public function changePassword ()
    {
        if (stripos($_SERVER['HTTP_REFERER'], 'user/email') === false && stripos($_SERVER['HTTP_REFERER'], 'showuser') === false) {
            IS_AJAX ? $this->ajaxReturn(['status'=>2, 'info'=>'非法访问！', 'href'=>false]) : $this->error('非法访问！');
        }

        if (IS_GET) {
            $content = $this->fetch('User/changePassword');
            $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);
        } else {
            $user_id = session('user.user_id') ? session('user.user_id') : session('tmp_user_id');
            if (!$user_id) {
                if (IS_AJAX) {
                    $this->ajaxReturn(['status'=>2, 'info'=>'非法访问！', 'href'=>false]);
                } else {
                    $this->error('非法访问！');
                }
            }

            $password = I('post.password');
            if (!$password) $this->ajaxReturn(['status'=>2, 'info'=>'密码不能为空', 'href' => false]);

            if (isset($_POST['new-password'])) {
                $new = $_POST['new-password'];
                $renew = $_POST['repassword'];

                if ($new != $renew) $this->ajaxReturn(['status'=>2, 'info'=>'您输入的密码不一致！', 'href' => false]);

                $password_db = D('User')->where(['user_id' => $user_id])->getField('password');

                if (!password_verify($password, $password_db)) {
                    $this->ajaxReturn(['status'=>2, 'info'=>'当前密码输入错误', 'href' => false]);
                }
                $password = $new;
            }
            $rs = D('User')->where(['user_id' => $user_id])->setField('password', password_hash($password, PASSWORD_DEFAULT));
            if ($rs) {
                setcookie(session_name(), null);
                session('user', null);
                $this->ajaxReturn(['status'=>1, 'info'=>'密码修改成功，请重新登陆！', 'href' => '/Index/index']);
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>'密码修改失败！', 'href' => false]);
            }
        }
    }

    private function _seekPassword ()
    {
        $this->display('User/seekPassword');
    }

    /**
     * 验证邮箱
     * @return [type] [description]
     */
    private function _check()
    {
        if (D('User')->where(['user_id' => session('tmp_user_id')])->setField('is_check', 1) ) {
            M()->table('email_verify')->where(['user_id' => session('tmp_user_id')])->delete();
            $this->success('验证成功！', '/User/Index');
        } else {
            $this->error('验证失败，请重新发送验证！');
        }

    }




}
