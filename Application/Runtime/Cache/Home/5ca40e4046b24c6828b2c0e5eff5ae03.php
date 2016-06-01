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

 <link rel="stylesheet" type="text/css" href="/Public/Home/Css/showMessage.css?v=0.2">
<div class="container">
	<div class="suibian">
		<ul class="middle_nav">
		  <li><a href="/User/showUser">我的资料</a></li>
	      <li><a href="/Good/getUserList">商品管理</a></li>
	      <li><a href="/Beg/getUserList">求购管理</a></li>
	      <li><a href="/Lost/getUserList">招领管理</a></li>
	      <li><a href="/User/showCollect">收藏管理</a></li>
	      <li><a href="/User/showAddress">地址管理</a></li>
	      <li><a href="/Order/showOrder">订单管理</a></li>
	      <li><a href="/Switch/showSwitch">换购管理</a></li>
	      <li class="personalhover"><a href="/Message/showMessage">消息管理</a></li>
	      <li><a href="/User/showReal">认证管理</a></li>
		</ul>
		<div class="clear"></div>
	</div>

	<div id="container">
	<div class="w">
		<div id="content">
			<div id="main" style="height: 659px;">
				<div class="mod-main mod-comm message-box">
					<form action="" id="queryMsgFrom" method="post">
					<div class="mc">
						<div class="mg-left" style="padding-top:0px">
							<div class="ui-scrollbar-wrap" style="position: relative; overflow: hidden; width: 253px; height: 659px; z-index: 0;">
							<div style="position: relative; overflow: hidden; width: 253px; height: 659px; z-index: 0;" class="ui-scrollbar-wrap">
								<div class="mg-noticelist" style="position: absolute; left: 0px; top: 0px; overflow: hidden;">
									<div class="ui-scrollbar-main">
										<ul>
											<!-- 一个侧边栏开始 -->
	    					        		<li onclick="queryByType(1)" class="mg-types <?php if(($_GET['type']) == "1"): ?>mg-types-cur<?php endif; ?>">
								        		<span class="mg-timg actimg">
	    										<s id="unsubscribe_icon_1" class="hide"></s>
	    								        </span>
	    						        		<div class="mg-tcont">
	        										<div class="mg-ttitle">
	    												<div style="float:left;width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
			            									<a href="/Message/showMessage/type/1" title="系统通知">
			            										系统通知
			            									</a>
	        											</div>
	        										<span class="mg-ttime"></span>
	        										</div>
			            							<span class="mg-illus">
			            								<div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:135px;float:left">
			            									<?php if(($notReadSystemInfo) != "0"): ?><font color="red"><?php echo ($notRead); ?>条未读消息</font>
		            										<?php else: ?>
			            										<font color="grey">无未读消息</font><?php endif; ?>

			            								</div>
			            							</span>
	        									</div>
	    									</li>
	    									<li onclick="queryByType(2)" class="mg-types <?php if(($_GET['type']) == "2"): ?>mg-types-cur<?php endif; ?>">
								        		<span class="mg-timg actimg">
	    										<s id="unsubscribe_icon_1" class="hide"></s>
	    								        </span>
	    						        		<div class="mg-tcont">
	        										<div class="mg-ttitle">
	    												<div style="float:left;width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
			            									<a href="javascript:void(0);" title="订单通知">
			            										订单通知
			            									</a>
	        											</div>
	        										<span class="mg-ttime"></span>
	        										</div>
			            							<span class="mg-illus">
			            								<div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:135px;float:left">
			            								    <?php if(($notReadOrderInfo) != "0"): ?><font color="red"><?php echo ($notReadOrderInfo); ?>条未读消息</font>
		            										<?php else: ?>
			            										<font color="grey">无未读消息</font><?php endif; ?>
			            								</div>
			            							</span>
	        									</div>
	    									</li>
	    									<li onclick="queryByType(3)" class="mg-types <?php if(($_GET['type']) == "3"): ?>mg-types-cur<?php endif; ?>">
								        		<span class="mg-timg actimg">
	    										<s id="unsubscribe_icon_1" class="hide"></s>
	    								        </span>
	    						        		<div class="mg-tcont">
	        										<div class="mg-ttitle">
	    												<div style="float:left;width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
			            									<a href="javascript:void(0);" title="商品交换">
			            										商品交换
			            									</a>
	        											</div>
	        										<span class="mg-ttime"></span>
	        										</div>
			            							<span class="mg-illus">
			            								<div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:135px;float:left">
			            								    <?php if(($notReadSwitchInfo) != "0"): ?><font color="red"><?php echo ($notReadSwitchInfo); ?>条未读消息</font>
		            										<?php else: ?>
			            										<font color="grey">无未读消息</font><?php endif; ?>
			            								</div>
			            							</span>
	        									</div>
	    									</li>
	    									<li onclick="queryByType(4)" class="mg-types <?php if(empty($_GET['type'])): ?>mg-types-cur<?php endif; ?>">
								        		<span class="mg-timg actimg">
	    										<s id="unsubscribe_icon_1" class="hide"></s>
	    								        </span>
	    						        		<div class="mg-tcont">
	        										<div class="mg-ttitle">
	    												<div style="float:left;width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
			            									<a href="javascript:void(0);" title="订单通知">
			            										私信通知
			            									</a>
	        											</div>
	        										<span class="mg-ttime"></span>
	        										</div>
			            							<span class="mg-illus">
			            								<div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:135px;float:left">
			            								    <?php if(($notReadLetter) != "0"): ?><font color="red"><?php echo ($notReadLetter); ?>条未读消息</font>
		            										<?php else: ?>
			            										<font color="grey">无未读消息</font><?php endif; ?>
			            								</div>
			            							</span>
	        									</div>
	    									</li>
	    									<li onclick="queryByType(5)" class="mg-types <?php if(($_GET['type']) == "5"): ?>mg-types-cur<?php endif; ?>">
								        		<span class="mg-timg actimg">
	    										<s id="unsubscribe_icon_1" class="hide"></s>
	    								        </span>
	    						        		<div class="mg-tcont">
	        										<div class="mg-ttitle">
	    												<div style="float:left;width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
			            									<a href="javascript:void(0);" title="回复通知">
			            										回复通知
			            									</a>
	        											</div>
	        										<span class="mg-ttime"></span>
	        										</div>
			            							<span class="mg-illus">
			            								<div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:135px;float:left">
			            								    <?php if(($notReadCommentInfo) != "0"): ?><font color="red"><?php echo ($notReadCommentInfo); ?>条未读消息</font>
		            										<?php else: ?>
			            										<font color="grey">无未读消息</font><?php endif; ?>
			            								</div>
			            							</span>
	        									</div>
	    									</li>
	    									<!-- 一个侧边栏结束 -->
	    					        	</ul>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="mg-right" style="padding-bottom: 10px; height: 659px;">

						<div class="ui-scrollbar-wrap" style="position: relative; height: 675px; z-index: 0;">
							<div class="ui-scrollbar-main" style="margin-top:10px">

						    	<ul id="msg-node-6163378646" class="mg-coupon">
								<!-- 每个消息开始 -->
								<?php if(is_array($list)): foreach($list as $key=>$vo): ?><li>
										<span class="mg-time" style="width:125px;margin-left:230px"><?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?></span>
										<div class="mg-box">
											<div class="mg-title">
	    										<h4 style="float: left"><?php echo ($vo["user_name"]); ?></h4>
											</div>
											<div class="mg-content clearfix">
												<div>
													<?php echo ($vo["content"]); ?>
												</div>
												<span onclick="addLetter(<?php echo ($vo["user_id"]); ?>, '<?php echo ($vo["user_name"]); ?>');" href="<?php echo ($vo["url"]); ?>" class="mg-details">
										    		点击回复&nbsp;&gt;&nbsp;
										    	</span>
										    </div>
										</div>
									</li><?php endforeach; endif; ?>
								<!-- 每个消息结束 -->
								</ul>
							</div>
						</div>
					</div>
					</div>
					</form>
				</div>
			</div>
	 		</div>
	</div>
	</div>
</div>

<div class="mt20">
    <div class="pagin fr">
        <div><?php echo ($page); ?></div>
    </div>
    <div class="clr"></div>
</div>

</body>
</html>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Letter/showLetter?wap=1" target="_blank">手机版</a>
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
