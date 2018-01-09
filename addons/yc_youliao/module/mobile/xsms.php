<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title'].'限时秒杀专场';
$userinfo = Member::initUserInfo(); //用户信息
$adv_type=5;//1首页，4拼团，5秒杀，6首单，7买单，8同城
$time = time();
$today = strtotime(date('Y-m-d', time())); // 今日
$mody = $today + 24 * 60 * 60; // 次日
$joinCity=$this->joinCity();
$codition =$this->getcookieCity();
$stage = empty($_GPC['stage']) ? 0 : $_GPC['stage'];
if($op=='display') {
//查询当天所有参加秒杀的商品的场次
    //查询哪些商品参与了秒杀

    $goods = pdo_fetchall(" SELECT distinct(g.time_id) FROM " . tablename(GOODS) ." g {$joinCity} WHERE g.uniacid =:uniacid  AND g.status=0  AND g.is_time=1 AND g.time_num>0 AND g.datestart <=:today AND  g.datestart < :mody AND  g.dateend >= :today and g.time_num>0 " , array(':uniacid' => $_W['uniacid'], ':today' => $today, ':mody' => $mody));

    //秒杀场次信息
    $stage_list= array();
    foreach ( $goods as   $v) {
        $time_list = pdo_fetch(" SELECT time_id,timestart,timeend FROM " . tablename(MSTIME) ." WHERE uniacid =:uniacid  AND time_id=:time_id ", array(':uniacid' => $_W['uniacid'],':time_id' =>$v['time_id']));
        $stage_list[]=$time_list;
    }

    //将符合条件的场次信息根据开始时间排序
    foreach($stage_list as $arr2){
        $flag[]=$arr2["timestart"];
    }
    array_multisort($flag, SORT_ASC, $stage_list);
    $xsms= array();
//处理场次信息 显示当前秒杀中的场次 及以后的场次信息 不足五场显示第二天的场次信息
    $nowhour=date("H",time());
    foreach ($stage_list as $k => $v) {
        $timestart =$v['timestart']; //场次开始时间
        $timeend = $v['timeend']; //场次结束时间

        if ($nowhour >= $timestart) {
            if ($nowhour >= $timeend) {
                $id = $v['time_id'];
                $v['first_status'] = 2;  //已结束
            } else {
                $v['first_status'] = 1; //秒杀中
                $id = $v['time_id'];
                $stage = $k;

                $current_status = 1;
            }
        } else {
            $v['first_status'] = 0; // 待秒杀
        }

        if ($timeend >=$nowhour ) { //秒杀结束时间大于当前时间 在该场次之后的都显示
            $xsms[] = $v;
        }

    }

//场次id 默认为当前正在秒杀场次
    if(empty($_GPC['id'])){
        foreach($xsms as $k => $v){
            if($v['first_status'] == 1){
                $id = $v['time_id'];
                $stage = $k;
                $current_status = 1;
                break;
            }


        }
        if(empty($id)){
            foreach($xsms as $k => $v){
                if($v['first_status'] == 0){
                    $id = $v['time_id'];
                    $stage = $k;
                    $current_status = 0;
                    break;
                }
            }
        }
    }else {
        $id = $_GPC['id'];
        $stage = empty($_GPC['stage']) ? 0 : $_GPC['stage'];
        $current_status = $xsms[$stage]['first_status'];
    }



}else if ($op == 'show_ajax') {
    $id =  intval($_GPC['id']); //场次
    $page =$this->getPage();
    $num = $this->getNum(); //每次取值的个数
    $xs=commonGetData::getmiaosha($id,$page,$num,$joinCity,$codition,$today,$mody);

    $xsms= array();
    $nowhour=date("H",time());
    foreach ($xs as $k => $v) {
        $timestart =$v['timestart']; //场次开始时间
        $timeend = $v['timeend']; //场次结束时间

        if ($nowhour >= $timestart) {
            if ($nowhour >= $timeend) {
                $id = $v['time_id'];
                $v['first_status'] = 2;  //已结束
            } else {
                $v['first_status'] = 1; //秒杀中
                $id = $v['time_id'];
                $stage = $k;
                $current_status = 1;
            }
        } else {
            $v['first_status'] = 0; // 待秒杀
        }

        $xsms[]=$v;
    }

    echo json_encode($xsms);
    exit;

}

include $this->template('../mobile/xsms');
exit();