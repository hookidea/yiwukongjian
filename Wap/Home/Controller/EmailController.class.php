<?php
namespace Home\Controller;

use Think\Controller;

class EmailController extends Controller
{
    /**
     * 发送一封邮件
     * @return [type] [description]
     */
    public function send ($email=null)
    {
        $this->type = I('type');
        if (!in_array($this->type, [0, 1, 2])) $this->ajaxReturn(['status' => 2, 'info' => '邮件类型错误！', 'href' => false]);

        if (IS_GET) {
            $this->_getForm();
        } else {

            if (is_null($email)) {

                if (0 == $this->type) {
                    $user_name = session('user.user_name');
                } else {
                    $user_name = I('post.user_name');
                }

                $user_info = D('User')->where(['user_name'=>$user_name])->field('user_id,email')->find();

                $email = I('post.email') ? I('post.email') : $user_info['email'];

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $this->ajaxReturn(['status' => 2, 'info' => '您输入的邮箱格式错误！', 'href' => false]);

                if (1 == $this->type) {
                    if (!$user_info['user_id']) $this->ajaxReturn(['status' => 2, 'info' => '您输入的用户名不存在！', 'href' => false]);
                    if ($user_info['email'] != $email) $this->ajaxReturn(['status' => 2, 'info' => '您输入的邮箱与该用户所绑定的邮箱不一致！', 'href' => false]);
                }
                $user_id = $user_info['user_id'];
            } else { // 修改邮箱/新注册之后自动发送激活邮件
                $this->type = 1;
                $user_id = session('user.user_id');

            }

            $this->_delete($user_id);     // 删除垃圾
            $this->_createKey();
            $this->id = M()->table('email_verify')->add(['type' => $this->type, 'user_id' => $user_id, 'hash' => $this->code, 'fail_time' => strtotime('+1 day')]);
            if (!$this->id) $this->ajaxReturn(['status' => 2, 'info' => '邮件发送失败，请刷新之后重试！', 'href' => false]);
            $this->_createImg();
            $this->_createUrl();
            $this->_createTitle();
            $this->_createContent();

            $accounts = C('EMAIL_ACCOUNT');
            $time = 3600 * 24 * 365;    // 缓存失效时间
            $num = S('EMAIL_SEND_NUM'); // 获取当前的发送次数
            if (!$num) {
                S('EMAIL_SEND_NUM', 1, $time);
            } else {
                S('EMAIL_SEND_NUM', ++$num, $time);
            }

            $key = floor($num % count($accounts));
            $row = $accounts[$key];     // 当次使用的账号

            $mail =  new \Org\Util\Email();

            $mail->setServer($row['server'], $row['email'], $row['password'], 465, true);
            $mail->setFrom($row['email']);
            $mail->setReceiver($email);

            $mail->setMail($this->title, $this->content);

            $mail->sendMail();

            if (is_null($email)) {
                switch ($this->type) {
                    case 0:
                        $this->ajaxReturn(['status'=>1, 'info'=>'邮箱激活邮件发送成功，请您于一天之内前往您的邮箱进行激活！', 'href'=>false]);
                        break;
                    case 1:
                        $this->ajaxReturn(['status'=>1, 'info'=>'密码找回邮件发送成功，请您于一天之内前往您的邮箱进行处理！', 'href'=>false]);
                        break;
                }
            }


        }
    }

    private function _getForm ()
    {
        switch ($this->type) {
            case 1: // 找回密码
                $content = $this->fetch('Email/form1');
                break;
        }
        $this->ajaxReturn(['status'=>1, 'info'=>'获取表单成功', 'content'=>$content]);
    }

    private function _delete ($user_id)
    {
        M()->table('email_verify')->where(['user_id' => $user_id])->delete();
    }

    private function _createKey ()
    {
        $this->code = substr(str_shuffle('qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM1234567890'), 0, 30);
    }

