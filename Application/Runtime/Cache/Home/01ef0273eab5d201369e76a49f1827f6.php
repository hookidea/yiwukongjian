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

 <link rel="stylesheet" type="text/css" href="/Public/Home/Css/order.css?v=0.2">
          <form id="order-form">

<div id="mainframe">

<div id="container-order">
  <div class="w" id="content">
    <div class="m">
      <div class="checkout-tit">
        <span class="tit-txt">填写并核对交换信息</span>
      </div>

      <div class="mc">
        <div class="checkout-steps">
          <!-- 地址开始 -->
          <div class="step-tit">
              <h3>收货人信息</h3>
              <div class="extra-r">
                  <a clstag="pageclick|keycount|trade_201602181|3" onclick="addAddress()" class="ftx-05" href="#none">新增收货地址</a>

              </div>
          </div>

          <!-- 地址开始 -->

          <div class="step-cont">
            <div class="consignee-content" id="consignee-addr">
            <!--  -->
              <div class="ui-scrollbar-wrap" style="position: relative; overflow: hidden; width: 938px; height: 150px; z-index: 10;">
                <div class="consignee-scrollbar" style="position: absolute; left: 0px; top: 0px; overflow: hidden; height: 840px; width: 100%;">
                  <div class="ui-scrollbar-main">
                    <div class="consignee-scroll">
                    <!--  -->
                      <div id="consignee1" class="consignee-cont consignee-off" style="height: 420px;">
                        <ul id="consignee-list">

                      <?php if(is_array($addressList)): foreach($addressList as $key=>$address): if(($key) == "0"): if(($address["is_default"]) == "1"): ?><!-- 隐藏表单，收货地址 -->
                                <input type="hidden" name="address_name" value="<?php if(($address["is_default"]) == "1"): echo ($address["address_name"]); endif; ?>">
                                <input type="hidden" name="address_location" value="<?php if(($address["is_default"]) == "1"): echo ($address["address_location"]); endif; ?>">
                                <input type="hidden" name="phone" value="<?php if(($address["is_default"]) == "1"): echo ($address["phone"]); endif; ?>">
                                <input type="hidden" name="qq" value="" value="<?php if(($address["is_default"]) == "1"): echo ($address["qq"]); endif; ?>">
                              <?php else: ?>
                                <input type="hidden" name="address_name" value="">
                                <input type="hidden" name="address_location" value="">
                                <input type="hidden" name="phone" value="">
                                <input type="hidden" name="qq" value="" value=""><?php endif; endif; ?>




                          <li selected="selected" id="consignee_index_137842514" style="display: list-item;" class="ui-switchable-panel ui-switchable-panel-selected">
                            <div clstag="pageclick|keycount|trade_201602181|1" id="consignee_index_div_137842514" consigneeid="137842514" class="consignee-item <?php if(($address["is_default"]) == "1"): ?>item-selected<?php endif; ?>">
                              <span title="<?php echo ($address["address_name"]); ?>" limit="8"><?php echo ($address["address_name"]); ?></span>
                              <b></b>
                            </div>
                            <div class="addr-detail" title="<?php echo ($address["address_location"]); ?>">
                               <span limit="6" class="addr-name" title="<?php echo ($address["address_name"]); ?>" value="<?php echo ($address["address_name"]); ?>"><?php echo ($address["address_name"]); ?></span>
                               <span limit="45" class="addr-info" title="<?php echo ($address["address_location"]); ?>" value="<?php echo ($address["address_location"]); ?>"><?php echo ($address["address_location"]); ?></span>
                               <?php if(!empty($address["phone"])): ?><span class="addr-tel" value="<?php echo ($address["phone"]); ?>"><?php echo ($address["phone"]); ?>(手机)</span><?php endif; ?>
                               <?php if(!empty($address["qq"])): ?><span class="addr-tel" value="<?php echo ($address["qq"]); ?>"><?php echo ($address["qq"]); ?>(QQ)</span><?php endif; ?>
                               <?php if(($address["is_default"]) == "1"): ?><span class="addr-default">默认地址</span><?php endif; ?>
                            </div>
                            <div class="op-btns">
                              <span></span>
                              <?php if(($address["is_default"]) != "1"): ?><a class="ftx-05 setdefault-consignee" href="#none" onclick="setAddress(<?php echo ($address["address_id"]); ?>);">设为默认地址</a><?php endif; ?>
                              <a class="ftx-05 edit-consignee" href="#none" onclick="editAddress(this, <?php echo ($address["address_id"]); ?>);">编辑</a>
                              <a class="ftx-05 del-consignee" href="#none" onclick="delAddress(this, <?php echo ($address["address_id"]); ?>);">删除</a>
                            </div>
                          </li><?php endforeach; endif; ?>

                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 一个地址结束 -->

          <div class="hr"></div>

          <!-- 商品开始 -->
          <div id="shipAndSkuInfo">
              <div id="payShipAndSkuInfo">

                <div class="step-tit">
                  <h3>交换清单</h3>
                  <div class="extra-r">
                    <a clstag="pageclick|keycount|trade_201602181|15" class="return-edit ftx-05" id="cartRetureUrl" href="/Switch/match">返回重新匹配</a>
                  </div>
                </div>



                <div id="skuPayAndShipment-cont" class="step-cont">
                  <div id="shopping-lists" class="shopping-lists">


                      <!-- 一个店家的开始 -->
                      <div class="shopping-list ABTest">



                        <!-- 隐藏表单 -->
                        <input type="hidden" name="user_good_name" value="<?php echo ($userGood["good_name"]); ?>">
                        <input type="hidden" name="user_good_id" value="<?php echo ($userGood["good_id"]); ?>">
                        <input type="hidden" name="user_id" value="<?php echo ($userGood["user_id"]); ?>">
                        <input type="hidden" name="user_name" value="<?php echo ($userGood["user_name"]); ?>">
                        <input type="hidden" name="num" value="<?php echo ($num); ?>">

                        <!-- 一个商品结束 -->
                        <div class="goods-list">
                          <div class="goods-tit">
                            <h4 id="0" class="vendor_name_h">我的商品</h4>
                          </div>


                          <div class="goods-items">
                            <div goods-id="1039799" class="goods-item goods-item-extra">

                              <div class="p-img">
                                <a href="/<?php echo ($userGood["good_id"]); ?>.html" target="_blank"><img alt="" src="<?php echo ($userGood["thumb_img"]); ?>"></a>
                              </div>
                              <div class="goods-msg">
                                <div class="goods-msg-gel">
                                  <div class="p-name">
                                       <a target="_blank" href="/<?php echo ($userGood["good_id"]); ?>.html">
                                         <?php echo ($userGood["good_name"]); ?>
                                       </a>
                                  </div>
                                    <div class="p-price">
                                        <strong class="jd-price">￥<?php if(($userGood["is_promote"]) == "1"): echo ($userGood["promote_price"]); else: echo ($userGood["shop_price"]); endif; ?></strong>
                                        <span class="p-num">x<?php echo ($num); ?></span>
                                        <span skuid="1039799" class="p-state" id="pre-state">有货</span>
                                    </div>
                                </div>
                              </div>
                              <div class="clr"></div>
                            </div>
                          </div>

                        </div>
                        <!-- 一个商品结束 -->


                        <div class="clr"></div>
                      </div>
                      <!-- 一个店家的结束 -->

                       <!-- 要交换的商品开始 -->
                      <div class="shopping-list ABTest">

                        <!-- 隐藏表单 -->
                        <input type="hidden" name="raply_good_name" value="<?php echo ($raplyGood["good_name"]); ?>">
                        <input type="hidden" name="raply_id" value="<?php echo ($raplyGood["user_id"]); ?>">
                        <input type="hidden" name="raply_name" value="<?php echo ($raplyGood["user_name"]); ?>">
                        <input type="hidden" name="raply_good_id" value="<?php echo ($raplyGood["good_id"]); ?>">
                        <input type="hidden" name="num" value="<?php echo ($num); ?>">

                        <!-- 一个商品结束 -->
                        <div class="goods-list">
                          <div class="goods-tit">
                            <h4 id="0" class="vendor_name_h">我要交换的商品</h4>
                          </div>


                          <div class="goods-items">
                            <div goods-id="1039799" class="goods-item goods-item-extra">

                              <div class="p-img">
                                <a href="/<?php echo ($raplyGood["good_id"]); ?>.html" target="_blank"><img alt="" src="<?php echo ($raplyGood["thumb_img"]); ?>"></a>
                              </div>
                              <div class="goods-msg">
                                <div class="goods-msg-gel">
                                  <div class="p-name">
                                       <a target="_blank" href="/<?php echo ($raplyGood["good_id"]); ?>.html">
                                         <?php echo ($raplyGood["good_name"]); ?>
                                       </a>
                                  </div>
                                    <div class="p-price">
                                        <strong class="jd-price">￥<?php if(($raplyGood["is_promote"]) == "1"): echo ($raplyGood["promote_price"]); else: echo ($raplyGood["shop_price"]); endif; ?></strong>
                                        <span class="p-num">x<?php echo ($num); ?></span>
                                        <span skuid="1039799" class="p-state" id="pre-state">有货</span>
                                    </div>
                                </div>
                              </div>
                              <div class="clr"></div>
                            </div>
                          </div>

                        </div>
                        <!-- 一个商品结束 -->


                        <div class="clr"></div>
                      </div>
                      <!-- 要交换的商品结束 -->

                  </div>
                  <div class="clr"></div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>


    <div class="trade-foot">
      <div class="trade-foot-detail-com">
        <div class="fc-consignee-info">
            <span class="mr20">寄送至：</span>
            <span>收货人：</span>
        </div>
      </div>

      <div class="group" id="checkout-floatbar">
        <div class="ui-ceilinglamp checkout-buttons">
          <div style="display: none;" class="sticky-placeholder hide">
          </div>
      </form>
          <div class="sticky-wrap">
            <div class="inner">
              <a onclick="return submitOrder();" class="checkout-submit">
                提交申请
                <b></b>
              </a>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clr"></div>
  </div>
