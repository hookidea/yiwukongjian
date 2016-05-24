$( document ).ready( function () {

var width = $(window).width();
w1 = width*0.025;
$('.top input:last-child').width(width-101-w1);
// console.log(width-118-w1)
// var load = $('#loading-layer');
// $(window).ajaxStart(function () {
//   load.show();
// }).ajaxStop(function () {
//   load.hide();
// });

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


$('.top .search-btn').click(function () {
  var _this = $(this);
  if (!$(this).next().val()) {
    alert('输入的关键字不能为空！');
    return false;
  }
  $('.top form').eq(0).trigger('submit');

});

$('.menu-btn').click(function () {
  $(this).parent().next().fadeToggle('fast');
});

var imgs = $('.good-list li .index_img img');
var img_div = $('.good-list li .index_img');
var width = imgs.eq(0).width();
img_div.height(width);

setPage();



$('#top a img').click(function () {
  history.go(-1);
});

$('#go-top').click(goTop);

$(document).scroll(function () {
  var go = $('#go-top');
  if ($(this).scrollTop() < 300) {
    go.hide();
  } else {
    go.show();
  }
});

$( "#seek-alter-form" ).validate({
    rules: {
      password: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      repassword: {
        required: true,
        minlength: 6,
        maxlength: 20,
        equalTo: "#password"
      },
    },
    submitHandler: function(form){
      $.post('/User/changePassword', $(form).serialize(), function (msg) {
        backAppend(msg);
      });
    },
})

// 发布商品页，上传图片按钮的样式设置
var obj = $('#html5');
var width = $(window).width() * 0.43;
obj.height(width);
$('.upload-wr').height(obj.outerHeight(true));

// 防止首页图片高度丢失
$('.ul-wrap').height($('.first_row li').eq(0).height());


$("#more").click(function () {
    $('#more_in').slideToggle('fast')
  })
$('#more_in li').click(function(){
    var ind=$('#more_in li').index(this);
    $('#news li').hide();
    if(ind==0){$('#news li').show()}
    $('#news .style_'+ind).hide();
})
$('#wrap').click(function(){
    $('#more_in').slideUp()
})


$('#button').click(function(){
    if (!$('.compared_left .compared_text').html()) {
      alert('请选择您要交换的商品!');
      return false;
    }
    if (!$('.compared_right .compared_text').html()) {
      alert('请选择您要用来交换的商品!');
      return false;
    }
    var he=$(document).height();
    $('#back').css({height:he});
    $('#back,#address').show();
})

$('#back').click(function(){
    $('#back,#address').hide();
})

$('#compared_recommend_in li').click(function(){
    var ind=$('#compared_recommend_in li').index(this);
    var b=$('#compared_recommend_in li').eq(ind).html();
    $('.compared_right').html(b);

    $('.match-form').find('input[name="user_good_id"]').val($(this).attr('_good_id'));
})


$( "#changepassword-form" ).validate( {
    rules: {
      password: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      'new-password': {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      repassword: {
        required: true,
        minlength: 6,
        maxlength: 20,
        equalTo: "#new-password"
      },
    },
    submitHandler: function(form){
      $.post('/User/changePassword', $(form).serialize(), function (msg) {
        if (msg.status == 2) {
            var box = $('.mailbox');
            box.find('label').remove();
            box.append('<label id="password-error" class="error" for="password">' + msg.info + '</label>');
        } else {
          location.href = '/User/login';
        }
      });
    },
})

$( "#login-form" ).validate( {
    rules: {
      user_name: {
        required: true,
        minlength: 4,
        maxlength: 11,
      },
      password: {
        required: true,
        minlength: 6,
        maxlength: 20,
      },
    },
    submitHandler: function(form){
        $.post('/User/login', $(form).serialize(), function (msg) {
          if (msg.status == 2) {
            var box = $('.password');
            box.find('label').remove();
            box.append('<label id="password-error" class="error" for="password">' + msg.info + '</label>');
          } else {
            location.href = '/User/index';
          }
        });
    }
} )


$.validator.addMethod("check_phone_qq",function(value, element, params){
  var val = $(params).val();
  var flag_zi = value.match(/^\d{7,12}$/);
  var flag_out = val.match(/^\d{7,12}$/);

  if (value) { // 值不为空时，验证自己
      return flag_zi ? true : false;
  } else {  // 值为空时，验证其他
      return flag_out ? true : false;
  }

}, "手机/QQ必须填写一个，且格式是正确");

$( "#real-form" ).validate( {
  rules: {
    real_name: {
      required: true,
      minlength: 2,
      maxlength: 20,
    },
    real_number: {
      required: true,
      number: true,
      minlength: 10,
      maxlength: 18
    },
    real_location: {
      required: true,
      minlength: 1,
      maxlength: 50
    },
    phone: {
      minlength: 7,
      maxlength: 12,
      check_phone_qq: '#qq'
    },
    qq: {
      minlength: 7,
      maxlength: 12,
      check_phone_qq: '#phone'
    }
  },
  submitHandler: function(form){
    var btn = $('.login_btn');
    $.post('/Real/add', $(form).serialize(), function (msg) {
      if (msg.status == 2) {
        btn.html('提交申请');
        $('.mailbox').append('<label id="password-error" class="error" for="password">' + msg.info + '</label>');
      } else {
        location.href = '/User/showUser';
      }
    });
  },
})

$.validator.addMethod("check_user_name",function(value,element,params){
  if (!value.match(/^\w*$/i)) {
    return false;
  } else {
    return true;
  }
},"用户名必须是4—11位的英文字母或数字");

$( "#reg-form" ).validate( {
  rules: {
    user_name: {
      required: true,
      minlength: 4,
      maxlength: 11,
      check_user_name: true
    },
    password: {
      required: true,
      minlength: 6,
      maxlength: 20
    },
    repassword: {
      required: true,
      minlength: 6,
      maxlength: 20,
      equalTo: "#password"
    },
    email: {
      required: true,
      email: true
    },
    agree: {
      required: true,
    }
  },
  messages: {
    agree: "请同意我们的服务条款",
  },
  submitHandler: function(form){
    $.post('/User/reg', $(form).serialize(), function (msg) {
      if (msg.status == 2) {
        $('.mailbox').append('<label id="password-error" class="error" for="password">' + msg.info + '</label>');
      } else {
        location.href = '/User/index';
      }
    });
  },
})

$( "#seekpassword-form" ).validate( {
  rules: {
    user_name: {
      required: true,
      minlength: 6,
      maxlength: 20,
    },
    email: {
      required: true,
      email: true
    },
  },
  submitHandler: function(form){
    $.post('/Email/send', $(form).serialize() + '&type=1', function (msg) {
      if (msg.status == 2) {
        $('.qq').append('<label id="password-error" class="error" for="password">' + msg.info + '</label>');
      } else {
        backAppend({status: 1, 'info': '邮件发送成功，请您在一天之内前往您的邮件进行处理！', href: '/User/login'});
      }
    });
  }
})







} );

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

// 完成一个订单
function fullOrder (order_id) {
    if (confirm('确定执行该操作？')) {
        $.post('/Order/fullOrder', {'order_id': order_id}, function (msg) {
            backAppend(msg);
        });
    }
    return false;
}


function getMatch (good_id) {

    var good_name = $('.compared_left .compared_text').text();

    var page = Number($('#match_id').attr('_page')) + 1;

    $.ajax({
        type: 'get',
        url: '/Switch/match/good_id/' + good_id + '/p/' + page,
        success:function (msg) {
            if (msg.status == 1) {

                $('#compared_recommend_in').html(msg.content);
                $('#match_id').attr('_page', page);

            } else {
                alert(msg.info);
                $('#match_id').attr('_page', page-1).css('text-decoration', 'line-through');

            }

            $('#compared_recommend_in li').click(function(){
              var _this = $(this);
              var ind=$('#compared_recommend_in li').index(this);
              var b=$('#compared_recommend_in li').eq(ind).html();
              $('.compared_right').html(b);

              $('.match-form').find('input[name="user_good_id"]').val(_this.attr('user_id'));
            })
        },
    });
    return false;
}

// 更改交换状态
function changeSwitchStatus (switch_id, status) {
    if (confirm('确定执行该操作？')) {
        $.post('/Switch/changeSwitchStatus', {switch_id: switch_id, status: status}, function (msg) {
        backAppend(msg);
      });
    }
}


// 商品详情页面评论回复(回复个别用户。类似@)
// $('.detall_reply').click(setRecover);
function setRecover(e, is_login) {
  if (is_login === -1) {
    alert('抱歉，您还没有登陆，暂时不能发表评论！');
    return;
  }
  var _this = $(e).is('div') ? $(e) : $(this);
  var user = _this.prev().find('.username');
  $("input[name='raply_name']").val(user.text());
  $("input[name='raply_id']").val(user.attr('uid'));
  var info = '回复 ' + user.text() + ' ：';
  $('.reply_to_text_box').val(info).attr('raply', info);
}

// 商品详情页的评论（添加评论）
function addComment (e, head_img) {
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
      console.log(user_name);
      var user_id = user_id_input.val();
      var raply_name = raply_name_input.val();
      var date_str = new Date().Format("MM-dd hh:mm");

      if (raply_name) {  // @
        var str = '<div class="message_text"><div class="user_comment"><div class="message_user username" uid="' + user_id + '">' + user_name + '</div><div class="message_user huifu-text">回复</div><div class="message_user">' + raply_name + '</div></div><div class="detall_reply" onclick="setRecover(this, 1)">回复</div><div class="message_user time">' + date_str + '</div><div class="clear"></div><div class="detall_text"> ' + content + ' </div></div>';

      } else { // 非@
        var str = '<div class="message_text"><div class="message_user"><span class="username" uid="' + user_id + '">' + user_name + '</span></div><div class="detall_reply" onclick="setRecover(this, 1)">回复</div><div class="message_user time">' + date_str + '</div><div class="clear"></div><div class="detall_text">' + content + '</div></div>';


      }

      raply_name_input.val('');
      raply_id_input.val('');
      textarea.val('');
      textarea.attr('raply', '');

      $('.comment-wr').prepend(str);
      // $('.detall_reply').click(this, setRecover);

      var h5 = $('.comment h5');
      var num = Number(h5.attr('_num')) + 1;
      h5.html('评论(' + num + ')');
      h5.attr('_num', num);

    }else{
      alert(msg.info);
    }
  })
}

