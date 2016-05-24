$( document ).ready( function () {

  // 窗口按钮的top值
  $('#window-btn').css('top', ($(window).height() - 250)/2);


  $('.index_btn').click(function () {
    $(this).next().slideToggle('fast');
  });

  $('#login_wrap').mouseenter(function () {
      $('#login_slider').slideDown('fast');
  }).mouseleave(function () {
      $('#login_slider').hide();
  });

  $('.login_btn').click(function(){
    $('.log_in ul li').first().trigger('click');
  });

  $('.search_bar .sub').click(function () {
    if (!$(this).prev().val()) {
      backAppend({status: 2, info: '请输入您要搜索的关键字', href: false});
      return false;
    }
  });

  $('.search_bar .text,.beg_text').click(function () {
    $(this).val('');
  });

  setPage(); // 计算分页的width，让其居中显示
  setBack(); // 计算黑色背景的宽高

// 全局防止重复提交
$(window).ajaxStart(function () {
  var obj = $( document.activeElement );
  if (obj.is('input') || obj.is('a') || obj.is('button')) {
    obj.prop("disabled", true);
    setTimeout(function () { // 5秒后自动恢复
      obj.prop("disabled", false);
    }, 3000);
  }
}).ajaxStop(function () {
  var obj = $( document.activeElement );
  if (obj.is('input') || obj.is('a') || obj.is('button')) {
    obj.prop("disabled", false);
  }
});

} );


function setBack () {
  // 计算黑色背景的宽高
  $(".back").css("height", $(document).height()+"px");
  $(".back").css("width", $(document).width()+"px");
}

/**
 * 返回顶部
 * @return {[type]} [description]
 */
function goTop () {
  var timer = setInterval(function () {
    if ($(document).scrollTop() < 1) {
      clearInterval(timer);
    }
    $(document).scrollTop($(document).scrollTop() / 2)
  }, 50);
}

/**
 * 显示三大发布按钮
 */
function indexShowType (type) {
  location.href = '/Index/index/sort/' + type;
}

/**
 * 首页的三大发布的跳转
 */
function indexIssueType (type) {
  switch (type) {
    case 0:
      location.href = '/Good/issue';
      break;
    case 1:
      location.href = '/Beg/issue';
      break;
    case 2:
      location.href = '/Lost/issue';
      break;
  }

}

/**
 * 查看不同类型的信息
 */
function queryByType (type) {
  if (type != 4) {
    location.href = '/Message/showMessage/type/' + type;
  } else {
    location.href = '/Letter/showLetter';
  }

}

// 计算分页的width，让其居中显示
function setPage() {
  var paging = $('.pagin');
  var pageWidth = 0;
  paging.find('div a').each(function () {
     pageWidth += $(this).outerWidth(true);
  });
  paging.find('div span').each(function () {
     pageWidth += $(this).outerWidth(true);
  });
  paging.width(pageWidth);
}

/**
 * 商品详情的+-按钮，注意：该操作不影响购物车实际的数量
 * @param  number   good_id 商品ID
 * @param  1/0      type    操作类型
 * @param  boolean  reload  成功后是否刷新
 */
function numIncDec(good_id, type, reload) {
  var rmb_input = $('#rmb_input');
  var val = Number(rmb_input.val());
  if (type) { // 添加
    $.get('/Good/getNumber/good_id/' + good_id,  function (msg) {
      if (msg.status == 1 && Number(msg.num) > val) {
        rmb_input.val(val+1);
        if (reload) location.reload();
      } else {
        backAppend({'status': 2, 'info': '库存不足，添加失败', 'time': 300});
      }
    });
  } else {
    val = val - 1 ? val - 1 : 0;
    rmb_input.val(val);
    if (reload) location.reload();
  }
}

/**
 * 删除购物车中的单个商品
 * @param  {[type]} good_id [description]
 * @return {[type]}         [description]
 */
function delCart (good_id) {
  if (confirm('确定要从购物车中移除该商品？')) {
    $.post('/Cart/del', {'good_id': good_id}, function (msg) {
      if (msg.status == 1) {
        location.reload();
      } else {
        backAppend({'status': 2, 'info': '删除失败！', 'time': 300});
      }
    });
  }
}

