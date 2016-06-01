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

 <link rel="stylesheet" type="text/css" href="/Public/Home/Css/match.css?v=0.2">
        <div class="wrap matches">
            <h2>商品匹配</h2>
    <?php if(!empty($userList)): ?><div class="match-left">
                <div class="ul-title">点击选择你的商品</div>
                <div class="ul-view view-left">
                    <div class="left-left div-ul">
                        <ul class="ul">
                        <?php if(is_array($userList)): foreach($userList as $key=>$uo): ?><li _user_id="<?php echo ($uo["good_id"]); ?>">
                                <img src="<?php echo ($uo["thumb_img"]); ?>" alt="">
                                <div class="desc">
                                    <a href="/<?php echo ($uo["good_id"]); ?>.html"><div class="good_name"><?php echo ($uo["good_name"]); ?></div></a>
                                    <div class="rmb-matches">￥<?php echo ($uo["shop_price"]); ?></div>
                                </div>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="left-right">
                    <div class="img_div">
                        <!-- 大图 -->
                        <!-- <img src="" alt=""> -->
                    </div>
                    <div class="desc">
                        <div class="good_name"></div>
                        <div class="rmb-matches"></div>
                    </div>
                </div>
            </div>
        <form class="match-form" method="POST" action="/Switch/accounts">
            <div class="center">
                <div class="info"><?php echo ($info); ?></div>
                <div class="ajax-info"><img src="/Public/Home/Img/loading.gif" />正在匹配中，请稍后</div>
                <div class="center-top">=</div>

                <?php if(empty($_GET['good_id'])): ?><div class="match-keyword">
                        <span>输入匹配关键字：</span>
                        <input type="text" name="keyword" placeholder="可选">
                    </div>
                    <div class="match-float">
                        <span>价格浮动范围：</span>
                        <input type="text" name="float" placeholder="可选" value="30">
                    </div><?php endif; ?>

                <div class="match-num">
                    <span>输入交换数量：</span>
                    <input type="text" name="num" value="1">
                </div>
                <div class="center-button">
                    <input type="submit" value="交 换" class="button" onclick="return checkSwitch();">
                    <input type="hidden" name="user_good_id">
                    <?php if(empty($_GET['good_id'])): ?><!-- 没有指定 -->
                        <input type="hidden" name="raply_id">
                        <input type="hidden" name="raply_name">
                        <input type="hidden" name="raply_good_id">
                        <button onclick="return getMatch()" _page="0" class="match-next button">换一批</button>
                    <?php else: ?>
                        <!-- 指定 -->
                        <input type="hidden" name="raply_id" value="<?php echo ($raplyGood["user_id"]); ?>">
                        <input type="hidden" name="raply_name" value="<?php echo ($raplyGood["user_name"]); ?>">
                        <input type="hidden" name="raply_good_id" value="<?php echo ($raplyGood["good_id"]); ?>"><?php endif; ?>
                </div>
            </div>
        </form>
            <div class="match-right">
                <div class="right-left">
                    <div class="img_div">
                        <!-- 大图 -->
                        <!-- <img src="" alt=""> -->
                    </div>
                    <div class="desc">
                        <div class="good_name"></div>
                        <div class="rmb-matches"></div>
                    </div>
                </div>
                <div class="ul-title right-ul-title">点击选择要交换的商品</div>
                <div class="ul-view view-right">
                    <div class="right-right div-ul">
                        <ul class="ul">
                            <?php if(!empty($_GET['good_id'])): ?><li _user_id="<?php echo ($raplyGood["user_id"]); ?>" _user_name="<?php echo ($raplyGood["user_name"]); ?>" _good_id="<?php echo ($raplyGood["good_id"]); ?>">
                                    <img src="<?php echo ($raplyGood["thumb_img"]); ?>" alt="">
                                    <div class="desc">
                                        <a href="/<?php echo ($raplyGood["good_id"]); ?>.html"><div class="good_name"><?php echo ($raplyGood["good_name"]); ?></div></a>
                                        <?php if(($raplyGood["is_promote"]) == "1"): ?><div class="rmb-matches">￥<?php echo ($raplyGood["promote_price"]); ?></div>
                                            <?php else: ?>
                                                <div class="rmb-matches">￥<?php echo ($raplyGood["shop_price"]); ?></div><?php endif; ?>

                                    </div>
                                </li><?php endif; ?>

                        </ul>
                    </div>
                </div>

            </div>

        <?php else: ?>
            <p class="info-p">没有匹配到结果，是否<a href="/Good/issue" style="color: red;">立即去发布</a>新商品用以交换该商品？</p><?php endif; ?>

        </div>