    private function _createTitle ()
    {
        switch ($this->type) {
            case 0:
                $this->title = '易物空间 - 验证邮箱邮件';
                $this->btnText = '验证邮箱';
                break;

            case 1:
                $this->title = '易物空间 - 找回密码邮件';
                $this->btnText = '找回密码';
                break;
        }
    }

    private function _createUrl ()
    {
        $this->url = 'http://14web.cn/User/email?id=' . $this->id . '&key=' . $this->code;
    }

    private function _createContent ()
    {
        $this->content = '<table border="0" cellpadding="0" cellspacing="0" width="650px" id="templateContainer" style="margin: 50px auto 50px auto;border-radius: 2px"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" class="templateContainer"><tbody><tr><td valign="top" data-container="header" class="headerContainer tpl-container dragTarget"><div class="block tpl-block image-block"><div data-attach-point="containerNode"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="imageBlock"><tbody class="imageBlockOuter"><tr><td valign="top" class="imageBlockInner"><table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="imageContentContainer"><tbody><tr><td class="imageContent" align="center" valign="top" style="background-color:rgba(255,255,255,0);padding-top: 15px"><img src="' . $this->imageData . '"></td></tr></tbody></table></td></tr></tbody></table></div></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="650" class="templateContainer"><tbody><tr><td valign="top" data-container="body" class="bodyContainer tpl-container dragTarget"><div class="block tpl-block text-block" style="border-radius: 0px; border: 0px solid rgb(0, 0, 0);"><div data-attach-point="containerNode"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="textBlock"><tbody class="textBlockOuter"><tr><td valign="top" class="textBlockInner"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" class="textContentContainer"><tbody><tr><td valign="top" class="textContent" style="padding-top:5px; padding-right: 40px; padding-bottom: 25px;padding-left: 40px;background-color:rgba(255,255,255,0)"><div style="text-align: center"><br><span style="font-family: \'Microsoft YaHei\', 微软雅黑, SimSun, 宋体, Heiti, 黑体, sans-serif;text-align: center; font-size: 14px !important; line-height:24.9333px;">点击下方按钮' . $this->btnText . '（链接24小时内有效）<br></span></div><div style="text-align:center;margin-top: 20px"><div style="width: 600px;display:inline-block;padding:10px"><a class="activeA" style="display:inline-block;background:#07d681;border-radius:4px;padding: 0px auto;color:white;text-decoration:none;font-size:16px;line-height: 44px ; width: 280px;height: 44px" href="' . $this->url . '" target="_blank">' . $this->btnText . '</a></div></div><div style="text-align:center;margin-top: 20px">或复制以下网址到浏览器里直接打开：<br><a style="color: #6DC6DD; font-weight: normal;" href="' . $this->url . '" target="_blank">' . $this->url . '</a></div></td></tr></tbody></table></td></tr></tbody></table></div></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="650" class="templateContainer"><tbody><tr><td valign="top" data-container="footer" class="footerContainer tpl-container dragTarget"><div class="block tpl-block text-block"><div data-attach-point="containerNode"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="textBlock"><tbody class="textBlockOuter"><tr><td valign="top" class="textBlockInner"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" class="textContentContainer"><tbody><tr><td valign="top" class="textContent" style="background-color:rgba(255,255,255,0)"><div style="text-align:center"><div style="border-top:1px solid #ddd;width: 620px;display:inline-block;padding-bottom: 10px"></div></div><div style="margin-top: 10px;margin-bottom: 20px"></div><div class="locate" style="word-wrap: break-word; outline: none;margin-bottom:10px;color:#c4c4c4; clear: both;font-family:\'Microsoft YaHei\',Arial; font-size: 14.6667px; line-height: 24.9333px; text-align: center;"><span style="font-size: 12px;"><em style="line-height: 20.8px;">Copyright © 2016 YW.GZITTC.com. All Rights Reserved.</em></span></div></td></tr></tbody></table></td></tr></tbody></table></div></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>';
    }

    private function _createImg()
    {
        $imageData = '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';

        $this->imageData = 'data: '.mime_content_type($image).';base64,'.$imageData;
    }


}
