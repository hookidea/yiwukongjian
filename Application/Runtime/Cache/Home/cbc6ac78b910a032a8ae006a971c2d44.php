<?php if (!defined('THINK_PATH')) exit();?>
<div class="page">
<div class="form-div Sign-box" id="form-div">
    <form id="reg-form" action="" method="post">
        <table>
            <tr>
                <td>用户名</td>
                <td>
                  <input name="user_name" type="text" id="username">
                </td>
                <td>
                  <div class="login-error-div" id="username-error">
                      <div class="easytip-text">用户名必须是4—11位的英文字母或数字</div>
                      <div class="easytip-arrow"></div>
                  </div>
                  <div class="login-error-div" id="username-e-error">
                      <div class="easytip-text">抱歉，该用户名已被注册，请更换！</div>
                      <div class="easytip-arrow"></div>
                  </div>
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input name="password" type="password" id="password"></td>
                <td>
                  <div class="login-error-div" id="password-error">
                      <div class="easytip-text">密码长度必须在6—20个字符内</div>
                      <div class="easytip-arrow"></div>
                  </div>
                </td>
            </tr>
            <tr>
                <td>确认密码</td>
                <td><input name="repassword" type="password" id="repassword"></td>
                <td>
                  <div class="login-error-div" id="repassword-error">
                      <div class="easytip-text">两次密码输入要一致</div>
                      <div class="easytip-arrow"> </div>
                  </div>
                </td>
            </tr>
            <tr>
                <td>邮箱 </td>
                <td><input name="email" type="text" id="email"></td>
                <td>
                  <div class="login-error-div" id="email-error">
                      <div class="easytip-text">邮箱格式错误</div>
                      <div class="easytip-arrow"></div>
                  </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: left;">　
                    <input name="remember" class="remember" type="checkbox" id="">　两个星期内免登陆　
                    <input name="agree" class="agree remember" type="checkbox" id="agree">　同意<a class="article-a" href="/Index/article">服务条款</a>　
                </td>
                <td>
                  <div class="login-error-div" id="agree-error">
                      <div class="easytip-text">请同意我们的服务条款</div>
                      <div class="easytip-arrow"></div>
                  </div>
                </td>
            </tr>
        </table>

        <div class="buttons">
            <input value="注册" type="submit" style="margin-top:20px;">
            <input value="登录" type="button" style="margin-top:20px;" class="login-button">
        </div>
        <br class="clear">
    </form>
</div>
<div class="form-div login-box" id="form-div2">
    <form id="login-form" action="" method="post">
        <table>
            <tr>
                <td>　用户名</td>
                <td><input name="user_name" type="text" id="username"></td>
                <td>
                  <div class="login-error-div" id="username-l-error">
                      <div class="easytip-text">用户名必须是4—11位的英文字母或数字</div>
                      <div class="easytip-arrow"></div>
                  </div>
                </td>
            </tr>
            <tr>
                <td>　密　码</td>
                <td><input name="password" type="password" id="password"></td>
                <td>
                  <div class="login-error-div" id="password-l-error">
                      <div class="easytip-text">密码长度必须在6—20个字符内</div>
                      <div class="easytip-arrow"></div>
                  </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: left;"><input name="remember" class="remember" type="checkbox" id="">　两个星期内免登陆　<span onclick="sendEmail(1, 1);" style="color: #225592;float: right; margin-right: 10px; cursor: pointer;">忘记密码？</span></td>
            </tr>
        </table>

        <div class="buttons">
            <input value="登录" type="submit">
            <input value="注册" type="button" class="register-button">
        </div>
        <br class="clear">
    </form>
</div>
</div>

<script src="/Public/Home/Js/validate.js"></script>
<script type="text/javascript">
(function () {

    setBack();  // 设置遮罩层的宽高
    $(window).resize(setBack);

    $('.back').html(' ');
    $('.error-div').hide();

    // 我要注册按钮
    $('.register-button').click(function(){
      $('.login-box').css('display','none');
      $('.Sign-box').css('display','block');
      $('.error-div').hide();
    })

    // 我要登陆按钮
    $('.login-button').click(function(){
      $('.login-box').css('display','block');
      $('.Sign-box').css('display','none');
      $('.error-div').hide();
    })

    // 遮罩层
    $('.back').click(function(){
        $('.page').css('display', 'none');
        $(this).css('display', 'none');
        $('.error-div').css('display', 'none');
        $(window).unbind('scroll');
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
          email: {
            required: true,
            email: true
          },
        },
        success: function (label){
          var id = $(label).attr('for');
          $('#' + id + '-l-error').hide();
        },
        errorPlacement: function ( error, element ) {
          var id =  $( element ).attr('id');
          var val =  $( element ).val();
          if (id == 'user_name' && $('#user_name-e-error').css('display') == 'block') {
          } else {
            $('#' + $( element ).attr('id') + '-l-error').show();
          }
        },
        submitHandler: function(form){
            $.post('/User/login', $(form).serialize(), function (msg) {
              backAppend(msg);
              $('.page').hide();
            });
        }
    } )

    $( "#reg-form" ).validate( {
        rules: {
          user_name: {
            required: true,
            minlength: 4,
            maxlength: 11
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
            required: true
          }
        },
        submitHandler: function(form){
          $.post('/User/reg', $(form).serialize(), function (msg) {
            backAppend(msg);
            $('.page').hide();
          });
        },
        success: function (label){
            var id = $(label).attr('for');
            if (id == 'username') {
                if (!$('#' + id).val().match(/^\w*$/i)) {
                  $('#username-error').show();
                } else {
                  $('#username-error').hide();
                  $.get('/User/checkUserExists/username/'+$('#username').val(), function (msg) {
                        if (msg.status != 1) {
                          $('#username-e-error').show();
                        }
                  });
                }
            } else {
                    $('#' + id + '-error').hide();
            }
        },
        errorPlacement: function ( error, element ) {
          var id = $( element ).attr('id');
          if (id != 'username') {
            $('#' + id + '-error').show();
          } else {
            var username_e_error = $('#username-e-error');
            if (username_e_error.css('display') == 'block') {
              username_e_error.hide();
              $('#username-error').show();
            } else {
              $('#username-error').show();
            }
          }
        }
    })

    })();


</script>