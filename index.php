<?php

 function is_mobile(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
    $is_mobile = false;
    for ($m=0, $len_m=count($mobile_agents); $m < $len_m; $m++) {
        if (stristr($user_agent, $mobile_agents[$m])) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
 }
if (isset($_GET['wap'])) {
    if (1 == $_GET['wap']) {
        define('APP_PATH', './Wap/');
        setcookie('wap', 1, time() + 3600 * 24 * 365, '/');
    } else {
        define('APP_PATH', './Application/');
        setcookie('wap', 0, time() + 3600 * 24 * 365, '/');
    }
    header('location: ' . str_replace('?wap=' . $_GET['wap'], '', $_SERVER['REQUEST_URI']));
} else { // 自动判断
    if (isset($_COOKIE['wap'])) {
        if (1 == $_COOKIE['wap']) {
            define('APP_PATH', './Wap/');
            setcookie('wap', 1, time() + 3600 * 24 * 365, '/');
        } else {
            define('APP_PATH', './Application/');
            setcookie('wap', 0, time() + 3600 * 24 * 365, '/');
        }
    } else {
        if(is_mobile()){
            define('APP_PATH', './Wap/');
            setcookie('wap', 1, time() + 3600 * 24 * 365, '/');
        }else{
            define('APP_PATH', './Application/');
            setcookie('wap', 0, time() + 3600 * 24 * 365, '/');
        }
    }
}



// 应用入口文件

// 检测PHP环境
// if (version_compare(PHP_VERSION, '5.3.0', '<')) {
//     die('require PHP > 5.3.0 !');
// }

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

define('BIND_MODULE', 'Home');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
