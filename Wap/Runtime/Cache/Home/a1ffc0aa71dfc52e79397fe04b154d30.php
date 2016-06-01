<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
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

    <p id="top"><a><img src="/Public/Wap/Img/bg.png" alt=""></a><span id="more"><img src="/Public/Wap/Img/more.png" alt=""/></span>
        商品详情
        <ul id="more_in">
            <li onclick="location.href='/User/index'">个人中心</li>
            <li onclick="location.href='/'">返回首页</li>
        </ul>
    </p>
<div class="wrap">
    <div class="img">
      <div class="brand_new">
        <?php if(($row["is_new"]) == "1"): ?>全新
          <?php else: ?>
            二手<?php endif; ?>
      </div>
        <div id="slider-wrap">
          <ul id="slider">
            <?php if(is_array($imgList)): foreach($imgList as $key=>$io): ?><li><img src="<?php echo ($io["save_path"]); ?>" /></li><?php endforeach; endif; ?>
          </ul>
        </div>
        <div class="pages">
          <?php if(($row["is_promote"]) == "1"): ?><span class="detall_money"><em>￥</em><?php echo ($row["promote_price"]); ?></span>
              <span class="detall_money" style="text-decoration: line-through;"><em>￥</em><?php echo ($row["shop_price"]); ?></span>
            <?php else: ?>
              <span class="detall_money"><em>￥</em><?php echo ($row["shop_price"]); ?></span><?php endif; ?>

          <span class="chaffer">
            <?php if(($row["is_chaffer"]) == "1"): ?>可议价
              <?php else: ?>
                不可议价<?php endif; ?>
          </span>
          <span class="collect <?php if(($is_collect) == "1"): ?>collect-on<?php else: ?>collect-off<?php endif; ?>" current="<?php echo ($is_collect); ?>" onclick="collect(this, <?php echo ($row["good_id"]); ?>, <?php echo ($row["shop_price"]); ?>);"></span>
          <span class="number">1/<?php echo (count($imgList)); ?></span>
        </div>
    </div>
    <div class="brief_introduction">
      <?php echo ($row["good_name"]); ?>
    </div>
    <div class="details_column">
        <div class="release">发布时间：<?php echo (date('Y-m-d H:i:s',$row["add_time"])); ?></div>
        <!-- <div class="frequency">浏览次数:111</div> -->
        <div class="clear"></div>
        <div class="transaction">
          交易地点：<span><?php echo ($row["address"]); ?></span>
        </div>

    </div>
    <div class="item">
        <div class="item_img"><img src="<?php echo ($head_img); ?>" alt="">
          <span class="item_name"><a href="/User/showUser/user_id/<?php echo ($row["user_id"]); ?>" style="color: #52B0D4;"><?php echo ($row["user_name"]); ?></a>（<?php if(($is_real) == "1"): ?>已实名<?php else: ?>未实名<?php endif; ?>）<a style="margin-top:-2px;" clstag="click|keycount|orderlist|ziyingchatim" title="联系他/她" href="#none" class="btn-im btn-im-jd" onclick="addLetter(<?php echo ($row["user_id"]); ?>, '<?php echo ($row["user_name"]); ?>', <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>);"></a></span>
        </div>
    </div>
    <div class="introduction">
      <!-- <span class="product_details"><img src="/Public/Wap/Img/8.png" alt=""></span> -->
      <p>卖家描述：<?php echo ($row["good_desc"]); ?></p>
      <div class="clear"></div>
    </div>
    <?php if(!empty($row["switch"])): ?><div class="contact_information">
         我想换购：<?php echo ($row["switch"]); ?>
      </div><?php endif; ?>
    <div class="contact_information">
         库　　存：<?php echo ($row["good_number"]); ?>
    </div>
      <div class="contact_information">
          <div class="phone">
            <?php if(!empty($row["qq"])): if(empty($_SESSION['shop']['user'])): ?><p>Q&nbsp;&nbsp;　　Q：<?php echo (substr($row["qq"],0,4)); ?>*******<a class="login-text" href="/User/login">登录查看全部信息</a></p>
                <?php else: ?>
                  <?php if(!empty($row["qq"])): ?><p>Q　　&nbsp;&nbsp;Q：<?php echo ($row["qq"]); ?></p><?php endif; endif; endif; ?>

            <?php if(!empty($row["phone"])): if(empty($_SESSION['shop']['user'])): ?><p>手　　机：<?php echo (substr($row["phone"],0,4)); ?>*******<a class="login-text" href="/User/login">登录查看全部信息</a></p>
                <?php else: ?>
                  <?php if(!empty($row["phone"])): ?><p>手　　机：<?php echo ($row["phone"]); ?></p><?php endif; endif; endif; ?>

          </div>
          <div class="clear"></div>
      </div>
      <div class="leave_message">
        <div class="text_box">
          <form class="send_comment" method="POST">
            <input type="hidden" name="good_id" value="<?php echo ($row["good_id"]); ?>">
            <input type="hidden" name="raply_id" value="">
            <input type="hidden" name="raply_name" value="">
            <input type="hidden" name="good_user_id" value="<?php echo ($row["user_id"]); ?>">
            <input type="hidden" name="good_user_name" value="<?php echo ($row["user_name"]); ?>">
            <input type="hidden" name="user_id" value="<?php echo session('user.user_id'); ?>">
            <input type="hidden" name="user_name" value="<?php echo session('user.user_name'); ?>">

            <?php if(!empty($_SESSION['shop']['user'])): ?><textarea name="content" class="reply_to_text_box comment_content"></textarea>
              <button type="button" name="button" class="reply_box_button comment_btn" onclick="addComment(this, '<?php echo session("user.save_path"); ?>');">评论</button><?php endif; ?>
            <div class="clear"></div>
          </form>
        </div>
        <div class="commentList">
          <div class="comment-wr">
            <?php if(is_array($commentList)): foreach($commentList as $key=>$vo): ?><div class="message_text">
                <?php if(empty($vo["raply_id"])): ?><div class="message_user">
                    <span class="username" uid="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></span>
                  </div>
                <?php else: ?>
                  <div class="user_comment">
                    <div class="message_user username" uid="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></div>
                    <div class="message_user huifu-text">回复</div>
                    <div class="message_user"><?php echo ($vo["raply_name"]); ?></div>
                  </div><?php endif; ?>
                <div class="detall_reply" onclick="setRecover(this, <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>)">回复</div>
                <div class="message_user time"><?php echo (date("m-d H:i",$vo["add_time"])); ?></div>
                <div class="clear"></div>
                <div class="detall_text"><?php echo ($vo["content"]); ?></div>
              </div><?php endforeach; endif; ?>
          </div>
          <div class="page-wrap">
            <div class="mt20">
                <div class="pagin fr">
                    <div><?php echo ($page); ?></div>
                </div>
                <div class="clr"></div>
            </div>
          </div>

        </div>


      </div>

        <!-- 逻辑开始 -->
          <?php if(($row["is_delete"]) == "1"): ?><div class="Join"><a class="shan">该商品已被删除</a></div>
          <?php else: ?>
              <?php if (C('CHECK_ISSUE_GOOD') && $row['is_check'] != 1) { ?>
                  <div class="Join"><a class="shan">该商品暂未审核</a></div>
              <?php } else { ?>
                  <?php if(($row["good_number"]) < "1"): ?><div class="Join"><a class="shan">该商品暂时无货</a></div>
                  <?php else: ?>
                      <?php if ($row['user_id'] != session('user.user_id')) { ?>
                          <?php if(($row["is_switch"]) == "1"): ?><div class="Join"> <a href="/Switch/match/good_id/<?php echo ($row["good_id"]); ?>">立即换购</a></div>
                          <?php else: ?>
                              <div class="Join"><a class="shan">该商品不支持换购</a></div><?php endif; ?>
                      <?php } endif; ?>
              <?php } endif; ?>
        <!-- 逻辑结束 -->
</div>

<?php if(!empty($_GET['keyword'])): ?><p class="keyword-info">提示：搜索结果可能存在延时！</p><?php endif; ?>

<div id="go-top">
    <img src="/Public/Wap/Img/top.png" />
</div>

<?php if (!in_array(CONTROLLER_NAME, ['User', 'Category'])) { ?>
<footer>
      <a href="/">首页</a>
      <a href="/Good/showGood/good_id/4?wap=0">电脑版</a>
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
