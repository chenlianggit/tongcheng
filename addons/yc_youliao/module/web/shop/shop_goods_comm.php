<?php
global $_GPC, $_W;
$op = isset($_GPC['op'])?$_GPC['op']:'display';
$cfg   		 = $this->module['config'];
$shop_id=getShop_id();
$pindex    = $this->getWebPage();
$psize     = $this->getWebNum();
if($op == 'display'){
    $isweb='1';
    $where['uniacid'] = $_W['uniacid'];
    $where['shop_id'] = $shop_id;
    //$where['status'] = 0;
    $order=' `orderby` ';
    $by = ' DESC ';
    if($_GPC['status'] === '0') $where['status'] = 0;
    if($_GPC['status'] == '1') $where['status'] = 1;
    if(!empty($_GPC['orderby'])) $order = htmlspecialchars($_GPC['orderby']);
    if (!empty($_GPC['keyword'])) {
        $where['title@'] = htmlspecialchars($_GPC['keyword']);
    }
    if (!empty($_GPC['is_hot'])) {
        $cid = intval($_GPC['is_hot']);
        $where['is_hot'] = $cid;
    }

    if (!empty($_GPC['is_time'])) {
        $cid = intval($_GPC['is_time']);
        $where['is_time'] = $cid;
    }
    if (!empty($_GPC['is_group'])) {
        $cid = intval($_GPC['is_group']);
        $where['is_group'] = $cid;
    }
    $info = Goods::getAllGood($where,$pindex,$psize ,$order.$by);
    $list = $info[0];
    $pager = $info[1];
}elseif($op == 'post'){
    $id = intval($_GPC['id']);
    if($id>0 && $shop_id>0){
        $item =Goods::getSingleGood($id,$shop_id);
    }
    $category = Goods::getcate($shop_id);
    $timelist = webCommon::getTimelist();
    $allspecs = pdo_fetchall("select * from " . tablename(SPEC) . " where goodsid=:id order by displayorder asc", array(":id" => $id));
    foreach ($allspecs as &$s) {
        $s['items'] = pdo_fetchall("select * from " . tablename(S_ITEM) . " where specid=:specid order by displayorder asc", array(":specid" => $s['id']));
    }

    unset($s);

    $piclist = unserialize($item['thumb_url']);
    $html = "";
    $options = pdo_fetchall("select * from " . tablename(OPTION) . " where goodsid=:id order by id asc", array(':id' => $id));
    $specs = array();
    $piclist1 = unserialize($item['thumb_url']);
    $piclist = array();
    if (is_array($piclist1)) {
        foreach ($piclist1 as $p) {
            $piclist[] = is_array($p) ? $p['attachment'] : $p;
        }
    }

    if (count($options) > 0) {
        $specitemids = explode("_", $options[0]['specs']);
        foreach ($specitemids as $itemid) {
            foreach ($allspecs as $ss) {
                $items = $ss['items'];
                foreach ($items as $it) {
                    if ($it['id'] == $itemid) {
                        $specs[] = $ss;
                        break;
                    }
                }
            }
        }
        $html = '<table  class="tb spectable" style="border:1px solid #ccc;"><thead><tr>';
        $len = count($specs);
        $newlen = 1;
        $h = array();
        $rowspans = array();
        for ($i = 0; $i < $len; $i++) {
            $html .= "<th>" . $specs[$i]['title'] . "</th>";
            $itemlen = count($specs[$i]['items']);
            if ($itemlen <= 0) {
                $itemlen = 1;
            }
            $newlen *= $itemlen;
            $h = array();
            for ($j = 0; $j < $newlen; $j++) {
                $h[$i][$j] = array();
            }
            $l = count($specs[$i]['items']);
            $rowspans[$i] = 1;
            for ($j = $i + 1; $j < $len; $j++) {
                $rowspans[$i] *= count($specs[$j]['items']);
            }
        }


        $html .= '<th class="info" style="width:130px;" ><div class=""><div class="input-append input-prepend"><span class="add-on">库存</span><input type="text" class="span1 option_stock_all"  VALUE=""/><span class="add-on"><a href="javascript:;" class="icon-hand-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></th>';
        $html .= '<th class="success" style="width:150px;"><div class=""><div class="input-append input-prepend"><span class="add-on">销售价格</span><input type="text" class="span1 option_marketprice_all"  VALUE=""/><span class="add-on"><a href="javascript:;" class="icon-hand-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div><br/></th>';
        $html .= '<th class="warning" style="width:150px;"><div class=""><div class="input-append input-prepend"><span class="add-on">市场价格</span><input type="text" class="span1 option_productprice_all"  VALUE=""/><span class="add-on"><a href="javascript:;" class="icon-hand-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></th>';
        $html .= '<th class="danger" style="width:150px;"><div class=""><div class="input-append input-prepend"><span class="add-on">团购价格</span><input type="text" class="span1 option_groupprice_all"  VALUE=""/><span class="add-on"><a href="javascript:;" class="icon-hand-down" title="批量设置" onclick="setCol(\'option_groupprice\');"></a></span></div></th>';
        $html .= '<th class="success" style="width:150px;"><div class=""><div class="input-append input-prepend"><span class="add-on">秒杀价格</span><input type="text" class="span1 option_weight_all"  VALUE=""/><span class="add-on"><a href="javascript:;" class="icon-hand-down" title="批量设置" onclick="setCol(\'option_time_money\');"></a></span></div></th>';

        $html .= '</tr>';
        for ($m = 0; $m < $len; $m++) {
            $k = 0;
            $kid = 0;
            $n = 0;
            for ($j = 0; $j < $newlen; $j++) {
                $rowspan = $rowspans[$m];
                if ($j % $rowspan == 0) {
                    $h[$m][$j] = array("html" => "<td rowspan='" . $rowspan . "'>" . $specs[$m]['items'][$kid]['title'] . "</td>", "id" => $specs[$m]['items'][$kid]['id']);
                } else {
                    $h[$m][$j] = array("html" => "", "id" => $specs[$m]['items'][$kid]['id']);
                }
                $n++;
                if ($n == $rowspan) {
                    $kid++;
                    if ($kid > count($specs[$m]['items']) - 1) {
                        $kid = 0;
                    }
                    $n = 0;
                }
            }
        }
        $hh = "";
        for ($i = 0; $i < $newlen; $i++) {
            $hh .= "<tr>";
            $ids = array();
            for ($j = 0; $j < $len; $j++) {
                $hh .= $h[$j][$i]['html'];
                $ids[] = $h[$j][$i]['id'];
            }
            $ids = implode("_", $ids);
            $val = array("id" => "", "title" => "",   "stock" => "","groupprice" => "", "productprice" => "", "marketprice" => "", "time_money" => "");
            foreach ($options as $o) {
                if ($ids === $o['specs']) {
                    $val = array("id" => $o['id'], "title" => $o['title'], "stock" => $o['stock'], "groupprice" => $o['groupprice'], "productprice" => $o['productprice'], "marketprice" => $o['marketprice'], "time_money" => $o['time_money']);
                    break;
                }
            }
            $hh .= '<td>';
            $hh .= '<input name="option_stock_' . $ids . '[]"  type="text" class="span1 option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/></td>';
            $hh .= '<input name="option_id_' . $ids . '[]"  type="hidden" class="span1 option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
            $hh .= '<input name="option_ids[]"  type="hidden" class="span1 option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
            $hh .= '<input name="option_title_' . $ids . '[]"  type="hidden" class="span1 option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
            $hh .= '</td>';
            $hh .= '<td><input name="option_marketprice_' . $ids . '[]" type="text" class="span1 option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
            $hh .= '<td><input name="option_productprice_' . $ids . '[]" type="text" class="span1 option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
            $hh .= '<td><input name="option_groupprice_' . $ids . '[]" type="text" class="span1 option_groupprice option_groupprice_' . $ids . '" " value="' . $val['groupprice'] . '"/></td>';
            $hh .= '<td><input name="option_time_money_' . $ids . '[]" type="text" class="span1 option_time_money option_time_money_' . $ids . '" " value="' . $val['time_money'] . '"/></td>';
            $hh .= "</tr>";
        }
        $html .= $hh;
        $html .= "</table>";
    }
    $stores = array();



    //提交数据
    if (checksubmit('submit')) {

        $result=goods::postData($shop_id);
        $result1=intval($result);
        if($result1==0){
            $this->message($result);
        }else{
            $id=$result;
        }

        if($result=='error'){
            $this->message($result);
        }else{
            $id=intval($result);
        }
        $totalstocks = 0;
        $param_ids = $_POST['param_id'];
        $param_titles = $_POST['param_title'];
        $param_values = $_POST['param_value'];
        $param_displayorders = $_POST['param_displayorder'];
        $len = count($param_ids);
        $paramids = array();
        for ($k = 0; $k < $len; $k++) {
            $param_id = "";
            $get_param_id = $param_ids[$k];
            $a = array("uniacid" => $_W['uniacid'], "title" => $param_titles[$k], "value" => $param_values[$k], "displayorder" => $k, "goodsid" => $id,);
            if (!is_numeric($get_param_id)) {
                pdo_insert(PARAM, $a);
                $param_id = pdo_insertid();
            } else {
                pdo_update(PARAM, $a, array('id' => $get_param_id));
                $param_id = $get_param_id;
            }
            $paramids[] = $param_id;
        }
        if (count($paramids) > 0) {
            pdo_query("delete from " . tablename(PARAM) . " where goodsid=$id and id not in ( " . implode(',', $paramids) . ")");
        } else {
            pdo_query("delete from " . tablename(PARAM) . " where goodsid=$id");
        }
        $files = $_FILES;
        $spec_ids = $_POST['spec_id'];
        $spec_titles = $_POST['spec_title'];
        $specids = array();
        $len = count($spec_ids);
        $specids = array();
        $spec_items = array();
        for ($k = 0; $k < $len; $k++) {
            $spec_id = "";
            $get_spec_id = $spec_ids[$k];
            $a = array("uniacid" => $_W['uniacid'], "goodsid" => $id, "displayorder" => $k, "title" => $spec_titles[$get_spec_id]);
            if (is_numeric($get_spec_id)) {
                pdo_update(SPEC, $a, array("id" => $get_spec_id));
                $spec_id = $get_spec_id;
            } else {
                pdo_insert(SPEC, $a);
                $spec_id = pdo_insertid();
            }
            $spec_item_ids = $_POST["spec_item_id_" . $get_spec_id];
            $spec_item_titles = $_POST["spec_item_title_" . $get_spec_id];
            $spec_item_shows = $_POST["spec_item_show_" . $get_spec_id];
            $spec_item_thumbs = $_POST["spec_item_thumb_" . $get_spec_id];
            $spec_item_oldthumbs = $_POST["spec_item_oldthumb_" . $get_spec_id];
            $itemlen = count($spec_item_ids);
            $itemids = array();
            for ($n = 0; $n < $itemlen; $n++) {
                $item_id = "";
                $get_item_id = $spec_item_ids[$n];
                $d = array(
                    "uniacid" => $_W['uniacid'],
                    "specid" => $spec_id,
                    "displayorder" => $n,
                    "title" => $spec_item_titles[$n],
                    "show" => $spec_item_shows[$n],
                    "thumb" => $spec_item_thumbs[$n]
                );
                $f = "spec_item_thumb_" . $get_item_id;
                $old = $spec_item_oldthumbs[$k];
                $f = "spec_item_thumb_" . $get_item_id;
                if (is_numeric($get_item_id)) {
                    pdo_update(S_ITEM, $d, array("id" => $get_item_id));
                    $item_id = $get_item_id;
                } else {
                    pdo_insert(S_ITEM, $d);
                    $item_id = pdo_insertid();
                }
                $itemids[] = $item_id;
                $d['get_id'] = $get_item_id;
                $d['id'] = $item_id;
                $spec_items[] = $d;
            }
            if (count($itemids) > 0) {
                pdo_query("delete from " . tablename(S_ITEM) . " where uniacid={$_W['uniacid']} and specid=$spec_id and id not in (" . implode(",", $itemids) . ")");
            } else {
                pdo_query("delete from " . tablename(S_ITEM) . " where uniacid={$_W['uniacid']} and specid=$spec_id");
            }
            pdo_update(SPEC, array("content" => serialize($itemids)), array("id" => $spec_id));
            $specids[] = $spec_id;
        }
        if (count($specids) > 0) {
            pdo_query("delete from " . tablename(SPEC) . " where uniacid={$_W['uniacid']} and goodsid=$id and id not in (" . implode(",", $specids) . ")");
        } else {
            pdo_query("delete from " . tablename(SPEC) . " where uniacid={$_W['uniacid']} and goodsid=$id");
        }
        $option_idss = $_POST['option_ids'];
        $option_productprices = $_POST['option_productprice'];
        $option_marketprices = $_POST['option_marketprice'];
        $option_groupprice = $_POST['option_groupprice'];
        $option_stocks = $_POST['option_stock'];
        $option_time_money = $_POST['option_time_money'];
        $len = count($option_idss);
        $optionids = array();
        for ($k = 0; $k < $len; $k++) {
            $option_id = "";
            $get_option_id = $_GPC['option_id_' . $ids][0];
            $ids = $option_idss[$k];
            $idsarr = explode("_", $ids);
            $newids = array();
            foreach ($idsarr as $key => $ida) {
                foreach ($spec_items as $it) {
                    if ($it['get_id'] == $ida) {
                        $newids[] = $it['id'];
                        break;
                    }
                }
            }
            $newids = implode("_", $newids);
            $a = array("title" => $_GPC['option_title_' . $ids][0], "productprice" => $_GPC['option_productprice_' . $ids][0], "groupprice" => $_GPC['option_groupprice_' . $ids][0], "marketprice" => $_GPC['option_marketprice_' . $ids][0], "stock" => $_GPC['option_stock_' . $ids][0], "time_money" => $_GPC['option_time_money_' . $ids][0], "goodsid" => $id, "specs" => $newids,"uniacid" => $_W['uniacid']);
            $totalstocks += $a['stock'];
            if (empty($get_option_id)) {
                pdo_insert(OPTION, $a);
                $option_id = pdo_insertid();
            } else {
                pdo_update(OPTION, $a, array('id' => $get_option_id));
                $option_id = $get_option_id;
            }
            $optionids[] = $option_id;
        }
        if (count($optionids) > 0) {
            pdo_query("delete from " . tablename(OPTION) . " where goodsid=$id and id not in ( " . implode(',', $optionids) . ")");
        } else {
            pdo_query("delete from " . tablename(OPTION) . " where goodsid=$id");
        }

        $this->message('商品更新成功！', $this->createWebUrl('shop_goods', array('op' => 'display')), 'success');
    }


}elseif($op == 'delete'){
    $res =webCommon::deleteGood($_GPC['id'],$shop_id);
    if($res) message('操作成功',referer(),'success');
}elseif(checksubmit('upgood')) {
    Goods::changeStatus($_GPC['checkid'], 'up',$shop_id);
}elseif(checksubmit('downgood')){
    Goods::changeStatus($_GPC['checkid'],'down',$shop_id);
//批量排序
}elseif(checksubmit('suborder')){
    Goods::orderData($_GPC['orderby'],GOODS,$shop_id);
    $this->message('排序更新成功！',referer(), 'success');
}