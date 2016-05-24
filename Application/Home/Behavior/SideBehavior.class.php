<?php

/**
 * @Author: hookidea
 * @Role:
 * @Date:   2016-04-01 08:20:06
 * @Last Modified by:   hookidea
 * @Last Modified time: 2016-05-05 11:00:45
 */
namespace Home\Behavior;

class SideBehavior {
    // 行为扩展的执行入口必须是run
    public function run(&$params){
        if (session('user.user_id')) {
            if (!in_array(strtolower(CONTROLLER_NAME), ['letter', 'message'])) {
                // 计算未读消息的总数
                $_GET['totalNotReal'] = R('Letter/getNotReadLetter') + R('Message/getNotReadOrderInfo') + R('Message/getNotReadSystemInfo') + R('Message/getNotReadSwitchInfo') + R('Message/getNotReadCommentInfo');
                // 查看购物车商品总数量

            }
        }

        $_GET['cartNum'] = R('Cart/getTotalNum');
    }
}
