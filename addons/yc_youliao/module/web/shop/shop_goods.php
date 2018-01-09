<?php
//根据不同的业务类型（ 商铺消费 酒店预订 影院订座 外卖点餐 微商城 ）引入不同的模型
//查询当前店铺的业务类型：根据子类型查询，如果子类弄为空则根据父类查询
$title='商品管理';
$shop_id=getShop_id();
$shop =Shop::getShopInfo($shop_id);
if($shop['ccate_id']==0 || empty($shop['ccate_id'])){
    $shop_type =Shop::getShopType($shop['pcate_id']);
}else{
    $shop_type =Shop::getShopType($shop['ccate_id']);
}
//'0商铺消费类,1酒店预订,2影院订座,3外卖点餐,4微商城'
if($shop_type==0){//引入业务类型模板
    require(SQ.'module/web/shop/shop_goods_comm.php');//基础模型
    include $this->template('web/shop/goods');
    exit();
}