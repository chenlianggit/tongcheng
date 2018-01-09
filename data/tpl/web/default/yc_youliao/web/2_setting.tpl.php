<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

   <section id="content">
        <section class="vbox">
          <section class="padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><a href="<?php  echo $this->createWebUrl('index')?>"><i class="fa fa-home"></i>首页</a></li>
              <li class="active">社区设置</li>
              
            </ul>  

     <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/settting_banner', TEMPLATE_INCLUDEPATH)) : (include template('web/settting_banner', TEMPLATE_INCLUDEPATH));?>
<div class="margin-10 setting">
      <form action="" method="post" class="form-horizontal form">
          <!--基础设置开始-->
          <a name="fabu" id="fabu"></a>
          <div class="panel panel-info none" <?php  if($op=='word') { ?>style="display:block;"<?php  } ?>>
              <div class="panel-heading setting-header" >敏感词过滤</div>
              <div class="form-group">

                  <div class=" col-xs-11 pd_15 margin-10">
                      <textarea style="min-height: 300px" class="form-control" name="sensitiveword"><?php  echo $word['sensitiveword'];?></textarea>
                      <span class="help-block" >多个敏感词可用|隔开</span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">敏感字替换</label>
                  <div class="col-sm-6">
                          <input type="text"name="replace"  class="form-control" value="<?php  echo $word['replace'];?>" />
                      </div>
                      <p class="help-block">默认替换成**</p>
                  </div>
              </div>

          <div class="panel panel-info none" <?php  if($op=='display') { ?>style="display:block;"<?php  } ?>>

              <div class="panel-heading setting-header" >功能开关</div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启红包功能</label>
                  <div class="col-sm-9 col-xs-12 ">
                      <input type="radio" name="isredpacket"  value="0" <?php  if($settings['isredpacket']==0) { ?>checked="checked"<?php  } ?>/>是
                      <input class="wl2" type="radio" name="isredpacket" value="1"<?php  if($settings['isredpacket']==1) { ?>checked="checked"<?php  } ?>
                      class="radiomar"/>否

                  </div>
              </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否打赏功能</label>
                  <div class="col-sm-9 col-xs-12 ">
                      <input type="radio" name="isshang"  value="0" <?php  if($settings['isshang']==0) { ?>checked="checked"<?php  } ?>/>是
                      <input class="wl2" type="radio" name="isshang" value="1"<?php  if($settings['isshang']==1) { ?>checked="checked"<?php  } ?>
                      class="radiomar"/>否

                  </div>
              </div>
              <div class="panel-heading setting-header" >发布设置</div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">圈子发布限制</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4 input-group">
                          <input type="text" onkeyup="clearNoNum(this);"name="ring_creidit"  class="form-control" value="<?php  echo $settings['ring_creidit'];?>" />
                          <span class="input-group-addon">积分</span>
                      </div>
                      <p class="help-block">0或空表示不限制发布条件</p>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">每天限制发布</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4 input-group">
                          <input type="text" onkeyup="clearNoNum(this);"name="ring_num"  class="form-control" value="<?php  echo $settings['ring_num'];?>" />
                          <span class="input-group-addon">条</span>
                      </div>
                      <p class="help-block">0或空表示不限制每天发布数量</p>
                  </div>
              </div>

          <div class="panel-heading setting-header">秒杀专场</div>
              <div class="col-xs-12 col-md-12 ml15">温馨提示：选择专场时间点时，请不要交叉、重叠！</div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                  <div class="col-sm-12" style="text-align: left">
                      <ul class="timeoption">
                          <?php  if(is_array($timelist)) { foreach($timelist as $item) { ?>
                      <li class=" bg-dark setting-time" >
                          <?php  echo $item['timestart'];?>: 00~<?php  echo $item['timeend'];?>: 00
                          <i class="fa fa-trash-o" onclick="deletetime(this,<?php  echo $item['time_id'];?>)"></i>
                      </li>
                          <?php  } } ?>
                      </ul>
                  </div>

                  <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                  <div class="text-right">
                  <select name="timestart" class="hour form-control" >
                      <option value="">开始时间</option>
                      <option value="0">00 : 00</option>
                      <option value="1">01 : 00</option>
                      <option value="2">02 : 00</option>
                      <option value="3">03 : 00</option>
                      <option value="4">04 : 00</option>
                      <option value="5">05 : 00</option>
                      <option value="6">06 : 00</option>
                      <option value="7">07 : 00</option>
                      <option value="8">08 : 00</option>
                      <option value="9">09 : 00</option>
                      <option value="10">10 : 00</option>
                      <option value="11">11 : 00</option>
                      <option value="12">12 : 00</option>
                      <option value="13">13 : 00</option>
                      <option value="14">14 : 00</option>
                      <option value="15">15 : 00</option>
                      <option value="16">16 : 00</option>
                      <option value="17">17 : 00</option>
                      <option value="18">18 : 00</option>
                      <option value="19">19 : 00</option>
                      <option value="20">20 : 00</option>
                      <option value="21">21 : 00</option>
                      <option value="22">22 : 00</option>
                      <option value="23">23 : 00</option>
                  </select>

                  <select name="timeend" class="hour form-control">
                      <option value="">结束时间</option>
                      <option value="0">00 : 00</option>
                      <option value="1">01 : 00</option>
                      <option value="2">02 : 00</option>
                      <option value="3">03 : 00</option>
                      <option value="4">04 : 00</option>
                      <option value="5">05 : 00</option>
                      <option value="6">06 : 00</option>
                      <option value="7">07 : 00</option>
                      <option value="8">08 : 00</option>
                      <option value="9">09 : 00</option>
                      <option value="10">10 : 00</option>
                      <option value="11">11 : 00</option>
                      <option value="12">12 : 00</option>
                      <option value="13">13 : 00</option>
                      <option value="14">14 : 00</option>
                      <option value="15">15 : 00</option>
                      <option value="16">16 : 00</option>
                      <option value="17">17 : 00</option>
                      <option value="18">18 : 00</option>
                      <option value="19">19 : 00</option>
                      <option value="20">20 : 00</option>
                      <option value="21">21 : 00</option>
                      <option value="22">22 : 00</option>
                      <option value="23">23 : 00</option>
                  </select>
                  </div>
                  <div class="col-sm-2 text-left">
                      <span class="font_13px_999 add_btn add_s_inco">确认添加</span>
                  </div>

          </div>

          <div class="panel-heading setting-header">订单设置</div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">拼团失败是否自动退款</label>
                            <div class="col-sm-9 col-xs-12 ">
                                <input type="radio" name="isautorefundgroup"  value="1" <?php  if($settings['isautorefundgroup']==1) { ?>checked="checked"<?php  } ?>/> 自动
                                <input class="wl2" type="radio" name="isautorefundgroup" value="2"<?php  if($settings['isautorefundgroup']==2) { ?>checked="checked"<?php  } ?>
                                class="radiomar"/>非自动

                            </div>
                        </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">拼团失败是否退积分</label>
                  <div  class="radiofix">
                      <input type="radio" name="isreturncredit" value="1" <?php  if($settings['isreturncredit']==1) { ?>checked="checked"<?php  } ?>/> 退还
                      <input type="radio" name="isreturncredit" value="2"<?php  if($settings['isreturncredit']==2) { ?>checked="checked"<?php  } ?>
                      class="radiomar"/>不退还
                  </div>
              </div>
              <div class="form-group">
                                 <label class="col-xs-12 col-sm-3 col-md-2 control-label">自动取消订单期限</label>
                 <div class="col-sm-9 col-xs-12">
                     <div class="input-group col-md-2">
                                     <input type="text" class="form-control" name="autocancelordertime" class="form-control" value="<?php  echo $settings['autocancelordertime'];?>" />
                                     <span class="input-group-addon">分钟</span>
                                 </div>
                             </div>
                 <div class="clearfix"></div>
                 <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                  <div class="col-md-10 help-block">用户下单后，在这个时间内没有支付，系统会自动取消订单。一天=1440 分钟</div>
             </div>
             <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">自动取消前</label>
                 <div class="col-sm-9 col-xs-12">
                     <div class="input-group col-md-2">
                                    <input type="text" class="form-control"  name="remindmessagetime" class="form-control" value="<?php  echo $settings['remindmessagetime'];?>" />
                                    <span class="input-group-addon">分钟</span>
                     </div>
                            </div>
                 <div class="clearfix"></div>
                 <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                 <div class="col-md-10 help-block">自动取消订单前，模板消息通知用户前去支付</div>
             </div>



          <div class="panel-heading setting-header">支付设置</div>

           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启余额支付</label>
               <div class="col-sm-9 col-xs-12 ">
                    <input type="radio" name="balance"  value="0" <?php  if($settings['balance']==0) { ?>checked="checked"<?php  } ?>/> 开
                    <input type="radio" class="wl2" name="balance" <?php  if($settings['balance']==1) { ?>checked="checked"<?php  } ?> value="1" class="radiomar"/>关
                        <p class="help-block">默认为开启</p>
                    </div>
                </div>
               <div class="form-group">
                   <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启微信支付</label>
                   <div class="col-sm-9 col-xs-12 ">
                       <input type="radio" name="wx" value="0"  <?php  if($settings['wx']==0) { ?>checked="checked"<?php  } ?>/> 开
                       <input type="radio" class="wl2" name="wx" <?php  if($settings['wx']==1) { ?>checked="checked"<?php  } ?> value="1" class="radiomar"/>关
                       <p class="help-block">默认为开启</p>
                   </div>
		        </div>
              <div class="panel-heading setting-header">用户提现设置<a  class="mar_left_10" href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=shop">商户提现设置请点击</a></div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">最低提现金额（用户）</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4  input-group">
                          <input type="text" name="transfer_min" class="form-control" value="<?php  echo $settings['transfer_min'];?>" />
                          <span class="input-group-addon">元</span>
                      </div>
                      <p class="help-block ">根据微信的规定，提现金额必须大于1元以上</p>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">最高提现金额（用户）</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4  input-group">
                          <input type="text" name="transfer_max" class="form-control" value="<?php  echo $settings['transfer_max'];?>" />
                          <span class="input-group-addon">元</span>
                      </div>
                      <p class="help-block ">根据微信的规定，提现金额必须小于2万元</p>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现手续费（用户）</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4  input-group">
                          <input type="text" name="transfer_user" class="form-control" value="<?php  echo $settings['transfer_user'];?>" />
                          <span class="input-group-addon">%</span>
                      </div>

                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现方式（用户）</label>
                  <div class="col-sm-9 col-xs-12">

                      <?php  $pay_type_user=$settings['pay_type_user']?>
                      <input type="checkbox" class="mr20"  name="pay_type_user[]" value="1"
                             <?php  if(!empty($pay_type_user) && in_array('1',$pay_type_user)) { ?>checked="checked"<?php  } ?>/>微信
                      <input type="checkbox" name="pay_type_user[]" class="wl2"
                             <?php  if(!empty($pay_type_user) && in_array('2',$pay_type_user)) { ?>checked="checked"<?php  } ?> value="2" />支付宝
                      <input type="checkbox" name="pay_type_user[]" class="wl2"
                             <?php  if(!empty($pay_type_user) && in_array('3',$pay_type_user)) { ?>checked="checked"<?php  } ?> value="3" />银行卡
                      <input type="checkbox" name="pay_type_user[]" class="wl2"
                             <?php  if(!empty($pay_type_user) && in_array('4',$pay_type_user)) { ?>checked="checked"<?php  } ?> value="4" />余额
                      <p class="help-block red">微信支付给个人需注意：</p>
                      <p class="help-block  "><a  class="red" href="https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2">1、需在公众号商户平台开通企业付款功能,需确保可用余额充足,更具体规则请点击</a></p>
                      <p class="help-block "><a class="red" href="https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=4_3">2、基于安全性，须在系统支付参数- 退款配置上传了两个证书，获得证书方式请点击</a></p>

                  </div>
              </div>

              <div class="panel-heading setting-header">签到</div>
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">签到积分</label>
                <div class="col-sm-9 col-xs-12">

                    <span>是否开启随机获得签到积分</span>
                     <input type="radio" name="qiandao_random" value="1" onClick="randomOpen();" <?php  if($settings['qiandao_random']==1) { ?>checked="checked"<?php  } ?>/> 是

                    <input type="radio" name="qiandao_random" onClick="randomClose();" <?php  if($settings['qiandao_random']==2) { ?>checked="checked"<?php  } ?> value="2"style="margin:0 0 0 20px" />否
                      <input type="text" name="qiandao_jifen" class="form-control" value="<?php  echo $settings['qiandao_jifen'];?>" />
                       <span class="qiandao_des" style="color:red"></span>
                </div>
            </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">1积分抵扣</label>
                  <div class="col-sm-8  col-md-4">
                      <div class="input-group">
                          <input type="text" onkeyup="clearNoNum(this);" name="credit2money" id="credit2money" class="form-control" value="<?php  echo $settings['credit2money'];?>" />
                          <span class="input-group-addon">元</span>
                      </div>
                      <span class="help-block">默认：1积分可抵扣0.1元</span>
                  </div>
              </div>

         	 <div class="panel-heading setting-header">评论设置</div>
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核开关</label>
                <div class="col-sm-9 col-xs-12 ">

                    
                     <input type="radio"   name="comment_flag" value="0"  <?php  if($settings['comment_flag']==0) { ?>checked="checked"<?php  } ?>/>开

                    <input type="radio" class="wl2" name="comment_flag"  <?php  if($settings['comment_flag']==1) { ?>checked="checked"<?php  } ?> value="1" />关
                    <p class="help-block">默认为开启,开启后，审核通过才显示在商品详情页面</p>
                </div>
            </div> 
            <!--<div class="form-group">-->
                <!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">评论积分</label>-->
                <!--<div class="col-sm-9 col-xs-12">-->
                    <!--<input type="text" name="comment_jifen" class="form-control" value="<?php  echo $settings['comment_jifen'];?>" />-->
                <!--</div>-->
            <!--</div>  -->

          <div class="panel-heading setting-header">消息设置</div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启模板消息</label>
                  <div class="col-sm-9 col-xs-12 ">
                      <input type="radio" name="istplon"  value="1" <?php  if($settings['istplon']==1) { ?>checked="checked"<?php  } ?>/>是
                      <input class="wl2" type="radio" name="istplon" value="2"<?php  if($settings['istplon']==2) { ?>checked="checked"<?php  } ?>
                      class="radiomar"/>否

                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">客服消息提醒时间间隔</label>
                  <div class="col-sm-2 col-xs-12">
                      <div class="input-group">
                          <input class="form-control" name="kefutplminute" value="<?php  echo $settings['kefutplminute'];?>" type="text">
                          <span class="input-group-addon">秒</span>
                      </div>
                  </div>
              </div>




          </div>