<script>

function checkSwitch () {
    if (!$('.match-left .left-right .img_div img').is('img')) {
        backAppend({status: 2, info: '你还没有选择你自己的物品！'});
        return false;
    }
    if (!$('.match-right .right-left .img_div img').is('img')) {
        backAppend({status: 2, info: '你还没有选择你要交换的物品！'});
        return false;
    }
    if (!$('.center .num input').val().match(/^\d+$/)) {
        backAppend({status: 2, info: '输入的交换数量非法！'});
        return false;
    }
}

$('.left-left .ul li').click(function () {
    var _this = $(this);
    var src = _this.find('img').attr('src');
    var good_name = _this.find('.good_name').text();
    var rmb = _this.find('.rmb-matches').text();
    _this.addClass('curr').siblings().removeClass('curr');
    var div = _this.parents('.match-left').find('.left-right');
    var img_div = div.find('.img_div');
    var desc = div.find('.desc');

    img_div.html('<img src="'+src+'" />');
    desc.find('.good_name').html(good_name);
    desc.find('.rmb-matches').html(rmb);

    $('button.match-next').attr('_page', 0);

    if (!<?php echo ((isset($_GET['good_id']) && ($_GET['good_id'] !== ""))?($_GET['good_id']):0); ?>) { // 没有指定交换的物品
        getMatch(); // 匹配
    }
    $('.match-form').find('input[name="user_good_id"]').val(_this.attr('_user_id'));

});

$('.right-right ul li').click(function () {
    var _this = $(this);
    var src = _this.find('img').attr('src');
    var good_name = _this.find('.good_name').text();
    var rmb = _this.find('.rmb-matches').text();
    _this.addClass('curr').siblings().removeClass('curr');
    var div = _this.parent().parent().parent().parent();
    var img_div = div.find('.img_div');
    var desc = div.find('.desc');
    img_div.html('<img src="'+src+'" />');
    desc.find('.good_name').html(good_name);
    desc.find('.rmb-matches').html(rmb);

    if (!<?php echo ((isset($_GET['good_id']) && ($_GET['good_id'] !== ""))?($_GET['good_id']):0); ?>) { // 没有指定交换的物品
        $('.match-form').find('input[name="raply_good_id"]').val(_this.attr('_good_id'));
        $('.match-form').find('input[name="raply_id"]').val(_this.attr('_user_id'));
        $('.match-form').find('input[name="raply_name"]').val(_this.attr('_user_name'));
    }
});

function getMatch () {
    var li = $('.left-left .ul li.curr');
    if (!li.is('li')) {
        backAppend({status: 2, info: '你还没有选择你自己的物品！', href: false});
        return false;
    }
    var good_name = li.find('.good_name').text();
    var rmb = li.find('.rmb-matches').text();
    var page = Number($('button.match-next').attr('_page')) + 1;
    var keyword = $('.match-keyword > input').val();
    if (!keyword) keyword = 0;
    var float = $('.match-float > input').val();
    if (!float) float = 30;
    $.ajax({
        type: 'get',
        url: '/Switch/match/price/' + rmb.substring(1) + '/good_name/' + good_name + '/p/' + page + '/keyword/' + keyword + '/float/' + float,
        beforeSend: function () {
            $('.ajax-info').show();
        },
        success:function (msg) {
            if (msg.status == 1) {
                $('.right-right ul').html(msg.content);
                if (!keyword && !float) {
                    $('button.match-next').attr('_page', page);
                }

            } else {
                backAppend(msg);
                $('.right-right ul').html('');
            }

            $('.right-right ul li').click(function () {
                var _this = $(this);
                var src = _this.find('img').attr('src');
                var good_name = _this.find('.good_name').text();
                var rmb = _this.find('.rmb-matches').text();
                _this.addClass('curr').siblings().removeClass('curr');
                var div = _this.parent().parent().parent().parent();
                var img_div = div.find('.img_div');
                var desc = div.find('.desc');
                img_div.html('<img src="'+src+'" />');
                desc.find('.good_name').html(good_name);
                desc.find('.rmb-matches').html(rmb);

                $('.match-form').find('input[name="raply_good_id"]').val(_this.attr('_good_id'));
                $('.match-form').find('input[name="raply_id"]').val(_this.attr('_user_id'));
                $('.match-form').find('input[name="raply_name"]').val(_this.attr('_user_name'));
            });

        },
        complete: function () {
            $('.ajax-info').hide();
        }
    });
    return false;
}
</script>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Switch/match/good_id/9?wap=1" target="_blank">手机版</a>
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
