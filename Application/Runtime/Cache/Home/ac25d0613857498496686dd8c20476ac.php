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

 <link rel="stylesheet" type="text/css" href="/Public/Home/Css/showOrder.css?v=0.2">
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
      <li class="personalhover"><a href="/Switch/showSwitch">换购管理</a></li>
      <li><a href="/Message/showMessage">消息管理</a></li>
      <li><a href="/User/showReal">认证管理</a></li>
    </ul>
    <div class="clear"></div>
  </div>

  <div id="container">
    <div class="w">
      <div id="content">
        <div id="main">
          <div id="order01" class="mod-main mod-comm mod-order">
              <div class="mt">
                  <h3 onclick="showSwitchType(0);" class="<?php if(($_GET['type']) != "1"): ?>curr<?php endif; ?>">主动交换</h3>
                  <h3 onclick="showSwitchType(1);" class="<?php if(($_GET['type']) == "1"): ?>curr<?php endif; ?>">被动交换</h3>
                  <div class="extra-r"></div>
              </div>
          </div>
          <div id="order02" class="mod-main mod-comm lefta-box">
            <div class="mt">
              <ul class="extra-l">
                <li class="fore1"><a class="txt <?php if(($_GET['status']) != "0"): ?>curr<?php endif; ?>"  onclick="showNotFull(0);">全部交换</a></li>
                <li>
                  <a class="txt <?php if(($_GET['status']) == "0"): ?>curr<?php endif; ?>" clstag="" id="ordertoReceive" href="#" onclick="showNotFull(1);">待完成<em><?php echo ($notFull); ?></em></a>
                </li>
                <li>
                </li>
              </ul>
              <div class="extra-r">
                <div class="search">
                  <input type="text" placeholder="请输入商品名称/用户名/交换编号" class="itxt" id="ip_keyword" style="color: rgb(204, 204, 204);" name="keyword">
                  <a clstag="click|keycount|orderinfo|search" class="search-btn" onclick="searchSwitch(this);">搜索<b></b></a>
                  <!-- <a class="default-btn high-search" clstag="click|keycount|orderlist|gaoji" href="#none">高级<b></b></a> -->
                </div>
              </div>
            </div>
            <div class="mc">
              <table class="td-void order-tb">
                <colgroup>
                    <col class="number-col">
                    <col class="consignee-col">
                    <col class="amount-col">
                    <col class="status-col">
                    <col class="operate-col">
                </colgroup>
                <thead>
                  <tr>
                    <th>
                      <div class="ordertime-cont" onclick="showTimeSwitch(event);">
                        <div class="time-txt">近三个月交换<b></b><span class="blank"></span> </div>
                        <div class="time-list">
                          <ul>
                            <li><a class="curr" clstag="click|keycount|orderlist|zuijinsangeyue" _val="1" href="#none"><b></b>近三个月交换</a></li>
                            <li><a clstag="click|keycount|orderlist|jinniannei" _val="2" href="#none"><b></b>今年内交换</a></li>
                            <li><a clstag="click|keycount|orderlist|2015" _val="3" href="#none"><b></b>2015年交换</a></li>
                            <li><a clstag="click|keycount|orderlist|2014" _val="4" href="#none"><b></b>2014年交换</a></li>
                            <li><a clstag="click|keycount|orderlist|2013" _val="5" href="#none"><b></b>2013年交换</a></li>
                            <li><a clstag="click|ke ycount|orderlist|before_2013" _val="6" href="#none"><b></b>2013年以前交换</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="order-detail-txt ac">交换详情</div>
                    </th>
                    <th>收货人</th>
                    <th>角色</th>
                    <th>状态</th>
                    <th>操作</th>
                  </tr>
                </thead>

            <!-- 一个订单一个tbody -->
            <?php if(is_array($switchList)): foreach($switchList as $key=>$switch): ?><tbody id="tb-12251082074">
                <tr class="sep-row"><td colspan="5"></td></tr>

                <tr class="tr-th">
                  <td colspan="5">
                    <span class="gap"></span>
                    <span title="<?php echo (date("Y-m-d H:i:s",$switch["add_time"])); ?>" class="dealtime"><?php echo (date("Y-m-d H:i:s",$switch["add_time"])); ?></span>

                    <span class="number">交换编号：<a clstag="click|keycount|orderinfo|order_num" target="_blank" id="idUrl12251082074" name="orderIdLinks"><?php echo ($switch["switch_sn"]); ?></a></span>
                    <div class="tr-operate">
                      <span class="order-shop">
                        <span>申请交换：</span>
                        <span class="shop-txt"><?php echo ($goodList["$key"]["0"]["user_name"]); ?></span>
                        <a clstag="click|keycount|orderlist|ziyingchatim" title="联系他/她" href="#none" class="btn-im btn-im-jd" onclick="addLetter(<?php echo ($goodList["$key"]["0"]["user_id"]); ?>, '<?php echo ($goodList["$key"]["0"]["user_name"]); ?>', <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>);"></a>
                      </span>
                      <span class="order-shop">
                        <span>被交换：</span>
                        <span class="shop-txt"><?php echo ($goodList["$key"]["1"]["user_name"]); ?></span>
                        <a clstag="click|keycount|orderlist|ziyingchatim" title="联系他/她" href="#none" class="btn-im btn-im-jd" onclick="addLetter(<?php echo ($goodList["$key"]["1"]["user_id"]); ?>, '<?php echo ($goodList["$key"]["1"]["user_name"]); ?>', <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>);"></a>
                      </span>
                      <!-- <a _passkey="25D65818AA427ED48B8CB7B385AC42DB" _orderid="12251082074" class="order-del" clstag="click|keycount|orderlist|dingdanshanchu" href="#none" style="display: none;" title="删除"></a> -->
                    </div>
                  </td>
                </tr>

                <tr oty="0,4,70" id="track12251082074" class="tr-bd">

                  <td>
                    <div class="goods-item p-188078">
                      <div class="p-img">
                          <a target="_blank" clstag="click|keycount|orderinfo|order_product" href="http://item.jd.com/188078.html">
                            <img width="60" height="60" data-lazy-img="done" title="<?php echo ($goodList["$key"]["0"]["good_name"]); ?>" src="<?php echo ($goodList["$key"]["0"]["thumb_img"]); ?>" class="">

                          </a>
                      </div>
                      <div class="p-msg">
                        <div class="p-name"><a title="<?php echo ($goodList["$key"]["0"]["good_name"]); ?>" target="_blank" clstag="click|keycount|orderinfo|order_product" class="a-link" href="/<?php echo ($goodList["$key"]["0"]["good_id"]); ?>.html"><?php echo ($goodList["$key"]["0"]["good_name"]); ?></a></div>
                      </div>
                    </div>
                    <div class="goods-number">
                        x<?php echo ($switch["num"]); ?>
                    </div>

                    <div class="clr"></div>
                  </td>

                  <td rowspan="1">
                    <div class="consignee tooltip">
                      <span class="txt"><?php echo ($switch["address_name"]); ?></span><b></b>
                      <div class="prompt-01 prompt-02">
                        <div class="pc">
                          <strong><?php echo ($switch["address_name"]); ?></strong>
                          <p><?php echo ($switch["address_location"]); ?></p>
                          <p><?php echo ($switch["phone"]); ?></p>
                        </div>
                        <div class="p-arrow p-arrow-left"></div>
                      </div>
                    </div>
                  </td>
                  <td rowspan="1">
                    <div class="amount">
                      <span>申请交换</span>
                    </div>
                  </td>
                  <td rowspan="2">
                    <div class="status">
                      <span class="order-status ftx-03">

                      <?php switch($switch["status"]): case "0": ?>等待对方同意<?php break;?>
                      <?php case "1": ?>交换成立，等待交换完成<?php break;?>
                      <?php case "2": ?>交换被拒绝，交换取消<?php break;?>
                      <?php case "3": ?>交换完成<?php break; endswitch;?>

                      </span>
                    </div>
                  </td>
                  <td id="operate12251082074" rowspan="2">
                    <div class="operate">
                      <div _baina="0" id="pay-button-12251082074"></div>

                        <?php if(($switch["status"]) == "0"): if ($switch['raply_id'] == session('user.user_id')) { ?>
                            <span target="_blank" class="btn-again" onclick="changeSwitchStatus(<?php echo ($switch["switch_id"]); ?>, 1);">同意</span>
                            <br/>
                            <br/>
                            <span target="_blank" class="btn-again" onclick="changeSwitchStatus(<?php echo ($switch["switch_id"]); ?>, 2);">不同意</span>
                          <?php } endif; ?>

                        <?php if ($switch['user_id'] == session('user.user_id')) { ?>
                          <?php if(($switch["status"]) == "1"): ?><span target="_blank" class="btn-again" style="cursor: text;"></span>
                            <?php else: ?>
                              <?php if ($switch['user_id'] != session('user.user_id')) { ?>
                                  <span target="_blank" class="btn-again" onclick="changeSwitchStatus(<?php echo ($switch["switch_id"]); ?>, 3)"><b></b>完成</span>
                              <?php } endif; ?>
                        <?php } ?>


                      <br>
                    </div>
                  </td>
                </tr>

