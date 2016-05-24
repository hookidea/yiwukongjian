<?php

/**
 * @Author: hookidea
 * @Role:
 * @Date:   2016-04-01 06:55:18
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-05-05 19:32:48
 */

/**
 * 过滤函数
 * @param  [type] $value [description]
 * @return [type]        [description]
 */
function filterFunc ($value) {
    if (is_numeric($value)) {
        return (int)$value;
    } else {
        return htmlspecialchars(strip_tags($value), ENT_QUOTES);
    }
}

// 修改配置文件内容
function setConfig($key, $value, $path=null)
{
    if(is_null($path)) $path = CONF_PATH . 'config.php';
    $content = file_get_contents($path);
    $preg ='/(([\'\"])'.$key.'\2\s*=>\s*)(\w*),/im';
    return file_put_contents($path, preg_replace($preg, '$1 '.$value.',', $content));
}


function getHomePage (&$m, $where, $pagesize=10) {
    $m1 = clone $m;
    $count = $m->where($where)->count();
    $m = $m1;
    $m->where($where);
    $page = new \Think\Page($count, $pagesize);
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');

    $page->parameter = array_merge(I('get.'), $where);

    $m->limit($page->firstRow, $page->listRows);
    return $page;
}

function getPage (&$m, $where, $pagesize=10) {
    $m1 = clone $m;
    $count = $m->where($where)->count();
    $m = $m1;
    $m->where($where);
    $page = new \Think\Page($count, $pagesize);
    // $page->lastSuffix = false;
    $page->setConfig('header', '共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('first', '首页');
    $page->setConfig('last', '末页');
    $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% - %HEADER%');

    $page->parameter = array_merge(I('get.'), $where);

    $m->limit($page->firstRow, $page->listRows);
    return $page;
}

function getSearchPage ($total, $pagesize=10) {
    $page = new \Think\Page($total, $pagesize);
    // $page->lastSuffix = false;
    $page->setConfig('header', '共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('first', '首页');
    $page->setConfig('last', '末页');
    $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% - %HEADER%');
    $page->parameter = array_merge(I('get.'), I('post.'));
    return $page;
}

function getSearchHomePage ($total, $pagesize=10) {
    $page = new \Think\Page($total, $pagesize);
    // $page->lastSuffix = false;
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
    $page->parameter = array_merge(I('get.'), I('post.'));
    return $page;
}


function getOrderPage (&$m, $where, $pagesize=10) {
    $m1 = clone $m;
    $count = $m->where($where)->count();
    $m = $m1;
    $m->where($where);
    $page = new \Think\Page($count, $pagesize);
    // $page->lastSuffix = false;
    $page->setConfig('prev', '上一页');
    $page->setConfig('next', '下一页');
    $page->setConfig('first', '首页');
    $page->setConfig('last', '末页');
    $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

    $page->parameter = array_merge(I('get.'), $where);

    $m->limit($page->firstRow, $page->listRows);
    return $page;
}
