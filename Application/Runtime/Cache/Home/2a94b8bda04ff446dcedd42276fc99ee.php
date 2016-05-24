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

 <div class="wrap">
	<div class="category">
	<h2><img src="/Public/Home/Img/classification.png" alt=""></h2>
		<div>
		<ul>
			<?php if(is_array($cateList)): foreach($cateList as $key=>$vo): ?><li><a href="/Good/getList/cat_id/<?php echo ($vo["cat_id"]); ?>"><?php echo ($vo["cat_name"]); ?></a></li><?php endforeach; endif; ?>
				<li><a href="/Beg/getList" style="color: #52B0D4;">求购招领</a></li>
				<li><a href="/Lost/getList" style="color: #52B0D4;">失物招领</a></li>
		</ul>
		</div>
	</div>
	<div class="recommend">
		<div class="index-splide">
			<div class="latest index_btn"><span></span></div>
			<ul class="index_ul">
				<li onclick="indexShowType(0);">最近更新</li>
				<li onclick="indexShowType(1);">最高销量</li>
			</ul>
		</div>
		<div class="index-splide">
			<div class="issue index_btn"><span>我要发布</span></div>
			<ul class="issue_ul">
				<li onclick="indexIssueType(0);">发布商品</li>
				<li onclick="indexIssueType(1);">发布求购</li>
				<li onclick="indexIssueType(2);">发布招领</li>
			</ul>
		</div>
	</div>

	<div class="commodity-wrap">

	<ul class="com">
		<?php if(is_array($list)): foreach($list as $key=>$good): ?><li class="single">
					<a href="/<?php echo ($good["good_id"]); ?>.html" class="img" title="<?php echo ($good["good_name"]); ?>"><img src="<?php echo ($good["thumb_img"]); ?>" alt="<?php echo ($good["good_name"]); ?>"></a>
					<div class="money"><a href="/<?php echo ($good["good_id"]); ?>.html"><em>￥</em><?php if(($good["promote_price"]) == "0"): echo ($good["shop_price"]); else: echo ($good["promote_price"]); endif; ?></a></div>
					<div class="Writing"><?php echo ($good["good_name"]); ?></div>
					<div class="name"><a href="/User/showUser/user_id/<?php echo ($good["user_id"]); ?>"><?php echo ($good["user_name"]); ?></a></div>
				</li><?php endforeach; endif; ?>
	</ul>

	<div class="clear"></div>
		</div>

</div>

<div class="mt20">
    <div class="pagin fr">
        <div><?php echo ($page); ?></div>
    </div>
    <div class="clr"></div>
</div>

<script type="text/javascript">

	var sort = <?php echo ((isset($_GET['sort']) && ($_GET['sort'] !== ""))?($_GET['sort']):0); ?>;
	$('.recommend ul li').eq(sort).addClass('curr');
	var text = ['最新更新', '最高销量'];
	$('.recommend .latest span').html(text[sort]);

	$('.index-splide').mouseleave(function () {
		$(this).find('ul').stop().slideUp('fast');
	}).mouseenter(function () {
		$(this).find('ul').stop().slideDown('fast');
	});

</script>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/?wap=1" target="_blank">手机版</a>
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