<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>易物空间</title>
    <link rel="stylesheet" type="text/css" href="/Public/Wap/Css/index.css?v=2.1">
    <link rel="shortcut icon" href="/Public/Home/Img/favicon.ico" />
    <script src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/Wap/Js/begin.js"></script>
  </head>
<body>


 
<div id="back" class="back"></div>
<div class="msg"></div>
<div class="form"></div>

<p id="top"><a><img src="/Public/Wap/Img/bg.png" alt=""></a><span id="more"><img src="/Public/Wap/Img/more.png" alt=""/><?php if(!empty($notReadCount)): ?><b></b><?php endif; ?></span>
    <?php switch($_GET['type']): case "2": ?>订单通知<?php break;?>
        <?php case "1": ?>系统通知<?php break;?>
        <?php case "3": ?>商品交换<?php break;?>
        <?php case "4": ?>私信通知<?php break;?>
        <?php case "5": ?>回复通知<?php break;?>
        <?php default: ?>私信通知<?php endswitch;?>
    <ul id="more_in">
        <li onclick="queryByType(2)">订单通知<span class="not-real-num"><?php echo ($notReadOrderInfo); ?></span></li>
        <li onclick="queryByType(1)">系统通知<span class="not-real-num"><?php echo ($notReadSystemInfo); ?></span></li>
        <li onclick="queryByType(3)">商品交换<span class="not-real-num"><?php echo ($notReadSwitchInfo); ?></span></li>
        <li onclick="queryByType(4)">私信通知<span class="not-real-num"><?php echo ($notReadLetterInfo); ?></span></li>
        <li onclick="queryByType(5)">回复通知<span class="not-real-num"><?php echo ($notReadCommentInfo); ?></span></li>
        <li onclick="location.href='/User/index'">个人中心</li>
        <li onclick="location.href='/'">返回首页</li>
    </ul>
</p>
<div id="beg-wrap">
    <?php if(!empty($list)): ?><ul id="news">
            <?php if(is_array($list)): foreach($list as $key=>$vo): ?><li>
                	<span class="time"><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></span>
                    <h4 class="style"><?php echo ($vo["user_name"]); ?></h4 >
                    <div class="clear"></div>
                    <p class="con"><?php echo ($vo["content"]); ?></p>
                    <span class="huifu-letter" onclick="addLetter(<?php echo ($vo["user_id"]); ?>, '<?php echo ($vo["user_name"]); ?>', <?php echo (is_array($_SESSION['shop']['user'])); ?>);">回复 ></span>
                    <div class="clear"></div>
                </li><?php endforeach; endif; ?>
        </ul>
    <?php else: ?>
        <p class="empty-p">暂无信息</p><?php endif; ?>
</div>

<?php if(!empty($_GET['keyword'])): ?><p class="keyword-info">提示：搜索结果可能存在延时！</p><?php endif; ?>

<div id="go-top">
    <img src="/Public/Wap/Img/top.png" />
</div>

<?php if (!in_array(CONTROLLER_NAME, ['User', 'Category'])) { ?>
<footer>
      <a href="/">首页</a>
      <a href="/Letter/showLetter?wap=0">电脑版</a>
      <a onclick="addBug(1);">反馈建议</a>
      <a href="/Index/article" class="last">服务条款</a>
      <p>Copyright © 2016 YW.GZITTC.COM. All rights reserved.</p>
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