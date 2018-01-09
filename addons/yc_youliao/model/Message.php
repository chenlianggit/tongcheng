<?php

class Message 
{

//{{first.DATA}}
//商户名称：{{keyword1.DATA}}
//商家姓名：{{keyword2.DATA}}
//支付金额：{{keyword3.DATA}}
//支付状态：{{keyword4.DATA}}
//申请时间：{{keyword5.DATA}}
//{{remark.DATA}}
//OPENTM405848458
//商户入驻申请通知




//{{first.DATA}}
//账号名称：{{keyword1.DATA}}
//审核状态：{{keyword2.DATA}}
//审核时间：{{keyword3.DATA}}
//{{remark.DATA}}

//管理员审核提醒
    public static function admin_checkmessage($i_item,$url,$openid,$status,$nickname,$remark){
        $item=commonGetData::gettpl('OPENTM405884804');
        if(empty($item['tpl_id']))return;
        $i_id =$item['tpl_id'];
        $msg_json ='{
                "touser":"'.$openid.'",
                "template_id":"'.$i_id.'",
                "url":"'.$url.'",
                "topcolor":"#000000",
                "data":{
                    "first": {
                        "value":"'.$i_item.'",
						"color":"#EA0913"
                    },
                    "keyword1":{
                        "value":"'.$nickname.'",
						"color":"#fb5100"
                    }, 
					"keyword2":{
                        "value":"' .$status .'",
						"color":"#fb5100"
                    }, 
					"keyword3":{
                      "value":"' . date('Y-m-d H:i:s', TIMESTAMP) .'",
						"color":"#fb5100"
                    }, 
					"remark":{
                   "value":"' . $remark . '",
                   "color":"#777777"
               	}
                }
            }';
        return self::commonPostMessage($msg_json);

    }

//{{first.DATA}}
//审核事项：{{keyword1.DATA}}
//申请账号：{{keyword2.DATA}}
//申请时间：{{keyword3.DATA}}
//{{remark.DATA}}
//OPENTM409023186
//管理员审核提醒
    public static function a_checkmessage($openid,$url,$i_item,$name,$nickname,$createtime,$i_remark = '点击查看详情') {
        $item=commonGetData::gettpl('OPENTM409023186');
        if(empty($item['tpl_id']))return;
        $i_id =$item['tpl_id'];
        ;
        $msg_json ='{
                "touser":"'.$openid.'",
                "template_id":"'.$i_id.'",
                "url":"'.$url.'",
                "topcolor":"#000000",
                "data":{
                    "first": {
                        "value":"'.$i_item.'",
						"color":"#EA0913"
                    },
                    "keyword1":{
                        "value":"'.$name.'",
						"color":"#fb5100"
                    }, 
					"keyword2":{
                        "value":"' .$nickname .'",
						"color":"#fb5100"
                    }, 
					"keyword3":{
                        "value":"' . date('Y-m-d H:i:s',$createtime) .'",
						"color":"#fb5100"
                    }, 
					"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
                }
            }';
        return self::commonPostMessage($msg_json);

    }

    public static function admin_checkmsg($i_item,$url,$name,$nickname,$createtime,$remark='') {
        $where['msg_flag'] ='0';
        $shop = util::getAllDataBySingleTable(ADMIN, $where,'admin_id','openid,nickname');
        if(empty($shop))return;
        foreach ($shop as $s){
            if($s['openid'] ){
                self::a_checkmessage($s['openid'],$url,'亲爱的'.$s['nickname'].','.$i_item,$name,$nickname,$createtime,$remark);
            }

        }
    }

