<?php
/**
 * 米花商城模块处理程序
 *
 * @author 米花
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class yc_youliaoModuleProcessor extends WeModuleProcessor {
	public function respond()
    {
        load()->func('logging');
        logging_run("进入" . json_encode($this->message));
        $message = $this->message;
        $msgType = $message['msgtype'];
        if ($msgType == 'event') {
            $eventType = $message['event'];
            if ($eventType == 'TEMPLATESENDJOBFINISH') { //模板消息发送成功回调
                $msgId = $message['msgid'];
                $status = $message['status'];
                if ($status == 'success') {
                    $set['status'] = 2;
                    $set['receive_time'] = date("Y-m-d H:i:s");
                } else {
                    $set['status'] = 3; //用户微信拒收
                    $set['msg_body'] = '用户设置了拒绝接收模板消息,'.$status;
                }
                pdo_update('t_notify_result', $set, ['msg_id' => $msgId]);
            }
        }
        echo 'success';
    }
}