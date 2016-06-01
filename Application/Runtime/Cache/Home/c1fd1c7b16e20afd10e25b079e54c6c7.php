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

 <?php if(!empty($list)): ?><div class="wrap">
		<?php if(empty($_GET['keyword'])): ?><div class="nav">
				<div>
				<a class="rank" href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/Good/getList/cat_id/<?php echo ($_GET['cat_id']); ?>/sort/sales_num/order/'+order;location.href=url;">
					销量
					<?php if(isset($_GET['sort'])): if($_GET['sort']== 'sales_num'): if($_GET['order']== 'asc'): ?><span class="icon search_sort_asc"></span>
								      <?php else: ?>
								        <span class="icon search_sort_desc"></span><?php endif; ?>
							    <?php else: ?>
									<span class="icon"></span><?php endif; ?>
					<?php else: ?>
							<span class="icon search_sort_desc"></span><?php endif; ?>

				</a>
				<a class="rank" href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/Good/getList/cat_id/<?php echo ($_GET['cat_id']); ?>/sort/shop_price/order/'+order;location.href=url;">
				价格
					<?php if($_GET['sort']== 'shop_price'): if($_GET['order']== 'asc'): ?><span class="icon search_sort_asc"></span>
						      <?php else: ?>
						        <span class="icon search_sort_desc"></span><?php endif; ?>
					    <?php else: ?>
							<span class="icon"></span><?php endif; ?>
				</a>
				<a class="rank last" href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/Good/getList/cat_id/<?php echo ($_GET['cat_id']); ?>/sort/add_time/order/'+order;location.href=url;">
				时间
					<?php if($_GET['sort']== 'add_time'): if($_GET['order']== 'asc'): ?><span class="icon search_sort_asc"></span>
						      <?php else: ?>
						        <span class="icon search_sort_desc"></span><?php endif; ?>
					    <?php else: ?>
							<span class="icon"></span><?php endif; ?>
				</a>
				</div>
			</div><?php endif; ?>

		<?php if(!empty($_GET['keyword'])): if(!empty($_GET['keyword'])): ?><p class="keyword-info">提示：搜索结果可能存在延时！</p><?php endif; endif; ?>


		<ul class="com" style="width: 100%;">
			<?php if(is_array($list)): foreach($list as $key=>$good): ?><li class="single">
						<a href="/<?php echo ($good["good_id"]); ?>.html" class="img" title="<?php echo ($good["good_name"]); ?>"><img src="<?php echo ($good["thumb_img"]); ?>" alt=""></a>
						<div class="money"><a><em>￥</em><?php if(($good["promote_price"]) == "0"): echo ($good["shop_price"]); else: echo ($good["promote_price"]); endif; ?></a></div>
						<div class="Writing"><?php echo ($good["good_name"]); ?></div>
						<div class="name"><a href="/User/showUser/user_id/<?php echo ($good["user_id"]); ?>"><?php echo ($good["user_name"]); ?></a></div>
					</li><?php endforeach; endif; ?>
		</ul>
	</div>

	<div class="clear"></div>

<div class="mt20">
    <div class="pagin fr">
        <div><?php echo ($page); ?></div>
    </div>
    <div class="clr"></div>
</div>

<?php else: ?>

	<?php if(!empty($_GET['cat_id'])): ?><p class="info-p">抱歉，该分类下暂无商品，正在返回上一页...</p>
		<?php else: ?>
			<p class="info-p">抱歉，没有找到“<span style="color: #333;font-weight:700;"><?php echo ($_GET['keyword']); ?></span>”的搜索结果，，正在返回上一页...</p><?php endif; ?>

	<script type="text/javascript">
		setTimeout(function () {
			history.go(-1);
		}, 1000);

	</script><?php endif; ?>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Good/getList?wap=1" target="_blank">手机版</a>
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