//{{first.DATA}}
//文章标题：{{keyword1.DATA}}
//发布时间：{{keyword2.DATA}}
//发布人：{{keyword3.DATA}}
//状态：{{keyword4.DATA}}
//{{remark.DATA}}
//审核通过提醒
//OPENTM407392801

	public static function kmessage($openid,$item='',$module,$fee,$title,$time,$orderid,$idoforder) {
		
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		$i_item = empty($item) ? '您有一笔订单还未支付，就要过期了，支付后我们会马上安排给您发货。' : $item;

		$i_id = $module -> module['config']['k_id'];
		$i_remark = $module -> module['config']['k_remark'];

		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"type":{
					"value":"商品"
				},				
               	"o_money":{
					"value":"'.$fee.'",
               		"color":"#fb5100"
				},
               	"e_title":{
					"value":"'.$title.'",
               		"color":"#fb5100"
				},
               	"order_date":{
					"value":"' . date('Y-m-d H:i:s',$time) .'",
               		"color":"#fb5100"
				},
               	"o_id":{
					"value":"'.$orderid.'",
               		"color":"#fb5100"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}

    //TM00015
    //订单支付成功
    //{{first.DATA}}
    //支付金额：{{orderMoneySum.DATA}}
    //商品信息：{{orderProductName.DATA}}
    //{{Remark.DATA}}

    public static function ordermessage($openid,$i_item,$url,$title,$fee,$i_remark = '点击查看详情') {
        $item=commonGetData::gettpl('TM00015');
        if(empty($item['tpl_id']))return;
        $i_id =$item['tpl_id'];
        $msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"orderMoneySum":{
					"value":"'.$fee.' 元",
               		"color":"#fb5100"
				},				
               	"orderProductName":{
					"value":"'.$title.'",
               		"color":"#fb5100"
				},               			
               	"Remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
        return self::commonPostMessage($msg_json);

    }

    //OPENTM406726102
    //用户下单成功
    //{{first.DATA}}
    //下单账号：{{keyword1.DATA}}
    //下单时间：{{keyword2.DATA}}
    //下单产品：{{keyword3.DATA}}
    //下单金额：{{keyword4.DATA}}
    //联系电话：{{keyword5.DATA}}
    //{{remark.DATA}}
    public static function shop_ordermessage($shop_id,$id,$i_item){
    $where['shop_id'] =$shop_id;
    $where['msg_flag'] ='0';
    $shop = util::getAllDataBySingleTable(SHOP_ADMIN, $where,'admin_id','openid,nickname');
    if(empty($shop))return;
    foreach ($shop as $s){
        if($s['openid']){
            self::a_ordermessage($s['openid'],$id,'亲爱的'.$s['nickname'].','.$i_item);
        }

    }
}
    public static function shop_dis_ordermessage($shop_id,$url,$title,$fee){
        $where['msg_flag'] ='0';
        $where['shop_id'] =$shop_id;
        $shop = util::getAllDataBySingleTable(SHOP_ADMINADMIN, $where,'admin_id','openid,nickname');
        if(empty($shop))return;
        foreach ($shop as $s){
            if($s['openid']){
                self::ordermessage($s['openid'],'亲爱的'.$s['nickname'].',有人买单啦！',$url,$title,$fee);
            }

        }
    }
    public static function admin_ordermessage($i_item,$url,$title,$fee,$remark=''){
        $where['msg_flag'] ='0';
        $shop = util::getAllDataBySingleTable(ADMIN, $where,'admin_id','openid,nickname');
        if(empty($shop))return;
        foreach ($shop as $s){
            if($s['openid']){
                self::ordermessage($s['openid'],'亲爱的'.$s['nickname'].','.$i_item,$url,$title,$fee,$remark);
            }

        }
    }

    public static function a_ordermessage($openid,$id,$i_item) {
        $url= Util::createModuleUrl('order',array('op'=>'detail','id'=>$id));
        $order=Order::getOrderAndGood($id);
        $fans=mc_fansinfo($order['openid']);
        $item=commonGetData::gettpl('OPENTM406726102');
        if(empty($item['tpl_id']))return;
        $i_id =$item['tpl_id'];
        $i_remark = '点击查看详情';
        $msg_json ='{
                "touser":"'.$openid.'",
                "template_id":"'.$i_id.'",
                "url":"'.$url.'",
                "topcolor":"#000000",
                "data":{
                    "first": {
                        "value":"'.$i_item.'",
						"color":"#EA0913"
                    },
                    "keyword1":{
                        "value":"'.$fans['nickname'].'",
						"color":"#fb5100"
                    }, 
					"keyword2":{
                        "value":"' . date('Y-m-d H:i:s',$order['createtime']) .'",
						"color":"#fb5100"
                    }, 
					"keyword3":{
                        "value":"'.$order['title'].'",
						"color":"#fb5100"
                    }, 
					"keyword4":{
                        "value":"'.$order['totalmoney'].'元",
						"color":"#fb5100"
                    },  
					"keyword5":{
                        "value":"'.$order['mobile'].'",
						"color":"#fb5100"
                    },                  
                    "remark":{
                        "value":"'.$i_remark.'",
                        "color":"#000000"
                    }
                }
            }';
        return self::commonPostMessage($msg_json);

    }


	/*
	售出成功通知
	{{first.DATA}}
	商品名称：{{keyword1.DATA}}
	成交时间：{{keyword2.DATA}}
	成交金额：{{keyword3.DATA}}
	{{remark.DATA}}
	编号：OPENTM406074965[标题：售出成功通知]
	*/
	public static function jmessage($module,$title,$fee,$idoforder) {
		if(empty($module->module['config']['adminopenid'])) return false;		
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder,'isadmin'=>1));
		$i_item = '组团成功';
		$i_id = $module -> module['config']['j_id'];
		$i_remark = $module -> module['config']['j_remark'];
		$msg_json = '{
           	"touser":"' . $module->module['config']['adminopenid'] . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$title.'",
               		"color":"#fb5100"
				},				
               	"keyword2":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#fb5100"
				},
               	"keyword3":{
					"value":"'.$fee.' 元",
               		"color":"#fb5100"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	/*
	订单取消通知	
	编号：TM00850[标题：订单取消通知]
	*/
	public static function imessage2($openid,$module,$title,$orderid,$fee,$address,$idoforder) {
		$url2 = Util::createModuleUrl('order',array('op'=>'detail','id'=>$idoforder));
		$i_item = '您有一笔订单没有及时支付已被取消了，点击此处可查看订单详情。';
        $item=commonGetData::gettpl('TM00850');
        if(empty($item['tpl_id']))return;
        $i_id =$item['tpl_id'];
		$i_remark ='';
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"orderProductPrice":{
					"value":"'.$fee.'",
               		"color":"#fb5100"
				},				
               	"orderProductName":{
					"value":"'.$title.'",
               		"color":"#fb5100"
				},
					"orderAddress":{
					"value":"'.$address.'",
               		"color":"#fb5100"
				},
				"orderName":{
					"value":"'.$orderid.'",
               		"color":"#fb5100"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		

	
	
	/*
	订单完成通知
	{{first.DATA}}
	订单号：{{keyword1.DATA}}
	完成时间：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM202521011[标题：订单完成通知]
	*/
	public static function hmessage($openid,$module,$orderid,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		
		$i_item = '您有一笔订单超过确认收货时间已自动完成了，点击此处查看订单详情';
		$i_id = $module -> module['config']['h_id'];
		$i_remark = $module -> module['config']['h_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#fb5100"
				},				
               	"keyword2":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#fb5100"
				},
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	/*
	组团失败提醒
	{{first.DATA}}
    商品信息：{{keyword1.DATA}}
    组团信息：{{keyword2.DATA}}
    {{remark.DATA}}
	编号：OPENTM400833482[标题：组团失败提醒]
	*/
	public static function gmessage($openid,$module,$title,$fullnumber,$groupid) {
		$url2 = Util::createModuleUrl('group',array('groupid'=>$groupid, 'op'=>'detail'));
		$i_item = '您的团购组团失败了，请等待系统处理此订单，点击此处查看团详情';
        $item=commonGetData::gettpl('OPENTM400833482');
        if(empty($item['tpl_id']))return;
		$i_id = $item['tpl_id'];
        $i_remark ='';
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$title.'",
               		"color":"#fb5100"
				},				
               	"keyword2":{
					"value":"'.$fullnumber.'人团",
               		"color":"#fb5100"
				},
				 	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
              
           	}
        }';

		return self::commonPostMessage($msg_json);
	}	
	
	
	
	/*
	订单退款提醒
	{{first.DATA}}
	订单编号：{{keyword1.DATA}}
	退款金额：{{keyword2.DATA}}
	退款方式：{{keyword3.DATA}}
	到账时间：{{keyword4.DATA}}
	{{remark.DATA}}
	编号：OPENTM200565278[标题：订单退款提醒]
	*/
	public static function fmessage($openid,$module,$orderid,$fee,$paytype,$url2) {
		
		if($paytype == '2') $typestr = '支付方式原路退回';
		if($paytype == '1') $typestr = '退回账户余额内';
		$i_item = '您有订单已退款了，点击此处查看订单详情';
        $item=commonGetData::gettpl('OPENTM200565278');
        if(empty($item['tpl_id']))return;
        $i_id = $item['tpl_id'];
		$i_remark = '';
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#fb5100"
				},				
               	"keyword2":{
					"value":"'.$fee.' 元",
               		"color":"#fb5100"
				},			
               	"keyword3":{
					"value":"'.$typestr.'",
               		"color":"#fb5100"
				},				
               	"keyword4":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#777777"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	
	/*
	
	编号：OPENTM00303[标题：商品已发出通知]
	*/
	public static function emessage($openid,$module,$title,$expressname,$expressnumber,$address,$idoforder) {
		$url2 = Util::createModuleUrl('myorder',array('op'=>'detail','orderid'=>$idoforder));
		if(empty($expressname)) $expressname = '无物流';
		if(empty($expressnumber)) $expressnumber = '无物流';
		$i_item = '嗖嗖嗖，您的宝贝已上路，点击此处可查看订单详情';
		$i_id = $module -> module['config']['sendMsgTemplateid'];
		$i_remark = $module -> module['config']['e_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
                "delivername":{
                        "value":"'.$expressname.'",
						"color":"#000000"
                    }, 
					"ordername":{
                        "value":"'.$expressnumber.'",
						"color":"#000000"
                    },                  
                    "remark":{
                        "value":"'.$i_remark.'",
                        "color":"#000000"
                    }
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	/*
	拼团成功通知
	{{first.DATA}}
	订单编号：{{keyword1.DATA}}
	团购商品：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM407456411[标题：拼团成功通知]
	*/
	public static function dmessage($openid,$module,$orderid,$groupid,$goodtitle = '') {
		$url2 = Util::createModuleUrl('group',array('op'=>'detail','groupid'=>$groupid));
		$i_item = '恭喜!组团成功啦，我们会尽快安排发货，点击此处可查看订单详情';
        $item=commonGetData::gettpl('OPENTM407456411');
        if(empty($item['tpl_id']))return;
		$i_id = $item['tpl_id'];
		$i_remark = '';
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$orderid.'",
               		"color":"#fb5100"
				},				
               	"keyword2":{
					"value":"'.$goodtitle.'",
					"value":"..",
               		"color":"#fb5100"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}		
	
	
	
	
	/*
	参团成功通知
{{first.DATA}}
拼团名：{{keyword1.DATA}}
拼团价：{{keyword2.DATA}}
有效期：{{keyword3.DATA}}
{{remark.DATA}}
	编号：OPENTM400048581[标题：参团成功通知]
	*/
	public static function cmessage($openid,$module,$title,$overtime,$price,$groupid,$number) {
		$time = Util::lastTime($overtime,false);		
		$url2 = Util::createModuleUrl('group',array('op'=>'detail','groupid'=>$groupid));
		$i_item = '您已参团成功，再邀请'.$number.'位朋友参团就可团购成功了，点击此处可查看团详情';
        $item=commonGetData::gettpl('OPENTM400048581');
        if(empty($item['tpl_id']))return;
        $i_id = $item['tpl_id'];
		$i_remark = '';
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},							
               	"keyword1":{
					"value":"' . $title .'",
               		"color":"#fb5100"
				},	
               	"keyword2":{
					"value":"' . $price .' 元",
               		"color":"#fb5100"
				},				
               	"keyword3":{
					"value":"' . $time .'",
               		"color":"#fb5100"
				},							
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	
	/*
	开团成功提醒
	{{first.DATA}}
	商品名称：{{keyword1.DATA}}
	商品价格：{{keyword2.DATA}}
	组团人数：{{keyword3.DATA}}
	拼团类型：{{keyword4.DATA}}
	组团时间：{{keyword5.DATA}}
	{{remark.DATA}}
	编号：OPENTM407307456[标题：开团成功提醒]
	*/
	public static function bmessage($openid,$module,$title,$price,$number,$groupid) {
		$url2 = Util::createModuleUrl('group',array('op'=>'detail','groupid'=>$groupid));
		$lastnumber = $number - 1;
		$title = self::shortTitle($title);
		$i_item = '您已开团成功，再邀请'.$lastnumber.'位朋友参团就可团购成功了，点击此处可查看团详情';
        $item=commonGetData::gettpl('OPENTM407307456');
        if(empty($item['tpl_id']))return;
        $i_id = $item['tpl_id'];
		$i_remark = $module -> module['config']['b_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},							
               	"keyword1":{
					"value":"' . $title .'",
               		"color":"#fb5100"
				},	
               	"keyword2":{
					"value":"' . $price .' 元",
               		"color":"#fb5100"
				},				
               	"keyword3":{
					"value":"' . $number .'人",
               		"color":"#fb5100"
				},
               	"keyword4":{
					"value":"多人拼团",
               		"color":"#fb5100"
				},				
               	"keyword5":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#fb5100"
				},							
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}	
	
	
	/*
	商品支付成功通知
	{{first.DATA}}
	付款金额：{{keyword1.DATA}}
	商品详情：{{keyword2.DATA}}
	支付方式：{{keyword3.DATA}}
	交易单号：{{keyword4.DATA}}
	交易时间：{{keyword5.DATA}}
	{{remark.DATA}}
	编号：OPENTM206425979[标题：商品支付成功通知]
	*/
	public static function amessage($openid,$module,$fee,$title,$paytype,$orderid,$idoforder) {
		$url2 = Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$idoforder));
		if( $paytype == 'wechat')  $paytype = '微信支付';
		if( $paytype == 'credit')  $paytype = '余额支付';
		$title = self::shortTitle($title);
		$i_item = '您已支付成功，我们会在最快的时间内为您发货，点击此处可查看订单详情';
		$i_id = $module -> module['config']['a_id'];
		$i_remark = $module -> module['config']['a_remark'];
		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $i_item .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"' . $fee .' 元",
               		"color":"#44b549"
				},							
               	"keyword2":{
					"value":"' . $title .'",
               		"color":"#fb5100"
				},
               	"keyword3":{
					"value":"' . $paytype .'",
               		"color":"#fb5100"
				},	
               	"keyword4":{
					"value":"' . $orderid .'",
               		"color":"#fb5100"
				},					
               	"keyword5":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#777777"
				},				
               	"remark":{
                   "value":"' . $i_remark . '",
                   "color":"#777777"
               	}
           	}
        }';
		return self::commonPostMessage($msg_json);
	}

	//客服提醒
    //OPENTM207327169
    public static function kfmsg( $i_id,$data){
        $title='您有一条未读消息';
        if($data['flag']==1){
            $data['content']='[图片]';
        }
        $url= Util::createModuleUrl('chat', array('op' => 'savechat','toopenid' => $data['openid']));
        $remark= '消息内容：' . $data['content'];
        $msg_json = '{
           	"touser":"' . $data['toopenid'] . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $title .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"' . date('Y-m-d H:i:s', TIMESTAMP) .'",
               		"color":"#777777"
				},				
              	"keyword2":{
					"value":"' . 1 .'人",
               		"color":"#777777"
				},
               	"remark":{
                   "value":"' . $remark. '",
                   "color":"#fb5100"
               	}
           	}
        }';
        return self::commonPostMessage($msg_json);
    }

