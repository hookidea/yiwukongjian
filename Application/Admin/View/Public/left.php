<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>ECSHOP Menu</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/general.css">
  <style type="text/css">
body {
  background: #80BDCB;
}
#tabbar-div {
  background: #278296;
  padding-left: 10px;
  height: 21px;
  padding-top: 0px;
}
#tabbar-div p {
  margin: 1px 0 0 0;
}
.tab-front {
  background: #80BDCB;
  line-height: 20px;
  font-weight: bold;
  padding: 4px 15px 4px 18px;
  border-right: 2px solid #335b64;
  cursor: hand;
  cursor: pointer;
}
.tab-back {
  color: #F4FAFB;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer;
}
.tab-hover {
  color: #F4FAFB;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer;
  background: #2F9DB5;
}
#top-div
{
  padding: 3px 0 2px;
  background: #BBDDE5;
  margin: 5px;
  text-align: center;
}
#main-div {
  border: 1px solid #345C65;
  padding: 5px;
  margin: 5px;
  background: #FFF;
}
#menu-list {
  padding: 0;
  margin: 0;
}
#menu-list ul {
  padding: 0;
  margin: 0;
  list-style-type: none;
  color: #335B64;
}
#menu-list li {
  padding-left: 16px;
  line-height: 16px;
  cursor: hand;
  cursor: pointer;
}
#main-div a:visited, #menu-list a:link, #menu-list a:hover {
  color: #335B64
  text-decoration: none;
}
#menu-list a:active {
  color: #EB8A3D;
}
.explode {
  background: url(/Public/Admin/Img/menu_minus.gif) no-repeat 0px 3px;
  font-weight: bold;
}
.collapse {
  background: url(/Public/Admin/Img/menu_plus.gif) no-repeat 0px 3px;
  font-weight: bold;
}
.menu-item {
  background: url(/Public/Admin/Img/menu_arrow.gif) no-repeat 0px 3px;
  font-weight: normal;
}
#help-title {
  font-size: 14px;
  color: #000080;
  margin: 5px 0;
  padding: 0px;
}
#help-content {
  margin: 0;
  padding: 0;
}
.tips {
  color: #CC0000;
}
.link {
  color: #000099;
}
</style>

