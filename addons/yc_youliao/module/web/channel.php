<?php
global $_GPC, $_W;
$title='频道管理';
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	if (!empty($_GPC['displayorder'])) {
		foreach ($_GPC['displayorder'] as $id => $displayorder) {
			pdo_update(CHANNEL, array('displayorder' => $displayorder), array('id' => $id, 'weid' => $_W['uniacid']));
		}
		$this->message('模型排序更新成功！', $this->createWebUrl('channel', array('op' => 'display')), 'success');
	}
	$list = pdo_fetchall("SELECT * FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} ORDER BY displayorder ASC ");
	if($list){
	    $condition= " and weid =".$_W['uniacid'] ;
    }
	foreach($list as $k=>$v){
		$list[$k]['fieldslist'] = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE mid = {$v['id']} {$condition} ORDER BY displayorder ASC");
		$list[$k]['fieldnum'] = count($list[$k]['fieldslist']);
		if (!empty($v['fid'])) {
			$children[$v['fid']][] = $list[$k];
			unset($list[$k]);
		}
	}
	$list2 = pdo_fetchall("SELECT * FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} ORDER BY displayorder ASC ");
	foreach($list2 as $k=>$v){
		$list2[$k]['fieldslist'] = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE weid = {$_W['uniacid']} AND mid = {$v['id']} ORDER BY displayorder ASC");
		$list2[$k]['fieldnum'] = count($list[$k]['fieldslist']);
	}
	include $this->template('web/channel');
} elseif($operation == 'customdisplayorder'){
	if (!empty($_GPC['displayorder'])) {
		foreach ($_GPC['displayorder'] as $id => $displayorder) {
			pdo_update(fields, array('displayorder' => $displayorder), array('id' => $id, 'weid' => $_W['uniacid']));
		}
		$this->message('排序更新成功！', $this->createWebUrl('channel', array('op' => 'display')), 'success');
	}
}elseif($operation == 'html'){
	$id = intval($_GPC['id']);
	$type = trim($_GPC['type']);
	if($type != 'list' && $type != 'detail'){
		$this->message('没有对应的自定义页面！');
	}
	$moduleres = pdo_fetch("SELECT * FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND id = {$id}");
	$fieldslist = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE weid = {$_W['uniacid']} AND mid = {$id} ORDER BY displayorder ASC");
	if($type == 'list'){
		$showhtml = htmlspecialchars_decode($moduleres['listhtml']);
		include $this->template('web/modulehtml');
	}
	if($type == 'detail'){
		$showhtml = htmlspecialchars_decode($moduleres['detailhtml']);
		include $this->template('web/modulehtml2');
	}
}elseif($operation == 'changehtml'){
	$id = intval($_GPC['id']);
	$type = trim($_GPC['type']);
	$htmlcon = trim($_GPC['htmlcon']);
	$module = pdo_fetch("SELECT * FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND id = {$id}");
	if(empty($module)){
		$resArr['error'] = 1;
		$resArr['message'] = '不存在需要修改的模型信息！';
		echo json_encode($resArr);
		exit;
	}
	if($type == 'list'){
		pdo_update(CHANNEL,array('listhtml'=>$htmlcon),array('id'=>$id));
	}
	if($type == 'detail'){
		pdo_update(CHANNEL,array('detailhtml'=>$htmlcon),array('id'=>$id));
	}
	$resArr['error'] = 0;
	$resArr['message'] = '更新成功！';
	echo json_encode($resArr);
	exit;
}elseif($operation == 'custom'){
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$enname = trim($_GPC['enname']);
		if(empty($enname)){
			$this->message("请输入字段英文名！");
		}
		$sysennamearr = array('area','createtime','nickname','id','weid','mid','avatar','province','city','district','lng','lat','views','status','module','isneedpay','haspay');
		if(in_array($enname,$sysennamearr)){
			$this->message("不能使用系统内置字段英文名称！");
		}
		$mid = intval($_GPC['mid']);
		$hasenname = pdo_fetch("SELECT id FROM ".tablename(FIELDS)." WHERE mid = {$mid} AND enname = '{$enname}'");
		if (empty($id)) {
			if(!empty($hasenname)){
				$this->message("该模型已经存在相同的字段！");
			}
		}else{
			$fieldsres = pdo_fetch("SELECT enname FROM ".tablename(FIELDS)." WHERE mid = {$mid} AND id = {$id}");
			if($fieldsres['enname'] != $enname){
				if(!empty($hasenname)){
					$this->message("该模型已经存在相同的字段！");
				}
			}
		}
		$islenval = intval($_GPC['islenval']);
		if($islenval == 1){
			$minlen = intval($_GPC['minlen']);
			$maxlen = intval($_GPC['maxlen']);
		}else{
			$minlen = $maxlen = 0;
		}
		$data = array(
			'weid' => $_W['uniacid'],
			'mid' => $mid,
			'name' => trim($_GPC['name']),
			'showname' => trim($_GPC['showname']),
			'enname' => $enname,
			'mtype' => trim($_GPC['mtype']),
			'mtypecon' => trim($_GPC['mtypecon']),
			'isrequired'=>intval($_GPC['isrequired']),
			'islenval'=>$islenval,
			'minlen'=>$minlen,
			'maxlen'=>$maxlen,
			'displayorder' => intval($_GPC['displayorder']),
			'defaultval' => trim($_GPC['defaultval']),
			'danwei' => trim($_GPC['danwei']),
			'sharetype' => intval($_GPC['sharetype']),
		);
		if (!empty($id)) {
			pdo_update(FIELDS, $data, array('id' => $id, 'weid' => $_W['uniacid']));
		} else {
			pdo_insert(FIELDS, $data);
		}
		$this->message('操作成功！', $this->createWebUrl('channel', array('op' => 'display')), 'success');
	}
}elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	$fid = intval($_GPC['fid']);
	if (!empty($id)) {
		$item = pdo_fetch("SELECT * FROM " . tablename(CHANNEL) . "  WHERE id = :id AND weid = :weid", array(':id' => $id, ':weid' => $_W['uniacid']));
	}else{
		$modulelist = pdo_fetchall("SELECT * FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND fid = 0 ORDER BY displayorder ASC");
		foreach($modulelist as $k=>$v){
			$modulelist[$k]['children'] = pdo_fetchall("SELECT id,name FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND fid = {$v['id']} ORDER BY displayorder ASC");
		}
	}
    $bg = util::decode_channel_param($item, $item['bgparam']);
	if (checksubmit('submit')) {
		$canrelease = intval($_GPC['canrelease']);
		if($canrelease == 1){
			$minscore = intval($_GPC['minscore']);
		}else{
			$minscore = 0;
		}
		$isneedpay = intval($_GPC['isneedpay']);
		if($isneedpay == 1){
			$needpay = $_GPC['needpay'];
		}else{
			$needpay = 0;
		}
        $bgparam =util:: encode_channel_param($_GPC);
		$data = array(
			'weid' => $_W['uniacid'],
			'name' => trim($_GPC['name']),
			'thumb' => $_GPC['thumb'],
			'displayorder' => intval($_GPC['displayorder']),
			'sharetitle' => trim($_GPC['sharetitle']),
			'sharethumb' => trim($_GPC['sharethumb']),
			'sharedes' => trim($_GPC['sharedes']),
			'canrelease' => $canrelease,
			'isshenhe' => intval($_GPC['isshenhe']),
			'iscang' => intval($_GPC['iscang']),
			'minscore' => $minscore,
			'isneedpay'=> $isneedpay,
			'needpay'=>$needpay,
			'autourl' => trim($_GPC['autourl']),
			//'listhtml' => trim($_GPC['listhtml']),
			//'detailhtml' => trim($_GPC['detailhtml']),
			'ison' => intval($_GPC['ison']),
            'defult_list' => intval($_GPC['defult_list']),
            'defult_detail' => intval($_GPC['defult_detail']),
			'zdprice'=>$_GPC['zdprice'],
            'haibaobg' => trim($_GPC['haibaobg']),
            'bgparam' =>$bgparam,
             'show_comment' => intval($_GPC['show_comment']),//1开启评论 2不开启
            'show_location' => intval($_GPC['show_location'])//1显示发布位置 2不显示

        );

		if (!empty($id)) {
			pdo_update(CHANNEL, $data, array('id' => $id, 'weid' => $_W['uniacid']));
		} else {
			$data['fid'] = intval($_GPC['fid']);
			pdo_insert(CHANNEL, $data);
			$mid = pdo_insertid();
			$fuzhi = $_GPC['fuzhi'];
			if(is_numeric($fuzhi)){
				$fieldarr = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE weid = {$_W['uniacid']} AND mid = {$fuzhi}");
				foreach($fieldarr as $k=>$v){
					$datafield = array(
						'weid' => $_W['uniacid'],
						'mid' => $mid,
						'name' => $v['name'],
						'showname' => $v['showname'],
						'enname' => $v['enname'],
						'mtype' => $v['mtype'],
						'mtypecon' => $v['mtypecon'],
						'isrequired'=>$v['isrequired'],
						'islenval'=>$v['islenval'],
						'minlen'=>$v['minlen'],
						'maxlen'=>$v['maxlen'],
						'displayorder' => $v['displayorder'],
						'defaultval' => $v['defaultval'],
						'danwei' => $v['danwei'],
						'sharetype' => $v['sharetype'],
					);
					pdo_insert(FIELDS, $datafield);
				}
				$fuzhimodulecenter = pdo_fetch("SELECT listhtml,detailhtml FROM " . tablename(CHANNEL) . " WHERE id = :id AND weid = :weid", array(':id' => $fuzhi, ':weid' => $_W['uniacid']));
				$datafuzhi = array(
					'listhtml' => $fuzhimodulecenter['listhtml'],
					'detailhtml' => $fuzhimodulecenter['detailhtml'],
				);
				pdo_update(CHANNEL, $datafuzhi, array('id' => $mid, 'weid' => $_W['uniacid']));
			}else{
				$fieldarr = neizhifield($fuzhi);
				foreach($fieldarr as $k=>$v){
					$datafield = array(
						'weid' => $_W['uniacid'],
						'mid' => $mid,
						'name' => $v[0],
						'showname' => $v[1],
						'enname' => $v[2],
						'mtype' => $v[3],
						'mtypecon' => $v[4],
						'isrequired'=>$v[5],
						'islenval'=>$v[6],
						'minlen'=>$v[7],
						'maxlen'=>$v[8],
						'displayorder' => $v[9],
						'defaultval' => $v[10],
						'danwei' => '',
						'sharetype' => $v[11],
					);
					pdo_insert(FIELDS, $datafield);
				}
			}
		}
		$this->message('操作成功！', $this->createWebUrl('channel', array('op' => 'display')), 'success');
	}
	include $this->template('web/channel');
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$modulecenter = pdo_fetch("SELECT id FROM " . tablename(CHANNEL) . " WHERE id = {$id}");
	if (empty($modulecenter)) {
		$this->message('抱歉，该模型信息不存在或是已经被删除！', $this->createWebUrl('channel', array('op' => 'display')), 'error');
	}
	pdo_delete(CHANNEL, array('id' => $id));
	pdo_delete(FIELDS, array('mid' => $id));
	
	$modulechildren = pdo_fetchall("SELECT id FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND fid = {$id}");
	if(!empty($modulechildren)){
		foreach($modulechildren as $k=>$v){
			pdo_delete(CHANNEL, array('id' => $v['id']));
			pdo_delete(FIELDS, array('mid' => $v['id']));
		}
	}
	$this->message('删除模型信息成功！', $this->createWebUrl('channel', array('op' => 'display')), 'success');
}elseif ($operation == 'deletefield') {
	$id = intval($_GPC['id']);
	$modulefield = pdo_fetch("SELECT id FROM " . tablename(FIELDS) . " WHERE id = {$id}");
	if (empty($modulefield)) {
		$this->message('抱歉，该自定义信息不存在或是已经被删除！', $this->createWebUrl('channel', array('op' => 'display')), 'error');
	}
	pdo_delete(FIELDS, array('id' => $id));
	$this->message('删除自定义信息信息成功！', $this->createWebUrl('channel', array('op' => 'display')), 'success');
}


