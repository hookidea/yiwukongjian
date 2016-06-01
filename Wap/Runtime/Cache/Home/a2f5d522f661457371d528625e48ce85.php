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


 
      <div class="Personal_top">个人中心<span></span></div>
      <div class="Personal_wrap">
          <div class="personal_back">
              <img src="<?php echo session('user.save_path'); ?>" alt="">
              <span class="personal_user"><?php echo session('user.user_name'); ?></span>
              <!-- <span class="grade">用户等级</span> -->
          </div>
            <div class="personal_nav">
              <ul>
                <a href="/Good/issue"><li><span>发布商品</span></li></a>
                <a href="/Beg/issue"><li><span>发布求购</span></li></a>
                <a href="/Lost/issue"><li><span>发布招领</span></li></a>
                <a href="/User/showCollect"><li><span>我的收藏</span></li></a>
                <a href="/Good/getUserList"><li><span>我的商品</span></li></a>
                <a href="/Beg/getUserList"><li><span>我的求购</span></li></a>
                <a href="/Lost/getUserList"><li><span>我的招领</span></li></a>
                <a href="/Message/showMessage"><li><span><s>我的消息<?php if(($total) > "0"): ?><b><?php echo ($total); ?></b><?php endif; ?></s></span></li></a>
                <a href="/Switch/showSwitch"><li><span>我的换购</span></li></a>
                <a href="/Order/showOrder"><li><span>我的订单</span></li></a>
                <a href="/User/showUser"><li><span>我的账号</span></li></a>
                <a href="/User/logout"><li><span>退出</span></li></a>
                <div class="clear"></div>
              </ul>
            </div>
      </div>
    <div class="bottom">
        <ul>
          <li><a href="/"><img src="/Public/Wap/Img/bmt.png"/></a></li>
          <li><a href="/Category/getList"><img src="/Public/Wap/Img/bmp.png"/></a></li>
          <li><a href="/User/index"><img src="/Public/Wap/Img/bmw.png"/></a></li>
        </ul>
    </div>

<?php if(!empty($_GET['keyword'])): ?><p class="keyword-info">提示：搜索结果可能存在延时！</p><?php endif; ?>

<div id="go-top">
    <img src="/Public/Wap/Img/top.png" />
</div>

<?php if (!in_array(CONTROLLER_NAME, ['User', 'Category'])) { ?>
<footer>
      <a href="/">首页</a>
      <a href="/User/index?wap=0">电脑版</a>
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