</head>
<body>
  <div id="tabbar-div">
    <p>
      <span style="float:right; padding: 3px 5px;" >
        <a href="javascript:closeFrame();">
          <img id="toggleImg" src="/Public/Admin/Img/menu_minus.gif" width="9" height="9" border="0" alt="闭合" />
        </a>
      </span>

      <span class="tab-front" id="menu-tab">菜单</span>
    </p>
  </div>
  <div id="main-div">
    <div id="menu-list">
      <ul>
       <!--  <li class="explode" key="02_cat_and_goods" name="menu">
          <span>前端应用</span>
          <ul>
            <li class="explode">
              <span>个人中心</span>
              <ul>
                <li class="menu-item">
                  <a href="goodslist.php" target="main-frame">登陆/注册</a>
                </li>
                <li class="menu-item">
                  <a href="goodslist.php" target="main-frame">消息管理</a>
                </li>
              </ul>
            </li>

            <li class="explode">
              <span>内容展示</span>
              <ul>
                <li class="menu-item">
                  <a href="goodslist.php" target="main-frame">分页管理</a>
                </li>
                <li class="menu-item">
                  <a href="goodslist.php" target="main-frame">系统信息</a>
                </li>
              </ul>
            </li>

          </ul>
        </li> -->
        <li class="explode" key="02_cat_and_goods" name="menu">
          <span>管理中心</span>
          <ul>

          <?php @session_start(); $keys = array_keys($_SESSION['shop']['user']); if (isset($_SESSION['shop']['user']['system_manage'])) { ?>
            <li class="explode" key="02_cat_and_goods" name="menu">
              <span>系统管理</span>
              <ul>
                  <li class="menu-item">
                    <a href="/admin.php/System/getHandle" target="main-frame">操作记录</a>
                  </li>
                  <li class="menu-item">
                    <a href="/admin.php/System/configManage" target="main-frame">配置管理</a>
                  </li>
                  <li class="menu-item">
                    <a href="/admin.php/System/voidManage" target="main-frame">空间管理</a>
                  </li>
                  <li class="menu-item">
                    <a href="/admin.php/System/systemInfo" target="main-frame">系统信息</a>
                  </li>
              </ul>
            </li>
          <?php } ?>

          <?php if (array_intersect($keys, ['good_getlist', 'good_add', 'good_edit', 'good_onsale', 'good_promote', 'good_check', 'good_lift', 'good_delete'])) { ?>

            <li class="explode" key="02_cat_and_goods" name="menu">
              <span>商品管理</span>
              <ul>
                <?php if (isset($_SESSION['shop']['user']['good_getlist'])) { ?>
                <li class="menu-item">
                  <a href="/admin.php/Good/getList/delete/0" target="main-frame">商品列表</a>
                </li>
                <?php } ?>
                <?php if (isset($_SESSION['shop']['user']['good_check'])) { ?>
                <li class="menu-item">
                  <a href="/admin.php/Good/getList/check/0" target="main-frame">未审核商品</a>
                </li>
                <?php } ?>
                <?php if (isset($_SESSION['shop']['user']['good_add'])) { ?>
                <li class="menu-item">
                  <a href="/Good/issue" target="_blank">添加新商品</a>
                </li>
                <?php } ?>
                <?php if (isset($_SESSION['shop']['user']['good_lift'])) { ?>
                <li class="menu-item">
                  <a href="/admin.php/Good/getList/lift/1" target="main-frame">被举报商品</a>
                </li>
                <?php } ?>
                <?php if (isset($_SESSION['shop']['user']['good_delete'])) { ?>
                <li class="menu-item">
                  <a href="/admin.php/Good/getList/delete/1" target="main-frame">商品回收站</a>
                </li>
                <?php } ?>
              </ul>
            </li>
          <?php } ?>

          <?php if (isset($_SESSION['shop']['user']['category_manage'])) { ?>
            <li class="explode" key="02_cat_and_goods" name="menu">
              <span>分类管理</span>
              <ul>
                <li class="menu-item">
                  <a href="/admin.php/Category/getList" target="main-frame">所有分类</a>
                </li>
                <li class="menu-item">
                  <a href="/admin.php/Category/add" target="main-frame">添加新分类</a>
                </li>
                <li class="menu-item">
                  <a href="/admin.php/Category/getList/is_show/0" target="main-frame">分类回收站</a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <?php if (isset($_SESSION['shop']['user']['order_manage'])) { ?>
            <li class="explode" key="04_order" name="menu">
              <span>订单管理</span>
              <ul>
                <li class="menu-item">
                  <a href="/admin.php/Order/getList" target="main-frame">订单列表</a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <?php if (array_intersect($keys, ['user_getlist', 'user_add', 'user_edit', 'user_check', 'user_real', 'user_seal', 'user_delete'])) { ?>
              <li class="explode" key="04_order" name="menu">
                <span>用户管理</span>
                <ul>
                  <?php if (isset($_SESSION['shop']['user']['user_getlist'])) { ?>
                  <li class="menu-item">
                    <a href="/admin.php/User/getList/delete/0" target="main-frame">用户列表</a>
                  </li>
                  <?php } ?>

                  <?php if (isset($_SESSION['shop']['user']['user_real'])) { ?>
                  <li class="menu-item">
                    <a href="/admin.php/User/getNotReal" target="main-frame">实名申请列表</a>
                  </li>
                  <?php } ?>

                  <?php if (isset($_SESSION['shop']['user']['user_add'])) { ?>
                  <li class="menu-item">
                    <a href="/admin.php/User/add" target="main-frame">添加新用户</a>
                  </li>
                  <?php } ?>

                  <?php if (isset($_SESSION['shop']['user']['user_delete'])) { ?>
                  <li class="menu-item">
                    <a href="/admin.php/User/getList/delete/1" target="main-frame">用户回收站</a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
          <?php } ?>

          <?php if (isset($_SESSION['shop']['user']['role_manage'])) { ?>
            <li class="explode" key="04_order" name="menu">
              <span>角色管理</span>
              <ul>
                <li class="menu-item">
                  <a href="/admin.php/Role/getList" target="main-frame">所有角色</a>
                </li>
                <li class="menu-item">
                  <a href="/admin.php/Role/add" target="main-frame">添加新角色</a>
                </li>

              </ul>
            </li>
          <?php } ?>

          <?php if (isset($_SESSION['shop']['user']['comment_manage'])) { ?>
            <li class="explode" key="04_order" name="menu">
              <span>评论管理</span>
              <ul>
                <li class="menu-item">
                  <a href="/admin.php/Comment/getList" target="main-frame">所有评论</a>
                </li>
              </ul>
            </li>
          <?php } ?>

          <?php if (isset($_SESSION['shop']['user']['bug_manage'])) { ?>
            <li class="explode" key="04_order" name="menu">
              <span>反馈建议</span>
              <ul>
                <li class="menu-item">
                  <a href="/admin.php/Bug/getList" target="main-frame">所有反馈</a>
                </li>
                <li class="menu-item">
                  <a href="/admin.php/Bug/getList/is_full/0" target="main-frame">未处理</a>
                </li>
                <li class="menu-item">
                  <a href="/admin.php/Bug/getList/is_full/1" target="main-frame">已处理</a>
                </li>
              </ul>
            </li>
          <?php } ?>

           <!--  <li class="explode" key="04_order" name="menu">
              <span>友情链接管理</span>
              <ul>
                <li class="menu-item">
                  <a href="#" target="main-frame">所有链接</a>
                </li>
                <li class="menu-item">
                  <a href="#" target="main-frame">添加新链接</a>
                </li>
              </ul>
            </li> -->


            <!-- <li class="explode" key="04_order" name="menu">
              <span>回收站管理</span>
              <ul>
                <li class="menu-item">
                  <a href="/admin.php/Good/recList" target="main-frame">回收站列表</a>
                </li>
              </ul>
            </li> -->
          </ul>
        </li>


      </ul>
    </div>
    <div id="help-div" style="display:none">
      <h1 id="help-title"></h1>

      <div id="help-content"></div>
    </div>
  </div>

</body>
</html>
<script src="/Public/Admin/Js/jquery.js"></script>

<script type="text/javascript">
  function closeFrame() {
      var obj = window.parent.document.getElementsByTagName('frameset')[1];
      if (obj.cols.search('160') !== -1) {
          obj.cols = '0, 10, *';
      } else {
          obj.cols = '160, 10, *';
      }
  }

  $('.explode span').click(function () {
    var next = $(this).next();
    var parent = $(this).parent();


    if (next.css('display') == 'block') {
        parent.css('background', 'url(/Public/Admin/Img/menu_plus.gif) no-repeat 0px 3px');
    } else {
        parent.css('background', 'url(/Public/Admin/Img/menu_minus.gif) no-repeat 0px 3px');

    }

    next.slideToggle('fast');  // 必须放在修改css的下面

  });

</script>