function delMutCart () {
  if (confirm('确定要从购物车中移除所有商品？')) {
    $.post('/Cart/delMul', $('#accounts-form').serialize(), function (msg) {
      if (msg.status == 1) {
        location.reload();
      } else {
        backAppend({'status': 2, 'info': '删除失败！', 'time': 300});
      }
    });
  }
}

/**
 * 移动购物车中的单个商品到收藏
 * @param  {[type]} good_id [description]
 * @return {[type]}         [description]
 */
function moveCart (good_id, shop_price) {
  if (confirm('确定要移动到我的收藏？')) {
    $.post('/Collect/collect', {'good_id': good_id, 'shop_price': shop_price}, function (msg) {
      if (msg.status == 1) {
        delCart(good_id);
      } else {
        backAppend({'status': 2, 'info': '移动失败！', 'time': 300});
      }
    });
  }
}
function moveMutCart () {
  if (confirm('确定要移动到我的收藏？')) {
    good_id = $('#accounts-form').serialize();
    $.post('/Collect/collect', good_id, function (msg) {
      if (msg.status == 1) {
        delMutCart();  // 删除购物车
      } else {
        backAppend({'status': 2, 'info': '移动失败！', 'time': 300});
      }
    });
  }
}

/**
 * 结算
 */
function accounts () {
  $.post('/Order/add', $('#accounts-form').serialize(), function (msg) {

  });
}

/**
 * 全选/取消全选
 * @param  1/0      type    全选/取消全选
 */
function full_select () {
  $('input:checkbox').prop('checked', true);
  $('input:checkbox').trigger('click');
}
function del_select () {
  $('input:checkbox').prop('checked', false);
  $('.billing p em').html('￥0');
  $('.save > span').html('￥0');
}

/**
 * 购物车的+-按钮，注意：该操作影响购物车实际的数量
 * @param  number   good_id 商品ID
 * @param  1/0      type    操作类型
 */
function cartIncDec (good_id, type, num) {
  var rmb_input = $('.rmb_input').eq(num);
  var val = Number(rmb_input.val());
  if (type) { // 添加
    $.post('/Cart/inc', {'good_id': good_id}, function (msg) {
      if (msg.status == 1) {
        rmb_input.val(val+1);
        $('.compute').eq(num).html(msg.total);
      } else {
        backAppend(msg);
      }
    });
  } else {
    $.post('/Cart/dec', {'good_id': good_id}, function (msg) {
      if (msg.status == 1) {
        val = val - 1 ? val - 1 : 0;
        rmb_input.val(val);
        $.get('/Cart/getTotal', function (result) {
          if (1 == result.status) {
            $('.billing p em').html('￥' + result.total);
          } else {
            location.reload();
          }
        });
      } else {
        backAppend(msg);
      }
    });

  }
}

/**
 * 把商品添加进购物车
 */
function addCart (good_id) {
  var num = $('#rmb_input').val();
  $.post('/Cart/add', {'num': num, 'good_id': good_id}, function (msg) {
    if (msg.status == 1) {
      var b = $('#window-btn ul li b.cart');
      b.html(Number(b.html()) + 1);
    }
    backAppend(msg);
  });
}

/**
 * 负责在back(即黑色背景上添加提示信息)
 * @param  JSON    status：状态，info：错误信息
 * msg.href = false ，不刷新，只提示几秒退出
 */
function backAppend(msg){
    var back = $('.back');
    var msgDiv = $('.msg');

    msgDiv.html('<div id="info-div">' + msg.info + '</div>');
    var info_div = $('#info-div');
    var left = ($(document).width() - info_div.outerWidth(true)) / 2;
    var top = $(document).scrollTop() + (($(window).height() - info_div.outerHeight(true)) / 2);
    info_div.css({top: top, left: left});

    back.show();
    var time = msg.time ? msg.time : 500;
    if (msg.href == 'backReload') {
      location.href = document.referrer;
    } else if (msg.href == 'back') {
      history.go(-1);
    } else if (msg.href) { // 指定了跳转链接
      setTimeout(function () {
          location.href = msg.href;
      }, time);
    } else if (msg.href === false) { // 起提示作用，自动隐藏，不刷新
      setTimeout(function () {
          $('.form,.back,.page').hide();
          msgDiv.html('');
      }, time);
    } else {
      if (msg.status == 1) {  // 成功
          setTimeout(function () {
              location.reload();
          }, time);
      } else {  // 失败
          setTimeout(function () {
            $('.form,.back,.page').hide();
            msgDiv.html('');
          }, time);
      }
    }

}

