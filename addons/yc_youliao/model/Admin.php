<?php 
class Admin{
    public $group_ids;
    public $salt       = 'hjasdf01';
    public $username   = 'mihua_sq_wq_admin';
    //独立后台的微擎管理人员的登录
    //独立后台
    public function adminLogin($passport,$password){
            global $_GPC, $_W;
            $username = trim($passport);
            pdo_query('DELETE FROM '.tablename('users_failed_login'). ' WHERE lastupdate < :timestamp', array(':timestamp' => TIMESTAMP-300));
            $failed   = pdo_get('users_failed_login', array('username' => $username, 'ip' => CLIENT_IP));
            if ($failed['count'] >= 5) {
                return array('errcode'=>1,'msg'=>'输入密码错误次数超过5次，请在5分钟后再登录');
            }
            if(empty($username)) {
                return array('errcode'=>1,'msg'=>'请输入要登录的用户名');
            }
            $member['username'] = $username;
            $member['password'] = $password;
            if(empty($member['password'])) {
                return array('errcode'=>1,'msg'=>'请输入密码');
            }
            if(pdo_fieldexists(SHOP_ADMIN,'passport')){
                $record     = $this->vaildShopAdmin($username,$password);
            }
            if(!$record){
                $wq_record  = user_single($member);
            }

            if( $record || $wq_record ) {
                if($record['admin_status'] == 1 && $record) {
                    return array('errcode'=>1,'msg'=>'您的账号已经暂停，如需继续登录，请联系管理员！');
                }
                if($wq_record['status'] == 1 && $wq_record) {
                    return array('errcode'=>1,'msg'=>'您的账号正在审核或是已经被系统禁止，请联系管理员解决！');
                }
                $founders = explode(',', $_W['config']['setting']['founder']);
                $_W['isfounder'] = in_array($record['uid'], $founders);
                if (empty($_W['isfounder'])) {
                    if (!empty($record['endtime']) && $record['endtime'] < TIMESTAMP) {
                        message('您的账号有效期限已过，请联系网站管理员解决！');
                    }
                }
                if (!empty($_W['siteclose']) && empty($_W['isfounder'])) {
                    message('站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason']);
                }
               
                $cookie                 = array();
                if(!$record){
                    if($wq_record['uid']!=$_W['config']['setting']['founder']){
                        exit("非系统管理员账号和本模块内置账号不能登录");
                    }
                    $record                 = $wq_record;
                    $cookie['uid']          = $record['uid'];
                    $cookie['lastvisit']    = $record['lastvisit'];
                    $cookie['lastip']       = $record['lastip'];
                    isetcookie('_admin_id','',-7 * 86400,'/');
                    isetcookie('_admin_name','',-7 * 86400,'/');
                    isetcookie('_admin_img','',-7 * 86400,'/');
                    isetcookie('_db_group_id','',-7 * 86400,'/');
                    isetcookie('_data_group_id','',-7 * 86400,'/');
                    isetcookie('__uniacid', $record['uniacid'], 7 * 86400);


                }else{
                    $cookie['uid']          = $record['admin_uid'];
                    isetcookie('_admin_id',   $record['admin_id'], 7 * 86400,'/');
                    isetcookie('_admin_name', $record['admin_name'],7 * 86400,'/');
                    isetcookie('_admin_img',  $record['avatar'],7 * 86400,'/');
                    isetcookie('__uniacid', $record['uniacid'], 7 * 86400);
                    isetcookie('__uid', $record['admin_uid'], 7 * 86400);
                    $_SESSION['uniacid']      = $record['uniacid'];
                    setShop_id($record['shop_id']);
                    setAdmin_type($record['admin_type']);
                    if($record['group_id']==0){
                        $record['group_id'] = "N";
                    }

                    $record                 = $this->getWqAdmin();
                    $cookie['lastvisit']    = $record['lastvisit'];
                    $cookie['lastip']       = $record['lastip'];

                }
                $_SESSION['admin_name']      = $username;
                $cookie['hash']         = md5($record['password'] . $record['salt']);
                if( str_replace('.','',IMS_VERSION)  < 144 || !function_exists("authcode") ){
                    $session = base64_encode(json_encode($cookie));
                }elseif(function_exists("authcode") ){
                    $session = authcode(json_encode($cookie), 'encode');
                }
                isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
                $status                 = array();
                $status['uid']          = $record['uid'];
                $status['lastvisit']    = TIMESTAMP;
                $status['lastip']       = CLIENT_IP;
                user_update($status);
			    isetcookie('__uid', $record['uid'], 7 * 86400);
                $list = $this->getAllPlatform();
                setWebLogin($list[0]['uniacid'],$record['uid']);
                pdo_delete('users_failed_login', array('id' => $failed['id']));
                return array('errcode'=>0,'msg'=>'success','uid'=>$record['uid']);
            } else {
                if (empty($failed)) {
                    pdo_insert('users_failed_login', array('ip' => CLIENT_IP, 'username' => $username, 'count' => '1', 'lastupdate' => TIMESTAMP));
                } else {
                    pdo_update('users_failed_login', array('count' => $failed['count'] + 1, 'lastupdate' => TIMESTAMP), array('id' => $failed['id']));
                }
                return array('errcode'=>1,'msg'=>'登录失败，请检查您输入的用户名和密码！');
            }       
    }
   
     public function getGroup(){
        $list        = pdo_fetchall("select * from  ".tablename("uni_group")." ");
        $group_ids[] = '-1';
        foreach($list as $row){
            $modules = unserialize($row['modules']);
            if($modules){
                foreach ($modules as  $value) {
                    if($value=='yc_youliao'){
                        $group_ids[]=$row['id'];
                        break;
                    }
                }
            }
        }
        $this->group_ids = $group_ids;
        return $group_ids;
    }

  

   //该公众号有没有权限
    public function validPlatform($uniacid){
        if(!$this->group_ids){
            $this->getGroup();
        }
        $in_str   = implode(',',$this->group_ids);
        $result   = pdo_fetch("select * from ".tablename('uni_account_group')." where  uniacid = ".$uniacid." and groupid in (".$in_str.") ");       
        return $result;
    }



     //获取用户信息
    public function getAdminInfo($admin_id){
        $where               = " uid=:admin_id";
        $params[":admin_id"] = $admin_id;
        $re = pdo_fetch("select * from  ".tablename('users')." where ".$where,$params);
        return $re;
    }     
    //判断登录人员的身份
    public function judeAdminType($uid=false){
        global $_W,$_GPC;
        $jia_admin = true;
        if(!$uid){
            $uid    = $_W['uid'];
        }
        $user_info  = user_single($uid);
        if($_W['isfounder']){
            $sq_admin  = false;
            $out        = array('admin'=>'top','isfounder'=>1);
        }else{
           $admin_id = $_GPC['_admin_id'];
           $result   = $this->getAdminInfo($admin_id);
           
        }
        if(!$sq_admin){
               setDbAdmin(0);
               setTeacherAdmin(0);
        }
       
          
        return $out;
    }

    //获取所有有权限的公众号
    public function getAllPlatform(){
 	        $sql    = "SELECT * FROM ". tablename('uni_account'). " as a LEFT JOIN". tablename('account'). " as b ON a.default_acid = b.acid where b.isdeleted <> 1 order by a.`rank` DESC, a.`uniacid` DESC ";
            $list   = pdo_fetchall($sql, $pars);
            if(!empty($list)) {
                foreach($list as $unia => &$account) {
                    $account['details'] = uni_accounts($account['uniacid']);
                    $account['setmeal'] = uni_setmeal($account['uniacid']);
                   // $have_power         = $this->validPlatform($account['uniacid']);
                    $have_power = true;
                    if(!$have_power)
                        unset($list[$unia]);
                }
            } 
            return $list;
    }

    //微擎米花社区组
    public function wqGroup($type){
        if(!$type){
            return false;
        }
        $group_type    = $this->group_type[$type];
        $group_info    = pdo_fetch("select * from ".tablename('users_group')." where name='".$group_type."' ");
        if(!$group_info){
            $in['name']     = $group_type;
            $in['package']  = 'N;';
            pdo_insert('users_group',$in);
            $id = pdo_insertid();
        }else{
            $id = $group_info['id'];
        }
        return $id;
    }

    public function addShopAdmin($in){
        $wq_admin   = $this->getWqAdmin();
        if(!$in['salt']){
            $salt                        = rand(10000, 99999);
        }else{
            $salt                        = $in['salt'];
        }
        $admin_in['group_id']       = $in['group_id'];
        $admin_in['shop_id']     = $in['shop_id'];
        $admin_in['openid']           = $wq_admin['uid'];
        $admin_in['avatar']           = $in['avatar'];
        $admin_in['nickname']           = $in['nickname'];
        $admin_in['uniacid']           = $in['uniacid'];
        $admin_in['status']           = $in['status'];
        $admin_in['msg_flag']           = $in['msg_flag'];
        $admin_in['admin_name']          = $in['admin_name'];
        $admin_in['passport']            = $in['passport'];
        $admin_in['password']            = user_hash($in['password'],$salt);
        $admin_in['salt']                = $salt;
        pdo_insert(SHOP_ADMIN,$admin_in);
        $admin_id  = pdo_insertid();
        return $admin_id;
    }

    //获取社区要求的内置的微擎账号
    public function getWqAdmin(){
        $result = $this->checkWqPassport($this->username);
        if(!$result){
            $this->addWqAdmin();
            $result = $this->checkWqPassport($this->username);
        }
        return $result;
    }
    public function checkWqPassport($passport){
        $result = pdo_fetch("select * from ".tablename('users')." where username=:username ",array(':username'=>$passport));
        return $result;
    }
    //验证社区账户
    public function vaildShopAdmin($passport,$password){
        $result       = $this->getShopAdmin($passport);
        $in_passwored = user_hash($password,$result['salt']);
        if($result['password']==$in_passwored)
            return $result;
        else
            return false;
    }
    //通过社区账号获取信息
    public function getShopAdmin($passport){
        $params[":passport"] = $passport;
        $result              = pdo_fetch(" select * from ".tablename(SHOP_ADMIN)." where passport=:passport  and status=:status ",array(':passport'=>$passport,':status'=>'0'));
        return   $result;
    }

    //获取手机端管理员
    public static function getAdminAll(){
        global $_W;
        $where               = "  uniacid=:uniacid";
        $params[":uniacid"] = $_W['uniacid'];
        $result              = pdo_fetchall(" select * from ".tablename(ADMIN)."where ".$where,$params);
        return   $result;
    }
    public static function getShopAdminAll($shop_id){
        global $_W;
        $where               = " shop_id=:shop_id and uniacid=:uniacid";
        $params[":shop_id"] = $shop_id;
        $params[":uniacid"] = $_W['uniacid'];
        $result              = pdo_fetchall(" select * from ".tablename(SHOP_ADMIN)."where ".$where,$params);
        return   $result;
    }
    public static function getShopAdminById($shop_id,$admin_id){
        global $_W;
        $where               = " shop_id=:shop_id and admin_id=:admin_id and uniacid=:uniacid";
        $params[":shop_id"] = $shop_id;
        $params[":uniacid"] = $_W['uniacid'];
        $params[":admin_id"] = $admin_id;
        $result              = pdo_fetch(" select * from ".tablename(SHOP_ADMIN)."where ".$where,$params);
        return   $result;
    }
    //添加微擎管理人员
    public function addWqAdmin(){
        $salt       = $this->salt;
        $password   = rand(10000, 99999);
        $password   = user_hash($password,$salt);
        $user_in['groupid'] = $this->wqGroup(3);
        $user_in['username']= $this->username;
        $user_in['password']= $password;
        $user_in['salt']    = $salt;
        $user_in['status']  = 2;
        $user_in['joindate']= TIMESTAMP;
        pdo_insert('users',$user_in);
        $user_id  = pdo_insertid();
        return $user_id;
    }
