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

 <div class="wrap">
	<div class="header">
				<div class="ori-image">
					<div class="hea" style="background: #F6F6F6 url(/Public/Home/Img/<?php if(($is_collect) == "1"): ?>heart_full<?php else: ?>heart<?php endif; ?>.png) no-repeat scroll center 10px;" current="<?php echo ($is_collect); ?>"  onclick="collect(this, <?php echo ($row["good_id"]); ?>, <?php echo ($row["shop_price"]); ?>);">
						<?php echo ($row["collect_num"]); ?>
					</div>

					<?php if(is_array($imgList)): foreach($imgList as $key=>$img): ?><img src="<?php echo ($img["save_path"]); ?>" class="imag"/><?php endforeach; endif; ?>

					<div class="article">
						<ul>
							<?php if(is_array($imgList)): foreach($imgList as $key=>$img): ?><li <?php if(($key) == "0"): ?>class="article_hover"<?php endif; ?> ><img src="<?php echo ($img["save_path"]); ?>" alt="" /></li><?php endforeach; endif; ?>
						</ul>
					</div>
				</div>
				<div class="simple">
					<h3><?php echo ($row["good_name"]); ?></h3>
					<div class="rmb">
						<em>￥</em>
						<span class="qian <?php if(($row["is_promote"]) == "1"): ?>shan<?php endif; ?>">
							<?php echo ($row["shop_price"]); ?>
						</span>
						<?php if(($row["is_chaffer"]) == "1"): ?><span class="is-discount">可议价</span>
						<?php else: ?>
							<span class="is-discount">不可议价</span><?php endif; ?>
						<?php if(($row["is_new"]) == "1"): ?><span class="is-new">全新商品</span>
	          <?php else: ?>
	            <span class="is-new">二手商品</span><?php endif; ?>
					</div>
					<!-- <span style="color:#999; margin-left:5px;">浏览次数</span> -->
					<div class="list">
							<div class="list_left">
										<ul>
											<li>我想换购</li>
											<li>促销信息</li>
											<li>交易地点</li>
											<li class="two">卖家</li>
											<li>认证状态</li>
											<li>联系方式</li>
											<li class="two">QQ</li>
											<li class="two">库存</li>
											<li style="margin-bottom:0px;">发布时间</li>
										</ul>
							</div>
							<div class="list_right">
										<ul>
											<li>
											<?php if(!empty($row["switch"])): echo ($row["switch"]); else: ?>无<?php endif; ?>
											</li>
											<li class="list_right-rmb">
												<?php if(($row["is_promote"]) == "1"): ?><em>￥</em><span><?php echo ($row["promote_price"]); ?></span>
												<?php else: ?>
													无<?php endif; ?>
											</li>
											<li class="address" title="<?php echo ($row["address"]); ?>"><?php echo ($row["address"]); ?></li>
											<li>
												<a href="/User/showUser/user_id/<?php echo ($row["user_id"]); ?>" class="show_user_name"><?php echo ($row["user_name"]); ?></a>
												<a title="联系他/她" href="#none" class="btn-im btn-im-jd tel_me_show" onclick="addLetter(<?php echo ($row["user_id"]); ?>, '<?php echo ($row["user_name"]); ?>', <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>);"></a>
											</li>
											<?php if(!empty($location)): ?><li><?php echo ($location); ?></li>dfdsfdsf
												<?php else: ?>
													<li>未验证</li><?php endif; ?>

											<?php if(empty($row["phone"])): ?><li>无</li>
												<?php else: ?>
												<?php if(empty($_SESSION['shop']['user'])): ?><li class="login_text"><?php echo (substr($row["phone"],0,4)); ?>*******<a class="login_btn">登录查看全部信息</a></li>
												<?php else: ?>
													<?php if(empty($row["phone"])): ?><li class="login_text">无</li>
													<?php else: ?>
														<li class="login_text"><?php echo ($row["phone"]); ?></li><?php endif; endif; endif; ?>

											<?php if(empty($row["qq"])): ?><li>无</li>
												<?php else: ?>
												<?php if(empty($_SESSION['shop']['user'])): ?><li class="login_text"><?php echo (substr($row["qq"],0,4)); ?>*******<a class="login_btn">登录查看全部信息</a></li>
												<?php else: ?>
													<?php if(empty($row["qq"])): ?><li class="login_text">无</li>
													<?php else: ?>
														<li class="login_text"><?php echo ($row["qq"]); ?></li><?php endif; endif; endif; ?>
											<li><?php echo ($row["good_number"]); ?></li>

											<li style="margin-bottom:0px;"><?php echo (date("Y-m-d H:i:s",$row["add_time"])); ?></li>

										</ul>
							</div>
							<div class="gou">

							<!-- 逻辑开始 -->
								<?php if(($row["is_delete"]) == "1"): ?><span class="wuhuo">该商品已被删除</span>
								<?php else: ?>
								    <?php if (C('CHECK_ISSUE_GOOD') && $row['is_check'] != 1) { ?>
								    	<span class="wuhuo">该商品暂未审核</span>
								    <?php } else { ?>
								        <?php if(($row["good_number"]) < "1"): ?><span class="wuhuo">该商品暂时无货</span>
								        <?php else: ?>
								            <?php if ($row['user_id'] != session('user.user_id')) { ?>
							        			<?php if(($row["is_switch"]) == "1"): ?><a href="/Switch/match/good_id/<?php echo ($row["good_id"]); ?>">
														<img class="add_cart_img huangou" src="/Public/Home/Img/huangou.png"/>
													</a><?php endif; ?>
							        			<img class="add_cart_img" src="/Public/Home/Img/add_cart.png" onclick="addCart(<?php echo ($row["good_id"]); ?>);"/>
							        			<div class="plusless_good">
							        				<div class="less" onclick="numIncDec(<?php echo ($row["good_id"]); ?>, 0);">-</div>
							        				<input type="text" value="1" id="rmb_input">
							        				<div class="plus" onclick="numIncDec(<?php echo ($row["good_id"]); ?>, 1);">+</div>
							        			</div>
								            <?php } endif; ?>
								    <?php } endif; ?>
							<!-- 逻辑结束 -->

							</div>
					</div>

					<div class="clear"></div>

					<div class="newspaper">
							<ul>
								<li class="report" onclick="liftGood(<?php echo ($row["good_id"]); ?>);">举报</li>
							</ul>
					</div>
				</div>
	</div>
	<div class="Product_desciption">
				<div class="Profile_picture">
							<span><img src="<?php echo ($head_img); ?>" alt="" /></span>
				</div>
				<div class="text_description">
					<?php echo ($row["good_desc"]); ?>
				</div>
	</div>
	<div class="comment">
			<h5 _num="<?php echo (count($commentList)); ?>">评论</h5>
			<!-- <div class="comment-view"> -->
				<div class="comment-wr">

					<?php if(is_array($commentList)): foreach($commentList as $key=>$vo): ?><div class="single_reviews">
							<div class="comments_avatar">
								<a href="/User/showUser/user_id/<?php echo ($vo["user_id"]); ?>">
									<img src="<?php echo ($vo["save_path"]); ?>" alt="" />
								</a>
							</div>
							<div class="reply">
								<?php if(empty($vo["raply_id"])): ?><a href="/User/showUser/user_id/<?php echo ($vo["user_id"]); ?>">
								 		<p class="user_comment username" uid="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></p>
								 	</a>
							 	<?php else: ?>
								 	<p class="user_comment">
								 		<a href="/User/showUser/user_id/<?php echo ($vo["user_id"]); ?>">
									 		<span class="user_name username" uid="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></span>
									 	</a>
									 	<span class="huifu">回复</span>
									 	<a href="/User/showUser/user_id/<?php echo ($vo["raply_id"]); ?>">
									 		<span id="raply_name"><?php echo ($vo["raply_name"]); ?></span>
									 	</a>
								 	</p><?php endif; ?>
								 <div class="comment_text"><?php echo ($vo["content"]); ?></div>
							</div>
							<!-- 回复按钮 -->
							<div class="recover_text" onclick="setRecover(this, <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>);">回复</div>
							<span class="comment_time">发表于<?php echo (date("Y-m-d H:i",$vo["add_time"])); ?></span>
						</div><?php endforeach; endif; ?>

				</div>
			<!-- </div> -->

			<!-- <div class="more-style more">显示全部评论</div> -->

	        <?php if(!empty($_SESSION['shop']['user'])): ?><div class="reply_box">
					<div class="reply_box_avatar">
						<a href="/User/showUser/user_id/<?php echo ($row["user_id"]); ?>">
							<img src="<?php echo session('user.save_path'); ?>" alt="" />
						</a>
					</div>
					<div>
						<form class="send_comment">
							<input type="hidden" name="good_id" value="<?php echo ($row["good_id"]); ?>">
							<input type="hidden" name="good_user_id" value="<?php echo ($row["user_id"]); ?>">
							<input type="hidden" name="good_user_name" value="<?php echo ($row["user_name"]); ?>">
							<input type="hidden" name="raply_id" value="">
							<input type="hidden" name="raply_name" value="">
							<input type="hidden" name="user_id" value="<?php echo session('user.user_id'); ?>">
							<input type="hidden" name="user_name" value="<?php echo session('user.user_name'); ?>">
							<textarea type="text" name="content" class="reply_to_text_box comment_content"></textarea>
							<input type="button" name="submit" value="评论" onclick="addComment(this);" class="reply_box_button comment_btn">
						</form>
					</div>
				</div><?php endif; ?>

			<div class="page-wrap">
				<div class="mt20">
				    <div class="pagin fr">
				        <div><?php echo ($page); ?></div>
				    </div>
				    <div class="clr"></div>
				</div>
			</div>
	</div>


	<!-- <div class="want">
		<h4>猜你想要</h4>
			<ul>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
	</div> -->
	<div class="clear"></div>



    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/2.html?wap=1" target="_blank">手机版</a>
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