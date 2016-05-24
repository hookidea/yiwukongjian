/*
* @Author: hookidea
* @Date:   2016-04-06 15:58:23
* @Last Modified by:   hookidea
* @Last Modified time: 2016-05-19 23:02:10
*/

'use strict';

$("#upload-form").validate({
    rules: {
      'good_name': {
        required: true,
        minlength: 1,
        maxlength: 60,
      },
      'switch': {
        required: false,
        minlength: 1,
        maxlength: 30,
      },
      'good_desc': {
        required: true,
        minlength: 20,
        maxlength: 150,
      },
      'keywords': {
        required: false,
        minlength: 1,
        maxlength: 30,
      },
      'beg_title': {
        required: true,
        minlength: 1,
        maxlength: 60,
      },
      'beg_desc': {
        required: true,
        minlength: 20,
        maxlength: 150,
      },
      'lost_title': {
        required: true,
        minlength: 1,
        maxlength: 60,
      },
      'lost_desc': {
        required: true,
        minlength: 20,
        maxlength: 150,
      },
      'address': {
        required: true,
        minlength: 1,
        maxlength: 150,
      },
      'address_location': {
        required: true,
        minlength: 1,
        maxlength: 150,
      },
      'address_name': {
        required: true,
        minlength: 1,
        maxlength: 20,
      },
      'shop_price': {
        number:true,
        range:[0,99999],
      },
      'price': {
        required: true,
        number:true,
        range:[0,99999],
      },
      'promote_price': {
        number: true,
        range:[0,99999],
      },
      'phone': {
        number: true,
        minlength: 7,
        maxlength: 12,
      },
      'qq': {
        number: true,
        minlength: 5,
        maxlength: 12,
      },
      'good_number': {
        required: true,
        number: true,
        range:[1,65535],
      },
      'is_agree': {
        required: true,
      },
      'intro': {
        minlength: 1,
        maxlength: 50,
      },
      'nickname': {
        minlength: 1,
        maxlength: 20,
      },
      'qq-intro': {
        number: true,
        minlength: 5,
        maxlength: 12,
      },
      'phone-intro': {
        number: true,
        minlength: 7,
        maxlength: 12,
      },
      'email': {
        required: true,
        email: true,
      },
      'real_name': {
        required: true,
        minlength: 1,
        maxlength: 20,
      },
      'real_location': {
        required: true,
        minlength: 1,
        maxlength: 50,
      },
      'real_number': {
        required: true,
        minlength: 1,
        maxlength: 18,
      },
      'num': {
        required: true,
        number: true,
      },
    },
    success: function (label){
        var name = $(label).attr('for');
        switch(name){
            case 'shop_price':
                var val = $('input[name="shop_price"]').val();
                if (val==0 || val) {
                    $('#promote_price-error').hide();
                    $('#shop_price-error').hide();
                } else {
                    if (!$('input[name="promote_price"]').val().match(/^\d{1,5}$|^\d{1,5}\.\d{1,2}$/)) {
                        $('#promote_price-error').show();
                    } else {
                        $('#shop_price-error').hide();
                    }
                }
                return;
            case 'promote_price':
                var val = $('input[name="promote_price"]').val();
                if (val==0 || val) {
                    $('#promote_price-error').hide();
                    $('#shop_price-error').hide();
                } else {
                    if (!$('input[name="shop_price"]').val().match(/^\d{1,5}$|^\d{1,5}\.\d{1,2}$/)) {
                        $('#shop_price-error').show();
                    } else {
                        $('#promote_price-error').hide();
                    }
                }
                return;
            case 'qq':
                var val = $('input[name="qq"]').val();
                if (val==0 || val) {
                    $('#qq-error').hide();
                    $('#phone-error').hide();
                } else {
                    if (!$('input[name="phone"]').val().match(/^\d{7,12}$/)) {
                        $('#phone-error').show();
                    } else {
                        $('#qq-error').hide();
                    }
                }
                return;
            case 'phone':
                var val = $('input[name="phone"]').val();
                if (val==0 || val) {
                    $('#qq-error').hide();
                    $('#phone-error').hide();
                } else {
                    if (!$('input[name="qq"]').val().match(/^\d{7,12}$/)) {
                        $('#qq-error').show();
                    } else {
                        $('#phone-error').hide();
                    }
                }
                return;
            default:
                $('#' + name + '-error').hide();
                return;
        }
    },
    errorPlacement: function ( error, element ) {
        name = $( element ).attr('name');
        $('#' + name + '-error').show();
    },
    submitHandler: function(form){
        var flag = $(form).attr('flag').toLowerCase();
        switch (flag) {
            case 'good':
                var promote_price = $('input[name="promote_price"]');
                var shop_price = $('input[name="shop_price"]');
                if (!promote_price.val() && !shop_price.val()) {
                    $('#promote_price-error').show();
                    $('#shop_price-error').show();
                    return;
                }
                var phone = $('input[name="phone"]');
                var qq = $('input[name="qq"]');
                if (!phone.val() && !qq.val()) {
                    $('#phone-error').show();
                    $('#qq-error').show();
                    return;
                }
                break;

        }

        if (flag != 'editIntro') {
            var phone = $('input[name="phone"]');
            var qq = $('input[name="qq"]');

            if (!phone.val() && !qq.val()) {
                $('#phone-error').show();
                $('#qq-error').show();
                return;
            }

        }

        if (confirm('确定执行该操作？')) {
            var url = '';
            switch (flag) {
                case 'beg':
                    url = '/Beg/issue';
                    break;
                case 'lost':
                    url = '/Lost/issue';
                    break;
                case 'good':
                    url = '/Good/issue';
                    break;
                case 'editIntro':
                    url = '/User/editIntro';
                    break;
                case 'editReal':
                    url = '/User/editReal';
                    break;
                case 'switch':
                    url = '/Switch/create';
                    break;
            }
            $.post(url, $(form).serialize(), function (msg) {
                alert(msg.info);
                if (1 == msg.status) {
                    if (flag == 'good' || flag == 'switch') {
                        location.href = msg.href;
                    } else {
                        location.href = document.referrer;
                    }

                }
            });
        }


    },
});


