<?php if (!defined('THINK_PATH')) exit();?>
<div id="letter-wrap">
  <form action="" method="POST" class="letter-form">
      <div id="letter_div" class="moxie-shim moxie-shim-html5">
          <textarea maxlength="100" name="content" placeholder="私信内容最大长度不能超过100个字符"></textarea>
      </div>
      
      <div class="buttons">
          <input value="" type="hidden" name="raply_id">
          <input value="" type="hidden" name="raply_name">
          <input value="发 送" id="send-btn" type="button" name="letter" onclick="addLetter();">
      </div>
  </form>
</div>