//添加店铺管理人员
    public function addSqAdmin($in,$admin_id=0){
        $wq_admin   = $this->getWqAdmin();
        if(!$in['salt']){
            $salt                        = rand(10000, 99999);
        }else{
            $salt                        = $in['salt'];
        }

        $admin_in['admin_uid']           = $wq_admin['uid'];
        $admin_in['uniacid']           = $in['uniacid'];
        $admin_in['admin_type']           = $in['admin_type'];
        $admin_in['shop_id']          = $in['shop_id'];
        $admin_in['openid']          = $in['openid'];
        $admin_in['avatar']           = $in['avatar'];
        $admin_in['admin_name']          = $in['admin_name'];
        $admin_in['mobile']          = $in['mobile'];
        $admin_in['msg_flag']          = $in['msg_flag'];
        $admin_in['customer']          = $in['customer'];
        $admin_in['passport']            = $in['passport'];
        $admin_in['password']            = user_hash($in['password'],$salt);
        $admin_in['salt']                = $salt;
        if($admin_id>0){//更新
            pdo_update(SHOP_ADMIN,  $admin_in, array('admin_id' =>$admin_id,'shop_id' => $in['shop_id'],'uniacid' => $in['uniacid']));
        }else{//插入
            pdo_insert(SHOP_ADMIN,$admin_in);
            $admin_id  = pdo_insertid();
        }

        return $admin_id;
    }

    public static function postAdmin($shop_id){
        global $_W,$_GPC;
    $openid=$_GPC['openid'];
    $passport=$_GPC['passport'];
    $admin_type=$_GPC['admin_type'];
    $admin_id= intval($_GPC['admin_id']);
    if(empty($admin_type))return '管理员类型不能为空';
    if(empty($openid))return '请选择管理员';
    $scount = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename(SHOP_ADMIN) . ' WHERE passport =:passport limit 1', array( ':passport' => $passport));
    if ($scount > 0 && $admin_id==0) return '用户名已被使用，请您重新设置';
