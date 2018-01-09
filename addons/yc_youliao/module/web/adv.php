<?php 
        $class_dao_adv = D('Adv');
        $op  = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $title='广告管理';
		if($op == 'display'){
			$result = $class_dao_adv->dataList(false);
            $list   = $result['list'];
		}elseif($op == 'post'){
			$id     = intval($_GPC['id']);
            if($id){
                $adv = $class_dao_adv->dataEdit($id); 
            }
			if(checksubmit('submit')){
               $_GPC['type']=json_encode(iunserializer($_GPC['type']));
                $in  =  getNewUpdateData($_GPC,$class_dao_adv);
				if ($id) {
                    $class_dao_adv->dataEdit($id,$in);
				}else{
					$id = $class_dao_adv->dataAdd($in);
				}
				$this->message('更新幻灯片成功！', $this->createWebUrl('adv', array('op' => 'display')), 'success');
			}
		} elseif ($op == 'delete') {
			$id  = intval($_GPC['id']);
            if($id){
                $class_dao_adv->delete(array($class_dao_adv->id=>$id));
            }
			$this->message('幻灯片删除成功！', $this->createWebUrl('adv', array('op' => 'display')), 'success');
		}
include $this->template('web/adv');
exit();