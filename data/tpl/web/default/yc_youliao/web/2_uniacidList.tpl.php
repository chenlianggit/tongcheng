<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/yc_youliao/public/css/uniacidList.css" />

<script src="../addons/yc_youliao/public/js/jquery-2.1.4.min.js"></script>


   	<div class="container">		
			<section class="main clearfix" >
				
				<div class="fleft cd-dropdown">
					<ul>
						
						<li class="acidtitle">
							<p>请选择您要管理的公众号</p>
							<div class="unia_arrow">
							<img src="../addons/yc_youliao/public/images/arrow-up.png">
							</div>
						</li>
						 <?php  if(is_array($list)) { foreach($list as $row) { ?>
						<li class="acidlist">
							<a href="<?php  echo $this->createWebUrl("uniacidList",array("uniacid"=>$row['uniacid'],'ac'=>'change' ));?> ">
							<div class="content1">
							 <?php  $img = tomedia('headimg_'.$row['acid'].'.jpg');  ?> 
							 <img src="<?php  if($img) { ?><?php  echo $img;?><?php  } ?>"onerror="this.src='../addons/yc_youliao/public/images/gw-wx.gif'" />
							</div>

							<div class="content2">
								<div class="list-title"><?php  echo $row['name'];?></div>
								<div class="list-datetime">  <?php  echo $row['setmeal']['groupname'];?> </div>
								<div class="list-datetime">    <?php  echo $row['description'];?></div>
							</div>

							<div class="unia_arrow_right">
							<img src="../addons/yc_youliao/public/images/arrow-right.png">
							</div>
							<a>
						</li>
						 <?php  } } ?>

					</ul>


				
				</div>
			
			</section>

			
		</div>
		<script>
			
			$( function() {			
			$(".unia_arrow").click(function(){
 			
			   $(".acidlist").toggle();
			});

			});

		</script>

		

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>