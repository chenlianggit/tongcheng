<?php

/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2017/11/2
 * Time: 10:05
 */

class Redpackage
{
    static function getRedpackage($pageStart,$num,$condition){
        //获取指定状态的福利红包列表
        global $_W;
        $list = pdo_fetchall("SELECT r.*,u.avatar,u.nickname FROM " . tablename(REDPACKAGE) . " r  left join ". tablename(MEMBER) . "  u on r.openid=u.openid  and r.uniacid = u.uniacid WHERE  {$condition} and  r.uniacid=".$_W['uniacid']."  ORDER BY  red_id desc  limit {$pageStart},{$num}  ");

        return $list;
    }
    static function getRedpackageRecords($condition){
        //获取指定状态的福利红包列表
        global $_W;
        $list = pdo_fetchall("SELECT r.*,u.avatar,u.nickname FROM " . tablename(GETREDPACKAGE) . " r  left join ". tablename(MEMBER) . "  u on r.openid=u.openid  and r.uniacid = u.uniacid WHERE  {$condition} and  r.uniacid=".$_W['uniacid']."  ORDER BY r.create_time");
        return $list;
    }

    public function getShangRecordList($openid,$pageIndex,$num)
    {
        global $_W;
        $list = pdo_fetchall("select * from  " .tablename(CASH). " where cash_type >=2 and status=1 and uniacid=" . $_W['uniacid'] . " and openid ='" . $openid."' order by cash_id desc limit {$pageIndex},{$num}");
        foreach ($list as $k => $v) {
                    //收到打赏
                    $list[$k]['type'] = 3;
                    $userinfo = Member::getMemberByopenid($v['from_openid']);
                    $list[$k]['avatar'] = $userinfo['avatar'];
                    $list[$k]['nickname'] = $userinfo['nickname'];
            }
        return $list;
    }

    public function sendShangRecordList($openid,$pageIndex,$num)
    {
        global $_W;
        $list = pdo_fetchall("select * from  " .tablename(CASH) . " where cash_type >=2 and status=1 and uniacid=" . $_W['uniacid'] . " and from_openid ='" . $openid."' order by cash_id desc limit {$pageIndex},{$num} " );
        foreach ($list as $k => $v) {
                //发出打赏
                $list[$k]['type'] = 2;
                $userinfo = Member::getMemberByopenid($v['openid']);
                $list[$k]['avatar'] = $userinfo['avatar'];
                $list[$k]['nickname'] = $userinfo['nickname'];
        }
        return $list;
    }

    public function getRedpackageRecordList($openid,$pageIndex,$num)
    {
        global $_W;
        $list = pdo_fetchall("select * from  " . tablename(CASH) . " where cash_type= 1 and uniacid=" . $_W['uniacid'] . " and openid ='" . $openid."' order by cash_id desc limit {$pageIndex},{$num}  ");
        foreach ($list as $k => $v) {
            //抢到的红包
            $list[$k]['type'] = 1;
            $userinfo = Member::getMemberByopenid($v['from_openid']);
            $list[$k]['avatar'] = $userinfo['avatar'];
            $list[$k]['nickname'] = $userinfo['nickname'];
        }
        return $list;
    }

    public function sendRedpackageRecordList($openid,$pageIndex,$num)
    {
        global $_W;
        $list = pdo_fetchall("select * from  " . tablename(REDPACKAGE) . " where  status=1 and uniacid=" . $_W['uniacid'] . " and openid ='" . $openid."' order by red_id desc limit {$pageIndex},{$num}");
        foreach ($list as $k => $v) {
            //抢到的红包
            $list[$k]['type'] = 1;
            $userinfo = Member::getMemberByopenid($v['openid']);
            $list[$k]['avatar'] = $userinfo['avatar'];
            $list[$k]['nickname'] = $userinfo['nickname'];
            $list[$k]['amount'] =  $list[$k]['total_amount'];
        }
        return $list;
    }

    public function getRingRed_recordList($id,$type)//type 2圈子 3信息
    {
        global $_W;
        $list = pdo_fetchall("select * from  " . tablename(CASH) . " where cash_type= {$type} and uniacid=" . $_W['uniacid'] . " and type_id={$id} and status=1 order by cash_id desc  ");
        foreach ($list as $k => $v) {
            //抢到的红包
            $list[$k]['type'] = 1;
            $userinfo = Member::getMemberByopenid($v['from_openid']);
            $list[$k]['avatar'] = $userinfo['avatar'];
            $list[$k]['nickname'] = $userinfo['nickname'];
            $list[$k]['create_time'] =date('Y-m-d h:i',$v['create_time']);
        }
        return $list;
    }
    /**
     * @param $uniacid
     * @param $amount    金额
     * @param $toOpenid  收款人openid
     * @param $type_id   关联id
     * @param $fromOpenid 付款人openid
     * @param $cashType   打赏类型，目前支持1、抢红包，2圈子打赏
     */
    public static function addCashRecord($uniacid,$amount,$toOpenid,$type_id,$fromOpenid,$cashType,$totalAmount){
        $data = array(
            'uniacid' =>$uniacid,
            'amount' => $amount/100,
            'create_time' => time(),
            'openid' => $toOpenid,
            'type_id' => $type_id,
            'from_openid' =>$fromOpenid ,
            'cash_type' =>$cashType
        );
        $result=pdo_insert(CASH, $data);
        //更新用户总提现金额
        pdo_update(MEMBER, array('balance'=>$totalAmount), array('openid' => $toOpenid, 'uniacid' => $uniacid));
    }
}