// 商品详情页评论分页
$('.leave_message .pagin a').click(commentPage);
function commentPage () {
  var _this = $(this);
      url = _this.attr('href');
  $.get(url, function (msg) {
    var page = '<div class="page-wrap"><div class="mt20"><div class="pagin fr"><div>' + msg.page + '</div></div><div class="clr"></div></div></div>';
    var content = msg.content;
    var str = '';
    for (key in content) {
      var row = content[key];
      var date_str = new Date(row.add_time*1000).Format("MM-dd hh:mm");
      if (row.raply_id != 0) {
        str += '<div class="message_text"><div class="user_comment"><div class="message_user username" uid="row.user_id">' + row.user_name + '</div><div class="message_user huifu-text">回复</div><div class="message_user">' + row.raply_name + '</div></div><div class="detall_reply">回复</div><div class="message_user time">' + date_str + '</div><div class="clear"></div><div class="detall_text">' + row.content + '</div></div>';
      } else {
        str += '<div class="message_text"><div class="message_user"><span class="username" uid="' + row.user_id + '">' + row.user_name + '</span></div><div class="detall_reply">回复</div><div class="message_user time">' + date_str + '</div><div class="clear"></div><div class="detall_text">' + row.content + '</div></div>';
      }
    }

    $('.comment-wr').html(str);
    $('.page-wrap').html(page);

    $(document).scrollTop($('.comment-wr').position().top);
    setPage();

    $('.pagin a').click(commentPage);
    $('.detall_reply').click(setRecover);
  });
  return false;
}

