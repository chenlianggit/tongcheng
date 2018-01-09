<?php
global $_W,$_GPC;
$op = $_GPC['op'];
$cfg=$this->module['config'];
$refundDetail = $cfg['refundDetail'];
$noticeid=1;//因与手机共用一套模板，手机需要$noticeid区分是否管理员还是普通用户
$m=1;
if($op){//ajax请求处理退货退款操作
    return  Order::ajaxrefund($op,$noticeid,$cfg);
    exit;
}

//退款数据展示
$ogid = intval($_GPC['ogid']);
$where['id'] = $ogid;
if ($ogid < 0) {
    message('订单不存在', referer(), error);
}
$url=$this->createWeb('refund');
$data = util::getSingelDataInSingleTable(ORDER_GOODS, $where, '*');
$orwhere['id'] = $data['orderid'];
$order = util::getSingelDataInSingleTable(ORDER, $orwhere, 'ordertype,status,refundmoney,refundtime,ordersn,shop_id');
$shop_id=$order['shop_id'];
$refund_id = $data['refund_id'];
$order_status = $data['order_status'];
if (empty($data)) message('退款已申请或订单不存',  referer(), error);
$codition['id'] = $data['refund_id'];
$where1['goods_id'] = $data['goodsid'];
$item = util::getSingelDataInSingleTable(REFUND, $codition, '*');
if($item['from_user']!=$_W['openid'] && $noticeid<0 )die;
$goods = util::getSingelDataInSingleTable(GOODS, $where1, 'thumb,title');
$shop_cfg=commonGetData::getShopCfg($shop_id);
$address= $shop_cfg['address'];
$mobile= $shop_cfg['mobile'];
$man= $shop_cfg['man'];
include $this->template('web/shop/shop_refund');
exit;