//{{first.DATA}}
//
//退款金额：{{orderProductPrice.DATA}}
//商品详情：{{orderProductName.DATA}}
//订单编号：{{orderName.DATA}}
//{{remark.DATA}}
	//退款申请通知
    public static function applyrefund($openid,$msg_id,$title,$orderid,$fee,$productname,$ogid,$i_item) {
        $url2 = Util::createModuleUrl('refund',array('ogid'=>$ogid));
        $i_id = $msg_id;
        $msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $title .'",
                   "color":"#777777"
               	},
               	"orderProductPrice":{
					"value":"'.$fee.'元'.'",
               		"color":"#fb5100"
				},				
               	"orderProductName":{
					"value":"'.$productname.'",
               		"color":"#fb5100"
				},					
				"orderName":{
					"value":"'.$orderid.'",
               		"color":"#fb5100"
				},
               	"remark":{
                   "value":"' . $i_item. '",
                   "color":"#000000"
               	}
           	}
        }';
        return self::commonPostMessage($msg_json);
    }
//退款申请结果通知
    public static function refundresult($openid,$msg_id,$title,$orderid,$fee,$ogid,$i_item) {
        $url2 = Util::createModuleUrl('refund',array('ogid'=>$ogid));
        $i_id = $msg_id;
        $msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url2 . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $title .'",
                   "color":"#777777"
               	},
               	"keyword1":{
               	    "value":"'.$orderid.'",					
               		"color":"#fb5100"
				},				
				"keyword2":{
					"value":"'.$fee.'元'.'",
               		"color":"#fb5100"
				},
               	"remark":{
                   "value":"' . $i_item . '",
                   "color":"#000000"
               	}
           	}
        }';
        return self::commonPostMessage($msg_json);
    }

    public static function admin_acount($title,$money,$admin_user,$addtime,$id,$paytype) {
        $where['msg_flag'] ='0';
        $shop = util::getAllDataBySingleTable(ADMIN, $where,'admin_id','openid,nickname');
        if(empty($shop))return;
        $i_item='请您及时处理';
        foreach ($shop as $s){
           if($s['openid']){//提现申请
                self::amount($s['openid'],$title,$money,$admin_user,$addtime,$id,$paytype,$i_item);
            }

        }
    }
    //提现申请
