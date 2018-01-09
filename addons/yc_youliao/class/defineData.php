<?php
defined('IN_IA') or exit('Access Denied');
define('yc_youliao',IA_ROOT.'/addons/yc_youliao/');
define('MIHUA_SQ','//' . $_SERVER['HTTP_HOST'] .'/addons/yc_youliao/');
define('MIHUA_STYLE','//' . $_SERVER['HTTP_HOST'] .'/addons/yc_youliao/public/');//$_W['siteroot']
define('SQ', '../addons/yc_youliao/');
define('STYLE', '../addons/yc_youliao/public/');
define('MODULE', 'yc_youliao');//待发信息队列

//数据表
define('ADV', 'mihua_sq_adv');
define('CHANNEL', 'mihua_sq_channel');//MODULECENTER
define('FIELDS', 'mihua_sq_fields');
define('INFO', 'mihua_sq_info');//MESSAGE
define('MEMBER', 'mihua_sq_member');
define('CITY', 'mihua_sq_city');
define('AREA', 'mihua_sq_area');
define('CATE', 'mihua_sq_shop_cate');
define('SHOP', 'mihua_sq_shop');
define('GOODS', 'mihua_sq_goods');
define('GOODS_CATE', 'mihua_sq_goods_cate');//商品分类
define('ORDER', 'mihua_sq_order');
define('ORDER_GOODS', 'mihua_sq_order_goods');
define('GROUP', 'mihua_sq_group');
define('DISCOUNT', 'mihua_sq_discount');
define('DISCOUNT_USER', 'mihua_sq_userdiscount');
define('SHOP_ADMIN', 'mihua_sq_shop_admin');
define('SHOP_APPLY', 'mihua_sq_shop_apply');
define('ADMIN_GROUP', 'mihua_sq_admin_group');
define('RING', 'mihua_sq_ring');
define('TOPIC', 'mihua_sq_topic');
define('ZAN', 'mihua_sq_ring_zan');
define('MSTIME', 'mihua_sq_mstime');
define('S_ITEM', 'mihua_sq_spec_item');
define('SPEC', 'mihua_sq_spec');
define('OPTION', 'mihua_sq_option');
define('PARAM', 'mihua_sq_param');
define('USER', 'mihua_sq_member');//mihua_sq_user
define('ADDRESS', 'mihua_sq_address');
define('ACCOUNT', 'mihua_sq_account');
define('QIAN', 'mihua_sq_qiandao');
define('COLLECT', 'mihua_sq_collect');
define('CHAT', 'mihua_sq_chat');
define('TPL', 'mihua_sq_tpl');
define('COMMENT', 'mihua_sq_comment');//评论
define('CART', 'mihua_sq_cart');//评论
define('DISCOUNT_RE', 'mihua_sq_discount_record');//优惠买单记录
define('INTEGRAL', 'mihua_sq_integral');//发布信息奖励积分
define('INFOORDER', 'mihua_sq_infoorder');//布信息支付订单
define('ZDORDER', 'mihua_sq_zdorder');//置顶订单
define('INORDER', 'mihua_sq_shopinorder');//商家入驻订单
define('ADMIN', 'mihua_sq_admin');//商家入驻订单
define('INFO_COMMENT', 'mihua_sq_info_comment');//同城信息评论
define('ORDER_RE', 'mihua_sq_order_record');//记录可提现的订单
define('SHOP_USER', 'mihua_sq_shop_user');//记录可提现的订单
define('WAIT_MESSAGE', 'mihua_sq_waitmessage');//待发信息队列
define('BALANCE', 'mihua_sq_balance');//余额充值
define('SHARE_HISTORY', 'mihua_sq_share_history');//分享
define('BLACK', 'mihua_sq_black');//黑名单
define('WORD', 'mihua_sq_sensitiveword');//敏感词
define('FOOT', 'mihua_sq_footmark');//浏览记录

define('REDPACKAGE', 'mihua_sq_redpackage');//发布福利红包
define('GETREDPACKAGE', 'mihua_sq_get_redpackage');//领取福利红包
define('CASH', 'mihua_sq_cash');//可提现金额表
define('MSG', 'mihua_sq_msg');//公告表
define('RENEW', 'mihua_sq_shop_renew');//商户缴费表
define('CFG', 'mihua_sq_shop_cfg');//商户基础设置
define('REFUND', 'mihua_sq_refund');//用户退款记录
?>