/**
 * 上架一个商品
 */
function onSale(good_id, current) {
  if (confirm('确定执行该操作？')) {
    $.post('/Good/onSale', {'good_id': good_id, 'current': current}, function (msg) {
      backAppend(msg);
    });
  }

}

// 完成求购
function full (id, type) {
  if (confirm('确定完成？')) {
    if (type == 'lost') {
      $.post('/Lost/fullLost', {'lost_id': id}, function (msg) {
        backAppend(msg);
      });
    } else {
      $.post('/Beg/fullBeg', {'beg_id': id}, function (msg) {
        backAppend(msg);
      });
    }

  }
}

// 个人中心取消收藏
function collect_user (good_id, shop_price) {
  if (confirm('确定执行该操作？')) {
    var data = shop_price ? {'good_id': good_id, 'shop_price': shop_price} : {'good_id': good_id};
    $.post('/Collect/collect', data, function (msg) {
      backAppend(msg);
    });
  }


}



// 商品详情页的添加/取消收藏
function collect(e, good_id, shop_price){
  var _this = $(e);
  var type = _this.attr('current') == 0 ? 1 : 0;
  if (type) { // 添加收藏
    var data = {'good_id': good_id, 'shop_price': shop_price};
  } else { // 取消收藏
    var data = {'good_id': good_id};
  }
  $.post('/Collect/collect', data, function(msg){
    if(msg.status == 1){
      if(type){  // 添加收藏
        $(_this).css('background', '#F6F6F6 url(/Public/Home/Img/heart_full.png) no-repeat scroll center 10px').html(Number($(_this).html())+1);
        _this.attr('current', 1)
      }else{  // 取消收藏
        $(_this).css('background', '#F6F6F6 url(/Public/Home/Img/heart.png) no-repeat scroll center 10px').html($(_this).html()-1);
        _this.attr('current', 0)

      }
    }else{
      backAppend(msg);
    }
  });
}

function liftGood (good_id) {
  if (confirm('确定举报该商品？')) {
    $.post('/Lift/liftGood', {good_id: good_id}, function (msg) {
      backAppend(msg);
    });
  }
}



Date.prototype.Format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

// 求购页面，评论
$('.number_beg').click(function(){
  num = $('.xs_beg .number_beg').index(this);
  $('.information-content_beg').eq(num).show();
  this
})
$('.more').click(function(){
  var _this = $(this);
  if (Number(_this.attr('status')) == 1) {
    _this.html('隐藏全部评论');
    _this.attr('status', 0);
  } else {
    _this.html('显示全部评论');
    _this.attr('status', 1);
  }
  _this.prev().toggle('fast');
  $(document).hide($(this).prev().position().top);
});
$('.comment_button_beg').click(function(){
  var _this = $(this);
  var ind = $('.xs_beg .comment_button_beg').index(this);
  if (Number(_this.attr('status')) == 1) {
    _this.html('显示评论区');
    _this.attr('status', 0);
  } else {
    _this.html('隐藏评论区');
    _this.attr('status', 1);
  }
  $('.comment_list_beg').eq(ind).fadeToggle('fast');
})

