<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>易物空间</title>
    <link rel="shortcut icon" href="/Public/Home/Img/favicon.ico" />
    <meta http-equiv="cleartype" content="on">
    <meta name="keywords" content="易物空间">
    <meta name="description" content="易物空间">
    <meta name="author" content="hookidea@gmail.com">
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

 <?php if(!empty($result)): ?><div class="wrap">
				<h4>全部商品</h4>
				<div class="xian">
						<input type="checkbox" value="1" onclick="full_select();"><span onclick="full_select();" class="cart_select_box">全选</span><span onclick="del_select();" class="cart_select_box">全不选</span>
						<div class="wenzi">商品</div>
						<div class="unit_price">单价(元)</div>
						<div class="quantity">数量</div>
						<div class="subtotal">小计</div>
						<div class="operating">操作</div>
				</div>
	<form id="accounts-form" method="POST" action="/Order/accounts">
			<?php if(is_array($result["list"])): foreach($result["list"] as $key=>$vo): ?><div class="xq">
						<input type="checkbox" checked="checked" name="selects[]" value="<?php echo ($vo["good_id"]); ?>" class="check">
						<a href="/<?php echo ($vo["good_id"]); ?>.html">
							<div class="shopping_img"><img src="<?php echo ($vo["thumb_img"]); ?>" title="<?php echo ($vo["good_name"]); ?>" /></div>
							<div class="shopping_wz"><?php echo ($vo["good_name"]); ?></div>
						</a>
						<?php if(($vo["is_promote"]) == "1"): ?><div class="unit-price">促销价：<?php echo ($vo["promote_price"]); ?></div>
							<?php else: ?>
								<div class="unit-price">原  价：<?php echo ($vo["shop_price"]); ?></div><?php endif; ?>

						<input type="hidden" name="good_ids[]" value="<?php echo ($vo["good_id"]); ?>">
						<input type="hidden" name="shop_prices[]" value="<?php echo ($vo["shop_price"]); ?>">
						<input type="hidden" name="promote_prices[]" value="<?php echo ($vo["promote_price"]); ?>">
						<input type="hidden" name="is_promotes[]" value="<?php echo ($vo["is_promote"]); ?>">

						<div class="have">
							<div class="plusless">
								<div class="less" onclick="cartIncDec(<?php echo ($vo["good_id"]); ?>, 0, <?php echo ($key); ?>);">-</div><input type="text" name="num[]" value="<?php echo ($vo["num"]); ?>" class="rmb_input"><div class="plus" onclick="cartIncDec(<?php echo ($vo["good_id"]); ?>, 1, <?php echo ($key); ?>);">+</div>
							</div>
							<span>有货</span></div>
							<div class="compute">
								<?php echo ($vo["total"]); ?>
							</div>
						<div class="operating-btn">
							<span onclick="delCart(<?php echo ($vo["good_id"]); ?>);">删除</span>
							<span onclick="moveCart(<?php echo ($vo["good_id"]); ?>, <?php echo ($vo["shop_price"]); ?>);">移动我的收藏</span>
						</div>

				</div><?php endforeach; endif; ?>


			<div class="shopping_footer">
				<input type="checkbox" name="name" value="" onclick="full_select();">
				<ul>
					<li onclick="full_select();" class="full_select" class="cart_select_box">全选</li>
					<li onclick="del_select();" class="cart_select_box">全不选</li>
					<li onclick="delMutCart();">删除选中的商品</li>
					<li onclick="moveMutCart();">移动到我的收藏</li>
				</ul>
				<div class="billing">
						<p>已选择<span>1</span>件商品总价：<em>￥<?php echo ($result['total']); ?></em></p>
						<p class="save">
							优惠/促销：： -<span>￥<?php echo ($result['sheng']); ?></span>
						</p>
						<div class="clr"></div>
						<div class="billing-btn">
								<input type="submit" name="name" value="去结算">
						</div>
				</div>
			</div>
		</div>
	</form>
<?php else: ?>
	<p class="info-p">您的购物车中暂无商品，正在返回上一页...</p>

	<script type="text/javascript">
		setTimeout(function () {
			history.go(-1);
		}, 1000);

	</script><?php endif; ?>



<script type="text/javascript">

	$('input[type=checkbox]').click(function () {
		$.get('/Cart/getAjaxTotal', $('#accounts-form').serialize(), function (msg) {
			$('.billing p em').html('￥'+msg.total);
			$('.save > span').html('￥'+msg.sheng);
		});
	});
</script>



    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Cart/showCart?wap=1" target="_blank">手机版</a>
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
