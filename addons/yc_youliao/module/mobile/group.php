<?php
	global $_W,$_GPC;
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'group';
    $do=$_GPC['do'];
	$userinfo =  Member::initUserInfo(); //用户信息
	$title='我的拼团';
	$is_shop_admin=intval($_GPC['is_shop_admin']);
    $shop_id=getShop_id();
	//团购订单列表
	if($op == 'group'){
		$gstatus=$_GPC['gstatus'];
		if(empty($gstatus)){
            $all=1;
        }
        $keyword =$this->getKeyword();
        $starttime =$this->getStarttime();
        $endtime =$this->getEndtime();
        if($is_shop_admin==1){
		    $do='shop_admin';
            $banner_title='拼团管理';
            $input_detail='用户名';
            if( $shop_id>0){
                $wherea['shop_id'] = $shop_id;
            }
            if($keyword){
                $statusstr .= ' AND d.`titile` like %'. $keyword.'% ';
            }
            if($starttime){
                $wherea['createtime >'] = $starttime;
            }
            if($endtime){
                $whereb['createtime >'] = $endtime;
            }

        }else{
            $wherea['openid'] = $_W['openid'];
        }
		$wherea['groupid>'] = 1;
		if($gstatus == 1) { //组团中的
			$whereb['overtime>'] = time();
			$whereb['lastnumber>'] = 0.1;
			$whereb['status'] = 1;
		}
		if($gstatus == 2){ // 失败的
			//$whereb['overtime<'] = time(); 
			$statusstr .= ' AND b.`status` = 2 ';
		} 
		if($gstatus == 3){ // 成功的
			$whereb['lastnumber'] = 0; 
			$statusstr .= ' OR b.`status` = 3 ';
		}
		if($gstatus == 4){ // 待支付
			$wherea['status'] = 0; 
			$statusstr .= ' and a.ordeytype in(2,3)';
		}
		
		//之所以不用$whereb是因为防止出现2个uniacid ,这里不加其他的时间和剩余人数判断，交由计划任务改变状态后显示相应状态的团		
		$select = ' a.id AS idoforder,a.groupid,a.status AS astatus,b.*,b.id AS bid,b.status AS bstatus ';
		$data = Group::getAllGroupOrder($wherea,$whereb,$selectstr,$select,intval($_GPC['page']),10,' a.`id` DESC ',false);		
		//print_r($data[0]);
		$list=$data[0];
		foreach((array)$data[0] as $k=>$v){
			$v['gstatus'] = Group::decodeGroupStatus($v['bstatus'],$v['overtime'],$v['isrefund'],$v['lastnumber']);
			if($v['gstatus'] == 1){
				$statusstr = '组团中';
			}elseif($v['gstatus'] == 2){
				if($v['astatus'] == 7){
					$statusstr = '团购失败,已退款';
				}else{
					$statusstr = '团购失败,待退款';
				}
			}elseif($v['gstatus'] == 3){
				$statusstr = '团购成功';
			}elseif($v['gstatus'] == 4){
				$statusstr = '退款中';
			}
			$groupurl = $this->createMobileUrl('group',array('op'=>'detail','groupid'=>$v['bid']));
			$orderurl = $this->createMobileUrl('order',array('op'=>'detail','id'=>$v['idoforder']));
			$goodurl = $this->createMobileUrl('good',array('id'=>$v['gid'],'shop_id'=>$v['shop_id']));
			$img = tomedia($v['thumb']);
			$str .= <<<div
			<div class="order_good_item group_list_item margin_top_5px router">
				<div class="order_item_top order_item_in">
					<span> </span><span class="fr font_ff5f27">{$statusstr}</span>
				</div>
				<div class="order_item_body item_cell_box order_item_in" style="border:0">
					<div class="order_good_left">
						<img src="{$img}">
					</div>
					<div class="order_good_right item_cell_flex">
						<a href="{$goodurl}">
							<div class="order_good_title good_title">{$v['title']}</div>
						</a>
					</div>			
				</div>
				<div class="order_item_price order_item_in">					
					<span class="font_13px_999">实付: <span class="font_ff5f27">{$v['price']}</span>元</span>
				</div>
				<div class="order_item_bot order_item_in" style="border:0">
					<a href="{$groupurl}"><span class="fr look_detail">团购详情</span></a>					
					<a href="{$orderurl}"><span class="fr look_detail">订单详情</span></a>
				</div>		
			</div>
div;
		}
    if($_GPC['isajax']==1) {
        echo json_encode(array('result' => '1', 'length'=>count($list),'str' => $str,));
        exit;
    }
	include $this->template('group');
	exit;
	
	}elseif($op=="detail"){
	$id = intval($_GPC['groupid']);
    $groupinfo = Group::getSingleGroup($id,$shop_id);
    $groupprice=util::getSingelDataInSingleTable(ORDER,array('groupid'=>$id,'openid'=>$_W['openid']),'price');
    $groupprice=$groupprice['price'];
	if(empty($groupinfo)) message('当前团购不存在');
	$groupinfo['gstatus'] = Group::decodeGroupStatus($groupinfo['status'],$groupinfo['overtime'],$groupinfo['isrefund'],$groupinfo['lastnumber']);

	
	//是否在团内
	$isingroup = Order::getSingleOrderByStatus(array('groupid'=>$id,'openid'=>$_W['openid']),' NOT IN (1,2) ');
	
	//人员列表
    $member_list = Group::getGroupMemberWithCache($id);
	$isgroup     = pdo_fetchall("SELECT goods_id as id,title,groupprice,sales,thumb FROM " . tablename(GOODS) . " WHERE  
		 uniacid = '{$_W['uniacid']}' AND status = '1'  and is_group=1 and  total>0 ORDER BY orderby DESC, sales DESC ");
    $share_title = '我正在团购一款宝贝，您也来参团吧';
    $share_info=   $groupinfo['title'];
    $share_link=   $_W['siteroot']."app/". $this->createMobileUrl('good').'&shop_id='.$groupinfo['shop_id'].'&id='.$groupinfo['gid'].'&groupid='.$groupinfo['id'];
    $share_img= $groupinfo['thumb'];

	include $this->template('group');
	exit;




	}

?>