/**
 * 指定时间，返回上一页
 * @return {[type]} [description]
 */
function goBack (time) {
  var time = time ? time : 0;
  setTimeout(function () {
      history.go(-1);
  }, time);
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
 * 负责在back(即黑色背景上添加提示信息)
 * @param  JSON    status：状态，info：错误信息
 * msg.href = false ，不刷新，只提示几秒退出
 */
function backAppend(msg){
    var back = $('.back');
    var msgDiv = $('.msg');

    msgDiv.html('<div id="info-div">'+msg.info+'</div>');

    var info_div = $('#info-div');
    var left = ($(document).width() - info_div.outerWidth(true)) / 2;
    var top = $(document).scrollTop() + (($(window).height() - info_div.outerHeight(true)) / 2);
    info_div.css({top: top, left: left});

    back.show();

    var time = msg.time ? msg.time : 1000;
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

// 商品详情页
window.onload = function () {
  var img = $('.img img');
  var img_width = img.width();
  var img_height = img.height();

  $('#slider-wrap').height(img_height);
  $('#slider li').width(img_width);
  $('#slider').width(img_width * img.length);

  var touchFunc = function(obj, type, func) {
      //滑动范围在5x5内则做点击处理，s是开始，e是结束
      var init = {x:5,y:5,sx:0,sy:0,ex:0,ey:0};
      var sTime = 0, eTime = 0;
      type = type.toLowerCase();

      obj.addEventListener("touchstart",function(){
          sTime = new Date().getTime();
          init.sx = event.targetTouches[0].pageX;
          init.sy = event.targetTouches[0].pageY;
          init.ex = init.sx;
          init.ey = init.sy;
          if(type.indexOf("start") != -1) func();
      }, false);

      obj.addEventListener("touchmove",function() {
          event.preventDefault();//阻止触摸时浏览器的缩放、滚动条滚动
          init.ex = event.targetTouches[0].pageX;
          init.ey = event.targetTouches[0].pageY;
          if(type.indexOf("move")!=-1) func();
      }, false);

      obj.addEventListener("touchend",function() {
          var changeX = init.sx - init.ex;
          var changeY = init.sy - init.ey;
          if(Math.abs(changeX)>Math.abs(changeY)&&Math.abs(changeY)>init.y) {
              //左右事件
              if(changeX > 0) {
                  if(type.indexOf("left")!=-1) func();
              }else{
                  if(type.indexOf("right")!=-1) func();
              }
          }
          else if(Math.abs(changeY)>Math.abs(changeX)&&Math.abs(changeX)>init.x){
              //上下事件
              if(changeY > 0) {
                  if(type.indexOf("top")!=-1) func();
              }else{
                  if(type.indexOf("down")!=-1) func();
              }
          }
          else if(Math.abs(changeX)<init.x && Math.abs(changeY)<init.y){
              eTime = new Date().getTime();
              //点击事件，此处根据时间差细分下
              if((eTime - sTime) > 300) {
                  if(type.indexOf("long")!=-1) func(); //长按
              }
              else {
                  if(type.indexOf("click")!=-1) func(); //当点击处理
              }
          }
          if(type.indexOf("end")!=-1) func();
      }, false);
  };

  touchFunc($('#slider-wrap')[0], 'left', function () {
    var obj = $('#slider');
    if (Math.abs(obj.position().left) < obj.width() - img_width) {
      obj.animate({
        left:  '-=' + img_width,
      }, 200);
      // number
      $('.number').html(String(Math.floor(Math.abs(obj.position().left) / img_width) + 2) + '/' + img.length);
    }
  });
  touchFunc($('#slider-wrap')[0], 'right', function () {
    var obj = $('#slider');
    if (Math.abs(obj.position().left) > 0) {
      obj.animate({
        left:  '+=' + img_width,
      }, 200);
      $('.number').html(String(Math.floor(Math.abs(obj.position().left) / img_width)) + '/' + img.length);
    }
  });
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
        $(_this).removeClass('collect-off').addClass('collect-on');
        _this.attr('current', 1)
      }else{  // 取消收藏
        $(_this).removeClass('collect-on').addClass('collect-off');
        _this.attr('current', 0)

      }
    }else{
      backAppend(msg);
    }
  });
}

