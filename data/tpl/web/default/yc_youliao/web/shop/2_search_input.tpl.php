<?php defined('IN_IA') or exit('Access Denied');?><div class="panel panel-info">
    <div class="panel-heading">筛选</div>
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="yc_youliao" />
            <input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>" />
            <input type="hidden" name="status" value="<?php  echo $status;?>" />
            <input type="hidden" name="today" value="<?php  echo $today;?>" />
            <input type="hidden" name="op" value="<?php  echo $_GPC['op'];?>" />

            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单号</label>
                <div class="col-xs-4">
                    <input class="form-control" name="ordersn" id="" type="text" value="<?php  echo $_GPC['ordersn'];?>" placeholder="订单号">
                </div>
            </div>
            <?php  if($search_type==2) { ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员姓名</label>
                <div class="col-xs-4">
                    <input name="realname" type="text" class="form-control" value="<?php  echo $_GPC['realname'];?>" placeholder='用户名'/>
								  </div>
							  </div>
							  <div class="form-group">
								  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">手机号码</label>
								  <div class="col-sm-9 col-xs-12">
									  <input name="mobile" type="text" class="form-control" value="<?php  echo $_GPC['mobile'];?>" placeholder="手机号码"/>
                </div>
            </div>
            <?php  } ?>
            <?php  if($search_type==3) { ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商铺名称</label>
                <div class="col-xs-4">
                    <select class="form-control tpl-category-parent" id="shop_id" name="shop_id">
                        <option value=""></option>
                        <?php  if(is_array($shop)) { foreach($shop as $item) { ?>
                        <option <?php  if($_GPC['shop_id']==$item['shop_id']) { ?>selected="selected"<?php  } ?>  value="<?php  echo $item['shop_id'];?>"><?php  echo $item['shop_name'];?></option>
                        <?php  } } ?>
                    </select>
            </div>
            </div>

            <?php  } ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">下单时间</label>
                <div class="col-sm-4 col-xs-12">
                    <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    <!--<button name="orderstatisticsEXP01" value="orderstatisticsEXP01" class="btn btn-default"><i class="fa fa-download"></i> 导出数据</button>-->
                    <!--<button type="button" class="btn btn-default">总记录数：<?php  echo $total;?></button>-->
                </div>
            </div>

        </form>
    </div>
</div>