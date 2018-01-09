<?php

//微猫源码
//http://www.weixin2015.cn
//QQ:2058430070


defined('IN_IA') or exit('Access Denied');
require("class/func.php");
require("class/autoLoad.php");
require("class/util.php");
//require("class/ImageCrop.class.php");
//require("class/qrcode.class.php");
require("class/redpackage_util.php");
require("class/defineData.php");
require("class/commonGetData.php");

class yc_youliaoModule extends WeModule 
{
	public function settingsDisplay($settings) 
	{
		global $_GPC, $_W;
		$title='社区设置';
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$timelist = pdo_fetchall("SELECT * FROM ".tablename('mihua_sq_mstime')." WHERE uniacid = {$_W['uniacid']}
	ORDER BY timestart ASC ");
		$word = commonGetData::sensitiveword();
	if (checksubmit()) 
	{
		$sensitiveword = $_GPC['sensitiveword'];
			$replace = $_GPC['replace'];
			if (!empty($sensitiveword) && empty($word)) {
				pdo_insert(WORD, array('sensitiveword' => $sensitiveword, 'replace' => $replace, 'uniacid' => $_W['uniacid']));
			} else {
				if (!empty($sensitiveword) && !empty($word)) {
					pdo_update(WORD, array('sensitiveword' => $sensitiveword, 'replace' => $replace), array('word_id' => $word['word_id'], 'uniacid' => $_W['uniacid']));
				}
			}
		$cfg = array( 
			'in_money' => $_GPC['in_money'], 
			'isredpacket' => $_GPC['isredpacket'],
			'isshang' => $_GPC['isshang'],
			'transfer' => $_GPC['transfer'],
			'transfer_min' => $_GPC['transfer_min'],
			'transfer_max' => $_GPC['transfer_max'],
			'transfer_user' => $_GPC['transfer_user'],
			'pay_type_user' => $_GPC['pay_type_user'],
			'views_num' => $_GPC['views_num'],
			'shop_logo' => $_GPC['shop_logo'],
			'shop_bgpic' => $_GPC['shop_bgpic'],
			'shop_enter' => $_GPC['shop_enter'],
			'shop_enter_price' => $_GPC['shop_enter_price'],
			'one_year_money' => $_GPC['one_year_money'],
			'two_year_money' => $_GPC['two_year_money'],
			'three_year_money' => $_GPC['three_year_money'],
			'one_renew' => $_GPC['one_renew'],
			'two_renew'=> $_GPC['two_renew'],
			'three_renew'=> $_GPC['three_renew'],
			'shop_transfer_min' => $_GPC['shop_transfer_min'],
			'shop_transfer_max' => $_GPC['shop_transfer_max'],
			'shop_pay_type' => $_GPC['shop_pay_type'],
			'contract' => htmlspecialchars_decode($_GPC['contract']),//入驻协议
			'shop_service_btn' => $_GPC['shop_service_btn'],
			//'contracthtml' => htmlspecialchars_decode($_GPC['help']),
			'refundtime' => $_GPC['refundtime'],//可申请退货时间
			'index_money' => $_GPC['index_money'],
			'time_money' => $_GPC['time_money'], 
			'group_money' => $_GPC['group_money'], 
			'balance' => $_GPC['balance'], 
			'wx' => $_GPC['wx'], 
			'showWater' => $_GPC['showWater'],
			'issamecity' =>  $_GPC['issamecity'],
			'isautorefundgroup' => trim($_GPC['isautorefundgroup']),
			'isreturncredit' => $_GPC['isreturncredit'],
			'autocancelordertime' => $_GPC['autocancelordertime'],
			'remindmessagetime' => $_GPC['remindmessagetime'],
			'qrcode_flag' => intval($_GPC['qrcode_flag']),
			'help' => htmlspecialchars_decode($_GPC['help']),
			'index_title' => $_GPC['index_title'],
			'footer' => htmlspecialchars_decode($_GPC['footer']),
			'comment_flag' => $_GPC['comment_flag'], 
			'disclaimer'=> htmlspecialchars_decode($_GPC['disclaimer']),
			'time_long' => $_GPC['time_long'],
			'qrcode_flag' => intval($_GPC['qrcode_flag']), 
			'qr_code' => $_GPC['qr_code'],
			'share_title' => trim($_GPC['share_title']), 
			'share_img' => $_GPC['share_img'],
			'share_info' => $_GPC['share_info'], 
			'qiandao_random' => $_GPC['qiandao_random'], 
			'qiandao_jifen' => trim($_GPC['qiandao_jifen']), 
			'credit2money'=> $_GPC['credit2money'],
			//'sensitiveword' => $_GPC['sensitiveword'],
			'showShop' => $_GPC['showShop'], 
			'showChannel' => $_GPC['showChannel'],
			'showChannelNum'=> $_GPC['showChannelNum'], 
			'istplon'=> $_GPC['istplon'],
			'kefutplminute'=> $_GPC['kefutplminute'], 
			'ring_creidit'=> $_GPC['ring_creidit'], 
			'ring_num'=> $_GPC['ring_num'],
			'mapak'=> $_GPC['mapak'], 
			'service_btn' => $_GPC['service_btn'], 
			'service_link' => $_GPC['service_link'],
			'service_w' => $_GPC['service_w'], 
			'service_h' => $_GPC['service_h'],
			'service_b' => $_GPC['service_b'],
			'service_l' => $_GPC['service_l'],
			'show_service' => $_GPC['show_service'],			
			'btn1_name' =>trim($_GPC['btn1_name']),
			'btn1_link' =>trim($_GPC['btn1_link']),
			'btn1' =>$_GPC['btn1'], 
			'btn1_hover' =>$_GPC['btn1_hover'],
			'btn2_name' =>trim($_GPC['btn2_name']),
			'btn2_link' =>trim($_GPC['btn2_link']),
			'btn2' =>$_GPC['btn2'],
			'btn2_hover' =>$_GPC['btn2_hover'], 
			'btn3_name' =>trim($_GPC['btn3_name']),
			'btn3_link' =>trim($_GPC['btn3_link']), 
			'btn3' =>$_GPC['btn3'],
			'btn3_hover' =>$_GPC['btn3_hover'],
			'btn4_name' =>trim($_GPC['btn4_name']), 
			'btn4_link' =>trim($_GPC['btn4_link']), 
			'btn4' =>$_GPC['btn4'], 
			'btn4_hover' =>$_GPC['btn4_hover'], 
			'btn5_name' =>trim($_GPC['btn5_name']),
			'btn5_link' =>trim($_GPC['btn5_link']), 
			'btn5' =>$_GPC['btn5'], 
			'btn5_hover' =>$_GPC['btn5_hover'],
			);
		if ($this->saveSettings($cfg)) 
		{
			$this->message('保存成功', '','success');
		}
		else
		{
			$this->message('保存失败', '','error');
		}
	}
	include $this->template('web/setting');
	exit;
}
public function message($msg,$url,$status)
{
	$template = 'web/message';
	include $this->template($template);
	exit();
}
}
?>