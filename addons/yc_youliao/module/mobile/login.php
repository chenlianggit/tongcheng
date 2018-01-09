<?php
global $_GPC,$_W;
isetcookie('_admin_id',"",time()-1);
isetcookie('__session',"",time()-1);
isetcookie('__uid',"",time()-1);
isetcookie('__shop_id',"",time()-1);
unset($_SESSION['shop_id']); //清缓存
include $this->template('../web/signin');
exit();