function neizhifield($neizhi){
	if($neizhi == 'neizhi1'){
		return array(
			array('租房标题', '租房标题', 'title', 'text', '', 1, 1, 12, 120, 1, '', 1, 0),
			array('租金', '租金', 'price', 'number', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('房屋图片', '房屋图片', 'thumbs', 'images', '', 1, 0, 0, 0, 5, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 6, '', 0, 0),
			array('手机号码', '手机号码', 'shouji', 'telphone', '', 1, 0, 0, 0, 7, '', 0, 0),
			array('房屋描述', '房屋描述', 'des', 'longtext', '', 1, 0, 0, 0, 8, '', 2, 0),
			array('户型', '户型', 'huxing', 'radio', '三室两厅|三室一厅|两室一厅|一室户|其他', 1, 0, 0, 0, 9, '', 0, 1),
			array('面积', '面积', 'areas', 'text', '', 1, 0, 0, 0, 10, '', 0, 0),
			array('所在小区', '所在小区', 'xiaoqu', 'text', '', 1, 0, 0, 0, 11, '', 0, 0),
			array('楼层', '楼层', 'fllor', 'text', '', 1, 0, 0, 0, 13, '', 0, 0),
			array('总楼层', '总楼层', 'allfllor', 'text', '', 1, 0, 0, 0, 14, '', 0, 0),
			array('付款方式', '付款方式', 'paytype', 'radio', '押一付一|押一付二|押一付三|面议', 1, 0, 0, 0, 15, '押一付三', 0, 1),
			array('朝向', '朝向', 'chaoxiang', 'text', '', 1, 0, 0, 0, 16, '', 0, 0),
			array('装修', '装修', 'zhuangxiu', 'radio', '精装修|简单装修', 1, 0, 0, 0, 17, '', 0, 0),
			array('房屋配置', '房屋配置', 'peizhi', 'checkbox', '床|衣柜|沙发|电视', 1, 0, 0, 0, 19, '', 0, 0),
		);
	}
	if($neizhi == 'neizhi2'){
		return array(
			array('个人说明', '个人说明', 'jyxuqiu', 'longtext', '', 1, 0, 0, 0, 7, '', 2, 0),
			array('体重', '体重', 'weight', 'number', '', 1, 0, 0, 0, 6, '', 0, 0),
			array('身高', '身高', 'height', 'number', '', 1, 0, 0, 0, 5, '', 0, 0),
			array('标题', '标题', 'title', 'text', '', 1, 1, 10, 100, 1, '', 1, 0),
			array('年龄', '年龄', 'age', 'text', '', 1, 0, 0, 0, 4, '', 0, 0),
			array('个人照片', '个人照片', 'zhaopian', 'images', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 8, '', 0, 0),
			array('电话', '电话', 'dianhua', 'telphone', '', 1, 0, 0, 0, 9, '', 0, 0),
			array('性别', '性别', 'sex', 'radio', '男|女', 1, 0, 0, 0, 9, '', 0, 1),
		);
	}
	if($neizhi == 'neizhi3'){
		return array(
			array('职位名称', '职位名称', 'zwtitle', 'text', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('招聘标题', '招聘标题', 'title', 'text', '', 1, 1, 12, 120, 1, '', 0, 0),
			array('薪水范围', '薪水范围', 'xinshui', 'radio', '1000-3000元/月|3000-6000元/月|6000-10000元/月|10000-20000元/月|20000元/月以上', 1, 0, 0, 0, 4, '', 0, 1),
			array('招聘人数', '招聘人数', 'needpeople', 'number', '', 1, 0, 0, 0, 6, '', 0, 0),
			array('工作地点', '工作地点', 'workaddress', 'text', '', 1, 0, 0, 0, 7, '', 0, 0),
			array('职位简介', '职位简介', 'des', 'longtext', '', 1, 0, 0, 0, 8, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 9, '', 0, 0),
			array('手机号码', '手机号码', 'shouji', 'telphone', '', 1, 0, 0, 0, 10, '', 0, 0),
			array('福利', '福利', 'fuli', 'checkbox', '五险一金|交通补助|餐补|加班少|下午茶|周末双休|话补|房补|加班补助|年底双薪|包吃住|包住|包吃', 1, 0, 0, 0, 15, '', 0, 0),
			array('公司名称', '公司名称', 'companyname', 'text', '', 1, 1, 5, 100, 16, '', 0, 0),
			array('要求学历', '要求学历', 'xueli', 'radio', '高中|大专|本科|研究生', 1, 0, 0, 0, 17, '', 0, 1),
		);
	}
	if($neizhi == 'neizhi4'){
		return array(
			array('二手物品标题', '二手物品标题', 'title', 'text', '', 1, 1, 12, 120, 1, '', 1, 0),
			array('二手物品图片', '二手物品图片', 'thumbs', 'images', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('价格', '价格', 'price', 'radio', '100元以下|100元以上', 1, 0, 0, 0, 3, '', 0, 1),
			array('原价', '原价', 'yuanjia', 'text', '', 1, 0, 0, 0, 4, '', 0, 0),
			array('详细描述', '详细描述', 'des', 'longtext', '', 1, 0, 0, 0, 5, '', 2, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 8, '', 0, 0),
			array('手机号码', '手机号码', 'shouji', 'telphone', '', 1, 0, 0, 0, 9, '', 0, 0),
			array('交易类型', '交易类型', 'type', 'radio', '个人|商家', 1, 0, 0, 0, 3, '', 0, 1),
		);
	}
	if($neizhi == 'neizhi5'){
		return array(
			array('标题', '标题', 'title', 'text', '', 1, 1, 12, 120, 1, '', 0, 0),
			array('期望职位', '期望职位', 'qiwangzw', 'text', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('期望工资', '期望工资', 'price', 'text', '', 1, 0, 0, 0, 4, '', 0, 0),
			array('学历', '学历', 'xueli', 'radio', '小学|初中|高中|中专|大专|本科|研究生|博士|博士以上', 1, 0, 0, 0, 9, '', 0, 1),
			array('工作地点', '工作地点', 'workaddress', 'text', '', 1, 0, 0, 0, 5, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 7, '', 0, 0),
			array('手机号码', '手机号码', 'shouji', 'telphone', '', 1, 0, 0, 0, 8, '', 0, 0),
			array('性别', '性别', 'sex', 'radio', '男|女', 1, 0, 0, 0, 11, '男', 0, 1),
			array('工作年限', '工作年限', 'gzyear', 'text', '', 1, 0, 0, 0, 10, '', 0, 0),
			array('自我评价', '自我评价', 'pingjia', 'longtext', '', 1, 0, 0, 0, 12, '', 0, 0),
			array('年龄', '年龄', 'age', 'number', '', 1, 0, 0, 0, 13, '', 0, 0),
		);
	}
	if($neizhi == 'neizhi6'){
		return array(
			array('拼车标题', '拼车标题', 'title', 'text', '', 1, 1, 12, 120, 1, '', 1, 0),
			array('费用', '费用', 'price', 'text', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('车辆照片', '车辆照片', 'thumbs', 'images', '', 1, 0, 0, 0, 4, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 5, '', 0, 0),
			array('手机号码', '手机号码', 'shouji', 'telphone', '', 1, 0, 0, 0, 6, '', 0, 0),
			array('详细描述', '详细描述', 'des', 'longtext', '', 1, 0, 0, 0, 7, '', 2, 0),
			array('出发地点', '出发地点', 'cfcity', 'text', '', 1, 0, 0, 0, 8, '', 0, 0),
			array('目的地', '目的地', 'ddcity', 'text', '', 1, 0, 0, 0, 9, '', 0, 0),
			array('出行时间', '出行时间', 'gotime', 'datetime', '', 1, 0, 0, 0, 13, '', 0, 0),
			array('座位数', '座位数', 'weizi', 'number', '', 1, 0, 0, 0, 14, '', 0, 0),
			array('拼车类型', '拼车类型', 'type', 'radio', '人找车|车找人', 1, 0, 0, 0, 14, '', 0, 1),
		);
	}
	if($neizhi == 'neizhi7'){
		return array(
			array('照片', '照片', 'tupian', 'images', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 9, '', 0, 0),
			array('电话', '电话', 'dianhua', 'telphone', '', 1, 0, 0, 0, 10, '', 0, 0),
			array('标题', '标题', 'title', 'text', '', 1, 1, 10, 90, 1, '', 1, 0),
			array('类型', '类型', 'type', 'radio', '寻人|寻物|寻宠物', 1, 0, 0, 0, 0, '', 0, 1),
			array('描述', '描述', 'des', 'longtext', '', 1, 0, 0, 0, 0, '', 2, 0),
		);
	}
	if($neizhi == 'neizhi8'){
		return array(
			array('活动标题', '活动标题', 'title', 'text', '', 1, 1, 10, 100, 1, '', 1, 0),
			array('图片', '图片', 'tupian', 'images', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('活动时间', '活动时间', 'huodongtime', 'datetime', '', 1, 0, 0, 0, 3, '', 0, 0),
			array('活动地点', '活动地点', 'huodongaddress', 'text', '', 1, 0, 0, 0, 4, '', 0, 0),
			array('活动费用', '活动费用', 'feiyong', 'text', '', 1, 0, 0, 0, 5, '', 0, 0),
			array('活动介绍', '活动介绍', 'des', 'longtext', '', 1, 0, 0, 0, 6, '', 2, 0),
			array('活动类型', '活动类型', 'type', 'radio', '看演唱会|看电影|户外旅游', 1, 0, 0, 0, 6, '', 0, 1),
		);
	}
	if($neizhi == 'neizhi10'){
		return array(
			array('标题', '标题', 'title', 'text', '', 1, 1, 10, 100, 1, '', 1, 0),
			array('商家地址', '商家地址', 'address', 'text', '', 1, 0, 0, 0, 2, '', 0, 0),
			array('详情说明', '详情说明', 'detailmsg', 'longtext', '', 1, 0, 0, 0, 5, '', 2, 0),
			array('价格', '价格', 'price', 'text', '', 1, 0, 0, 0, 6, '', 0, 0),
			array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 7, '', 0, 0),
			array('联系手机', '联系手机', 'shouji', 'telphone', '', 1, 0, 0, 0, 8, '', 0, 0),
			array('服务类型', '服务类型', 'type', 'radio', '生活服务|其他', 1, 0, 0, 0, 9, '', 0, 1),
			array('服务区域', '服务区域', 'servicearea', 'text', '', 1, 0, 0, 0, 10, '', 0, 0),
		);
	}
    if($neizhi == 'neizhi11'){
        return array(
            array('标题', '标题', 'title', 'text', '', 1, 1, 10, 100, 1, '', 1, 0),
            array('图片', '图片', 'tupian', 'images', '', 1, 0, 0, 0, 2, '', 0, 0),
            array('品种', '品种', 'pinzhong', 'radio', '泰迪|金毛|比熊|萨摩耶|阿拉斯加|博美|哈士奇|拉布拉多|德国牧羊犬|松狮|秋田犬|吉娃娃|藏獒|雪纳瑞|贵宾|边境牧羊犬|巴哥犬|古牧|罗威纳|银狐犬|杜宾犬|京巴|比特|苏格兰牧羊犬|高加索犬|灵缇犬|西高地|马犬|喜乐蒂|牛头梗|雪橇犬|西施犬|大白熊|卡斯罗|沙皮犬|蝴蝶犬|伯恩山犬|斗牛犬|万能梗|小鹿犬|猎狐梗|威玛烈犬|柴犬|斑点狗|巴吉度猎犬|阿富汗猎犬|格力犬|比格犬|大丹犬|腊肠犬|可卡犬|柯基犬|圣伯纳|其他', 1, 0, 0, 0, 9, '', 0, 1),
            array('描述', '描述', 'detailmsg', 'longtext', '', 1, 0, 0, 0, 5, '', 2, 0),
            array('价格', '价格', 'price', 'text', '', 1, 0, 0, 0, 6, '', 0, 0),
            array('联系人', '联系人', 'lianxiren', 'text', '', 1, 0, 0, 0, 7, '', 0, 0),
            array('联系手机', '联系手机', 'shouji', 'telphone', '', 1, 0, 0, 0, 8, '', 0, 0),
            array('所在区域', '所在区域', 'servicearea', 'text', '', 1, 0, 0, 0, 10, '', 0, 0),
        );
    }
}
exit;
?>