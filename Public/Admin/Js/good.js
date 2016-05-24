/*
* @Author: hookidea
* @Date:   2016-03-27 15:40:56
* @Last Modified by:   hookidea
* @Last Modified time: 2016-05-19 22:43:26
*/

'use strict';

$('#closeFrame').click(closeFrame);
$('#toggleImg').click(closeFrame);

/**
 * 空间管理
 * @param  {[type]} name [description]
 * @return {[type]}      [description]
 */
function voidManage (name) {
    if (confirm('确定执行该操作？')) {
        $.post('/admin.php/System/voidManage', {name: name}, function () {
            alert('操作成功！');
        });
    }
}

function setConfigValue (e, name) {
    var value = prompt('请输入您要修改的值：');
    if (value) {
        var span = $('#config-table span').eq($('button').index(e));
        $.post('/admin.php/System/configManage', {name: name, value: value}, function (msg) {
            if (msg.status) {
                span.html(value);
            } else {
                alert('操作失败！');
            }
        });
    }
}

function changeConfigValue (e, name) {
    if (confirm('确定执行该操作？')) {
        var span = $('#config-table span').eq($('button').index(e));

        var value = span.html().search('已开启') !== -1 ? false : true;
        var text = !value ? '已关闭' : '已开启';

        $.post('/admin.php/System/configManage', {name: name, value: value}, function (msg) {

            if (msg.status) {
                span.html(text);
            } else {
                alert('修改失败！');
            }
        });
    }
}

function closeFrame() {
    var obj = window.parent.document.getElementsByTagName('frameset')[1];
    if (obj.cols == '160, 10, *') {
        obj.cols='0, 10, *';
    } else {
        obj.cols='160, 10, *';
    }
}

function ajax(type, url, data) {
    if (type.toLowerCase() == 'get') {
        $.get(url, function (result) {
            alert(result.info);
            location.reload(true);
        });
    }
}

function parse() { // $("input[name='newsletter']").attr("checked", true)
    var url = $('#search').attr('url');
    var str = '';
    var cat_id = $('#cat_id').val();
    var brand_id = $('#brand_id').val();
    var status = $('#status').val();
    var suppliers_id = $('#suppliers_id').val();
    var keyword = $('#keyword').val();
    if (cat_id != 0) str += 'cat_id=' + cat_id + '&';
    if (brand_id != 0) str += 'brand_id=' + brand_id + '&';
    if (status != 0) str += 'status=' + status + '&';
    if (suppliers_id != 0) str += 'suppliers_id=' + suppliers_id + '&';
    if (keyword != undefined) str += 'keyword=' + keyword;
    $.get(url + '?' + str, function (result) {
        alert(result);
        // location.reload(true);
    });
}

/**
 * 全选/取消全选
 * @param  1/0      type    全选/取消全选
 */
function full_select () {
  $('input:checkbox').prop('checked', true);
  return false;
}
function del_select () {
  $('input:checkbox').prop('checked', false);
  $('.billing p em').html('￥0');
  $('.save > span').html('￥0');
  return false;
}

function multiGood (type) {
    if (confirm('确定执行此操作？')) {
        switch (type.toLowerCase()) {
            case 'delete':
                var url = '/admin.php/Good/delete';
                break;
            case 'onsale':
                var url = '/admin.php/Good/onsale';
                break;
            case 'check':
                var url = '/admin.php/Good/check';
                break;
            case 'lift':
                var url = '/admin.php/Good/lift';
                break;
        }

        $.post(url, $('#listForm').serialize(), function (msg) {
            alert(msg.info);
            if (msg.status == 1) {
                location.reload();
            }
        });
    }
    return false;
}

function multiUser (type) {
    if (confirm('确定执行此操作？')) {
        switch (type.toLowerCase()) {
            case 'delete':
                var url = '/admin.php/User/delete';
                break;
            case 'check':
                var url = '/admin.php/User/check';
                break;
            case 'real':
                var url = '/admin.php/User/real';
                break;
        }

        $.post(url, $('#listForm').serialize(), function (msg) {
            alert(msg.info);
            if (msg.status == 1) {
                location.reload();
            }
        });
    }
    return false;
}

function multiComment (type) {
    if (confirm('确定执行此操作？')) {
        switch (type.toLowerCase()) {
            case 'delete':
                var url = '/admin.php/Comment/delete';
                break;
        }

        $.post(url, $('#listForm').serialize(), function (msg) {
            alert(msg.info);
            if (msg.status == 1) {
                location.reload();
            }
        });
    }
}


function multiBug (type) {
    if (confirm('确定执行此操作？')) {
        switch (type.toLowerCase()) {
            case 'delete':
                var url = '/admin.php/Bug/delete';
                break;
            case 'setfull':
                var url = '/admin.php/Bug/setFull';
                break;
        }

        $.post(url, $('#listForm').serialize(), function (msg) {
            alert(msg.info);
            if (msg.status == 1) {
                location.reload();
            }
        });
    }
}