// 求购/招领页面评论回复(回复个别用户。类似@)
// $('.recover_text_beg').click(setRecoverBeg);
function setRecoverBeg(e, is_login) {
  if (is_login === -1) {
    alert('抱歉，您还没有登陆，暂时不能发表评论！');
    return;
  }
  var _this = $(e).is('div') ? $(e) : $(this);
  var user = _this.prev().find('.username');
  $("input[name='raply_name']").val(user.html());
  $("input[name='raply_id']").val(user.attr('uid'));
  var info = '回复 ' + user.html() + ' ：';
  $('.reply_to_text_box_beg').val(info).attr('raply', info);
}
// 求购/招领页面的评论（添加评论）
$('.reply_box_button_beg').click(function () {
  var _this = $(this);
      textarea = _this.prev(),
      content = textarea.val().replace(textarea.attr('raply'), ''),
      url = '/Comment/add',
      type = $(".send_comment input[name='type']").val(),
      ind = $('.reply_box_button_beg').index(_this),
      user_name_input = $(".send_comment > input[name='user_name']"),
      user_id_input = $(".send_comment > input[name='user_id']"),
      raply_name_input = $(".send_comment > input[name='raply_name']"),
      raply_id_input = $(".send_comment > input[name='raply_id']")

  $("input[name='content']").val(content);
  if (type == 'beg') {
    $("input[name='beg_id']").val(_this.attr('_beg_id'));
    $("input[name='beg_user_id']").val(_this.attr('_beg_user_id'));
    $("input[name='beg_user_name']").val(_this.attr('_beg_user_name'));
  } else {
    $("input[name='lost_id']").val(_this.attr('_lost_id'));
    $("input[name='lost_user_id']").val(_this.attr('_lost_user_id'));
    $("input[name='lost_user_name']").val(_this.attr('_lost_user_name'));
  }

  $.post(url, $('.send_comment').serialize(), function (msg){

    if(msg.status==1){

      var user_name = user_name_input.val();
      var user_id = user_id_input.val();
      var raply_name = raply_name_input.val();
      var raply_id = raply_id_input.val();
      var head_img = _this.prev().prev().find('img').attr('src');
      var date_str = new Date().Format("yyyy-MM-dd hh:mm:ss");

      if (raply_name) {  // @
        var str = '<div class="single_reviews_beg"><div class="comments_avatar_beg"><a href="/User/showUser/user_id/' + user_id + '"><img src="' + head_img + '" alt="" /></a></div><div class="reply_beg"><p class="user_comment_beg"><a href="/User/showUser/user_id/' + user_id + '"><span class="user_name username" uid="' + user_id + '">' + user_name + '</span></a><span class="huifu">回复</span><a href="/User/showUser/user_id/' + raply_id + '"><span id="raply_name">' + raply_name + '</span></a></p><div class="comment_text_beg">' + content + '</div></div><div class="recover_text_beg" onclick="setRecoverBeg(this)">回复</div><span class="comment_time comment_time_beg">发表于：' + date_str + '</span></div>';
      } else { // 非@
        var str = '<div class="single_reviews_beg"><div class="comments_avatar_beg"><a href="/User/showUser/user_id/' + user_id + '"><img src="' + head_img + '" alt="" /></a></div><div class="reply_beg"><a href="/User/showUser/user_id/' + user_id + '"><p class="user_comment_beg username" uid="' + user_id + '">' + user_name + '</p></a><div class="comment_text_beg">' + content + '</div></div><div class="recover_text_beg" onclick="setRecoverBeg(this)">回复</div><span class="comment_time comment_time_beg">发表于：' + date_str + '</span></div>';
      }

      var curr_view = $('.comment_view_beg').eq(ind);

      if (!curr_view.find('.single_reviews_beg').length) {
        _this.parent().prev().replaceWith('<div class="more more-style">隐藏全部评论</div>');
      }

      curr_view.append(str);
      _this.prev().val('');

      raply_name_input.val('');
      raply_id_input.val('');
      textarea.val('');
      textarea.attr('raply', '');

    }else{

      alert(msg.info);

    }
  })
});

// 商品详情页面评论回复(回复个别用户。类似@)
// $('.recover_text').click(setRecover);
function setRecover(e, is_login) {
  if (is_login === -1) {
    alert('抱歉，您还没有登陆，暂时不能发表评论！');
    return;
  }
  var _this = $(e).is('div') ? $(e) : $(this);
  var user = _this.prev().find('.username');
  $(".send_comment > input[name='raply_name']").val(user.html());
  $(".send_comment > input[name='raply_id']").val(user.attr('uid'));
  var info = '回复 ' + user.html() + ' ：';
  $('.send_comment > .reply_to_text_box').val(info).attr('raply', info);
}