</div>
</div>



<script>

// 计算地址视窗的高度
$('.ui-scrollbar-wrap').height($('#consignee_index_137842514').outerHeight(true) * $('.ui-switchable-panel').length);

// 在页面最开始，设置提交订单按钮前面的显示的收货信息值
(function () {
  if (!$('.item-selected').is('div')) {
    var _parent = $('.ui-switchable-panel-selected').eq(0);
    _parent.find('div').eq(0).addClass('item-selected');
  } else {
    var _parent = $('.item-selected').parent();
  }

  if (_parent.is('li')) {
    var address_name = _parent.find('span[class="addr-name"]').attr('value');
    var address_location = _parent.find('span[class="addr-info"]').attr('value');
    var phone = _parent.find('span[class="addr-tel"]').attr('value');
    var qq = _parent.find('span[class="addr-qq"]').attr('value');
    if (address_name) {
      var _span = $('.fc-consignee-info span');
      var one = '寄送至： ' + address_location;
      var two = '收货人： ' + address_name + ' ' + phone + '(手机)  ';
      if (qq) two += qq + '(QQ)';
      _span.first().html(one);
      _span.last().html(two);

      $('input[name="address_name"]').val(address_name);
      $('input[name="address_location"]').val(address_location);
      $('input[name="phone"]').val(phone);
      $('input[name="qq"]').val(qq);
    }
  }
})();


