<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>易物空间</title>
    <link rel="shortcut icon" href="/Public/Home/Img/favicon.ico" />
    <meta name="description" content="">
    <meta http-equiv="cleartype" content="on">
    <link rel="stylesheet" type="text/css" href="/Public/Home/Css/index.css?v=2.1">
    <link rel="stylesheet" type="text/css" href="/Public/Home/Css/upload.css?v=2.1">
    <script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <div class="form"></div>
    <div class="back"></div>
    <div class="msg"></div>

    <div id="top-wrap">
        <div class="top">
            <a href="/"><h1><img src="/Public/Home/Img/logo.png" alt="logo"></h1></a>
            <div class="search_bar">
                <form method="get" action="/Good/getList">
                    <input type="text" name="keyword" class="text" placeholder="" value="<?php echo ($_GET['keyword']); ?>">
                    <input type="submit" name="" value="搜索" class="sub" onclick>
                </form>
            </div>
        <?php if(empty($_SESSION['shop']['user'])): ?><div class="log_in">
                    <ul>
                        <li>登录</li>
                        <li>注册</li>
                    </ul>
                </div>
        <?php else: ?>
                <div id="login_wrap">
                    <a href="/User/showUser">
                        <div id="person_info" class="clearfix">
                            <img class="avatar" src="<?php echo session('user.save_path'); ?>">
                            <div class="person_name"><?php echo session('user.user_name'); ?></div>
                            <!-- <a href="/user/level" class="grade" target="_blank"><img src="/Public/Home/Img/ico_lv1.png"></a> -->
                        </div>
                    </a>
                    <div id="login_slider">
                        <ul>
                            <li><a href="/User/showUser">个人中心</a></li>
                            <li><a href="/User/showCollect">我的收藏</a></li>
                            <li><a href="/Switch/match">商品匹配</a></li>
                            <li><a href="javascript:logout();">退出登录</a></li>
                         </ul>
                    </div>
                </div><?php endif; ?>


            <div class="drop_down">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>


        </div>
    </div>

<div id="body-wrap">

 <div class="container">
   <!-- <div class="main_center">
       <div class="zuo">
           <div class="tx">

            <img src="<?php echo ($row["save_path"]); ?>">
            <img src="/Public/Home/Img/person_hover.png">

           </div>
       </div>

       <div class="you">
           <div class="name_user"><span><?php echo ($row["user_name"]); ?></span>
            <img src="/Public/Home/Img/ico_lv1.png" alt="" />

           </div>
           <p>已卖出<?php echo ($row["sales_num"]); ?>件商品</p>
           <ul class="seller_attr">
                <li>
                    当前等级：1
                    <span><a href="#">等级有什么用？</a></span>
                </li>
                <li>
                    当前积分：<?php echo ($row["integral"]); ?>
                    <span><a href="#">查看积分明细</a></span>
               </li>
               <li>
                    升级还需：0
                   <span><a href="#">如何升级？</a></span>
               </li>
           </ul>
       </div>
   </div> -->

    <div class="suibian">
        <ul class="middle_nav">
          <li class="personalhover"><a href="/User/showUser">我的资料</a></li>
          <li><a href="/Good/getUserList">商品管理</a></li>
          <li><a href="/Beg/getUserList">求购管理</a></li>
          <li><a href="/Lost/getUserList">招领管理</a></li>
          <li><a href="/User/showCollect">收藏管理</a></li>
          <li><a href="/User/showAddress">地址管理</a></li>
          <li><a href="/Order/showOrder">订单管理</a></li>
          <li><a href="/Switch/showSwitch">换购管理</a></li>
          <li><a href="/Message/showMessage">消息管理</a></li>
          <li><a href="/User/showReal">认证管理</a></li>
        </ul>
   </div>
   <div class="qq">
        <div class="aa">
            <div class="my_info">
                    <div class="account_info">
                        <h2>用户信息</h2>
                        <ul class="infos">
                            <li>用户名称</li>
                            <li class="right_info"><?php echo ($row["user_name"]); ?></li>
                            <li style="cursor: pointer;" class="check_user_btn right_info" onclick="changePassword(1);">更改密码</li>
                        </ul>
                        <ul class="infos">
                            <li>绑定邮箱</li>
                            <li class="right_info" id="email_name"><?php echo ($row["email"]); ?></li>
                            <?php if(($row["is_check"]) == "0"): ?><li style="cursor: pointer;" class="check_user_btn right_info"><span onclick="userCheck();">邮箱未验证，立即验证</span><span onclick="changeEmail(1);" style="margin-left: 20px;cursor: pointer;">修改邮箱</span></li>
                            <?php else: ?>
                                <li class="check_user_btn right_info">邮箱已验证<span onclick="changeEmail(1);" style="margin-left: 20px;cursor: pointer;">修改邮箱</span></li><?php endif; ?>
                        </ul>
                        <ul class="infos">
                            <li>注册时间</li>
                            <li class="right_info"><?php echo (date('Y-m-d H:i:s',$row["add_time"])); ?></li>
                        </ul>
                        <ul class="infos">
                            <li style="height: 70px; line-height: 70px;">我的头像</li>
                            <li class="right_info"><img style="width: 70px;" src="<?php echo ($row["save_path"]); ?>"></li>
                            <li  style="height: 70px; line-height: 70px;" class="check_user_btn right_info" id="upload_head"><span onclick="ajaxUploadImg();">点击修改头像</span></li>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
</div>


    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/User/showUser?wap=1" target="_blank">手机版</a>
            <span>/</span><a href="javascript:return false;" onclick="addBug(1);">反馈建议</a>
            <span>/</span><a href="/Index/article" target="_blank">服务条款</a>
            <?php if (session('user.login_bg')) { echo '<span>/</span><a href="/admin.php/Index/index" target="_blank">后台管理</a>'; } ?>
        </div>
        <div class="links-end">Copyright © 2016 YW.GZITTC.COM. All rights reserved.</div>
    </div>


    <div id="window-btn">
        <ul>
            <a href="/Cart/showCart">
                <li title="我的购物车">
                    <img src="/Public/Home/Img/cart-icon.gif"><b class="cart"><?php echo ($_GET['cartNum']); ?></b>
                </li>
            </a>
            <a href="/Message/showMessage" class="href">
                <li title="查看未读消息">
                    <img src="/Public/Home/Img/mess.gif"><b><?php echo ($_GET['totalNotReal']); ?></b>
                </li>
            </a>
            <a href="/User/showCollect" class="href">
                <li title="查看收藏">
                    <img src="/Public/Home/Img/collect-icon.gif"><b></b>
                </li>
            </a>
            <a href="/Switch/match">
                <li title="商品匹配">
                    <img src="/Public/Home/Img/match.gif" class="href">
                </li>
            </a>
            <li title="返回首页" onclick="location.href = '/Index/index';">
                <img src="/Public/Home/Img/home.gif" class="href">
            </li>
            <li title="返回顶部" onclick="goTop();">
                <img src="/Public/Home/Img/gotop.gif" class="href">
            </li>
        </ul>
    </div>

</div>

</body>
</html>

<script type="text/javascript" src="/Public/Home/Js/script.js"></script>

<script type="text/javascript" src="/Public/Home/Js/validate.js"></script>
<script type="text/javascript" src="/Public/Home/Js/upload.js"></script>


<script>
    $('#window-btn a.href').click(function () {
        if (<?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?> == -1) {
            backAppend({status: 2, info: '请先登陆', href: false});
            return false;
        }

    });
</script>