<!-- <?php print_r($goodList); ?> -->
 <!-- <?php echo ($goodList["$key"]["1"]["good_name"]); ?> -->
                <tr oty="0,4,70" id="track12251082074" class="tr-bd">

                  <td>
                    <div class="goods-item p-188078">
                      <div class="p-img">
                          <a target="_blank" clstag="click|keycount|orderinfo|order_product" href="http://item.jd.com/188078.html">
                            <img width="60" height="60" data-lazy-img="done" title="<?php echo ($goodList["$key"]["1"]["good_name"]); ?>" src="<?php echo ($goodList["$key"]["1"]["thumb_img"]); ?>" class="">

                          </a>
                      </div>
                      <div class="p-msg">
                        <div class="p-name"><a title="<?php echo ($goodList["$key"]["1"]["good_name"]); ?>" target="_blank" clstag="click|keycount|orderinfo|order_product" class="a-link" href="/<?php echo ($goodList["$key"]["1"]["good_id"]); ?>.html"><?php echo ($goodList["$key"]["1"]["good_name"]); ?></a></div>

                      </div>
                    </div>
                    <div class="goods-number">
                        x<?php echo ($switch["num"]); ?>
                    </div>

                    <div class="clr"></div>
                  </td>

                  <td rowspan="1">
                    <div class="consignee tooltip">
                      <span class="txt"><?php echo ($goodList["$key"]["1"]["user_name"]); ?></span><b></b>
                      <div class="prompt-01 prompt-02">
                        <div class="pc">
                          <strong><?php echo ($goodList["$key"]["1"]["user_name"]); ?></strong>
                          <p><?php echo ($goodList["$key"]["1"]["address"]); ?></p>
                          <p><?php echo ($goodList["$key"]["1"]["phone"]); ?></p>
                        </div>
                        <div class="p-arrow p-arrow-left"></div>
                      </div>
                    </div>
                  </td>
                  <td rowspan="1">
                    <div class="amount">
                      <span>被交换</span>
                    </div>
                  </td>

                </tr>

              </tbody><?php endforeach; endif; ?>

              </table>


            </div>
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

