<?php
global $_GPC,$_W;
$title='模板消息';
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op=="tpllist" || $op=="display"){
    $list = pdo_fetchall('SELECT * FROM ' . tablename(TPL) . " WHERE uniacid = {$_W['uniacid']} ORDER BY id ASC");
}elseif($op=="create"){
    $tplbh = trim($_GPC['tplbh']);
    $tpl_title= trim($_GPC['tpl_title']);
    $istplbh = pdo_fetch('SELECT * FROM ' . tablename(TPL) . " WHERE uniacid = {$_W['uniacid']} AND tplbh = '{$tplbh}'");
if (!empty($istplbh)) {
$this->message('您已添加该模板消息！', $this->createWebUrl('tpl'), 'error');
} else {
    $account_api = WeAccount::create();
    $token = $account_api->getAccessToken();
    if (is_error($token)) {
    $this->message('获取access token 失败');
    }
    $postdata = array('template_id_short' => $tplbh);
    $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={$token}";
    $response = ihttp_request($url, urldecode(json_encode($postdata)));
    $errarr = json_decode($response['content'], true);

    if ($errarr['errcode'] == 0) {
        $data = array('tplbh' => $tplbh, 'tpl_id' => $errarr['template_id'],'tpl_title' => $tpl_title, 'uniacid' => $_W['uniacid']);
        pdo_insert(TPL, $data);
        $this->message('添加模板消息成功！', $this->createWebUrl('tpl'), 'success');
        return;
    } else {
        $this->message($errarr['errmsg'], $this->createWebUrl('tpl'), 'error');
    }

    }
}elseif ($op=="delete"){
    $tplid = trim($_GPC['tplid']);
    $istplbh = pdo_fetch('SELECT * FROM ' . tablename(TPL) . " WHERE uniacid = {$_W['uniacid']} AND tpl_id = '{$tpl_id}'");
    if (!empty($istplbh)) {
        $this->message('没有该模板消息！', $this->createWebUrl('tpl'), 'error');
    } else {
//        if (empty($istplbh['tpl_key'])) {
//            $this->message('该该模板消息没有同步，不能删除！', $this->createWebUrl('tpl'), 'error');
//        }
        $account_api = WeAccount::create();
        $token = $account_api->getAccessToken();
        if (is_error($token)) {
            $this->message('获取access token 失败');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token={$token}";
        $postjson = '{"template_id":"' . $tplid . '"}';
        $response = ihttp_request($url, $postjson);
        $errarr = json_decode($response['content'], true);
        if ($errarr['errcode'] == 0) {
            pdo_delete(TPL, array('tpl_id' => $tplid));
            $this->message('删除模板消息成功！', $this->createWebUrl('tpl'), 'success');
            return;
        } else {
            $this->message($errarr['errmsg'], $this->createWebUrl('tpl'), 'error');
        }
    }
}elseif ($op=="manual"){
    $tplbh = trim($_GPC['tplbh']);
    $tpl_id = trim($_GPC['tpl_id']);
    $tpl_title = trim($_GPC['tpl_title']);
    $tplbh = trim($_GPC['tplbh']);
    $tpl_title= trim($_GPC['tpl_title']);
    $istplbh = pdo_fetch('SELECT * FROM ' . tablename(TPL) . " WHERE uniacid = {$_W['uniacid']} AND tplbh = '{$tplbh}'");
    if (!empty($istplbh)) {
        echo json_encode(array('status' => '0', 'str' => '您已添加'.$tpl_title));
        exit;
    } else {
        if (empty($tplbh) || empty($tpl_id) || empty($tpl_title)) {
            echo json_encode(array('status' => '0', 'str' => '添加失败'));
            exit;
        }
        $data = array('tplbh' => $tplbh, 'tpl_id' => $tpl_id, 'tpl_title' => $tpl_title, 'uniacid' => $_W['uniacid']);
        $resullt = pdo_insert(TPL, $data);
        if ($resullt) {
            echo json_encode(array('status' => '1', 'str' => '添加成功'));
            exit;
        }
    }
} elseif ($op=="update"){
    $success = 0;
    $account_api = WeAccount::create();
    $token = $account_api->getAccessToken();
    if (is_error($token)) {
        $this->message('获取access token 失败');
    }
    $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={$token}";
    $response = ihttp_request($url, urldecode(json_encode($data)));
    if (is_error($response)) {
        return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
    }
    $list = json_decode($response['content'], true);
    if (empty($list['template_list'])) {
        $this->message('访问公众平台接口失败, 错误: 模板列表返回为空');
    }
    foreach ($list['template_list'] as $k => $v) {
        $template_id = $v['template_id'];
        $data['tpl_title'] = $v['title'];
        preg_match_all('/{{(.*?)\\.DATA}}/', $v['content'], $key);
        preg_match_all('/}}\\n*(.*?){{/', $v['content'], $title);
        $keys = $this->formatTplKey($key[1], $title[1]);
        $data['tpl_key'] = serialize($keys);
        $data['tpl_example'] = $v['example'];
        pdo_update(TPL, $data, array('tpl_id' => $template_id));
    }
    $this->message('更新完闭！', $this->createWebUrl('tpl'), 'success');



}

include $this->template('web/tpl');
exit();