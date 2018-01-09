<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="upgrade-content">

	<div class="upgrade-heading we7-padding-vertical text-center">

		<img src="./resource/images/logo/logo-lg.png" alt="" class="we7-logo"/>

		<h2 class="upgrade-version">系统当前版本: <?php echo IMS_FAMILY;?><?php echo IMS_VERSION;?>（<?php echo IMS_RELEASE_DATE;?>）</h2>

	</div>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

