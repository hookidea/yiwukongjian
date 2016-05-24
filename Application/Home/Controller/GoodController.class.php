<?php
namespace Home\Controller;

use Think\Controller;

class GoodController extends Controller
{
    protected function _initialize ()
    {
        if (!in_array(strtolower(ACTION_NAME), ['getlist', 'getuserlist', 'showgood', 'match']) && !session('user')) { // 指定允许的操作
            if (IS_AJAX) {
                $this->ajaxReturn(['status'=>2, 'info'=>'请登陆之后在执行此操作！']);
            } else {
                $this->error('您还没有登陆，没有权限进行此操作！正在跳转到首页...', '/Index/index', 2);
            }
        }
    }

    public function getList ()
    {

        $pagesize = C('GOOD_PAGE_NUM');
        $keyword = I('get.keyword');
        $cat_id = I('get.cat_id');
        $sort = I('get.sort');
        $goods = D('Good');

        $page = new \Org\Util\Page($pagesize, false);

        // 使用MySQL进行排序，实时，效率低，消耗高
        if (in_array($sort, ['sales_num', 'shop_price', 'good_id', 'add_time']) || ((empty($sort = I('get.sort')) && $sort = 'add_time' ) & !$keyword)) { // 默认发布时间排名

            $order = I('get.order');
            if(!$order) $order = 'desc';

            $where = ['is_delete'=>0, 'is_on_sale'=>1, 'good_number' => ['gt', 0]];
            if ($cat_id) $where['cat_id'] = $cat_id;
            if (C('CHECK_ISSUE_GOOD')) $where['is_check'] = 1;

            $list = $goods->where($where)->field('is_promote,user_id,user_name,good_id,shop_price,promote_price,good_name,thumb_img')->limit($page->limit)->order($sort . ' ' . $order)->select();

        } else {// 使用Sphinx进行排序，效率高，消耗低
            $sphinx = new \Org\Util\Sphinx;

            $sphinx->setFilter('is_delete', [0]);
            $sphinx->setFilter('is_on_sale', [1]);
            $sphinx->SetFilterRange('good_number', 1, 99999);
            if (C('CHECK_ISSUE_GOOD')) $sphinx->setFilter('is_check', [1]);
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);

            $result = $sphinx->query($keyword, 'goods');

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);
            $list = $goods->where(['good_id'=>['in', $in]])->field('is_promote,user_id,user_name,good_id,shop_price,promote_price,good_name,thumb_img')->select();
        }

        $this->page = $page->show($list);
        $this->list = $list;
        $this->display();
    }

    public function getUserList ()
    {
        $pagesize = C('WAP_GOOD_PAGE_NUM');
        $keyword = I('get.keyword');
        $goods = D('Good');

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

        $page = new \Org\Util\Page($pagesize, false);

        // 使用MySQL进行排序，实时，效率低，消耗高
        if (!$keyword) {

            if (!$this->flag) { // 查看别人的
                $where = ['is_delete'=>0, 'is_on_sale'=>1];
                if (C('CHECK_ISSUE_GOOD')) $where['is_check'] = 1;
            }

            $where['user_id'] = $user_id;

            $list = $goods->where($where)->field('is_promote,user_id,user_name,good_id,shop_price,promote_price,good_name,thumb_img,add_time,good_number,sales_num,collect_num,is_on_sale')->limit($page->limit)->order('add_time desc')->select();

        } else {// 使用Sphinx进行排序，效率高，消耗低

            $sphinx = new \Org\Util\Sphinx;

            if (!$this->flag) { // 查看别人的
                $sphinx->setFilter('is_delete', [0]);
                $sphinx->setFilter('is_on_sale', [1]);
                if (C('CHECK_ISSUE_GOOD')) $sphinx->setFilter('is_check', [1]);
            }

            $sphinx->setFilter('user_id', [$user_id]);
            $sphinx->setLimits($pagesize*(I('get.p', 1)-1), $pagesize+1);

            $result = $sphinx->query($keyword, 'goods');

            if (!isset($result['matches'])) {
                $this->display();
                exit;
            }

            $in = array_keys($result['matches']);

            $list = $goods->where(['good_id'=>['in', $in]])->field('is_promote,user_id,user_name,good_id,shop_price,promote_price,good_name,thumb_img,add_time,good_number,sales_num,collect_num,is_on_sale')->select();
        }

        $this->page = $page->show($list);
        $this->list = $list;

        if ($this->flag) {
            $this->display();
        } else {
            $this->display('getOutUserList');
        }

    }


    public function showGood()
    {
        $comment = D('Comment');

        $page = new \Org\Util\Page(C('COMMENT_PAGE_NUM'), false);
        $good_id = I('get.good_id');
        $p = I('get.p');

        if (IS_AJAX) { // AJAX获取分页的
            // $commentList = $comment->query('select comment_id,user_id,user_name,raply_id,raply_name,content,add_time from comments where good_id = ' . $good_id . ' order by add_time desc limit ' . $page->limit);
            // $page = $page->show($commentList);
            // $commentList = $commentList;

            $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where good_id = ' . $good_id . ' order by add_time desc limit ' . $page->limit . ') as c left join images as d on c.user_id=d.user_id');
            $commentList = [];
            for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
                $commentList[$tmpList[$i]['lost_id']][] = $tmpList[$i];
            }
            $page = $page->show($commentList[0]);
            $this->ajaxReturn(['status' => 1, 'info' => '获取分页成功', 'content' => $commentList[0], 'page' => $page]);

        } else {

            $good = D('Good');
            $user = D('User');
            $real = D('Real');
            $image = D('Image');

            $row = $good->where(['good_id'=>$good_id])->relation(true)->find();
            $this->row = $row;

            // 商品发布人的头像
            $this->head_img = $image->where(['user_id' => $row['user_id']])->getField('save_path');

            $real_location = $real->where(['user_id' => $row['data']['user_id']])->getField('real_location');
            $this->location = $real_location;

            $is_collect = M()->table('collect_goods')->where(['user_id' => session('user.user_id'), 'good_id' => $good_id])->find();
            $this->is_collect = $is_collect ? 1 : 0;   // 该用户是否已经收藏过该商品


            $imgList = D('Image')->field('good_id,save_path')->where(['good_id'=>$good_id])->select();
            $this->imgList = $imgList;


            $tmpList = $comment->query('select c.*,d.save_path from (select * from comments where good_id = ' . $good_id . ' order by add_time desc limit ' . $page->limit . ') as c left join images as d on c.user_id=d.user_id');
            $commentList = [];
            for ($i=0, $len_i=count($tmpList); $i<$len_i; $i++) {
                $commentList[$tmpList[$i]['lost_id']][] = $tmpList[$i];
            }

            $this->page = $page->show($commentList[0]);
            $this->commentList = $commentList[0];
            $this->display();
        }


    }


    /**
     * 发布新商品
     * @return json 操作结果
     */
    public function issue ()
    {
        if (IS_GET) {
            $category = D('Category');
            $this->cateList = $category->where(['is_show' => 1])->order('grade desc')->select();
            $this->display();
        } else {
            $good = D('Good');
            $_POST['user_id'] = session('user.user_id');
            $_POST['user_name'] = session('user.user_name');

            if (empty(I('post.images'))) $this->ajaxReturn(['status'=>2, 'info'=>'必须上传至少一张图片！']);

            if (empty(I('post.shop_price')) && empty(I('post.promote_price'))) {
                $this->ajaxReturn(['status'=>2, 'info'=>'价格/促销价格必须选择一种！']);
            } else {
                if (empty(I('post.shop_price'))) unset($_POST['shop_price']);
                if (empty(I('post.promote_price'))) unset($_POST['promote_price']);
            }

            if (empty(I('post.qq')) && empty(I('post.phone'))) {
                $this->ajaxReturn(['status'=>2, 'info'=>'QQ/手机必须选择一种！']);
            } else {
                if (empty(I('post.phone'))) unset($_POST['phone']);
                if (empty(I('post.qq'))) unset($_POST['qq']);
            }

            if (C('REAL_ISSUE_GOOD')) { // 开启了实名发布商品
                if (!R('User/checkReal')) $this->ajaxReturn(['status'=>2, 'info'=>'您还没有实名，暂时没有权限发布商品！']);
            }

            $files = I('post.images');

            if (count($files) > 5)  $this->ajaxReturn(['status'=>2, 'info'=>'最多只能够上传五张图片！']);

            do{
                $good_sn = 'G' . date('YmdH') . rand(1111, 9999);
            }while($good->where(['good_sn' => $good_sn])->count());

            $_POST['good_sn'] = $good_sn;

            if (I('post.promote_price')) $_POST['is_promote'] = 1;

            if ($good->create(null, 1)) {
                // 处理图片
                $dir = './Uploads';
                $path = './Uploads' . '/Images/Good' . date('/Y/m/d/');

                $image_save = [];

                if (!is_dir($path)) {
                    if (!mkdir($path, 0777, true)) {
                        $this->ajaxReturn(['status'=>2, 'info'=>'服务器异常，创建保存目录失败！']);
                    }
                }

                $image = new \Think\Image();


                // 第一张用作封面
                $image->open($dir . '/Tmp/' . $files[0]);
                $thumb_img = $path . '230_' . $files[0];
                $image->thumb(230, 230, \Think\Image::IMAGE_THUMB_FIXED)->save($thumb_img);

                $good->thumb_img = substr($thumb_img, 1); // 存储在数据库的位置不需要最左边的点

                $id = $good->add();

                if ($id > 0) {

                    for($i=0, $len=count($files); $i<$len; $i++){
                        $image->open($dir . '/Tmp/' . $files[$i]);
                        $good_img = $path . '550_' . $files[$i];
                        $image->thumb(550, 550, \Think\Image::IMAGE_THUMB_FIXED)->save($good_img);
                        $image_save[] = ['good_id'=>$id, 'save_path'=>substr($good_img, 1)];
                    }

                    $result = M()->table('images')->addAll($image_save);

                    if ($result < 1) {
                        // 不能够真正删除，会破坏数据库的完整性
                        $good->where(['good_id' => $id])->save(['is_delete' => 1]);
                        $this->ajaxReturn(['status'=>2, 'info'=>'商品图片上传失败！']);
                    }

                    $info = C('CHECK_ISSUE_GOOD') ? '商品发布成功，请等待管理员审核！' : '商品发布成功！';

                    $this->ajaxReturn(['status'=>1, 'info'=>$info, 'href' => '/Good/showGood/good_id/' . $id]);

                } else {
                    $this->ajaxReturn(['status'=>2, 'info'=>'商品发布失败！']);
                }
            } else {
                $this->ajaxReturn(['status'=>2, 'info'=>$good->getError()]);
            }
        }

    }

    /**
     * 根据ID得到商品信息，支持in
     * @param  number/array  $args  要查询的商品ID，支持in
     * @param  string        $field 指定要查询的字段
     * @return array
     */
    public function getGood ($args, $field='*')
    {
        $good = D('Good');
        if ($field != '*') $good->field($field);
        if (is_array($args)) {
            return $good->where(['good_id' => ['in', $args]])->select();
        } else {
            return $good->where(['good_id' => $args])->find();
        }
    }

    /**
     * 获取商品库存
     * @return number/false  商品库存
     */
    public function getNumber ($good_id=null)
    {
        $good_id = I('get.good_id') ? I('get.good_id') : $good_id;
        if (!$good_id) return false;
        $num = D('Good')->where(['good_id' => $good_id])->getField('good_number');
        if (I('get.good_id')) {
            $this->ajaxReturn(['status'=>1, 'num'=>$num]);
        } else {
            return $num;
        }
    }

    /**
     * ajax预上传图片
     */
    public function uploadImg ()
    {
        $path = './Uploads/Tmp/';
        $img = explode(',', I('post.img'));
        $mime = explode(';', explode(':', $img[0])[1])[0];

        if (preg_match('/^image*/i', $mime) === 0) {
            $this->ajaxReturn(['status'=>2, 'info'=>'图片格式不正确！']);
        }
        $ext = explode('/', $mime)[1];

        do{
            $filename = rand('111111', '999999');
            $filepath = $path . $filename . '.' . $ext;
        }while(file_exists($filepath));

        if (file_put_contents($filepath, base64_decode($img[1]))) {
            $size = filesize($filepath);
            if ($size > C('IMAGE_SIZE') * 1024 * 1024) {
                $this->ajaxReturn(['status'=>2, 'info'=>'上传失败，图片大小必须在' . C('IMAGE_SIZE') . 'MB之内！']);
            }
            $this->ajaxReturn(['status'=>1, 'info'=>'上传成功！', 'path'=>$filename . '.' . $ext]);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'上传失败！']);
        }

    }

    /**
     * 上架一个商品
     */
    public function onSale ()
    {
        $good_id = I('post.good_id');
        if (!$good_id) $this->ajaxReturn(['status'=>2, 'info'=>'没有指明要上架的商品！']);

        $status = I('post.current') ? 0 : 1;

        $goods = D('Good');
        $result = $goods->where(['good_id' => $good_id])->save(['is_on_sale' => $status]);
        if($result){
            $this->ajaxReturn(['status'=>1, 'info'=>'操作成功！']);
        } else {
            $this->ajaxReturn(['status'=>2, 'info'=>'操作失败！']);
        }
    }

    /**
     * 减少库存
     */
    public function delNumber ($good_id, $num)
    {
        $good = D('Good');
        if (is_array($good_id)) {
            $good->where(['good_id' => ['in', $good_id]]);
        } else {
            $good->where(['good_id' => $good_id]);
        }
        if (!$good->setDec('good_number', $num)) {
            return false;
        }
        return true;
    }

}
