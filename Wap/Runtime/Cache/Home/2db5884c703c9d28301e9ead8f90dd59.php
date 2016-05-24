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

<div class="sou-wrap">
    <p id="top"><a><img src="/Public/Wap/Img/bg.png" alt=""></a><span class="menu-btn"><img src="/Public/Wap/Img/more.png" alt=""></span>
        招领专区
    </p>
    <div>
        <form action="/Lost/getList" method="GET">
            <input type="text" id="sousuo" name="keyword" placeholder="请输入您要搜索的关键字">
            <input type="submit" id="btn" value="">
        </form>
    </div>
</div>
<div id="beg-wrap">
    <?php if(isset($list)): ?><ul id="news">
                <?php if(is_array($list)): foreach($list as $key=>$vo): ?><li>
                        <h4 class="style"><?php echo ($vo["lost_title"]); ?></h4 >
                        <span class="beg-status">状态：<?php if(($vo["is_full"]) == "1"): ?>已完成<?php else: ?>未完成<?php endif; ?></span>
                        <div class="clear"></div>
                        <p class="con"><?php echo ($vo["lost_desc"]); ?></p>
                        <p class="locations_connection"><?php if(!empty($vo["phone"])): ?>手机：<?php echo (substr($vo["phone"],0,4)); ?>*******<?php endif; if(!empty($vo["qq"])): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QQ：<?php echo (substr($vo["qq"],0,4)); ?>*******<?php endif; ?></p>
                        <p class="locations_time"><span class="left"><a clstag="click|keycount|orderlist|ziyingchatim" title="联系他/她" href="#none" class="btn-im btn-im-jd left" onclick="addLetter(<?php echo ($vo["user_id"]); ?>, '<?php echo ($vo["user_name"]); ?>', <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>);"></a><a href="/User/showUser/user_id/<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></a></span>发布时间：<?php echo (date("Y-m-d",$vo["add_time"])); ?></p><!--限制字数15-->
                        <div class="clear"></div>
                    </li><?php endforeach; endif; ?>
            </ul>
        <?php else: ?>

            <p class="empty-p">抱歉，没有找到结果，正在返回上一页...</p>
            <script type="text/javascript">setTimeout(function(){history.go(-1);}, 1000);</script><?php endif; ?>
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
      <a href="/Lost/getList/lost_id/3?wap=0">电脑版</a>
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