$('#html5_file').change(changeFunc);

function closeDiv (e) {
    $(e).parent().remove();
    $('.upload-wr').height($('#html5').outerHeight(true) * (Math.ceil(($('.photo-area .photo').length + 1) / 2)));
    if (!$('#html5').is('div')) {
        $('.photo-area').append('<div id="html5" class="moxie-shim moxie-shim-html5"><div><input id="html5_file" type="file" name="" accept="image/*" class="image-input" capture="camera"></div></div></div>');
        $('#html5_file').change(changeFunc);
    }
}

function changeFunc(evt){

    var _this = $(this);
    var files = evt.target.files;
    var html5 = $('#html5');
    var maxsize = html5.attr('_s');
    var photos = $('.photo-area .photo');
    var num = files.length;

    var len = photos.length;

    var fileinput = '<div id="html5" class="moxie-shim moxie-shim-html5" _s="'+maxsize+'"><div><input id="html5_file" type="file" name="" accept="image/*" class="image-input" capture="camera"></div></div></div>';

    var f = files[0];

    if (f.size > maxsize * 1024 * 1024) {
        alert('上传失败，图片大小必须在' + maxsize + 'MB之内！');
        html5.remove();
        $('.photo-area').append(fileinput);
        $('#html5_file').change(changeFunc);
        return;
    }

    var curr = len + 1;
    var reader = new FileReader();

    reader.readAsDataURL(f);

    reader.onload = function(e){

        $.post("/Good/uploadImg", { img: e.target.result}, function(msg){

            if (msg.status == 1) {

                var len = $('.photo-area .photo').length;
                if (len < 5) {
                    $('.photo-area').prepend('<div class="photo" id="image'+curr+'"><span class="close" onclick="closeDiv(this)"></span><div><img width="140" height="140" src="' + e.target.result + '" alt="" class="image" url=""></div><div class="full-div"></div><div class="full-div"></div></div>');

                    $("#image"+curr).append('<input type="hidden" name="images[]" value="'+msg.path+'">');

                    var div = $("#image"+curr).find('.full-div');
                    div.addClass('upload-icon');
                    div.eq(1).addClass('upload-icon-hover');
                    html5.remove();
                }

                if (!$('#html5').is('div') && len < 4) {
                    $('.photo-area').append(fileinput);
                    $('#html5_file').change(changeFunc);
                    var obj = $('#html5');
                    var width = $(window).width() * 0.43;
                    obj.height(width);
                    $('.upload-wr').height($('#html5').outerHeight(true) * (Math.ceil((len+2) / 2)));
                    $('.photo-area .photo').height($('#html5').height());
                }

            } else {
                alert('上传 ' + f.name + ' 失败，原因：' + msg.info);
            }
        });
    }


}
