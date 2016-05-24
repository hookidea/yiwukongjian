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

 <link rel="stylesheet" type="text/css" href="/Public/Home/Css/showAddress.css?v=2.1">

<div class="container">
    <div class="suibian">
        <ul class="middle_nav">
          <li><a href="/User/showUser">我的资料</a></li>
          <li><a href="/Good/getUserList">商品管理</a></li>
          <li><a href="/Beg/getUserList">求购管理</a></li>
          <li><a href="/Lost/getUserList">招领管理</a></li>
          <li><a href="/User/showCollect">收藏管理</a></li>
          <li class="personalhover"><a href="/User/showAddress">地址管理</a></li>
          <li><a href="/Order/showOrder">订单管理</a></li>
          <li><a href="/Switch/showSwitch">换购管理</a></li>
          <li><a href="/Message/showMessage">消息管理</a></li>
          <li><a href="/User/showReal">认证管理</a></li>
        </ul>
   </div>
   <div class="qq">
        
        <div id="main-address">
          <div class="mod-main mod-comm" id="addressList">
              <div class="mt">
                <a href="javascript:;" class="e-btn add-btn btn-5" onclick="addAddress();">新增收货地址</a>
                <!-- <span class="ftx-03">您已创建<span class="ftx-02" id="addressNum_top"><?php echo (count($list)); ?></span>个收货地址，最多可创建<span class="ftx-02">20</span>个</span> -->
              </div>

              <div class="mc">
              <?php if(is_array($list)): foreach($list as $key=>$vo): ?><div id="addresssDiv-137842514" class="sm easebuy-m ">
                    <div class="smt">
                      <h3>
                        <?php echo ($vo["address_name"]); ?>
                        <?php if(($vo["is_default"]) == "1"): ?><span class="ftx-04 ml10">默认地址</span><?php endif; ?>
                      </h3>
                      <div class="extra">
                        <a href="#none" class="del-btn" onclick="delAddress(this, <?php echo ($vo["address_id"]); ?>);">删除</a>
                      </div>

                    </div>

                    <div class="smc">
                      <div class="items new-items">
                        <div class="item-lcol">
                          <div class="item">
                              <span class="label">收货人：</span>
                              <div class="fl">
                                  <?php echo ($vo["address_name"]); ?>
                              </div>
                              <div class="clr"></div>
                          </div>
                          <div class="item">
                              <span class="label">地址：</span>
                              <div class="fl">
                                  <?php echo ($vo["address_location"]); ?>
                              </div>
                              <div class="clr"></div>
                          </div>
                          <div class="item">
                              <span class="label">手机：</span>
                              <div class="fl">
                                  <?php echo ($vo["phone"]); ?>
                              </div>
                              <div class="clr"></div>
                          </div>
                          <div class="item">
                              <span class="label">QQ：</span>
                              <div class="fl">
                                  <?php echo ($vo["qq"]); ?>
                              </div>
                              <div class="clr"></div>
                          </div>
                        </div>

                        <div class="item-rcol">
                            <div class="extra">

                              <a onclick="setAddress(<?php echo ($vo["address_id"]); ?>);" href="javascript:;" class="ml10 ftx-05">设为默认</a>
                            </div>
                        </div>
                        <div class="clr"></div>
                      </div>
                    </div>
                  </div><?php endforeach; endif; ?>
              </div>
          </div>
        </div>
    </div>
</div>


    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/User/showAddress?wap=1" target="_blank">手机版</a>
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