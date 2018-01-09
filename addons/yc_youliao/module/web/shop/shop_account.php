<?php
global $_GPC,$_W;
$title='资金管理';
$shop_id=getShop_id();
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex    = $this->getWebPage();
$psize     = $this->getWebNum();
$g=getAdmin_type();
if ($g!= 1 &&  $g!="Y"){$this->message('您没有访问权限', referer(), 'error');}
$shop_where['shop_id']=$shop_id;
if($op=='display'){
    $starttime = strtotime($_GPC['time']['start']);
    $endtime   = strtotime($_GPC['time']['end']);
    if($starttime){
        $sqlweher.=' and createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and createtime <='.$endtime;
    }
    if($_GPC['ordersn']){
        $sqlweher.=" and ordersn LIKE '%{$_GPC['ordersn']}%'";
    }
    $sqlweher.=' and shop_id='.$shop_id;
    //订单记录
    $list = pdo_fetchall('SELECT * FROM ' . tablename(ORDER_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher} ORDER BY id DESC LIMIT  {$pindex},{$psize} ");
    $total= pdo_fetchcolumn('SELECT count(*) FROM ' . tablename(ORDER_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher}  ");
    $pager=pagination($total, $pindex, $psize);


     //买单记录
    $sqlweher.=' and status=1';
    $list2 = pdo_fetchall('SELECT * FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher} ORDER BY id DESC LIMIT  {$pindex},{$psize} ");
    $total2= pdo_fetchcolumn('SELECT count(*) FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher}  ");
    $pager2=pagination($total2, $pindex, $psize);


}elseif($op=='record'){
    $list =Shop::getSingleAccount($shop_id,0);

}elseif($op=='post'){
    $shop=Util::getSingelDataInSingleTable(SHOP,$shop_where);
    if( $shop['balance']<=0){
        $this->message('暂无可提现金额');
    }
    $item =Util::getSingelDataInSingleTable(ACCOUNT,$shop_where,'*','1','order by cash_id desc');
    if (checksubmit('submit')) {
        $money = (int) ($_GPC['money'] * 100);
        if ($money <= 0)
        {
            $this->message('提现金额不合法');
        }
        if ($money > $this->member['money'] || $this->member['money'] == 0)
        {
            $this->message('余额不足，无法提现');
        }
        if(!$data['bank_name'] = htmlspecialchars($_GPC['bank_name'])){
            $this->message('开户行不能为空');
        }
        if(!$data['bank_num'] = htmlspecialchars($_GPC['bank_num'])){
            $this->message('银行账号不能为空');
        }

        if(!$data['bank_realname'] = htmlspecialchars($_GPC['bank_realname'])){
            $this->message('开户姓名不能为空');
        }
        $data['bank_branch'] = htmlspecialchars($_GPC['bank_branch']);
        $data['user_id'] = $this->uid;

        $arr = array();
        $arr['shop_id'] = $shop_id;
        $arr['usernme'] = $_SESSION['admin_name'];
        $arr['money'] = $money;
        $arr['addtime'] = NOW_TIME;
        $arr['account'] = $this->member['account'];
        $arr['bank_name'] = $data['bank_name'];
        $arr['bank_num'] = $data['bank_num'];
        $arr['bank_realname'] = $data['bank_realname'];
        $arr['bank_branch'] = $data['bank_branch'];
        //提现记录表插入提现记录
        pdo_insert(ACCOUNT, $arr);
        $this->message('恭喜，申请提交成功，请您耐心等待！',referer(), 'success');
    }
}
include $this->template('web/shop/shop_account');
exit();