//{{first.DATA}}
//昵称：{{keyword1.DATA}}
//时间：{{keyword2.DATA}}
//金额：{{keyword3.DATA}}
//方式：{{keyword4.DATA}}
//{{remark.DATA}}
//OPENTM405485000
    public static function amount($openid,$title,$money,$admin_user,$addtime,$id,$paytype,$i_item) {
        $item=commonGetData::gettpl('OPENTM405485000');
        if(empty($item['tpl_id']))return;
        $url = Util::createModuleUrl('admin',array('op'=>'account','id'=>$id));
        if($paytype==1)$paytype='微信';
        elseif($paytype==2)$paytype='支付宝';
        elseif($paytype==3)$paytype='银行卡';
        elseif($paytype==4)$paytype='余额';
        $addtime= date('Y-m-d H:i', $addtime);
        $i_id = $item['tpl_id'];
        $msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $i_id . '",
           	"url":"' . $url. '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $title .'",
                   "color":"#777777"
               	},
               	"keyword1":{
               	    "value":"'.$admin_user.'",					
               		"color":"#fb5100"
				},				
				"keyword2":{
					"value":"'.$addtime.'",
               		"color":"#fb5100"
				},
				"keyword3":{
					"value":"'.$money.'",
               		"color":"#fb5100"
				},
				"keyword4":{
					"value":"'.$paytype.'",
               		"color":"#fb5100"
				},
               	"remark":{
                   "value":"' . $i_item . '",
                   "color":"#000000"
               	}
           	}
        }';
        return self::commonPostMessage($msg_json);
    }



    public function sendshopmsg($id){
        load()->model('mc');
        $order = pdo_fetch("SELECT * FROM " . tablename(ORDER) . " WHERE id ={$id}");
        if($order){
            $uid=mc_openid2uid($order['from_user']);
            $realname=pdo_fetchcolumn("select nickname from ".tablename('mc_members')." where uid ={$uid}");
            $from_user = $order['from_user'];
            $profile   = $this->getProfile($from_user);
            if (empty($profile)) {
            } else {
                if($order['shareid']){
                    $openid=pdo_fetchcolumn("select from_user from ".tablename(MEMBER)." where id={$order['shareid']} ");

                    if($openid!=$order['from_user']){
                        $this->sendgmsptz($order['ordersn'], $order['price'], $realname, $openid);
                    }
                }
                if($order['shareid2']){
                    $openid=pdo_fetchcolumn("select from_user from ".tablename(MEMBER)." where id={$order['shareid2']} ");
                    $this->sendgmsptz($order['ordersn'], $order['price'], $realname, $openid);
                }
                if($order['shareid3']){
                    $openid=pdo_fetchcolumn("select from_user from ".tablename(MEMBER)." where id={$order['shareid3']} ");
                    $this->sendgmsptz($order['ordersn'], $order['price'], $realname, $openid);
                }
                $user_data = pdo_fetch("SELECT * FROM " . tablename(MEMBER) . '   WHERE from_user=:from_user', array(':from_user' => $order['from_user']));
                if ($user_data['flag'] != 1) {
                    pdo_update(MEMBER, array('flag' => 1,'uid'=>$uid,'flagtime'=>TIMESTAMP), array('from_user' => $order['from_user']));

                }
            }
        }
    }

    public function sendgmsptz($ordersn, $orderprice, $agentname, $to_from_user) {
        global $_W;
        $time         = date('Y-m-d H:i:s');
        $tmsgtemplate = pdo_fetch('SELECT * FROM ' . tablename(MSG_TEMPLATE) . " WHERE  uniacid = :uniacid and tkey = :key", array(':uniacid' => $_W['uniacid'], ':key' => 'gmsptz'));
        if (!empty($tmsgtemplate['id']) && !empty($tmsgtemplate['template']) && $tmsgtemplate['tenable'] == 1) {
            $message1 = str_replace("{order_price}", $orderprice, $tmsgtemplate['template']);
            $message2 = str_replace("{order_sn}", $ordersn, $message1);
            $message3 = str_replace("{agent_name}", $agentname, $message2);
            //$message4 = str_replace("{agent_level}", $agent_level, $message3);
            $message  = str_replace("{time}", $time, $message3);
            $this->sendcustomMsg($to_from_user, $message);
        }
    }
    
    static function shortTitle($title){
		return mb_substr($title,0,40,"utf-8") . '...';
	}
	
	//模板消息url
	static function getUrl1(){
		load() -> model('account');
		$access_token = WeAccount::token();
		$url1 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token . "";		
		return $url1;
	}
	
	static function commonPostMessage($msg_json){
		$url1 = self::getUrl1();
		$res = Util::httpPost($url1, $msg_json,1);
		$res = json_decode((string)$res,true);
		if($res['errmsg'] == 'ok') return true;return false;
	}


	
	
}
?>