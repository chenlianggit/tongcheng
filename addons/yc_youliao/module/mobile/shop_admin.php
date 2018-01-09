<?php
global $_GPC,$_W;
$title = '店铺管理中心';
$userinfo = Member::initUserInfo(); //用户信息
$openid=$this->getOpenid();
$where['openid']=$openid;
$where['status']=0;
$a_data=$this->checkAdmin();
$s_data=$this->isshop_admin();
if(empty($a_data) && empty($s_data)  ){
    message('您不是店铺管理员或管理员身份已失效', '',  '','1');
}
$cfg=$this->module['config'];
$shopLogo=tomedia($cfg['shop_logo']);
$shopBgpic=tomedia($cfg['shop_bgpic']);
$transfer=$cfg['transfer'];
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$pageStart =  $this->pageIndex();
$keyword =$this->getKeyword();
$starttime =$this->getStarttime();
$endtime =$this->getEndtime();
$shop_id=intval($_GPC['shop_id']);
if($shop_id==0){
    $shop_id=getShop_id();
}else{
    setShop_id($shop_id);
}
if(empty($shop_id) || $shop_id==0){
    message('暂时无法获取商铺信息，请稍候再试');
}
$type=intval($_GPC['type']);
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$do=$_GPC['do'];
//店铺信息
$shop_where['shop_id']=$shop_id;
$item=util::getSingelDataInSingleTable(SHOP,$shop_where);
if($op=='display'){
    $msg=Member::member_msg(2);
    $msg=$msg[0];
    $account=util::getAllDataNumInSingleTable(ACCOUNT,$shop_where);
    //会员总数（扫商家二维码）
    $memberNum=util::getAllDataNumInSingleTable(SHOP_USER,$shop_where);
    include $this->template('../mobile/shop_admin/shop_admin');
    exit;
}elseif($op=='info'){
    $banner_title='编辑资料';
    $search=1;
    $check=intval($_GPC['check']);
    if($s_data['admin_type']>1 && empty($a_data)){
        message('很抱歉，您没有权限');
    }
    $cate = Shop::getCate();
    $ccate = Shop::getCcate();
    $city =Shop::getCity();
    $area = Shop::getArea();
    $business =Shop::getBusiness();
    if ($_GPC['po']=='1') {
        $res=Shop::editShopInfo($userinfo['id'],$item['shop_id'],1);
        $res1=intval($res);
        if($res1>0){//成功
            message('修改成功');
        }else{
            message($res);
        }

    }
    include $this->template('../mobile/shop_in');
    exit;

}elseif($op=='order'){
$banner_title='订单列表';
$input_detail='用户名';
$status=$_GPC['status'];
$sqlweher.=' and o.shop_id ='.$shop_id;//根据店铺获取数据
if( $status=="all")$sqlweher.=' and o.status >=0';
elseif(intval($status)<4)$sqlweher.=' and o.status ='.intval($status);
elseif(intval($status)>=4)$sqlweher.=' and o.status >='.intval($status);
if($starttime){
    $sqlweher.=' and o.createtime >='.$starttime;
}
if($endtime){
    $sqlweher.=' and o.createtime <='.$endtime;
}
if($keyword){
    $sqlweher.=" and m.nickname LIKE '%{$keyword}%'";
}
$leftjoin=  " left join ".tablename(MEMBER)."  m on m.openid=o.openid ";
$data=Order::getorderlist($sqlweher,$page,$num,$leftjoin);
$list=$data[0];
$goods=$data[1];
if($_GPC['isajax']==1) {
    echo json_encode(array('result' => '1', 'list' => $list, 'length' => count($list)));
    exit;
}
include $this->template('../mobile/shop_admin/shop_admin_order');
exit;
}elseif($op=='discount'){
    $banner_title='订单列表';
    $input_detail='用户名';
    $sqlweher.=' and r.shop_id ='.$shop_id;//根据店铺获取数据
    if($starttime){
        $sqlweher.=' and r.createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and r.createtime <='.$endtime;
    }
    if($keyword){
        $sqlweher.=" and m.nickname LIKE '%{$keyword}%'";
    }
    $id=intval($_GPC['id']);
    if($id>0){
        $sqlweher.=' and r.id ='.$id;
    }
    $data=commonGetData::getDiscount($page,$num,'',$sqlweher);
    $list=$data[0];
    if($_GPC['isajax']==1) {
        $info=Array();
        foreach ($list as $k => $v) {
            $v['createtime']=date('Y-m-d H:i', $v['createtime']);
            $v['logo']=$_W['attachurl'].$v['logo'];
            $info[]=$v;
        }

        echo json_encode(array('result'=>'1','list'=>$info,'length'=>count($info)));
        exit;
    }
    include $this->template('../mobile/shop_admin/shop_admin_order');
    exit();
}elseif($op=='group'){
    $banner_title='团购列表';
    $input_detail='用户名';
    die("<script>window.location.href='" . $this->createMobileUrl("group",array('gstatus'=>$_GPC['gstatus'],'is_shop_admin'=>1,'shop_id'=>$shop_id,'keyword'=>$_GPC['keyword'],'starttime'=>$_GPC['starttime'],'endtime'=>$_GPC['endtime'])). "';</script>");
}elseif($op=='goods'){
    if (checksubmit('submit')) {
        $result=goods::postData($shop_id);
        if(intval($result)>0){
            message('提交成功！', '',  'success','1');
        }else{
            message($result, '',  '','1');
        }
    }
    $banner_title='商品列表';
    $input_detail='商品名称';
    if($type==0){
        $goods_where['uniacid'] = $_W['uniacid'];
        $goods_where['shop_id'] = $shop_id;
        if ($keyword) {
            $goods_where['title@'] = htmlspecialchars($keyword);
        }
        if ($starttime) {
            $goods_where['createtime>'] = $starttime;
        }
        $order=' `orderby` ';
        $by = ' DESC ';
        $info = Goods::getAllGood($goods_where, $page,$num,$order.$by);
        $list = $info[0];
    }elseif($type==1){//编辑、增加商品
    $id=intval($_GPC['id']);
    load()->app('tpl');
    $isapp=1;
    if($id>0 && $shop_id>0){
        $item =Goods::getSingleGood($id,$shop_id);
    }
    $category = Goods::getcate($shop_id);
    $timelist = webCommon::getTimelist();

    }elseif($type==2){//删除商品
        $res =webCommon::deleteGood($_GPC['id'],$shop_id);
        if($res) {
            echo json_encode(array('status' => '1'));
            exit;
        }
        die('status:2');
    }

    if($_GPC['isajax']=="1"){
        echo json_encode(array('status' => '1','length'=>count($list),'list' => $list));
        exit;
    }
    include $this->template('../mobile/shop_admin/shop_admin_goods');
    exit();

}elseif($op=='cate'){
    $banner_title='分类列表';
    $input_detail='分类名称';
    if (checksubmit('submit')) {
        $result=goods::postCate($shop_id);
        $res1=intval($result);
        if($res1>0){
            message('提交成功！', '',  'success','1');
        }else{
            message($result, '',  'error','1');
        }
    }

    if($type==0){
        if($keyword){
            $cate_where='and name like %'.$keyword.'% ';
        }
        $list = Goods::getcate($shop_id,$cate_where);
    }elseif($type==1 && !empty($id)){//展示数据
        $category =Util::getSingelDataInSingleTable(GOODS_CATE,array('id'=>$id,'shop_id'=>$shop_id));
    }elseif($type==2 && !empty($id)){//删除数据
        pdo_delete(GOODS_CATE, array('id' => $id,'shop_id'=>$shop_id));
        echo json_encode(array('status' => '1'));
        exit;
    }
    include $this->template('../mobile/shop_admin/shop_admin_cate');
    exit();
}elseif($op=='account'){
    $transfer_min=!empty($cfg['shop_transfer_min']) ? $cfg['shop_transfer_min'] :1;//最低提现金额
    $transfer_max=!empty($cfg['shop_transfer_max']) ? $cfg['shop_transfer_max'] :20000;//最高提现金额
    if($s_data['admin_type']>1 && empty($a_data)){
        message('很抱歉，您没有权限');
    }
    if ($s_data['admin_type']!=1) message('很抱歉，您没有超级管理员权限', '',  '','1');
    if ($_GPC['submit_post']=='1') {
        $admin_id=intval($s_data['admin_id']);
        if ($admin_id==0)
        {
            return '管理员不能为空';
        }
        $result=Shop::postAccountApplay($item,$transfer_min,$transfer_max ,$admin_id,$transfer);
        if(intval($result)>0){
            echo json_encode(array('status' => '1', 'str' => '提交成功'));
            exit;
        }else{
            echo json_encode(array('status' => '0', 'str' => $result));
            exit;
        }
    }
    $banner_title='账户管理';
    $search=2;
    $flag=intval($_GPC['flag']);
    //订单记录
    $id=intval($_GPC['id']);
    if($id>0){//详情页
        $search=1;
        $item=commonGetData::getAccountDetail($id);
    }elseif($type==0) {
        $sqlweher.=' and shop_id='.$shop_id;
        if($starttime){
            $sqlweher.=' and o.createtime >='.$starttime;
        }
        if($endtime){
            $sqlweher.=' and o.createtime <='.$endtime;
        }
        //商品订单，flag=0
        if( $flag==0) {
            $list = pdo_fetchall('SELECT * FROM ' . tablename(ORDER_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher} ORDER BY id DESC LIMIT  {$pageStart},{$num} ");
            if ($_GPC['isajax'] == "1") {
                echo json_encode(array('status' => '1', 'length' => count($list),'type' => $type, 'list' => $list, 'flag' => 0));
                exit;
            }
        }elseif( $flag==1) {
            //优惠买单，flag=1
            $sqlweher .= ' and status=1';
            $list= pdo_fetchall('SELECT ordersn,createtime,paymoney ,id FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher} ORDER BY id DESC LIMIT  {$pageStart},{$num} ");
            if ($_GPC['isajax'] == "1") {
                echo json_encode(array('status' => '1', 'length' => count($list), 'type' => $type,'list' => $list, 'flag' => 1));
                exit;
            }
        }
    }elseif($type==1) {
            if ($flag == 0) {
                $status = 0;//审核中
            } else {
                $status = 1;//已处理
            }
            $list = pdo_fetchall('SELECT amount,ordersn,addtime,cash_id FROM ' . tablename(ACCOUNT) . " WHERE uniacid = {$_W['uniacid']} and shop_id ={$shop_id}  and status ={$status} ORDER BY cash_id DESC LIMIT  {$pageStart},{$num} ");
            if ($_GPC['isajax'] == "1") {
                echo json_encode(array('status' => '1', 'length' => count($list), 'type' => $type,'list' => $list, 'flag' => 0));
                exit;
            }

    }elseif($type==2) {
        $id=intval($_GPC['id']);
        $payType=$cfg['shop_pay_type'];
        if($id>0){
            $item=util::getSingelDataInSingleTable(ACCOUNT,array('cash_id'=>$cash_id)) ;
        }
    }
    include $this->template('../mobile/shop_admin/shop_admin_account');
    exit();
}elseif($op=='admin'){//管理员
    $banner_title='管理员';
    $search=1;
    if($s_data['admin_type']>1 && empty($a_data)){
        message('很抱歉，您没有权限');
    }
    $Admin = new Admin();
    if($_GPC['post']=='add'){//增加、编辑管理员
        $admin_id = intval($_GPC['admin_id']);
        if(!empty($admin_id)){
            $item = $Admin->getShopAdminById($shop_id,$admin_id);
        }
        if ($_GPC['ispost'] == "1") {
            $res=$Admin::postAdmin($shop_id);
            $res1=intval($res);
            if($res1==0){
                message($res, referer(), 'error');
            }else{
                message('操作成功！', $this->createMobileUrl('shop_admin', array('op' => 'admin')), 'success');
            }

        }

    }elseif($_GPC['post']=='delete'){//增加、编辑管理员
        $id = intval($_GPC['admin_id']);
        pdo_delete(SHOP_ADMIN, array('admin_id' => $id,'uniacid'=>$_W['uniacid'],'shop_id'=>$shop_id));
        echo json_encode(array('status' => '1'));
        exit;
    }else{
        $list =$Admin->getShopAdminAll($shop_id);
        if ($_GPC['isajax'] == "1") {
            echo json_encode(array('status' => '1', 'length' => count($list),'list' => $list));
            exit;
        }
    }

    include $this->template('../mobile/shop_admin/shop_admin_manager');
    exit();
}elseif ($op == 'query') {
    $ds=Member::searchMember();
    include $this->template('../web/shop/shop_admin_query');
    exit;

}elseif($op=='fans'){//会员
    $banner_title='会员管理';
    $search=1;
    if($s_data['admin_type']>1 && empty($a_data)){
        message('很抱歉，您没有权限');
    }
    $shop_where['shop_id']=$shop_id;
    $list=util::getAllDataInSingleTable(MEMBER,$shop_where,$page,$num,'id desc','avatar,nickname,id');
    $list=$list[0];
    foreach ($list as $k => $v) {//查找每个会员消费了多少次，消费了多少元
        $res=pdo_fetch('SELECT sum(price) as amount ,count(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}  and status>1 and userid='{$v['id']}'  ");
        $res1=pdo_fetch('SELECT sum(paymoney) as amount ,count(*) as num FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']}   and mid='{$v['id']}'  ");
        $list[$k]['amount']=$res['amount']+$res1['amount'];
        $list[$k]['num']=$res['num']+$res1['num'];
    }

    if($_GPC['isajax']=="1"){
        echo json_encode(array('status' => '1','length'=>count($list),'list' => $list));
        exit;
    }
    include $this->template('../mobile/shop_admin/shop_fans');
    exit();
}elseif($op == 'verify') {
    $banner_title='核销管理';
    $type=intval($_GPC['type']);
    if($type==1){
        $list = pdo_fetchall("SELECT  o.price,o.status,o.ordersn,g.* ,g.price as price1 , g.orderid as  id  , g.id as  ogid  FROM " . tablename(ORDER) . " o left join " . tablename(ORDER_GOODS) . " g on g.orderid=o.id  WHERE g.verifyopenid = '{$openid}' AND g.uniacid = '{$_W['uniacid']}' AND g.order_status >=1 ORDER BY g.createtime DESC LIMIT " . $pageStart . ',' . $num);

        if (!empty($list)) {
            foreach ($list as &$row) {
                $goods = pdo_fetchall("SELECT g.goods_id, g.title, g.thumb,  g.marketprice as price,o.total,o.optionid FROM " . tablename(ORDER_GOODS) . " o left join " . tablename(GOODS) . " g on o.goodsid=g.goods_id " . " WHERE o.id='{$row['ogid']}'");
                $row['createtime']=date('Y-m-d H:i', $row['createtime']);
                foreach ($goods as &$item) {
                    $option = pdo_fetch("select title,marketprice ,weight,groupprice,stock from " . tablename(OPTION) . " where id=:id limit 1", array(":id" => $item['optionid']));
                    if ($option) {
                        $item['title'] = "[" . $option['title'] . "]" . $item['title'];
                        $item['price'] = $option['marketprice'];
                        $item['groupprice'] = $option['groupprice'];
                    }
                }
                unset($item);
                $row['goods'] = $goods;
                $row['total'] = $goodsid;

            }
        }

        if($_GPC['isajax']=="1"){
            echo json_encode(array('status' => '1','length'=>count($list),'list' => $list));
            exit;
        }

    }
    include $this->template('../mobile/shop_admin/shop_verify');
    exit;
}elseif ($op == 'renew') {
    $type=intval($_GPC['type']);
    if($type==1){//'1续1年，2续2年，3续3年'
        $price=$cfg['one_renew'];
    }elseif($type==2){
        $price=$cfg['two_renew'];
    }elseif($type==3){
        $price=$cfg['three_renew'];
    }
    if(is_numeric($price) === false){
        message('未设置有效的续费套餐');
    }
    if($price==0){
        $status=1;
    }else{
        $status=0;
    }
    $ordersn=Shop:: insertRenew($type,$status, $price,$cfg,1,$shop_id,$userinfo['id']);
   if($price==0){//0元续费无须支付，直接续期
       $renew=util::getYearStamp();
       $renew= $renew* $type;
       $endtime=$item['endtime']+$renew;
       pdo_update(SHOP,array('endtime'=>$endtime),array('shop_id'=>$shop_id,'uniacid'=>$_W['uniacid']));
       message('已成功续期至：'.date('Y-m-d', $endtime),referer(),  'success');
       exit;
    }else {
       $params = array(
           'tid' => 'renew' . $ordersn,      //此号码用于业务模块中区分订单，交易的识别码
           'ordersn' => $ordersn,  //收银台中显示的订单号
           'title' => $item['shop_name'] . '--商户续费',          //收银台中显示的标题
           'fee' => $price,      //收银台中显示需要支付的金额,只能大于 0
           'user' => $openid,     //付款用户, 付款的用户名(选填项)
       );
       $result = commonGetData::insertlog($params);
       if ($result == 1) {
           $this->pay($params);
           exit();
       }
   }
}elseif($op=='renew_re'){//缴费记录
    $banner_title='商户缴费列表';
    $id=intval($_GPC['id']);
    $list=Shop::getShopRenew($shop_id,'');
    if($_GPC['isajax']==1) {
        $info=Array();
        foreach ($list as $k => $v) {
            $v['createtime']=date('Y-m-d H:i', $v['createtime']);
            $v['starttime']=date('Y-m-d H:i', $v['starttime']);
            $v['endtime']=date('Y-m-d H:i', $v['endtime']);
            $v['logo']=tomedia($v['logo']);
            $info[]=$v;
        }

        echo json_encode(array('result'=>'1','list'=>$info,'length'=>count($info)));
        exit;
    }elseif($id>0){
        $search=1;
        $item=Shop::getShopRenew($shop_id,'',$id);
        $item=  $item[0];
        include $this->template('../mobile/renew_detail');
        exit();
    }

    include $this->template('../mobile/shop_admin/shop_admin_order');
    exit();
}

