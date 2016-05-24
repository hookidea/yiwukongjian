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

 <form id="upload-form" method="post" flag="good">

<div class="wrap">
	<div class="upload_button">
			<img src="/Public/Home/Img/release-icon.png" alt="" />
	</div>
	<div class="wave">
		<img src="/Public/Home/Img/black-wave.png" alt="" />
	</div>
	<div class="post_text">
			<img src="/Public/Home/Img/release-title.png" alt="" />
	</div>
	<div class="information">
		<div class="upload-wr">
            <div class="photo-area init-up">
                <div id="html5" class="moxie-shim moxie-shim-html5" _s="<?php echo (C("IMAGE_SIZE")); ?>">
                	<div>
                        <input id="html5_file" type="file" name="" accept="image/*" class="image-input" capture="camera">
                    </div>
                </div>
            </div>
        </div>

	<div class="commodity">
		<div class="commodity_left">
			<p class="product-name"><font color="red">*</font>商品名称</p>
            <p class="product-name"><font color="red">*</font>交易地点</p>
            <p class="product-name"><font color="red">*</font>商品价格</p>
            <p class="product-name"><font color="red">*</font>所属分类</p>
            <p class="product-name"><font color="red">*</font>可否议价</p>
            <p class="product-name"><font color="red">*</font>商品类型</p>
            <p class="product-name"><font color="red">*</font>立即上架</p>
            <p class="product-name"><font color="red">*</font>可否换购</p>
            <p class="product-name">促销价格</p>
            <p class="product-name">库存数量</p>
            <p class="product-name">我想换购</p>
            <p class="product-name">搜索关键字</p>
			<p class="product-details"><font color="red">*</font>商品详情</p>
		</div>
		<div class="commodity_right">
			<div>
                <input type="text" name="good_name" class="product-text" placeholder="必填：商品名称长度必须要在1-60个字符之间">
                <div class="error-div" id="good_name-error" style="display: none; z-index: 999; text-align: left;">
                    <div class="easytip-text">必填：长度必须在1-60个字符之间</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
            <div>
                <input type="text" name="address" class="product-text" placeholder="必填：交易地点长度必须要在1-150个字符之间" value="工贸校园一站式楼下交易">
                <div class="error-div" id="address-error">
                    <div class="easytip-text">必填：长度必须在1-150个字符之间</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
            <div>
                <input type="text" value="" name="shop_price" class="price" placeholder="必填：商品价格/促销价格必填其一">
                <div class="error-div" id="shop_price-error">
                    <div class="easytip-text">必填：商品价格必须在0-99999之间</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>

			<div>
				<ul id="main_box">
				  <li class="select_box" value="">
				    <span>选择分类</span>
				    <ul class="son_ul" name="cat_id">
				    	<?php if(is_array($cateList)): foreach($cateList as $key=>$cate): ?><li value="<?php echo ($cate["cat_id"]); ?>"><?php echo ($cate["cat_name"]); ?></li><?php endforeach; endif; ?>

				    </ul>
				    <input type="hidden" name="cat_id" value="0">
				  </li>
				</ul>
			</div>
			<div class="can-knife">
				<input type="button" value="可议价" class="commodity_right_btn btn-hover" status="1">
				<input type="button" name="name" value="不可议价" class="commodity_right_btn" status="0">
				<input type="hidden" name="is_chaffer" value="1">
				<div class="clear"></div>
			</div>
			<div class="types-of">
				<input type="button" value="全新" class="commodity_right_btn" status="1">
				<input type="button" name="name" value="二手" class="commodity_right_btn btn-hover" status="0">
				<input type="hidden" name="is_new" value="1">
				<div class="clear"></div>
			</div>
			<div class="added">
				<input type="button" value="是" class="commodity_right_btn btn-hover" status="1">
				<input type="button" name="name" value="否" class="commodity_right_btn" status="0">
				<input type="hidden" name="is_on_sale" value="1">
				<div class="clear"></div>
			</div>
            <div class="added">
                <input type="button" value="是" class="commodity_right_btn btn-hover" status="1">
                <input type="button" name="name" value="否" class="commodity_right_btn" status="0">
                <input type="hidden" name="is_switch" value="1">
                <div class="clear"></div>
            </div>
            <div>
                <input type="text" value="" name="promote_price" class="price" placeholder="必填：商品价格/促销价格必填其一">
                <div class="error-div" id="promote_price-error">
                    <div class="easytip-text">选填：促销价格必须在0-99999之间</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
            <div>
                <input type="text" value="1" name="good_number" class="price" placeholder="选填：库存数量">
                <div class="error-div" id="good_number-error">
                    <div class="easytip-text">选填：库存数量必须在1-65535之间</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
            <div>
                <input type="text" name="switch" class="product-text" placeholder="选填：我想换购的物品的名称">
                <div class="error-div" id="switch-error">
                    <div class="easytip-text">选填：长度必须在30个字符内</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
            <div>
                <input type="text" value="" name="keywords" class="product-text" placeholder="选填：搜索关键字">
                <div class="error-div" id="keywords-error">
                    <div class="easytip-text">选填：长度必须在30个字符内</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
            <div>
                <textarea name="good_desc" class="product-deta-ilstext" placeholder='必填：长度必须在20-150个字符之间'></textarea>
                <div class="error-div" id="good_desc-error">
                    <div class="easytip-text">必填：长度必须在20-150个字符之间</div><div class="easytip-arrow">
                    </div>
                </div>
            </div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="contact">联系方式<span>(至少选填一个)</span></div>
	<div class="contact-information-left">
		<p class="product-name">　　<font color="red">*</font>手机</p>
		<p class="product-name">　　<font color="red">*</font>Q Q</p>
	</div>
	<div class="contact-information-right">
		<div>
            <input type="text" name="phone" class="price" placeholder="必填：手机/QQ必填其一">
            <div class="error-div" id="phone-error">
                <div class="easytip-text">必填：格式错误</div><div class="easytip-arrow">
                </div>
            </div>
        </div>
		<div>
            <input type="text" name="qq" class="price" placeholder="必填：手机/QQ必填其一">
            <div class="error-div" id="qq-error">
                <div class="easytip-text">必填：格式错误</div><div class="easytip-arrow">
                </div>
            </div>
        </div>
		<div class="Release-button">
			<input type="submit" name="name" value="立即发布">
		</div>
	</div>
	<div class="clear"></div>
</div>
</form>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Good/issue?wap=1" target="_blank">手机版</a>
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