$data = array(
    'uniacid' => $_W['uniacid'],
    'shop_id' => intval($shop_id),
    'openid' => trim($_GPC['openid']),
    'admin_name' => $_GPC['admin_name'],
    'mobile' => intval($_GPC['mobile']),
    'avatar' => $_GPC['avatar'],
    'nickname' => $_GPC['nickname'],
    'admin_type' => $admin_type,
    'status' => intval($_GPC['status']),//'0=>正常，1暂停
    'msg_flag' => intval($_GPC['msg_flag']),//'0=>发送通知,1=>不发送通知'
    'addtime' =>  TIMESTAMP,
    'customer' => intval($_GPC['customer']),


);

    if($admin_type!=3 ){
        if(empty($_GPC['password']) || empty($_GPC['passport']))return '用户名或密码不能为空';
        $data2 = array(
            'passport' => $_GPC['passport'],
            'password' => $_GPC['password'],
        );
        $in = array_merge($data, $data2);
        $Admin=new Admin();
        $Admin->addSqAdmin($in,$admin_id);
    }else{//核销员不需要后台登录
        if($admin_id>0){
            pdo_update(SHOP_ADMIN,  $data, array('admin_id' =>$admin_id,'shop_id' =>$shop_id));
        }else{
            pdo_insert(SHOP_ADMIN, $data);
        }


    }

    return 1;
}
static public  function checkUser($openid){
    global $_W;
     if(!empty($openid)){//手机端
         $sql=' and openid ="'.$openid.'"';
         $list = pdo_fetch('SELECT * FROM ' . tablename(ADMIN) . "  WHERE uniacid = {$_W['uniacid']}   {$sql} and status =0 ");
         if(!empty($list)) return 1;
     }else{//pc端验证
        if($_W['isfounder']) return 1;

    }

}
public static function getAccount_applay($openid,$status,$pageStart,$num,$sqlweher){
    global $_W;
    //验证是否管理员
    $a_data=self::checkUser($openid);
    if($a_data!=1)return;
    $list = pdo_fetchall('SELECT a.*,s.shop_name,s.logo FROM ' . tablename(ACCOUNT) . "a left join  " . tablename(SHOP) . " s on a.shop_id=s.shop_id  WHERE a.uniacid = {$_W['uniacid']}   {$sqlweher} and a.status ={$status} ORDER BY a.cash_id DESC LIMIT  {$pageStart},{$num} ");
    foreach ($list as $k => $v) {
        //获取申请人信息
        if(intval($v['shop_id'])>0){
            $userdata = commonGetData::getAdminnameByid($v['admin_id']);
        }else{
            $userdata = MEMBER::getMemberByopenid($v['openid'])  ;
        }

        $list[$k]['nickname'] = $userdata['nickname'];
        $list[$k]['avatar'] = $userdata['avatar'];
        if($v['check_admin']){//获取处理人信息
            $userdata = commonGetData::getAdminnameByid($v['check_admin'],ADMIN);
            $list[$k]['check_nickname'] = $userdata['nickname'];
            $list[$k]['check_avatar'] = $userdata['avatar'];
        }
    }
    return $list;
}

    static function getAdminByid($admin_id){
        $admin_where['admin_id'] =$admin_id;
        $a_data = util::getSingelDataInSingleTable(ADMIN, $admin_where, '*');
        return $a_data;
    }
    static function getShop_adminByid($shop_id,$admin_id){
        $admin_where['admin_id'] =$admin_id;
        $admin_where['shop_id'] =$shop_id;
        $a_data = util::getSingelDataInSingleTable(SHOP_ADMIN, $admin_where, '*');
        return $a_data;
    }
}