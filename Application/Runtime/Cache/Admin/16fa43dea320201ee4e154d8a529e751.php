<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <title>管理中心 - 分类列表</title>
  <meta name="robots">
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/main.css" />
  <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/general.css" />
</head>
<body>
            <h1>
            <span class="action-span">
              <a href="/admin.php/Category/add">添加新分类</a>
            </span>
            <span class="action-span1">
              <a href="#">管理中心</a>
            </span>
            <span id="search_id" class="action-span1">- 分类列表</span>
            <div style="clear:both"></div>
          </h1>
          <form action="/admin.php/Category/getList" name="searchForm" method="GET" style="width: 400px; margin: 0 auto;">
              <input type="text" name="keyword" size="15" placeholder="分类名/分类描述" style="width: 220px; text-align: center;" value="<?php if(isset($_GET['keyword'])): echo ($_GET['keyword']); endif; ?>"/>
              <input type="submit" value=" 搜索 " class="button" />

              <?php if(($_GET['keyword']!= '') OR ($list == '')): ?><a href="/admin.php/Category/getList"><input type="button" value=" 返回查看全部 " class="button" /></a><?php endif; ?>

            </form>

  <?php if(isset($list)): ?><form method="post" action="" name="listForm">

            <div class="list-div" id="listDiv">
              <table cellpadding="3" cellspacing="1">
                <tr>
                  <th>
                    分类名称
                  </th>
                  <th>
                    分类描述
                  </th>
                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='asc'?'desc':'asc',url='/admin.php/Category/getList/sort/grade/order/'+order;location.href=url;">显示排名</a>
                    <?php if($_GET['sort']== 'grade'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>asc<?php else: ?>desc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <?php if($_GET['sort']!= ''): ?><span class="icon_sort">
                            <img src="/Public/Admin/Img/sort_asc.gif"/>
                            <img src="/Public/Admin/Img/sort_desc.gif"/>
                          </span>
                          <?php else: ?>
                            <img src="/Public/Admin/Img/sort_desc.gif"/><?php endif; endif; ?>
                  </th>
                  <th>
                    正在使用
                  </th>
                  <th>
                    <a href="javascript:var order='<?php echo ($_GET['order']); ?>'=='asc'?'desc':'asc',url='/admin.php/Category/getList/sort/add_time/order/'+order;location.href=url;">发布时间</a>
                    <?php if($_GET['sort']== 'add_time'): ?><img src="/Public/Admin/Img/sort_<?php if($_GET['order']== desc): ?>desc<?php else: ?>asc<?php endif; ?>.gif"/>
                      <?php else: ?>
                        <span class="icon_sort">
                          <img src="/Public/Admin/Img/sort_asc.gif"/>
                          <img src="/Public/Admin/Img/sort_desc.gif"/>
                        </span><?php endif; ?>
                  </th>
                  <th>操作</th>
                </tr>

                <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                  <td align="center">
                    <?php echo ($vo["cat_name"]); ?>
                  </td>
                  <td align="center">
                    <?php echo (mb_substr($vo["cat_desc"],0,8,'UTF-8')); ?>
                  </td>
                  <td align="center">
                    <?php echo ($vo["grade"]); ?>
                  </td>
                  <td align="center">
                    <img src="/Public/Admin/Img/<?php if(($vo["is_show"]) == "1"): ?>yes<?php else: ?>no<?php endif; ?>.gif" />
                  </td>
                  <td align="center">
                    <?php echo (date('Y-m-d H:i:s', $vo["add_time"])); ?>
                  </td>

                  <td align="center">
                    <a href="/admin.php/Good/getList/cat_id/<?php echo ($vo["cat_id"]); ?>" target="_blank" title="查看该分类下的所有商品">
                      看
                    </a>
                    <a href="/admin.php/Category/edit/cat_id/<?php echo ($vo["cat_id"]); ?>" title="编辑该分类">
                      编
                    </a>
                    <a href="javascript:var flag=<?php echo ($vo["is_show"]); ?>;if(flag){str='确定要隐藏该分类？';}else{str='确定要显示该分类？';};if(confirm(str)){var cat_id = <?php echo ($vo["cat_id"]); ?>; $.get('/admin.php/Category/hiddenShow/current/' + flag + '/cat_id/' + cat_id, function (msg) {alert(msg.info); location.reload();})}"  title="显示/隐藏分类">
                      显
                    </a>
                  </td>
                </tr><?php endforeach; endif; ?>
                </table>


            </table>
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