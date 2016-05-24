<?php if (!defined('THINK_PATH')) exit();?>
<div class="page head-page letter-page">
<div class="head-form address-box" id="form-div">
    <form action="" method="POST" class="letter-form">
        <div id="letter_div" class="moxie-shim moxie-shim-html5">
            <textarea maxlength="100" name="content" placeholder="私信内容最大长度不能超过100个字符"></textarea>
        </div>

        <div class="buttons">
            <input value="" type="hidden" name="raply_id">
            <input value="" type="hidden" name="raply_name">
            <input value="发 送" type="button" name="letter" onclick="addLetter();">
        </div>
    </form>
</div>

</div>

<script src="/Public/Home/Js/validate.js"></script>

<script type="text/javascript">

// 遮罩层
$('.back').click(function(){
    $('.page').css('display','none');
    $(this).css('display','none');
    $(window).unbind('scroll');
})

</script>