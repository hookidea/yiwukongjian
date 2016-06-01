<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="keywords" content="易物空间">
    <meta name="description" content="易物空间">
    <meta name="author" content="hookidea@gmail.com">
    <title>易物空间</title>
    <link rel="stylesheet" type="text/css" href="/Public/Wap/Css/index.css?v=0.2">
    <link rel="shortcut icon" href="/Public/Home/Img/favicon.ico" />
    <script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Wap/Js/begin.js"></script>
  </head>
<body>


 
<div id="back" class="back"></div>
<div class="msg"></div>
<div class="form"></div>

<div class="sou-wrap order-sou-wrap">
    <p id="top"><a><img src="/Public/Wap/Img/bg.png" alt=""></a><span class="menu-btn"><img src="/Public/Wap/Img/more.png" alt=""></span>
        我的订单
    </p>
    <div>
        <form action="/Order/showOrder" method="GET">
            <input type="text" id="sousuo" name="keyword" placeholder="请输入商品名称/用户名/订单号">
            <input type="submit" id="btn" value="">
        </form>
    </div>
</div>
<ul id="banner">
    <?php if(empty($_GET['keyword'])): ?><li onclick="location.href='/Order/showOrder/type/0';" class="<?php if(($_GET['type']) != "1"): ?>co<?php endif; ?>">买家订单</li>
        <li onclick="location.href='/Order/showOrder/type/1';" class="<?php if(($_GET['type']) == "1"): ?>co<?php endif; ?>">卖家订单</li>
    <?php else: ?>
        <li class="co">搜索：<?php echo ($_GET['keyword']); ?>，<a style="color: #999;" href="/Order/showOrder">返回查看全部</a></li><?php endif; ?>
</ul>
<div id="wrap">
    <?php if(!empty($orderList)): ?><ul id="news">
            <?php if(is_array($orderList)): foreach($orderList as $key=>$order): ?><li class="style_2">
                    <p class="news_top">订单编号：<span class="num"><?php echo ($order["order_sn"]); ?></span>
                        <span class="zhuangtai">
                            <?php if(($order["status"]) == "1"): ?>已完成<?php else: ?>未完成<span>  <b onclick="fullOrder(<?php echo ($order["order_id"]); ?>);">确认完成</b></span><?php endif; ?>
                        </span>
                    </p>
                    <?php if(is_array($goodList[$key])): foreach($goodList[$key] as $key2=>$good): ?><div class="con">
                            <span class="con_img"><img src="<?php echo ($good["thumb_img"]); ?>" alt=""></span>
                            <p class="con_c"><?php echo ($good["good_name"]); ?></p>
                            <p class="con_n">x<?php echo ($good["num"]); ?></p>
                            <div class="clear"></div>
                        </div><?php endforeach; endif; ?>
                    <p class="lianxi price">￥<?php echo ($order["total_price"]); ?></p>
                    <?php if(($_GET['type']) == "1"): ?><!-- 卖家订单 -->
                        <p class="maijia">买家：<?php echo ($order["user_name"]); ?>
                            <img src="/Public/Home/Img/taobao.gif" title="联系他/她" onclick="addLetter(<?php echo ($order["user_id"]); ?>, '<?php echo ($row["user_name"]); ?>', <?php echo (is_array($_SESSION['shop']['user'])); ?>);" />
                        <!-- <a clstag="click|keycount|orderlist|ziyingchatim" title="联系他/她" href="#none" class="btn-im btn-im-jd right" onclick="addLetter(<?php echo ($order["user_id"]); ?>, '<?php echo ($row["user_name"]); ?>', <?php echo (is_array($_SESSION['shop']['user'])); ?>);"></a> -->
                        </p>
                    <?php else: ?>
                        <!-- 买家订单 -->
                        <p class="maijia">卖家：<?php echo ($order["seller_name"]); ?>
                           <!--  <a clstag="click|keycount|orderlist|ziyingchatim" title="联系他/她" href="#none" class="btn-im btn-im-jd right" onclick="addLetter(<?php echo ($order["seller_id"]); ?>, '<?php echo ($row["user_name"]); ?>', <?php echo (is_array($_SESSION['shop']['user'])); ?>);"></a> -->
                            <img src="/Public/Home/Img/taobao.gif" title="联系他/她" onclick="addLetter(<?php echo ($order["seller_id"]); ?>, '<?php echo ($row["user_name"]); ?>', <?php echo (is_array($_SESSION['shop']['user'])); ?>);" />
                        </p><?php endif; ?>

                    <p class="lianxi"><?php if(!empty($order["phone"])): ?>手机：<?php echo ($order["phone"]); endif; ?>&nbsp;&nbsp;<?php if(!empty($order["qq"])): ?>QQ：<?php echo ($order["qq"]); endif; ?></p>
                    <div class="clear"></div>
                </li><?php endforeach; endif; ?>
        </ul>
    <?php else: ?>
        <p style="text-align: center;padding-top:20px; font-size: 14px; color: #999;">暂无</p><?php endif; ?>
</div>

<div class="mt20">
    <div class="pagin fr">
        <div><?php echo ($page); ?></div>
    </div>
    <div class="clr"></div>
</div>



<?php if(!empty($_GET['keyword'])): ?><p class="keyword-info">提示：搜索结果可能存在延时！</p><?php endif; ?>

<div id="go-top">
    <img src="/Public/Wap/Img/top.png" />
</div>

<?php if (!in_array(CONTROLLER_NAME, ['User', 'Category'])) { ?>
<footer>
      <a href="/">首页</a>
      <a href="/Order/showOrder?wap=0">电脑版</a>
      <a onclick="addBug(1);">反馈建议</a>
      <a href="/Index/article" class="last">服务条款</a>
      <p>Copyright © 2016 YW.GZITTC.com. All Rights Reserved.</p>
</footer>
<?php } ?>

<div id="loading-layer" style="width: 100%; display: none;height: 100%; opacity: 0.9; position: absolute; left: 0px; top: 0px; z-index: 1000; animation-name: fadeOut; animation-duration: 300ms; animation-timing-function: ease; animation-delay: 0ms; animation-fill-mode: both;"><div id="loader-inner" style="width: 3.375rem;height: 3.375rem;position: absolute;left: 50%;top: 50%;margin-left: -1.6875rem;margin-top: -1.6875rem;background: rgba(0,0,0,.7);border-radius: 3px;background: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzgiIGhlaWdodD0iMzgiIHZpZXdCb3g9IjAgMCAzOCAzOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHJva2U9IiNmZmYiPgogICAgPGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxIDEpIiBzdHJva2Utd2lkdGg9IjIiPgogICAgICAgICAgICA8Y2lyY2xlIHN0cm9rZS1vcGFjaXR5PSIuNSIgY3g9IjE4IiBjeT0iMTgiIHI9IjE4Ii8+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0zNiAxOGMwLTkuOTQtOC4wNi0xOC0xOC0xOCI+CiAgICAgICAgICAgICAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxOCAxOCIgdG89IjM2MCAxOCAxOCIgZHVyPSIxcyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiLz4KICAgICAgICAgICAgPC9wYXRoPgogICAgICAgIDwvZz4KICAgIDwvZz4KPC9zdmc+) no-repeat 50% 50% rgba(0,0,0,.6);background-size: 72%"></div></div>

</body>
</html>

<script type="text/javascript" src="/Public/Wap/Js/validate.js"></script>
<script type="text/javascript" src="/Public/Wap/Js/messages_zh.js"></script>
<script type="text/javascript" src="/Public/Wap/Js/script.js"></script>
<script type="text/javascript" src="/Public/Wap/Js/upload.js"></script>


<script></script>