function addComment (e) {
    var textarea = $(e).prev(),
        content = textarea.val().replace(textarea.attr('raply'), ''),
        url = '/Comment/add',
        _this = $(e),
        user_name_input = $(".send_comment > input[name='user_name']"),
        user_id_input = $(".send_comment > input[name='user_id']"),
        raply_name_input = $(".send_comment > input[name='raply_name']")
        raply_id_input = $(".send_comment > input[name='raply_id']")

    textarea.val(content);
    $.post(url, $('.send_comment').serialize(), function (msg){

      if(msg.status==1){

        var user_name = user_name_input.val();
        var user_id = user_id_input.val();
        var raply_name = raply_name_input.val();
        var raply_id = raply_id_input.val();
        var head_img = _this.parent().parent().prev().find('img').attr('src');
        var date_str = new Date().Format("yyyy-MM-dd hh:mm");

        if (raply_name) {  // @
          var str = '<div class="single_reviews"><div class="comments_avatar"><a href="/User/showUser/user_id/' + user_id + '"><img src="' + head_img + '" alt="" /></a></div><div class="reply"><p class="user_comment"><a href="/User/showUser/user_id/' + user_id + '"><span class="user_name username" uid="' + user_id + '">' + user_name + '</span></a><span class="huifu">回复</span><a href="/User/showUser/user_id/' + raply_id + '"><span id="raply_name">' + raply_name + '</span></a></p><div class="comment_text">' + content + '</div></div><div class="recover_text" onclick="setRecover(this);">回复</div><span class="comment_time">发表于' + date_str + '</span></div>';
        } else { // 非@
          var str = '<div class="single_reviews"><div class="comments_avatar"><a href="/User/showUser/user_id/' + user_id + '"><img src="' + head_img + '" alt="" /></a></div><div class="reply"><a href="/User/showUser/user_id/' + user_id + '"><p class="user_comment username" uid="' + user_id + '">' + user_name + '</p></a><div class="comment_text">' + content + '</div></div><div class="recover_text" onclick="setRecover(this);">回复</div><span class="comment_time">发表于' + date_str + '</span></div>';
        }

        raply_name_input.val('');
        raply_id_input.val('');
        textarea.val('');
        textarea.attr('raply', '');

        $('.comment-wr').prepend(str);
        $('.detall_reply').click(setRecover);

      }else{
        alert(msg.info);
      }
    })
    return false;
}
// 商品详情页的评论（添加评论）
// $('.comment_btn').click(addComment);

// 商品详情页评论分页
$('.comment .pagin a').click(commentPage);
function commentPage () {
  var _this = $(this);
      url = _this.attr('href');
  $.get(url, function (msg) {
    var page = '<div class="page-wrap"><div class="mt20"><div class="pagin fr"><div>' + msg.page + '</div></div><div class="clr"></div></div></div>';
    var content = msg.content;
    var str = '';
    for (key in content) {
      var row = content[key];
      var date_str = new Date(row.add_time*1000).Format("yyyy-MM-dd hh:mm");
      if (row.raply_id != 0) {
        str += '<div class="single_reviews"><div class="comments_avatar"><a href="/User/showUser/user_id/' + row.user_id + '"><img src="' + row.save_path + '" alt="" /></a></div><div class="reply"><p class="user_comment"><a href="/User/showUser/user_id/' + row.user_id + '"><span class="user_name username" uid="' + row.user_id + '">' + row.user_name + '</span></a><span class="huifu">回复</span><a href="/User/showUser/user_id/' + row.raply_id + '"><span id="raply_name">' + row.raply_name + '</span></a></p><div class="comment_text">' + row.content + '</div></div><div class="recover_text">回复</div><span class="comment_time">发表于' + date_str + '</span></div>';
      } else {
        str += '<div class="single_reviews"><div class="comments_avatar"><a href="/User/showUser/user_id/' + row.user_id + '"><img src="' + row.save_path + '" alt="" /></a></div><div class="reply"><a href="/User/showUser/user_id/' + row.user_id + '"><p class="user_comment username" uid="' + row.user_id + '">' + row.user_name + '</p></a><div class="comment_text">' + row.content + '</div></div><div class="recover_text">回复</div><span class="comment_time">发表于' + date_str + '</span></div>';
      }
    }

    $('.comment-wr').html(str);
    $('.page-wrap').html(page);

    $(document).scrollTop($('.comment').position().top);
    setPage();
    $('.pagin a').click(commentPage);
    $('.recover_text').click(setRecover);
  });
  return false;
}

/**
 * 登出
 */
function logout(){
  if(confirm('确定退出登陆？')){
    $.get('/User/logout', function (msg) {
      backAppend(msg);
    });
  }

}