$('.consignee-item').click(function () {
  var _this = $(this);
  var _next = _this.next();
  $('.consignee-item').removeClass('item-selected');
  _this.addClass('item-selected');

  var address_name = _next.find('span[class="addr-name"]').attr('value');
  var address_location = _next.find('span[class="addr-info"]').attr('value');
  var phone = _next.find('span[class="addr-tel"]').attr('value');
  var qq = _next.find('span[class="addr-qq"]').attr('value');

  $('input[name="address_name"]').val(address_name);
  $('input[name="address_location"]').val(address_location);
  $('input[name="phone"]').val(phone);
  $('input[name="qq"]').val(qq);

  var _span = $('.fc-consignee-info span');
  var one = '寄送至： ' + address_location;
  var two = '收货人： ' + address_name + ' ' + phone + '(手机)  ';
  if (qq) two += qq + '(QQ)';
  _span.first().html(one);
  _span.last().html(two);

});


/**
 * 提交订单
 * @return {[type]} [description]
 */
function submitOrder () {
    if (!$('.item-selected').is('div')) {
      backAppend({status: 2, info: '您还没有选择收货地址！', href: false});
      return false;
    }
    if (confirm('提交申请之后将不能够取消，确定提交该交换申请？')) {

      $.post('/Switch/create', $('#order-form').serialize(), function (msg) {
        backAppend(msg);
      });
      return false;
    }
}

$('#consignee-list .ui-switchable-panel').mouseenter(function () {
  $(this).find('.op-btns').css('visibility', 'visible');
}).mouseleave(function () {
  $(this).find('.op-btns').css('visibility', 'hidden');
});



</script>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Switch/accounts?wap=1" target="_blank">手机版</a>
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
