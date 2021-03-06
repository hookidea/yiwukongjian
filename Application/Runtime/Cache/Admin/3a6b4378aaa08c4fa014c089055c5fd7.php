<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>管理中心 - 配置管理</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/Public/Admin/Css/main.css" />
        <style>
a{text-decoration: none;}
body{background: #DDEEF2; color: #192E32; font: 12px "sans-serif", "Arial", "Verdana";}
table{border: 1px solid #ccc; border-collapse: collapse; background: #FFF; width: 100%;}
th{background: #BBDDE5 url("/Public/Admin/Img/th_bg.gif") repeat-x;}
td,th{border: 1px solid #ccc; padding: 8px;text-align: center; }
button{font: 12px "sans-serif", "Arial", "Verdana";}
        </style>
    </head>
    <body>
<h1>
    <span class="action-span1">
        <a href="#">管理中心</a>
    </span>
    <span id="search_id" class="action-span1">- 配置管理</span>
    <div style="clear:both"></div>
  </h1>
        <table id="config-table">
            <tr>
                <th>配置项目</th>
                <th>状态</th>
                <th>操作</th>
                <th>配置项目</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            <tr>
                <td>开放网站注册：</td>
                <td>
                    <span>
                        <?php if (C('HOME_REGISTER_ON')) { ?>
                            已开启
                        <?php } else { ?>
                            已关闭
                        <?php } ?>
                    </span>
                </td>
                <td><button onclick="changeConfigValue(this, 'HOME_REGISTER_ON');">更改</button></td>
                <td>开放网站登陆：</td>
                <td>
                    <span>
                        <?php if (C('HOME_LOGIN_ON')) { ?>
                            已开启
                        <?php } else { ?>
                            已关闭
                        <?php } ?>
                    </span>
                </td>
                <td><button onclick="changeConfigValue(this, 'HOME_LOGIN_ON');">更改</button></td>
            </tr>
            <tr>
                <td>数据库调试模式：</td>
                <td>
                    <span>
                        <?php if (C('DB_DEBUG')) { ?>
                            已开启
                        <?php } else { ?>
                            已关闭
                        <?php } ?>
                    </span>
                </td>
                <td><button onclick="changeConfigValue(this, 'DB_DEBUG');">更改</button></td>
                <td>调试界面：</td>
                <td>
                    <span>
                        <?php if (C('SHOW_PAGE_TRACE')) { ?>
                            已开启
                        <?php } else { ?>
                            已关闭
                        <?php } ?>
                    </span>
                </td>
                <td><button onclick="changeConfigValue(this, 'SHOW_PAGE_TRACE');">更改</button></td>
            </tr>
            <tr>
                <td>商品发布审核（发布的商品需要审核通过查看/购买）：</td>
                <td>
                    <span>
                        <?php if (C('CHECK_ISSUE_GOOD')) { ?>
                            已开启
                        <?php } else { ?>
                            已关闭
                        <?php } ?>
                    </span>
                </td>
                <td><button onclick="changeConfigValue(this, 'CHECK_ISSUE_GOOD');">更改</button></td>
                <td>商品发布实名（未实名用户不能发布商品）：</td>
                <td>
                    <span>
                        <?php if (C('REAL_ISSUE_GOOD')) { ?>
                            已开启
                        <?php } else { ?>
                            已关闭
                        <?php } ?>
                    </span>
                </td>
                <td><button onclick="changeConfigValue(this, 'REAL_ISSUE_GOOD');">更改</button></td>
            </tr>
            <tr>
                <td>求购有效期（单位：月）</td>
                <td><span><?php echo C('BEG_TIME'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'BEG_TIME');">更改</button></td>
                <td>招领有效期（单位：月）</td>
                <td><span><?php echo C('LOST_TIME'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'LOST_TIME');">更改</button></td>
            </tr>

            <tr>
                <td>PC版消息一页显示条数：</td>
                <td><span><?php echo C('MESSAGE_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'MESSAGE_PAGE_NUM');">更改</button></td>
                <td>WAP版消息一页显示条数：</td>
                <td><span><?php echo C('WAP_MESSAGE_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_MESSAGE_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>PC版私信一页显示条数：</td>
                <td><span><?php echo C('LETTER_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'LETTER_PAGE_NUM');">更改</button></td>
                <td>WAP版私信一页显示条数：</td>
                <td><span><?php echo C('WAP_LETTER_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_LETTER_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>PC版商品一页显示条数：</td>
                <td><span><?php echo C('GOOD_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'GOOD_PAGE_NUM');">更改</button></td>
                <td>WAP版商品一页显示条数：</td>
                <td><span><?php echo C('WAP_GOOD_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_GOOD_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>后台一页显示条数：</td>
                <td><span><?php echo C('ADMIN_PAGESIZE'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'ADMIN_PAGESIZE');">更改</button></td>
                <td>前端用户头像裁剪大小（1：1）：</td>
                <td><span><?php echo C('HEAD_IMG_SIZE'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'HEAD_IMG_SIZE');">更改</button></td>
            </tr>
            <tr>
                <td>PC版求购一页显示条数：</td>
                <td><span><?php echo C('BEG_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'BEG_PAGE_NUM');">更改</button></td>
                <td>WAP版求购一页显示条数：</td>
                <td><span><?php echo C('WAP_BEG_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_BEG_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>PC版招领一页显示条数：</td>
                <td><span><?php echo C('LOST_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'LOST_PAGE_NUM');">更改</button></td>
                <td>WAP版招领一页显示条数：</td>
                <td><span><?php echo C('WAP_LOST_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_LOST_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>PC版我的收藏一页显示条数：</td>
                <td><span><?php echo C('COLLECT_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'COLLECT_PAGE_NUM');">更改</button></td>
                <td>WAP版我的收藏一页显示条数：</td>
                <td><span><?php echo C('WAP_COLLECT_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_COLLECT_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>PC版订单一页显示条数：</td>
                <td><span><?php echo C('ORDER_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'ORDER_PAGE_NUM');">更改</button></td>
                <td>WAP版订单一页显示条数：</td>
                <td><span><?php echo C('WAP_ORDER_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_ORDER_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>PC版商品评论一页显示条数：</td>
                <td><span><?php echo C('COMMENT_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'COMMENT_PAGE_NUM');">更改</button></td>
                <td>WAP版商品评论一页显示条数：</td>
                <td><span><?php echo C('WAP_COMMENT_PAGE_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_COMMENT_PAGE_NUM');">更改</button></td>
            </tr>
            <tr>
                <td>WAP版首页每种类型显示的个数：</td>
                <td><span><?php echo C('WAP_INDEX_NUM'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'WAP_INDEX_NUM');">更改</button></td>
                <td>图片上传限制大小（MB）：</td>
                <td><span><?php echo C('IMAGE_SIZE'); ?></span></td>
                <td><button onclick="setConfigValue(this, 'IMAGE_SIZE');">更改</button></td>
            </tr>

        </table>

    </body>
</html>


<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/good.js"></script>