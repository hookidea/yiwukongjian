<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <title>管理中心 - 商品列表</title>
  <meta name="robots">
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/general.css" />
  <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/main.css" />
</head>
<body>

  <h1>
    <span class="action-span">
      <a href="/Good/issue">添加新商品</a>
    </span>
    <span class="action-span1">
      <a href="#">管理中心</a>
    </span>
    <span id="search_id" class="action-span1">- <?php if(($_GET['check']) == "0"): ?>未审核商品列表<?php else: ?>商品列表<?php endif; ?></span>
    <div style="clear:both"></div>
  </h1>

  <div class="form-div">

  <form action="/admin.php/Good/getList" name="searchForm" method="get" style="width: 400px; margin: 0 auto;">
      <select name="cat_id">
        <option value="0">选择分类</option>
        <?php if(is_array($categoryList)): foreach($categoryList as $key=>$co): ?><option value="<?php echo ($co["cat_id"]); ?>"><?php echo ($co["cat_name"]); ?></option><?php endforeach; endif; ?>
      </select>
      <input type="text" name="keyword" size="15" placeholder="商品名/商品SN/关键字/用户名/用户ID" style="width: 220px; text-align: center;" value="<?php if(isset($_GET['keyword'])): echo ($_GET['keyword']); endif; ?>"/>
      <input type="submit" value=" 搜索 " class="button" />

  </form>

  <?php if(isset($list)): ?><form name="listForm" id="listForm">

            <div class="list-div" id="listDiv">
              <table cellpadding="3" cellspacing="1">
                <tr>
                 <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/good_id/order/'+order;location.href=url;">编号</a>
                    <?php if($_GET['sort']== 'good_id'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>
                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/good_sn/order/'+order;location.href=url;">货号</a>
                    <?php if($_GET['sort']== 'good_sn'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>

                  <th>
                    商品名称
                  </th>

                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/shop_price/order/'+order;location.href=url;">价格</a>
                    <?php if($_GET['sort']== 'shop_price'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>

                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/good_number/order/'+order;location.href=url;">库存</a>
                    <?php if($_GET['sort']== 'good_number'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>

                  <th>
                   <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/is_on_sale/order/'+order;location.href=url;">上架</a>
                    <?php if($_GET['sort']== 'is_on_sale'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>

                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/is_promote/order/'+order;location.href=url;">促销</a>
                    <?php if($_GET['sort']== 'is_promote'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>

                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/is_check/order/'+order;location.href=url;">审核</a>
                    <?php if($_GET['sort']== 'is_check'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>
                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/is_lift/order/'+order;location.href=url;">举报</a>
                    <?php if($_GET['sort']== 'is_lift'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>
                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='desc'?'asc':'desc',url='/admin.php/Good/getList/sort/is_delete/order/'+order;location.href=url;">删除</a>
                    <?php if($_GET['sort']== 'is_delete'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>
                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='asc'?'desc':'asc',url='/admin.php/Good/getList/sort/add_time/order/'+order;location.href=url;">发布时间</a>
                    <?php if($_GET['sort']== 'add_time'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <?php if($_GET['sort']!= ''): ?><span class="icon_sort">
                            <img src="/Public/Admin/Img/sort_asc.gif"/>
                            <img src="/Public/Admin/Img/sort_desc.gif"/>
                          </span>
                          <?php else: ?>
                            <img src="/Public/Admin/Img/sort_desc.gif"/><?php endif; endif; ?>
                  </th>
                  <th>
                    <a href="#">发布者</a>
                  </th>
                  <th>操作</th>
                </tr>
                <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                  <td>
                    <input type="checkbox" name="good_id[]" value="<?php echo ($vo["good_id"]); ?>" />
                    <?php echo ($vo["good_id"]); ?>
                  </td>
                  <td class="first-cell" style="">
                    <span >
                      <?php echo ($vo["good_sn"]); ?>
                    </span>
                  </td>
                  <td>
                    <span >
                      <?php echo ($vo["good_name"]); ?>
                    </span>
                  </td>

                  <td align="right">
                    <span >
                      <?php echo ($vo["shop_price"]); ?>
                    </span>
                  </td>
                  <td>
                    <span >
                      <?php echo ($vo["good_number"]); ?>
                    </span>
                  </td>

                  <td align="center">
                    <img src="/Public/Admin/Img/<?php if(($vo["is_on_sale"]) == "1"): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
                  </td>
                  <td align="center">
                    <img src="/Public/Admin/Img/<?php if(($vo["is_promote"]) == "1"): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
                  </td>
                  <td align="center">
                    <img src="/Public/Admin/Img/<?php if(($vo["is_check"]) == "1"): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
                  </td>
                  <td align="center">
                    <img src="/Public/Admin/Img/<?php if(($vo["is_lift"]) == "1"): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
                  </td>
                  <td align="center">
                    <img src="/Public/Admin/Img/<?php if(($vo["is_delete"]) == "1"): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
                  </td>

                  <td align="center">
                    <span >
                      <?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?>
                    </span>
                  </td>
                  <td align="center">
                    <span >
                      <?php echo ($vo["user_name"]); ?>
                    </span>
                  </td>
                  <td align="center">
                    <a href="/<?php echo ($vo["good_id"]); ?>.html" target="_blank" title="查看该商品页面">
                      看
                    </a>
                    <a href="javascript:var url = '/admin.php/Good', good_id = <?php echo ($vo["good_id"]); ?>, current = <?php echo ($vo["is_on_sale"]); ?>;if(confirm('确定切换上架状态？')){$.get(url + '/onsale/good_id/' + good_id + '/current/' + current, function (msg) {alert(msg.info); location.reload();});}" title="切换上架状态">
                      架
                    </a>
                    <a href="javascript:var url = '/admin.php/Good', good_id = <?php echo ($vo["good_id"]); ?>, current = <?php echo ($vo["is_promote"]); ?>;if(confirm('确定切换促销状态？')){$.get(url + '/promote/good_id/' + good_id + '/current/' + current, function (msg) {alert(msg.info); location.reload();});}" title="切换促销状态">
                      促
                    </a>
                    <a href="javascript:var url = '/admin.php/Good', good_id = <?php echo ($vo["good_id"]); ?>, current = <?php echo ($vo["is_check"]); ?>;if(confirm('确定切换审核状态？')){$.get(url + '/check/good_id/' + good_id + '/current/' + current, function (msg) {alert(msg.info); location.reload();});}" title="切换审核状态">
                      审
                    </a>
                    <a href="javascript:var url = '/admin.php/Good', good_id = <?php echo ($vo["good_id"]); ?>, current = <?php echo ($vo["is_lift"]); ?>;if(confirm('确定切换举报状态？')){$.get(url + '/lift/good_id/' + good_id + '/current/' + current, function (msg) {alert(msg.info); location.reload();});}" title="切换举报状态">
                      举
                    </a>
                    <a href="javascript:var url = '/admin.php/Good', good_id = <?php echo ($vo["good_id"]); ?>, current = <?php echo ($vo["is_delete"]); ?>;if(confirm('确定移动到回收站？')){$.get(url + '/delete/good_id/' + good_id + '/current/' + current, function (msg) {alert(msg.info); location.reload();});}" title="移动到回收站">
                      删
                    </a>
                  </td>
                </tr><?php endforeach; endif; ?>
                </table>


            </table>
          </div>
          <div id="full_action" style="float: left;">
            <input type="button" value="全选" onclick="full_select();">
            <input type="button" value="不全选" onclick="del_select();">
            <input type="button" value="全部删除" onclick="multiGood('delete');">
            <input type="button" value="全部下架" onclick="multiGood('onsale');">
            <input type="button" value="全部通过审核" onclick="multiGood('check');">
            <input type="button" value="全部取消举报" onclick="multiGood('lift');">
          </div>
          <div id="pager"><?php echo ($page); ?></div>

        </form>


    <?php else: ?>

        <p style="color:red; text-align: center;">没有匹配结果！正在返回上一页...</p>
        <script>
            setTimeout(function () {
              history.go(-1);
            }, 800);
        </script><?php endif; ?>


</body>
</html>

<script src="/Public/Admin/Js/jquery.js"></script>
<script src="/Public/Admin/Js/good.js"></script>