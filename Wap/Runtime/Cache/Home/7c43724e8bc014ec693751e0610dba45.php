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

      <div class="top">
        <h1><a href="/"><img src="/Public/Wap/Img/logo.png" /></h1></a>
          <form method="get" action="/Good/getList">
              <input type="submit" value="" class="keyword-submit">
              <span class="search-btn"></span>
              <input type="text" name="keyword" placeholder="搜索商品" value="<?php echo ($_GET['keyword']); ?>">
          </form>
      </div>
      <div class="wrap">
          <!-- <div class="ul-wrap">
            <ul class="first_row">
              <a href="/Good/issue"><li><img src="/Public/Wap/Img/1.png" alt="">发布商品</li></a>
              <a href="/Collect/showCollect"><li><img src="/Public/Wap/Img/2.png" alt="">我的关注</li></a>
              <li><img src="/Public/Wap/Img/3.png" alt="">失物招领</li>
              <li><img src="/Public/Wap/Img/2.png" alt="">我的二手</li>
            </ul>
          </div>
          <div class="clear"></div> -->
          <!-- http://14web.cn/Good/getList/cat_id/9/sort/sales_num/order/desc -->
          <div class="recommend">
                <div class="index-more"><h3>最新更新<a href="/Good/getList/sort/add_time/order/desc" class="right">更多>></a></h3></div>
                <ul class="good-list">
                  <?php if(is_array($timeList)): foreach($timeList as $key=>$to): ?><li>
                          <a href="/<?php echo ($to["good_id"]); ?>.html"><div class="index_img"><img src="<?php echo ($to["thumb_img"]); ?>" alt="<?php echo ($to["good_name"]); ?>" /></div></a>
                          <div class="name_wrap">
                            <p>
                              <?php echo ($to["good_name"]); ?>
                            </p>
                          </div>
                          <div class="love-item-bottom">
                            <?php if(($to["is_promote"]) == "1"): ?><span class="shop_price">￥<?php echo ($to["promote_price"]); ?></span>
                              <?php else: ?>
                                <span class="shop_price">￥<?php echo ($to["shop_price"]); ?></span><?php endif; ?>
                            <a href="/User/showUser/user_id/<?php echo ($to["user_id"]); ?>"><span class="right user_name"><?php echo ($to["user_name"]); ?></span></a>
                          </div>
                        </li><?php endforeach; endif; ?>

                  <div class="clear"></div>
                </ul>
                <div class="clear"></div>
          </div>
          <div class="recommend">
                <div class="index-more"><h3>最高销量<a href="/Good/getList/sort/sales_num/order/desc" class="right">更多>></a></h3></div>
                <ul class="good-list">
                  <?php if(is_array($salesList)): foreach($salesList as $key=>$to): ?><li>
                      <a href="/<?php echo ($to["good_id"]); ?>.html">
                      <div class="index_img"><img src="<?php echo ($to["thumb_img"]); ?>" alt="<?php echo ($to["good_name"]); ?>" /></div></a>
                      <div class="name_wrap">
                        <p>
                          <?php echo ($to["good_name"]); ?>
                        </p>
                      </div>
                      <div class="love-item-bottom">
                        <?php if(($to["is_promote"]) == "1"): ?><span class="shop_price">￥<?php echo ($to["promote_price"]); ?></span>
                          <?php else: ?>
                            <span class="shop_price">￥<?php echo ($to["shop_price"]); ?></span><?php endif; ?>
                        <a href="/User/showUser/user_id/<?php echo ($to["user_id"]); ?>"><span class="right user_name"><?php echo ($to["user_name"]); ?></span></a>
                      </div>
                    </li><?php endforeach; endif; ?>

                  <div class="clear"></div>
                </ul>
                <div class="clear"></div>
          </div>
      </div>
    <div class="bottom">
        <ul>
          <li><a href="/"><img src="/Public/Wap/Img/bmu.png"/></a></li>
          <li><a href="/Category/getList"><img src="/Public/Wap/Img/bmp.png"/></a></li>
          <li><a href="/User/index"><img src="/Public/Wap/Img/bmv.png"/></a></li>
        </ul>
    </div>

<?php if(!empty($_GET['keyword'])): ?><p class="keyword-info">提示：搜索结果可能存在延时！</p><?php endif; ?>

<div id="go-top">
    <img src="/Public/Wap/Img/top.png" />
</div>

<?php if (!in_array(CONTROLLER_NAME, ['User', 'Category'])) { ?>
<footer>
      <a href="/">首页</a>
      <a href="/?wap=0">电脑版</a>
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