// 发布商品页面，选择分类功能的实现 - 开始
$('.select_box').click(function(){
  var ul = $('.son_ul');
  var select_box = $('.select_box');
  if (ul.css('display') == 'none') {
    ul.css('background','#fff');
    select_box.css({'border-bottom': 'none', 'border-bottom-left-radius': 0, 'border-bottom-right-radius': 0});
  } else {
    select_box.css({'border-radius': '7px', 'border': '1px solid #52b0d4'});
  }
  $('.son_ul').slideToggle('fast');
})
$('.son_ul li').click(function(event){
  var _this = $(this);
  var val = _this.html();
  $(".select_box > span").html(val);
  $('.son_ul').hide();
  $(".select_box").css({'border-radius': '7px', 'border': '1px solid #52b0d4', 'background': '#EEE'});
  _this.parent().next().val(_this.val());
  event.stopPropagation();
})
$('.son_ul').mouseleave(function(){
  $('.select_box').css({'border-radius': '7px', 'border': '1px solid #52b0d4'});
  $(this).hide();
})
// 发布商品页面，选择分类功能的实现 - 结束




$('.commodity_right_btn').click(function(){
  var _this = $(this);
  _this.addClass("btn-hover").siblings().removeClass("btn-hover");
  _this.parent().find('input').last().val(_this.attr('status'));
})



// 点击头像，显示上传表单等
function ajaxUploadImg () {
  $.get('/User/uploadHead', function (msg) {
    $('.back').show();
    $('.form').html(msg.content);
    $('.form').show();
    $('.head-form').css('display', 'block');

  });
}


// 单个商品页面，计算缩略图的宽度等
var tp = $('.article ul').children().length*75;
$('.article ul').css({
  width: tp,
  'margin-left': (550 - tp)/2
});
$('.article ul li').mouseenter(function(){
    art = $('.article ul li').index(this);

    var src = $('.article ul li img').eq(art).attr('src');

    $('.imag').attr('src',src);
    $(".article ul li").removeClass();
    $(".article ul li").eq(art).addClass("article_hover");

})


// 登陆注册按钮
$('.log_in ul li').click(function(){
  $(document).scrollTop(0);
  ind = $('.log_in ul li').index(this);
  $('.back,.form').show();
  if(ind==0){  // 登陆
      $.get('/User/getForm', function (msg) {
        $('.form').html(msg.content);
        $('.login-box').css('display', 'block');
        $('.Sign-box').css('display', 'none');
      });
  }else{       // 注册
      $.get('/User/getForm', function (msg) {
        $('.form').html(msg.content);
        $('.login-box').css('display', 'none');
        $('.Sign-box').css('display', 'block');
      });
  }
  $ (window).scroll (function (){
    $(this).scrollTop (0)
  });

})
/**
 * 删除一个地址
 */
function delAddress (e, id) {
  if (confirm('确定删除？')) {
    $.post('/Address/del', {'address_id': id}, function (msg) {
      if (msg.status == 1) {
        $(e).parent().parent().detach();
      } else {
        backAppend(msg);
      }
    });
  }

}
/**
 * 添加一个地址
 */
function addAddress () {
  $(document).scrollTop(0);
  $('.back').css('display', 'block');
  $.get('/Address/getForm', function (msg) {
      $('.form').html(msg.content).show();
      $('.address-box').css('display', 'block');
    });
}
/**
 * 编辑一个地址
 */
function editAddress (e, id) {
  var _this = $(e);
  var _prev = _this.parent().prev();
  $(document).scrollTop(0);
  $('.back').css('display', 'block');
  $.get('/Address/getForm', function (msg) {
    $('.form').html(msg.content);
    $('.address-box').css('display', 'block');
    $('.page input[name="address_name"]').val(_prev.find('span[class="addr-name"]').attr('value'));
    $('.page input[name="address_location"]').val(_prev.find('span[class="addr-info"]').attr('value'));
    $('.page input[name="phone"]').val(_prev.find('span[class="addr-tel"]').attr('value'));
    $('.page input[name="qq"]').val(_prev.find('span[class="addr-qq"]').attr('value'));
    $('.page input:submit').val('保存');
    $('.page input[name="edit"]').val(1);
    $('.page input[name="address_id"]').val(id);
  });
}
/**
 * 设置默认地址
 */
function setAddress (id){
  if (confirm('确定要把这个地址设为默认地址？')) {
    $.post('/Address/setAddress', {'address_id': id}, function (msg) {
      backAppend(msg);
    });
  }
}