<script type="text/javascript">

var _status = <?php echo ((isset($_GET['status']) && ($_GET['status'] !== ""))?($_GET['status']):2); ?>; // 0：未完成，1：已完成
var _type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;  // 0：买家订单

// 自动选中正确的时间类别
var _timeType = <?php echo ((isset($_GET['timeType']) && ($_GET['timeType'] !== ""))?($_GET['timeType']):1); ?>; // 查看一定时间范围内的订单
if (_timeType) {
  var _obj = $('.time-list ul li').eq(_timeType-1);
  _obj.find('a').addClass('curr');
  _obj.siblings().find('a').removeClass('curr');
  $('.ordertime-cont .time-txt').html(_obj.text() + '<b></b>');
}

// 收货人信息的查看和隐藏
$('.consignee').mouseenter(function () {
  $(this).find('.prompt-01').show();
}).mouseleave(function () {
  $(this).find('.prompt-01').hide();
});

function changeSwitchStatus (switch_id, status) {
    if (confirm('确定执行该操作？')) {
        $.post('/Switch/changeSwitchStatus', {switch_id: switch_id, status: status}, function (msg) {
        backAppend(msg);
      });
    }
}

function showNotFull (status) {
  var type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;  // 0：买家订单
  status = status ? 0 : 1; // 为1，说明要查看未完成订单，所以status=0
  location.href = '/Switch/showSwitch/status/' + status + '/type/' + type;
}

function searchSwitch (e) {
  var _this = $(e);
  var val = _this.prev().val();
  location.href = '/Switch/showSwitch/keyword/' + val;
}

function showSwitchType (type) {
  location.href = '/Switch/showSwitch/type/' + type;
}

function showTimeSwitch(e, timeType) {
  var status = <?php echo ((isset($_GET['status']) && ($_GET['status'] !== ""))?($_GET['status']):2); ?>; // 0：未完成，1：已完成
  var type = <?php echo ((isset($_GET['type']) && ($_GET['type'] !== ""))?($_GET['type']):0); ?>;  // 0：买家订单
  var timeType = <?php echo ((isset($_GET['timeType']) && ($_GET['timeType'] !== ""))?($_GET['timeType']):1); ?>; // 查看一定时间范围内的订单

  $('.ordertime-cont .time-list').toggle();
  var target = $(e.target);
  var timeType = target.attr('_val');
  $('.ordertime-cont .time-txt').html(target.text() + '<b></b>');
  if (timeType) {
    location.href = "/Switch/showSwitch/timeType/" + timeType + '/type/' + type + '/status/' + status;
  }
}

</script>

    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Switch/showSwitch/type/1/switch_id/8?wap=1" target="_blank">手机版</a>
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
