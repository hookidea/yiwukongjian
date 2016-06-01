<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>易物空间</title>
    <link rel="shortcut icon" href="/Public/Home/Img/favicon.ico" />
    <meta name="description" content="">
    <meta http-equiv="cleartype" content="on">
    <link rel="stylesheet" type="text/css" href="/Public/Home/Css/index.css?v=0.2">
    <link rel="stylesheet" type="text/css" href="/Public/Home/Css/upload.css?v=0.2">
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
        <div class="suibian">
          <ul class="middle_nav">
            <li><a href="/User/showUser">我的资料</a></li>
            <li><a href="/Good/getUserList">商品管理</a></li>
            <li><a href="/Beg/getUserList">求购管理</a></li>
            <li><a href="/Lost/getUserList">招领管理</a></li>
            <li class="personalhover"><a href="/User/showCollect">收藏管理</a></li>
            <li><a href="/User/showAddress">地址管理</a></li>
            <li><a href="/Order/showOrder">订单管理</a></li>
            <li><a href="/Switch/showSwitch">换购管理</a></li>
            <li><a href="/Message/showMessage">消息管理</a></li>
            <li><a href="/User/showReal">认证管理</a></li>
          </ul>
          <div class="clear">
          </div>
       </div>
       <div class="qq">
         <div class="sc">

          <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="enshr_each">
                <a href="/<?php echo ($vo["data"]["good_id"]); ?>.html">
                 <img src="<?php echo ($vo["data"]["thumb_img"]); ?>" alt="">
                </a>
                 <h2><a href="/<?php echo ($vo["data"]["good_id"]); ?>.html"><?php echo (mb_substr($vo["data"]["good_name"],0,40)); ?> ...</a></h2>
                 <p>
                   收藏价格：<a href="/<?php echo ($vo["data"]["good_id"]); ?>.html" class="user_good"></a><span class="shop-price"><em>￥</em><?php echo ($vo["shop_price"]); ?></a></span>
                   <span>收藏时间：<?php echo (date("Y年m月d日",$vo["add_time"])); ?></span>

                 </p>
                 <div class="enshr_state">

                    <?php if(($vo["data"]["is_on_sale"]) == "0"): ?><span class="onsaling">下架中</span>
                      <?php else: ?>
                      <span class="onsaling">上架中</span><?php endif; ?>



                    <div class="beg_btn collect_user_btn" onclick="collect_user(<?php echo ($vo["data"]["good_id"]); ?>);">
                        取消收藏
                    </div>


                 </div>
             </div><?php endforeach; endif; ?>
         </div>
        </div>
    </div>

<div class="mt20">
    <div class="pagin fr">
        <div><?php echo ($page); ?></div>
    </div>
    <div class="clr"></div>
</div>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/User/showCollect?wap=1" target="_blank">手机版</a>
            <span>/</span><a href="javascript:return false;" onclick="addBug(1);">反馈建议</a>
            <span>/</span><a href="/Index/article" target="_blank">服务条款</a>
            <?php if (session('user.login_bg')) { echo '<span>/</span><a href="/admin.php/Index/index" target="_blank">后台管理</a>'; } ?>
        </div>
        <div class="links-end">Copyright © 2016 YW.GZITTC.com. All Rights Reserved.</div>
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
