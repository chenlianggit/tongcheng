<?php
global $_W,$_GPC;
$op = isset($_GPC['op'])?$_GPC['op']:'list';
$shop_id=getShop_id();
$pindex    = $this->getWebPage();
$page =$this->getPage();
$psize     = $this->getWebNum();
$search_type=2;
//添加，编辑
if(checksubmit('addcard')){
    //$_GPC = Util::trimWithArray($_GPC);
    $data['shop_id'] = intval($shop_id);
    $data['cardtype'] = intval($_GPC['cardtype']);
    $data['cardname'] = htmlspecialchars($_GPC['cardname']);
    $data['needcredit'] = intval($_GPC['needcredit']);
    $data['cardvalue'] = sprintf('%.2f',$_GPC['cardvalue']);
    $data['fullmoney'] = $_GPC['fullmoney'];
    $data['starttime'] = strtotime($_GPC['datelimit']['start']);
    $data['endtime'] = strtotime($_GPC['datelimit']['end']);
    $data['status'] =  intval($_GPC['status']);
    $data['time'] = time();
    $data['lastnum'] =  intval($_GPC['lastnum']);
    $data['randomnum']=$_GPC['randomnum'];


    //验证
    if(empty($data['cardtype']) ){
        $this->message('请选择类型');
    }
    if( empty($data['cardname']) ){
        $this->message('请输入名称');
    }
    if( $data['cardtype'] != 3){
        if( $data['cardvalue'] <= 0 || $data['fullmoney'] <=0  ){
            $this->message('面值或使用条件必须大于0');
        }
        if($data['cardtype'] == 1  && $data['cardvalue'] >= $data['fullmoney']){
            $this->message('面值不能大于等于设定的订单金额');
        }
        if($data['cardtype'] == 2  && $data['cardvalue'] >= 1){
            $this->message('折扣值应在0-1之间，有效小数是2位');
        }
    }else{
        if($data['randomnum']<=0 ){
            $this->message('随机减金额不能小于0');
        }
    }

    if( $data['starttime'] == $data['endtime']){
        $this->message('请选择使用期限');
    }


    if(!empty($_GPC['id'])){
        $res = pdo_update(DISCOUNT,$data,array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id'],'shop_id'=>$shop_id));
        Util::deleteCache('card',$_GPC['id']);
    }else{
        $res = Util::inserData(DISCOUNT,$data);
    }
    if($res) $this->message('操作成功',$this->createWebUrl('shop_discount', array('op' => 'list')), 'success');
}




//批量上下架
if(checksubmit('upstatus')) changeStatus($_GPC['checkid'],'up');
if(checksubmit('downstatus')) changeStatus($_GPC['checkid'],'down');

function changeStatus($idarray,$type){
    global $_W;
    $shop_id=getShop_id();
    if($type == 'up') $status = 0;
    if($type == 'down') $status = 1;

    if(empty($idarray)) $this->message('没有选择优惠券');
    foreach($idarray as $k=>$v){
        $id = intval($v);
        pdo_update(DISCOUNT,array('status'=>$status),array('uniacid'=>$_W['uniacid'],'shop_id'=>$shop_id,'id'=>$id));
        Util::deleteCache('card',$id);
    }
    message('操作完成',referer(),'success');
}


if($op == 'list'){
    $where['uniacid'] = $_W['uniacid'];
    $where['shop_id'] = $shop_id;
    if(!empty($_GPC['type'])) $where['cardtype'] = intval($_GPC['type']);
    if($_GPC['status'] == '1') $where['status'] = 1;
    if($_GPC['status'] == '2') $where['starttime>'] = time();
    if($_GPC['status'] == '3') $where['endtime<'] = time();

    $order = '`id` ';
    if($_GPC['order'] == 'value') $order = '`cardvalue` ';
    if($_GPC['order'] == 'total') $order = '`totalnum` ';
    if($_GPC['order'] == 'taked') $order = '`takednum` ';
    if($_GPC['order'] == 'used') $order = '`usednum` ';

    $by = ' DESC ';
    if($_GPC['by'] == '1') $by = ' ASC ';

    $info = Util::getAllDataInSingleTable(DISCOUNT,$where,$_GPC['page'],8,$order.$by);
    $list = $info[0];
    $pager = $info[1];
}elseif($op == 'edit'){
    $id = intval($_GPC['id']);
    $info = Discount::getSingleCard($id,$shop_id);
    $limittime['start'] = date('Y-m-d H:i:s',$info['starttime']);
    $limittime['end'] = date('Y-m-d H:i:s',$info['endtime']);

}elseif($op == 'delete'){
    $res = Discount::deleteCard($_GPC['id'],$shop_id);
    if($res) $this->message('删除成功',referer(),'success');
}elseif($op == 'takelog'){
    $where['uniacid'] = $_W['uniacid'];
    $where['shop_id'] = $shop_id;
    if(!empty($_GPC['type'])) $where['cardtype'] = intval($_GPC['type']);
    if(!empty($_GPC['status'])) $where['status'] = intval($_GPC['status']);

    if($_GPC['status'] == 1) $where['status'] = 0;
    if($_GPC['status'] == 2) $where['status'] = 1;
    if($_GPC['status'] == 3){
        $where['status'] = 0;
        $where['overtime<'] = time();
    }


    $order = ' b.`id` ';
    $by = ' DESC ';
    if(!empty($_GPC['order'])) $order = ' b.'.$_GPC['order'];

    if($_GPC['by'] == 1) $by = ' ASC ';



    $info = Discount::getTakedCard($where,8,intval($_GPC['page']),$order.$by,'web',true);
    $list = $info[0];
    $pager = $info[1];

}elseif($op == 'order'){
    $starttime = strtotime($_GPC['time']['start']);
    $endtime   = strtotime($_GPC['time']['end']);
    if($starttime){
        $sqlweher.=' and r.createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and r.createtime <='.$endtime;
    }
    if($_GPC['ordersn']){
        $sqlweher.=" and r.ordersn LIKE '%{$_GPC['ordersn']}%'";
    }
    if($_GPC['realname']){
        $sqlweher.=" and m.nicknameLIKE '%{$_GPC['realname']}%'";
    }
    if($_GPC['mobile']){
        $sqlweher.=" and m.mobile LIKE '%{$_GPC['mobile']}%'";
    }
    $sqlweher.=' and r.shop_id='.$shop_id;
    $data=commonGetData::getDiscount($page,$psize,'',$sqlweher,'0');
    $list=$data[0];
    $pager = pagination($data[1], $pindex, $psize);
}elseif($op == 'delete_re'){
    $id=intval($_GPC['id']);
    pdo_delete(DISCOUNT_RE, array('shop_id' => $shop_id,'shop_id' => $shop_id,'status' => 0,'uniacid' =>$_W['uniacid'],'id' => $id));
    message('操作完成',referer(),'success');
}elseif($op == 'detail'){
    $id=intval($_GPC['id']);
    if($id>0){
        $sqlweher.=' and r.id ='.$id;
        $data=commonGetData::getDiscount(0,1,'',$sqlweher,1);
        $item=$data[0][0];
    }


}



include $this->template('web/shop/discount');
exit;