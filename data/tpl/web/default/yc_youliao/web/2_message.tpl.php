<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php  $shop_name=getShop_name()?>
<?php  if(!empty($shop_name) ) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php  } else { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
      <!-- /.aside -->
       <section id="content">
        <section class="vbox">
          <section class="scrollable padder">

          <div class="container-fluid message i-t-md">
				<div class="jumbotron clearfix alert alert-success">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-lg-2">
					<i class="fa fa-5x <?php  if($status=="success") { ?>fa-check-circle<?php  } else { ?>fa-exclamation-triangle<?php  } ?>"></i>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
										<h2></h2>
				  <p><?php  echo $msg;?>
                        <br/>
          <?php  if($redirect) { ?>
					<p><a href="<?php  echo $redirect;?>">如果你的浏览器没有自动跳转，请点击此链接</a></p>
					<script type="text/javascript">
						setTimeout(function () {
							location.href = "<?php  echo $redirect;?>";
						}, 3000);
					</script>
					<?php  } else { ?>
          [<a href="javascript:history.go(-1);" class="alert-link">点击这里返回上一页</a>] &nbsp; [<a href="<?php  echo $this->createWebUrl('index')?>" class="alert-link">首页</a>]
            <?php  } ?>
									</div>
					</div>
		</div>
	</div>

       </section>
  </section>
</section>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>