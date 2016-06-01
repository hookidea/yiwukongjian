<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>易物空间</title>
    <link rel="shortcut icon" href="/Public/Home/Img/favicon.ico" />
    <meta name="description" content="">
    <meta http-equiv="cleartype" content="on">
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

     <div class="container">
        <div class="suibian">
          <ul class="middle_nav">
            <li><a href="/User/showUser/user_id/<?php echo ($_GET['user_id']); ?>">TA的资料</a></li>
            <li><a href="/Good/getUserList/user_id/<?php echo ($_GET['user_id']); ?>">TA的商品</a></li>
            <li><a href="/Beg/getUserList/user_id/<?php echo ($_GET['user_id']); ?>">TA的求购</a></li>
            <li class="personalhover"><a href="/Lost/getUserList/user_id/<?php echo ($_GET['user_id']); ?>">TA的招领</a></li>
          </ul>
          <div class="clear">
          </div>
       </div>
       <div class="qq">
         <div class="sc">

<?php if(!empty($lostList)): for ($y=0, $len_y=count($lostList); $y<$len_y; $y++) { $curr = $lostList[$y]['lost_id']; ?>
                <div class="xs_beg">
                  <div class="commodity_beg">
                    <div class="img_beg">
                      <a href="/User/showUser/user_id/<?php echo $lostList[$y]['user_id']; ?>">
                        <img src="<?php echo $lostList[$y]['save_path']; ?>" alt="" />
                      </a>
                    </div>
                    <div class="text_details_beg">
                      <h4><?php echo $lostList[$y]['lost_title']; ?></h4>
                      <p class="detail"><?php echo $lostList[$y]['lost_desc']; ?></p>
                      <div class="two_beg">
                        <span class="data_beg data_lost">
                              发布时间：<?php echo date('Y-m-d H:i:s', $lostList[$y]['add_time']); ?>
                        </span>

                      </div>
                      <div>
                        <div class="contacts_beg">
                          <a href="/User/showUser/user_id/<?php echo $lostList[$y]['user_id']; ?>">
                            <span>
                              <?php echo $lostList[$y]['user_name']; ?>
                            </span>
                          </a>
                        </div>
                        <div class="number_beg">
                        </div>
                        <div class="information-content_beg">
                          <?php if (!session('?user')) { ?>

                            <?php if ($lostList[$y]['phone']) { ?>
                              <span>手机：</span>
                              <?php echo substr($lostList[$y]['phone'], 0, 4),'*******'; ?>
                              <span class="login_btn">登陆查看全部</span>
                            <?php } ?>

                            <?php if ($lostList[$y]['qq']) { ?>
                              <span>QQ：</span>
                              <?php echo substr($lostList[$y]['qq'], 0, 4),'*******'; ?>
                              <span class="login_btn">
                              登陆查看全部
                              </span>
                            <?php } ?>

                          <?php } else { ?>

                            <?php if ($lostList[$y]['phone']) { ?>
                              <span>手机：</span><?php echo $lostList[$y]['phone']; ?>
                            <?php } ?>

                            <?php if ($lostList[$y]['qq']) { ?>
                              <span>QQ：</span><?php echo $lostList[$y]['qq']; ?>
                            <?php } ?>

                          <?php } ?>

                        </div>
                      </div>

                      <div class="comment_button_beg beg_btn">
                          显示评论
                      </div>

                      <?php if ($vo[$z]['is_full'] == 1) { ?>
                        <div class="fin_btn beg_btn disable">已完成</div>
                      <?php } else { ?>
                        <div class="fin_btn beg_btn disable">未完成</div>
                      <?php } ?>

                  <div class="comment_list_beg">

                    <div class="comment_view_beg">
                      <?php if (!empty($vo = $commentList[$curr])) { ?>
                        <?php for ($z=0, $len_z=count($vo); $z<$len_z; $z++) { ?>
                          <div class="single_reviews_beg">
                            <div class="comments_avatar_beg">
                              <a href="/User/showUser/user_id/<?php echo $vo[$z]['user_id']; ?>">
                                <img src="<?php echo $vo[$z]['save_path']; ?>" alt="" />
                              </a>
                            </div>
                            <div class="reply_beg">
                              <?php if (!$vo[$z]['raply_id']) { ?>
                                <a href="/User/showUser/user_id/<?php echo $vo[$z]['user_id']; ?>">
                                  <p class="user_comment_beg username" uid="<?php echo $vo[$z]['user_id']; ?>"><?php echo $vo[$z]['user_name']; ?></p>
                                </a>
                              <?php } else { ?>
                                <p class="user_comment_beg">
                                  <a href="/User/showUser/user_id/<?php echo $vo[$z]['user_id']; ?>">
                                    <span class="user_name username" uid="<?php echo $vo[$z]['user_id']; ?>"><?php echo $vo[$z]['user_name']; ?></span>
                                  </a>
                                  <span class="huifu">回复</span>
                                  <a href="/User/showUser/user_id/<?php echo $vo[$z]['raply_id']; ?>">
                                    <span id="<raply_name></raply_name>"><?php echo $vo[$z]['raply_name']; ?></span>
                                  </a>
                                </p>
                               <?php } ?>
                               <div class="comment_text_beg"><?php echo $vo[$z]['content']; ?></div>
                            </div>
                            <!-- 回复按钮 -->
                            <div class="recover_text_beg" onclick="setRecoverBeg(this, <?php echo ((isset($_SESSION['shop']['user']) && ($_SESSION['shop']['user'] !== ""))?($_SESSION['shop']['user']):-1); ?>)">回复</div>
                            <span class="comment_time comment_time_beg">发表于：<?php echo date('Y-m-d H:i:s', $vo[$z]['add_time']); ?></span>
                          </div>
                        <?php } ?>
                      <?php } ?>
                    </div>

                    <?php if (!empty($commentList[$curr])) { ?>
                      <div class="more more-style">隐藏全部评论</div>
                    <?php } else { ?>
                      <div class="more-style">暂无评论</div>
                    <?php } ?>

                    <?php if (session('?user')) { ?>
                      <div class="reply_box_beg">
                          <div class="reply_box_avatar_beg">
                            <a href="/User/showUser/user_id/<?php echo session('user.user_id'); ?>">
                              <img src="<?php echo session('user.save_path'); ?>" alt="" />
                            </a>
                          </div>
                        <textarea type="text" name="content-2" value="" class="reply_to_text_box_beg comment_content"></textarea>
                        <input type="button" name="name" value="评论" class="reply_box_button_beg" _lost_id="<?php echo $curr; ?>" _lost_user_id="<?php echo $lostList[$y]['user_id']; ?>" _lost_user_name="<?php echo $lostList[$y]['user_name']; ?>">
                      </div>
                    <?php } ?>

                    <div class="clear">
                    </div>
                  </div>
                    </div>
                  </div>
                </div>
            <?php } ?>


            <form class="send_comment">
              <input type="hidden" name="type" value="lost">
              <input type="hidden" name="lost_id" value="">
              <input type="hidden" name="raply_id" value="">
              <input type="hidden" name="raply_name" value="">
              <input type="hidden" name="lost_user_id" value="">
              <input type="hidden" name="lost_user_name" value="">
              <input type="hidden" name="user_id" value="<?php echo $_SESSION['shop']['user']['user_id'] ?>">
              <input type="hidden" name="user_name" value="<?php echo $_SESSION['shop']['user']['user_name'] ?>">
              <input type="hidden" name="content" value="">
            </form><?php endif; ?>


         </div>
        </div>
    </div>

<div class="mt20">
    <div class="pagin fr">
        <div><?php echo ($page); ?></div>
    </div>
    <div class="clr"></div>
</div>





    <div class="clear"></div>


    <div class="footer">
        <div class="links">
            <a href="/">首页</a><span>/</span>
            <a href="/Lost/getUserList/user_id/2?wap=1" target="_blank">手机版</a>
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