function changePassword(is_get) {
  if (is_get) {
    $.get('/User/changePassword', function (msg) {
      $('.back').show();
      $('.form').html(msg.content);
      $('.form').show();
      $('.back').click(function(){
          $('.page').hide();
          $(this).hide();
          $(window).unbind ('scroll');
      })
    });
  } else {
    $.post('/Email/send', post, function (msg) {
      backAppend(msg);
    });
  }
}

function userCheck () {
  if (confirm('确定要发送邮箱验证？')) {
    $.post('/Email/send', 'type=0', function (msg) {
      if (msg.status == 2) {
        backAppend(msg);
      } else {
        backAppend({status: 1, 'info': '邮件发送成功，请您在一天之内前往您的邮件进行处理！', href: false});
      }
    });
  }
}

function changeEmail (is_get) {

    if (is_get) {  // 获取私信表单
      $.get('/User/changeEmail', function (msg) {
        $('.back').show();
        $('.form').html(msg.content);
        $('.form').show();
        $('.head-form').show();

        $('.back').click(function(){
            $('.page').hide();
            $(this).hide();
        })
      });
    } else {
      $.post('/User/changeEmail', $('.letter-form').serialize(), function (msg) {
        $('.back').hide();
        $('.form').hide();
        backAppend(msg);
      });
    }
}

/**
 * 发送邮件
 * @param  0/1       is_get GET/POST
 * @param  number    type   发送的类型，0：用户验证，1、忘记密码，2、修改邮箱
 */
function sendEmail (is_get, type) {
  if (is_get) {  // 获取私信表单
      $.get('/Email/send/type/' + type, function (msg) {
        $('.back').show();
        $('.form').html(msg.content);
        $('.form').show();
        $('.head-form').show();

        $('#btn-send-email').attr('_type', type);

        $('.back').click(function(){
            $('.page').hide();
            $(this).hide();
        })
      });
  } else { // 发送私信

    if (1 == type) { // 找回密码
      var len = $('#send-mail-user').val().length;
      var user = len > 6 && len < 20;
      if (!user) {
        alert('用户名必须是6—16位的英文字母或数字');
        return false;
      }
    }

    var email = $('#send-mail').val().match(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i);
    if (email) {
        var post = $('.letter-form').serialize() + '&type=' + $('#btn-send-email').attr('_type');
        var btn = $('#btn-send-email');

        $.post('/Email/send', post, function (msg) {
          if (msg.status == 2) {
            alert(msg.info);
            btn.val('发送验证');
            btn.parent().width(72);
            return;
          } else {
            backAppend({status: 1, 'info': '邮件发送成功，请您在一天之内前往您的邮件进行处理！', href: false});
          }
        });

        btn.val('正在处理，请稍后...');
        btn.parent().width(155);
    } else {
        alert('您输入的邮箱格式错误！');
        return false;
    }

  }
}

/**
 * 添加一条私信
 */
function addLetter (id, name, is_login) {
  if (is_login == -1) {
    backAppend({status: 2, info: '您还没有登陆，不能发送私信！', href: false});
    return false;
  }
  if (id) {  // 获取私信表单
    $.get('/Letter/addLetter', function (msg) {
      $('.back').show();
      $('.form').html(msg.content);
      $('.form').show();
      $('.head-form').css('display', 'block');
      $('.buttons input[name="raply_id"]').val(id);
      $('.buttons input[name="raply_name"]').val(name);
    });
  } else { // 发送私信
    $.post('/Letter/addLetter', $('.letter-form').serialize(), function (msg) {
      $('.back').hide();
      $('.form').hide();
      backAppend(msg);
    });
  }
}



function addBug (type) {
  if (type == 1) {  // 获取私信表单
    $.get('/Bug/add', function (msg) {
      $('.back').show();
      $('.form').html(msg.content);
      var left = ($(window).width() - 300) / 2;
      $('#bug-wrap').css('left', left);
      $('.form').show();

      $('.back').click(function(){
        $('.back,.form').hide();
        $('.form').html('');
      })
    });
  } else { // 发送私信
    $.post('/Bug/add', $('.letter-form').serialize(), function (msg) {
      $('.back').hide();
      $('.form').hide();
      backAppend(msg);
    });
  }
}