// 举报一个商品
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

// 添加一条私信
function addLetter (id, name, is_login) {
  if (id) {  // 获取私信表单
    if (is_login == -1) {
      alert('您还没有登陆，不能发送私信！');
      return false;
    }
    $.get('/Letter/addLetter', function (msg) {
      $('.form').html(msg.content);

      $('.back,.form').show();
      $('.back').click(function(){
        $('.back,.form').hide();
      })

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


// 添加一条私信
function addBug (type) {
  if (type) {  // 获取私信表单
    $.get('/Bug/add', function (msg) {
      $('.form').html(msg.content);
      $('.back,.form').show();
      $('.back').click(function(){
        $('.back,.form').hide();
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

// 更改密码
function changePassword(is_get) {
  if (is_get) {
    $.get('/User/changePassword', function (msg) {
      $('.back').show();
      $('.form').html(msg.content);

      $('.back').click(function(){
          $('.page,form').hide();
          $(this).hide();
      })
    });
  } else {
    $.post('/Email/send', post, function (msg) {
      backAppend(msg);
    });
  }
}

// 用户邮箱验证
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

// 更改邮箱
function changeEmail (is_get) {

    if (is_get) {  // 获取私信表单
      $.get('/User/changeEmail', function (msg) {
        $('.back').show();
        $('.form').html(msg.content);
        $('.form').show();
        $('.head-form').show();

        $('.back').click(function(){
            $('.page,.form').hide();
            $(this).hide();
        })
      });
    } else {
      var email = $('#email-text').val().match(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i);
      if (email) {
          $.post('/User/changeEmail', $('.letter-form').serialize(), function (msg) {
            backAppend(msg);
          });
      } else {
          alert('您输入的邮箱格式错误！');
          return false;
      }
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
        $.post('/Email/send', post, function (msg) {
          if (msg.status == 2) {
            backAppend(msg);
          } else {
            backAppend({status: 1, 'info': '邮件发送成功，请您在一天之内前往您的邮件进行处理！', href: false});
          }
        });
    } else {
        alert('您输入的邮箱格式错误！');
        return false;
    }

  }
}
