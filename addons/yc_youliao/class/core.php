<?php
/**
 * B支付
 *
 * @author Bowen
 * @url 
 */

defined('IN_IA') or exit ('Access Denied');


class Core extends WeModuleSite
{   


    
    public function wechat_MchPay($openid, $amount = 0, $partner_trade_no = 0, $desc = '', $realname = '')
    {
        global $_W;
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        $account = uni_fetch($_W['uniacid']);
        $pay_set = uni_setting_load('payment', $_W['uniacid']);
        $refund_set = $pay_set['payment']['wechat_refund'];

        if(empty($pay_set) || empty($refund_set)){
            return array('status' =>0,'str' => '请在微擎-支付参数设置-微信退款-按要求上传证书');
        }
        if(empty($partner_trade_no)){
            return array('status' =>0,'str' => '商户订单号为空');
        }
        $sendMoney_param = array(
      		'mch_appid' => !empty($appid)?$appid:$account['key'],
      		'mchid' => !empty($mchid)?$mchid:$pay_set['payment']['wechat']['mchid'],
            'nonce_str' => random(30),
            'partner_trade_no' => $partner_trade_no,//商户订单号
            'openid' => $openid,
            'check_name' => 'NO_CHECK',
      		'amount' => $amount * 100,//金额
      		'desc' => $desc,
            'spbill_create_ip' => util::serverIP(),
       	);
        if($realname != ''){
            $sendMoney_param['re_user_name'] = $realname;
        }
        $sendMoney_param['sign'] = $this->wechatPay_Sign($sendMoney_param,$pay_set['payment']['wechat']['apikey']);
        $xml = array2xml($sendMoney_param);//转为xml
        $cert_path = ATTACHMENT_ROOT . $_W['uniacid'] . '_wechat_refund_cert.pem';
        $key_path = ATTACHMENT_ROOT . $_W['uniacid'] . '_wechat_refund_key.pem';
        $cert = authcode($refund_set['cert'], 'DECODE');
        $key = authcode($refund_set['key'], 'DECODE');
        file_put_contents($cert_path, $cert);
        file_put_contents($key_path, $key); 
        $extras = array();
        $extras['CURLOPT_SSLCERT'] = $cert_path;
        $extras['CURLOPT_SSLKEY'] = $key_path;
        load()->func('communication');
        $response = ihttp_request($url, $xml, $extras);
        unlink($cert_path);unlink($key_path);
        if ($response['code'] == 200) {
 			$responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
 			$responseObj = (array)$responseObj;
 			$return['code'] =  $responseObj['return_code'];
 			$return['result_code'] =  $responseObj['result_code'];
 			$return['err_code'] =  $responseObj['err_code'];
 			$return['msg'] =  $responseObj['return_msg'];
 			$return['trade_no'] = $responseObj['partner_trade_no'];
            $return['payment_time'] = $responseObj['payment_time'];
            if($return['code'] == 'SUCCESS' && $return['result_code'] == 'SUCCESS'){
            // $res= util::result(1, '打款成功', $return);
             return array('status' =>1);
            }

            return array('status' =>0,'str' => '打款失败，错误原因: '.$return['err_code']);
  		}
        return array('status' =>0,'str' => '请检查1：微擎后吧-公众号-支付参数-退款配置-是否开启并已上传两个证书，2：确保公众号商户平台已充值足够的余额，注：微信规定付款进来的余额不可以支付出去');
    }

    public function wechatPay_Sign($param, $apikey)
    {//生成支付签名
        ksort($param, SORT_STRING);
        $string1 = '';
        foreach($param as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$apikey}";
        $sign = strtoupper(md5($string1));
        return $sign;
    }

}