<!--基础设置结束-->
          <!--其他设置开始-->
          <div class="panel panel-default none" <?php  if($op=='page') { ?>style="display:block;"<?php  } ?>>
              <div class="panel-heading">页面设置</div>
              <div class="panel-body">
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">广告下方是否开启波浪效果</label>
                      <div class="col-sm-9 col-xs-12 ">
                          <input type="radio" name="showWater"  value="0" <?php  if($settings['showWater']==0) { ?>checked="checked"<?php  } ?>/> 是
                          <input class="wl2" type="radio" name="showWater" value="1"<?php  if($settings['showWater']==1) { ?>checked="checked"<?php  } ?>
                          class="radiomar"/>否
                          <p class="help-block">默认为开启</p>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">同城信息是否区分城市</label>
                      <div class="col-sm-9 col-xs-12 ">
                          <input type="radio" name="issamecity"  value="0" <?php  if($settings['issamecity']==0) { ?>checked="checked"<?php  } ?>/> 是
                          <input class="wl2" type="radio" name="issamecity" value="1"<?php  if($settings['issamecity']==1) { ?>checked="checked"<?php  } ?>
                          class="radiomar"/>否
                          <p class="help-block">默认为区分，如果不区分城市，则每个城市进来看到的数据都是一样的</p>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页是否展示同城信息</label>
                      <div class="col-sm-9 col-xs-12 ">
                          <input type="radio" name="showChannel"  value="1" <?php  if($settings['showChannel']==1) { ?>checked="checked"<?php  } ?>/>是
                          <input class="wl2" type="radio" name="showChannel" value="2"<?php  if($settings['showChannel']==2) { ?>checked="checked"<?php  } ?>
                          class="radiomar"/>否

                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页展示同城信息数量</label>
                      <div class="col-sm-6">
                          <div class="col-sm-4 input-group">
                              <input type="text" onkeyup="clearNoNum(this);"name="showChannelNum"  class="form-control" value="<?php  echo $settings['showChannelNum'];?>" />
                              <span class="input-group-addon">条</span>
                          </div>
                          <p class="help-block">默认最多展示5条信息</p>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页是否展示商圈入口(拼团、优惠买单、首单优惠)</label>
                      <div class="col-sm-9 col-xs-12 ">
                          <input type="radio" name="showShop"  value="1" <?php  if($settings['showShop']==1) { ?>checked="checked"<?php  } ?>/>是
                          <input class="wl2" type="radio" name="showShop" value="2"<?php  if($settings['showShop']==2) { ?>checked="checked"<?php  } ?>
                          class="radiomar"/>否

                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">随机浏览量（最高数）</label>
                      <div class="col-sm-9 col-xs-12">
                          <div class="input-group col-md-2">
                              <input type="text" name="views_num"  class="form-control" value="<?php  echo $settings['views_num'];?>" />
                              <span class="input-group-addon">次</span>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                      <div class="col-md-10 help-block">为空或0时每人每次浏览量+1，不为空时按最低1及所填的最高数随机生成浏览量</div>
                  </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
                  <div class="col-sm-8 col-sm-input">
                      <input type="text" name="index_title" class="form-control" value="<?php  echo $settings['index_title'];?>" />
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">底部版权</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_ueditor('footer', $settings['footer']);?>

                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">免责声明</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_ueditor('disclaimer', $settings['disclaimer']);?>

                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">客服图标按钮</label>
                  <div class="col-sm-9 col-xs-12 col-sm-input"><?php  echo tpl_form_field_image('service_btn', $settings['service_btn']);?>
                      <div  class="clearfix"></div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">客服链接</label>
                  <div class="col-sm-9 col-xs-12 col-sm-input">
                      <input type="text" name="service_link" placeholder="<?php  echo $_W['siteroot'];?>" class="form-control" value="<?php  echo $settings['service_link'];?>"><?php  echo $settings['service_link'];?></textarea>
                  </div>
              </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">客服按钮显示位置</label>
                      <div class="col-sm-9 col-xs-12 ">
                          <input type="radio" name="show_service"  value="1" <?php  if($settings['show_service']==1) { ?>checked="checked"<?php  } ?>/> 不显示
                          <input class="wl2" type="radio" name="show_service" value="2"<?php  if($settings['show_service']==2) { ?>checked="checked"<?php  } ?> class="radiomar"/>仅首页显示
                          <input class="wl2" type="radio" name="show_service" value="0"<?php  if($settings['show_service']==0) { ?>checked="checked"<?php  } ?> class="radiomar"/>全部页面显示
                      </div>
                  </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                  <div class="col-sm-9 col-xs-12">
                      <div class="input-group col-md-4">
                          <span class="input-group-addon">页面可移动按钮宽度</span>
                          <input type="text" name="service_w"  class="form-control" value="<?php  echo $settings['service_w'];?>" />
                          <span class="input-group-addon">px</span>
                      </div>
                      <br>
                      <div class="input-group col-md-4">
                          <span class="input-group-addon">页面可移动按钮高度</span>
                          <input type="text" name="service_h"  class="form-control" value="<?php  echo $settings['service_h'];?>" />
                          <span class="input-group-addon">px</span>
                      </div>
                      <br>


                  </div>

                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                      <div class="col-sm-9 col-xs-12">
                          <div class="input-group col-md-4">
                              <span class="input-group-addon">离底部距离</span>
                              <input type="text" name="service_b"  class="form-control" value="<?php  echo $settings['service_b'];?>" />
                              <span class="input-group-addon">px</span>
                          </div>
                          <br>
                          <div class="input-group col-md-4">
                              <span class="input-group-addon">离左边距离</span>
                              <input type="text" name="service_l"  class="form-control" value="<?php  echo $settings['service_l'];?>" />
                              <span class="input-group-addon">px</span>
                          </div>
                          <br>


                      </div>
                  </div>



              </div>
          </div>
          <!--其他设置结束-->

          <div class="panel panel-default none" <?php  if($op=='shop') { ?>style="display:block;"<?php  } ?>>
          <!--商户设置开始-->

              <div class="panel-heading setting-header">商户入驻规则</div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户入驻</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="radio" class="mr20"  name="shop_enter" value="0"  <?php  if($settings['shop_enter']==0) { ?>checked="checked"<?php  } ?>/>开启
                      <input type="radio" name="shop_enter" class="wl2"  <?php  if($settings['shop_enter']==1) { ?>checked="checked"<?php  } ?> value="1" />关闭
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户入驻费用</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="radio" onclick="renewPrice();" class="mr20"  name="shop_enter_price" value="0"  <?php  if($settings['shop_enter_price']==0) { ?>checked="checked"<?php  } ?>/>免费一年
                      <input type="radio" onclick="showEnterPrice();" name="shop_enter_price" class="wl2"  <?php  if($settings['shop_enter_price']==1) { ?>checked="checked"<?php  } ?> value="1" />按年收费
                      <input type="radio" onclick="hideEnterPrice();" name="shop_enter_price" class="wl2"  <?php  if($settings['shop_enter_price']==2) { ?>checked="checked"<?php  } ?> value="2" />永久免费
                  </div>
              </div>
              <div  id='enterPrice' <?php  if($settings['shop_enter_price']!=1) { ?>class="none "<?php  } ?>>
          <div class="form-group  " >
              <label class="col-xs-12 col-sm-3 col-md-2 control-label">入驻费用</label>
              <div class="col-sm-6">
                  <div class="col-sm-4 input-group">
                      <input type="text" onkeyup="clearNoNum(this);" name="one_year_money"  class="form-control" value="<?php  echo $settings['one_year_money'];?>" />
                      <span class="input-group-addon">元/1年</span>
                  </div>

              </div>
          </div>

                  <div class="form-group">
              <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
              <div class="col-sm-6">
              <div class="col-sm-4 input-group">
                  <input type="text" onkeyup="clearNoNum(this);" name="two_year_money"  class="form-control" value="<?php  echo $settings['two_year_money'];?>" />
                  <span class="input-group-addon">元/2年</span>
              </div>

          </div>
          </div>

                  <div class="form-group">
              <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
              <div class="col-sm-6">
                  <div class="col-sm-4 input-group">
                      <input type="text" onkeyup="clearNoNum(this);" name="three_year_money"  class="form-control" value="<?php  echo $settings['three_year_money'];?>" />
                      <span class="input-group-addon">元/3年</span>
                  </div>

              </div>
          </div>
              </div>
              <div  id='renewPrice'  <?php  if($settings['shop_enter_price']>1) { ?>class="none "<?php  } ?>>
          <div class="form-group">
              <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户续费</label>
              <div class="col-sm-6">
                  <div class="col-sm-4 input-group">
                      <input type="text" onkeyup="clearNoNum(this);" name="one_renew"  class="form-control" value="<?php  echo $settings['one_renew'];?>" />
                      <span class="input-group-addon">元/1年</span>
                  </div>

              </div>
          </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                      <div class="col-sm-6">
                          <div class="col-sm-4 input-group">
                              <input type="text" onkeyup="clearNoNum(this);" name="two_renew"  class="form-control" value="<?php  echo $settings['two_renew'];?>" />
                              <span class="input-group-addon">元/2年</span>
                          </div>

                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                      <div class="col-sm-6">
                          <div class="col-sm-4 input-group">
                              <input type="text" onkeyup="clearNoNum(this);" name="three_renew"  class="form-control" value="<?php  echo $settings['three_renew'];?>" />
                              <span class="input-group-addon">元/3年</span>
                          </div>
                          <p class="help-block">以上入驻0元表示不收取商户费用，小数位最多为两位，小数点须为英文半角符</p>
                      </div>
                  </div>
              </div>
          <!--<div class="form-group">-->
              <!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">开通秒杀专场费用</label>-->
              <!--<div class="col-sm-6">-->
                  <!--<div class="col-sm-4 input-group">-->
                      <!--<input type="text" onkeyup="clearNoNum(this);" name="time_money"  class="form-control" value="<?php  echo $settings['time_money'];?>" />-->
                      <!--<span class="input-group-addon">元</span>-->
                  <!--</div>-->
                  <!--<p class="help-block">0或空则表示不收取商户费用即可开通秒杀专场，小数位最多为两位</p>-->
              <!--</div>-->
          <!--</div>-->
          <!--<div class="form-group">-->
              <!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">开通拼团费用</label>-->
              <!--<div class="col-sm-6">-->
                  <!--<div class="col-sm-4 input-group">-->
                      <!--<input type="text" onkeyup="clearNoNum(this);"name="group_money"  class="form-control" value="<?php  echo $settings['group_money'];?>" />-->
                      <!--<span class="input-group-addon">元</span>-->
                  <!--</div>-->
                  <!--<p class="help-block">0或空则表示不收取商户费用即可开通拼团，小数位最多为两位</p>-->
              <!--</div>-->
          <!--</div>-->
              <div class="panel-heading setting-header">商户提现设置<a  class="mar_left_10" href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=display">用户提现设置请点击</a></div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">最低提现金额（商户）</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4  input-group">
                          <input type="text" name="shop_transfer_min" class="form-control" value="<?php  echo $settings['shop_transfer_min'];?>" />
                          <span class="input-group-addon">元</span>
                      </div>
                      <p class="help-block ">根据微信的规定，提现金额必须大于1元以上</p>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">最高提现金额（商户）</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4  input-group">
                          <input type="text" name="shop_transfer_max" class="form-control" value="<?php  echo $settings['shop_transfer_max'];?>" />
                          <span class="input-group-addon">元</span>
                      </div>
                      <p class="help-block ">根据微信的规定，提现金额必须小于2万元</p>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现手续费（商户）</label>
                  <div class="col-sm-6">
                      <div class="col-sm-4  input-group">
                          <input type="text" name="transfer" class="form-control" value="<?php  echo $settings['transfer'];?>" />
                          <span class="input-group-addon">%</span>
                      </div>

                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现方式（商户）</label>
                  <div class="col-sm-9 col-xs-12">

                      <?php  $payType=$settings['shop_pay_type']?>
                      <input type="checkbox" class="mr20"  name="shop_pay_type[]" value="1"
                             <?php  if(!empty($payType) && in_array('1',$payType)) { ?>checked="checked"<?php  } ?>/>微信
                      <input type="checkbox" name="shop_pay_type[]" class="wl2"
                             <?php  if(!empty($payType) && in_array('2',$payType)) { ?>checked="checked"<?php  } ?> value="2" />支付宝
                      <input type="checkbox" name="shop_pay_type[]" class="wl2"
                             <?php  if(!empty($payType) && in_array('3',$payType)) { ?>checked="checked"<?php  } ?> value="3" />银行卡
                      <input type="checkbox" name="shop_pay_type[]" class="wl2"
                             <?php  if(!empty($payType) && in_array('4',$payType)) { ?>checked="checked"<?php  } ?> value="4" />余额
                      <p class="help-block red">微信支付给个人需注意：</p>
                      <p class="help-block  "><a  class="red" href="https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2">1、需在公众号商户平台开通企业付款功能,需确保可用余额充足,更具体规则请点击</a></p>
                      <p class="help-block "><a class="red" href="https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=4_3">2、基于安全性，须在系统支付参数- 退款配置上传了两个证书，获得证书方式请点击</a></p>

                  </div>
              </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">入驻协议</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_ueditor('contract', $settings['contract']);?>

                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">可申请退货退款时间</label>
                  <div class="col-sm-9 col-xs-12">
                      <div class="input-group col-md-2">
                          <input type="text" class="form-control"  name="refundtime" class="form-control" value="<?php  echo $settings['refundtime'];?>" />
                          <span class="input-group-addon">天</span>
                      </div>
                  </div>
                  <div class="clearfix"></div>
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                  <div class="col-md-10 help-block">可在商品管理设置是否支持退货退款,默认为7天</div>
              </div>
          <div class="panel-heading setting-header">商户设置</div>
          <div class="form-group">
              <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺默认图标</label>
              <div class="col-sm-9 col-xs-12">
                  <?php  echo tpl_form_field_image('shop_logo', $settings['shop_logo'], '', array('extras' => array('text' => 'readonly')))?>

              </div>
          </div>
          <div class="form-group">
              <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺默认形象照</label>
              <div class="col-sm-9 col-xs-12">
                  <?php  echo tpl_form_field_image('shop_bgpic', $settings['shop_bgpic'], '', array('extras' => array('text' => 'readonly')))?>

              </div>
          </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺客服图标按钮</label>
                  <div class="col-sm-9 col-xs-12 col-sm-input"><?php  echo tpl_form_field_image('shop_service_btn', $settings['shop_service_btn']);?>
                      <div  class="clearfix"></div>
                  </div>
              </div>

      </div>
          <!--商户设置结束-->

          <!--分享设置开始-->

          <div class="panel panel-default none" <?php  if($op=='share') { ?>style="display:block;"<?php  } ?>>
              <div class="panel-heading">分享设置</div>
              <div class="panel-body">
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
                      <div class="col-sm-9 col-xs-12">
                              <input type="text"  name="share_title"  class="form-control" value="<?php  echo $settings['share_title'];?>" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图片</label>
                      <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_image('share_img', $settings['share_img'], '', array('extras' => array('text' => 'readonly')))?>

                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
                      <div class="col-sm-9 col-xs-12">
                          <input type="text"  name="share_info"  class="form-control" value="<?php  echo $settings['share_info'];?>" />

                      </div>
                  </div>

                  <div class="line line-dashed line-lg pull-in"></div>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注引导开关</label>
                      <div class="col-sm-9 col-xs-12">
                          <input type="radio" class="mr20"  name="qrcode_flag" value="0"  <?php  if($settings['qrcode_flag']==0) { ?>checked="checked"<?php  } ?>/>开
                          <input type="radio" name="qrcode_flag" class="wl2"  <?php  if($settings['qrcode_flag']==1) { ?>checked="checked"<?php  } ?> value="1" />关
                          <div>开启后，未关注用户即提示公众号二维码（未关注引导二维码）</div>
                      </div>
                  </div>

              </div>
              </div>

          <div class="panel panel-default none" <?php  if($op=='btn') { ?>style="display:block;"<?php  } ?>>
              <div class="panel-heading">导航图标设置</div>
              <div class="panel-body">
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标1名称（首页）</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn1_name"  class="form-control" value="<?php  echo $settings['btn1_name'];?>" />
                      <div>不填则使用默认名称</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标1链接</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn1_link"  class="form-control" value="<?php  echo $settings['btn1_link'];?>" />
                      <div>不填则使用默认链接</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标1：点击前</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn1', $settings['btn1'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标1：点击后</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn1_hover', $settings['btn1_hover'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              <div class="line line-dashed line-lg pull-in"></div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标2名称（附近）</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn2_name"  class="form-control" value="<?php  echo $settings['btn2_name'];?>" />
                      <div>不填则使用默认名称</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标2链接</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn2_link"  class="form-control" value="<?php  echo $settings['btn2_link'];?>" />
                      <div>不填则使用默认链接</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标2：点击前</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn2', $settings['btn2'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标2：点击后</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn2_hover', $settings['btn2_hover'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
                  <div class="line line-dashed line-lg pull-in"></div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标3名称（发布）</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn3_name"  class="form-control" value="<?php  echo $settings['btn3_name'];?>" />
                      <div>不填则使用默认名称</div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标3链接</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn3_link"  class="form-control" value="<?php  echo $settings['btn3_link'];?>" />
                      <div>不填则使用默认链接</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标3：点击前</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn3', $settings['btn3'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标3：点击后</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn3_hover', $settings['btn3_hover'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
                  <div class="line line-dashed line-lg pull-in"></div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标4名称（圈子）</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn4_name"  class="form-control" value="<?php  echo $settings['btn4_name'];?>" />
                      <div>不填则使用默认名称</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标4链接</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn4_link"  class="form-control" value="<?php  echo $settings['btn4_link'];?>" />
                      <div>不填则使用默认链接</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标4：点击前</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn4', $settings['btn4'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标4：点击后</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn4_hover', $settings['btn4_hover'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
                  <div class="line line-dashed line-lg pull-in"></div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标5名称（我的）</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn5_name"  class="form-control" value="<?php  echo $settings['btn5_name'];?>" />
                      <div>不填则使用默认名称</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标5链接</label>
                  <div class="col-sm-9 col-xs-12">
                      <input type="text"  name="btn5_link"  class="form-control" value="<?php  echo $settings['btn5_link'];?>" />
                      <div>不填则使用默认链接</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标5：点击前</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn5', $settings['btn5'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-xs-12 col-sm-3 col-md-2 control-label">图标5：点击后</label>
                  <div class="col-sm-9 col-xs-12">
                      <?php  echo tpl_form_field_image('btn5_hover', $settings['btn5_hover'], '', array('extras' => array('text' => 'readonly')))?>
                      <div>建议上传40px*40px透明背景图片，为空则使用默认图标</div>
                  </div>
              </div>
              </div>
          </div>
            <!--导航设置结束-->

          <!--外部请求参数设置开始-->
          <div class="panel panel-default none" <?php  if($op=='sign') { ?>style="display:block;"<?php  } ?>>
              <div class="panel-heading">外部请求参数设置</div>
              <div class="panel-body">
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">百度地图ak</label>
                      <div class="col-sm-9 col-xs-12">
                          <input type="text"  name="mapak"  class="form-control" value="<?php  echo $settings['mapak'];?>" />
                          <div><a class="green" href="http://lbsyun.baidu.com/apiconsole/key?application=key">申请百度地图ak(注册成为开发者--创建应用(应用类型:浏览器端)--获取ak)</a></div>
                      </div>
                  </div>
              </div>
          </div>
          <!--外部请求参数设置结束-->


    <div class="width100 ">
        <input name="submit" type="submit" value="提交" class="btn btn-primary">
     <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
    </div>
    </form>

      </form>
  </div>
</section>
</section>
</section>
<script>

    var url= "<?php  echo $this->createWebUrl('ajax_req')?>";
    function deletetime(obj,id){
        $.ajax({
            type:'post',
            url: url,
            dataType: 'json',
            data:{'op':'deletetime','id':id},
            success:function(data){
                if(data.status=='1'){
                    $(obj).parent().remove();
                    tip('删除成功');
                    tip_close();
                }else{
                    tip('删除失败');
                    tip_close();
                }

            }
        });
    }
    $('.add_s_inco').click(function(){
        var timestart=$('select[name="timestart"]').val();
        var timeend=$('select[name="timeend"]').val();
        if(timestart==timeend){
            tip('开始时间不能与结束时间一样');
            tip_close();
            return false;
        }
        if(timestart=="" || timeend==""){
            tip('开始时间或结束时间不能为空');
            tip_close();
            return false;
        }

        $.ajax({
            type:'post',
            url:url,
            dataType: 'json',
            data:{'op':'addtime','timestart':timestart,'timeend':timeend},
            success:function(data){
                if(data.status=='1'){
                    $('.timeoption ').append(' <li class="bg-dark setting-time">'+timestart+': 00~'+timeend+': 00<i class="fa fa-trash-o"onclick="deletetime(this,'+data.id+'})"></i> </li>');
                   // tip(data.id);
                }else if(data.status=='0'){
                    tip(data.str);
                    tip_close();
                }else{
                    tip('添加专场失败！');
                    tip_close();
                }

            }
        });


    });



</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>