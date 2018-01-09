var attachurl=window.sysinfo.siteroot+'/attachment/';
var app_link=window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry'+'&m=yc_youliao';
function createAppUrl(dostr,opstr,obj){
    var str = '&do='+dostr+'&op='+opstr;
    for(t in obj){
        str += '&'+t+'='+obj[t];
    }
    return window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry'+str+'&m=yc_youliao';
}
function appentList(data,adv_type,link,attachurl,btn,logo){
    var str ='';
    if(adv_type=='7'|| adv_type=='9') {
        str += '<div class="shop-list"><ul id="mihua_sq_list" class="am-cf">';
    }else if(adv_type=='4') {
        str +='<ul  class="groups">';
    }else{
        str +='';
    }
    $.each(data.list,function(index,value){
        if(adv_type=='7' || adv_type=='9') {
            var url = link +'&do=shop&shop_id='+ value.shop_id ;
            if(adv_type=='7'){
               url=url+'&op=discount' ;
            }
            str += '<li class="shop-list-li">';
            str += '<a href="' + url + '">';
            str += '<div class="shop-list-li-img">';
            if(value.logo !=null && value.logo !=''&& value.logo !=undefined) {
                str += '<img class="lazy inline" src="'+value.logo + '" >';
            }else{
                str += '<img class="lazy inline" src="'+logo+'" >';
            }

            str += '</div>';
            str += '<div class="shop-list-info">';
            if (value.distance !=null && value.distance > 0) {
                str += '<div class="y">' + value.distance + 'km</div>';
            }
            str += '<div class="wap1 mr_5 title">' + value.shop_name + '</div>';
            str += '<div>';
            str += ' <div class="shop_star_s mr_10">';
            if (value.dp !=null && value.dp > 0) {
                if (value.dp >= 5) {
                    str += ' <img src="../addons/yc_youliao/public/images/5x.png">';
                } else if (value.dp >= 4 && value.dp <= 4.9) {
                    str += ' <img src="../addons/yc_youliao/public/images/4x.png">';
                } else if (value.dp >= 3 && value.dp <= 3.9) {
                    str += ' <img src="../addons/yc_youliao/public/images/3x.png">';
                } else if (value.dp >= 2 && value.dp <= 2.9) {
                    str += ' <img src="../addons/yc_youliao/public/images/2x.png">';
                } else if (value.dp >= 1 && value.dp <= 1.9) {
                    str += ' <img src="../addons/yc_youliao/public/images/1x.png">';
                } else {
                    str += ' <img src="../addons/yc_youliao/public/images/0x.png">';
                }
            }
            str += '</span></div>';

            if (value.renjun !=null && value.renjun > 0  ) {
                str += '<div class="renjun"><cite>￥</cite>' + value.renjun + '/人</div>';
            }

            str += '<div class="shop-list-addr"><div class="wap1">';
            if (value.inco !=null && value.inco != "") {
                $.each(value.inco, function (key, val) {
                    str += '<i>' + val + '</i>';
                })

            }

            str += '</div></div></div></a></li>';
        } else if (adv_type == '4') {// 拼团样式
            var url = link +'&do=good&id='+ value.goods_id +'&shop_id='+value.shop_id;
            str += '<li>';
            str += '<a href="' + url + '">';
            str += '<div class="groups-img">';
            str += '<img src="'+value.thumb + '" ></div>';
            str += ' <h2 class="groups-title">' + value.title + '</h2>';
            str += '<div class="groups-detail">';
            str += '<div class="groups-detail-left fl">';
            str += ' <div class="price fl"><i>￥</i>'+value.groupprice+'</div>';
            str += ' <div class="des fr">已团'+value.sales+'件</div>';
            str += '</div>';
            str += '<div class="groups-detail-right fr mr-4r">';
            str += '<div class="group-local fl">';
            // if(value.data1[value.id]){
            //     $.each(value.data1[value.id],function(index,o){
            //         str += '<div class="avatar fr">';
            //         str += '<img src="'+attachurl+o.avatar + '" ></div>';
            //     })
            // }
            str += '</div>';
            str += '<div class="group-btn fr"> 去开团 </div>';
            str += '</div></div></a></li>';
        } else {
            var url = link +'&do=good&id='+ value.goods_id +'&shop_id='+value.shop_id;
            str += '<a href="' + url + '">';
            str += '<div class="second_list clearfix">';
            str += '<div class="second_img">';
            str += '<img src="'+value.thumb + '" >';
            str += '</div>';
            str += '<div class="second_content">';
            str += '<p class="goods_name">' + value.title + '</p>';
            str += '<p class="shop_name"><img src="../addons/yc_youliao/public/images/shop.png"/>' + value.shop_name + '</p>';
            str += '<div class="price">';
            if (adv_type == '6') {
                var price = (value.marketprice - value.isfirstcut).toFixed(2);
                str += '<span class="iconfont money_red">-￥' + value.isfirstcut + '</span>';
                str += '<del class="iconfont money_grizzly">￥' + value.marketprice + '</del>';
                str += '<div class="sheng">下单价￥' + price + '</div>';

            }
            str += '</div>';
            str += '<div class="go_second">';
            str += ' <button class="go_second_botton">'+btn+'</button>';
            str += '</div></div></div>';
            str += '</a>';
        }


    })

    if(adv_type==7 || adv_type==9) {
        str += '</ul></div>';
    }

    return str;


}
function order_str(v) {
    var str="";
    str += '<li class="space_list_li bg_white mb_10">';
    str += '<div class="my_dis_content f_14 c_999 am-cf mt_10 z order-status">编号：' + v.ordersn;
    if(v.status==0){
        str += '<span>未付款</span>';
    }else if(v.status==1){
        str += '<span">未使用</span>';
    }else if(v.status==3){
        str += '<span>已使用</span>';
    }else if(v.status==4){
        str += '<span>交易关闭</span>';
    }
    str += '</div><div class="d_time">' + v.createtime + '</div>';
    str += '<div class="clearfix"></div>';
    var name='';
    $.each(v.goods, function (key, x) {
        name+=x.title+' ';
        str += '<div class="listDiv_group mr_10 mt_5 my_dis_group am-cf">';
        str += ' <div class="listDiv_groupImg  mr_10">';
        str += '<a href="' + createAppUrl('good', 'display') + '&shop_id=' + v.shop_id +  '&id=' + x.goods_id + '">';
        str += '<img src="'+attachurl+x.thumb+'" >';
        str += '<h6 class="listDiv_groupH6 mt_5 cl">' + x.title + '</h6>';
        str += '<div class="list_desc ">';
        str += '<p class="f_12 ml_15">数量：' + x.total + '<span class="f_12 ml_15">单价：￥' + x.price + '</span></p>';
        str += '</div>';
        str += ' </a>';
        str += '</div>';
        str += '</div>';
    })
    str += '<div class="my_dis_love am-cf">';
    str += ' <span class="follow " >';
    if(v.nickname !='' && v.nickname !=null){
        str += '<span class="left avatar-nickname"><img src="'+v.avatar+'"> <em>'+v.nickname+'</em></span>';
    }
    str += '<span class="red f_14 left">支付：￥';
    str += v.price ;
    str += '</span><span class="right" >';
    if(v.status == 0){
        str += ' <a href="' + createAppUrl('pay', 'display') + '&type=good&ordersn=' + v.ordersn + '&name=' +name + '" class="gopay">去支付</a>';
        str += ' <a href="javascript:;" onclick="deleteorder(this,' +v.shop_id + ','+ v.id + '" class="godelete ">删除</a>';
}
    str += ' <a href="' + createAppUrl('order', 'detail') + '&shop_id=' + v.shop_id + '&id=' + v.id + '" class="follow " >';
    str += ' <em>查看详情</em></a>';
    str += '</span></span></div>';
    str += '<div class="clearfix"></div>';
    str += '</li>';
    return str;
}
function admin_info_str(v) {
    var str="";
    str += '<li class="info-list" >';
    str += '<h2><i></i><span>'+v.modulename+'</span><em><img src="../addons/yc_youliao/public/images/g_time.png">'+v.createtime+'</em></h2>';
    str +=' <p onclick="location.href='+createAppUrl('detail', 'display')+'&id='+v.id+'><img src="'+v.avatar+'"';
    str +=' <span>'+v.con.title+'</span>';
    if(v.con.thumbs!='' && v.con.thumbs!=null){

        str +='  <div class="mimg">';
        $.each(v.con.thumbs, function (key, x) {
            str += ' <img class="img2" src="'
            str += attachurl + x + '">  ';
        })
        str +='</div>';
    }
    str +='</p>';

    if(v.address!='' && v.address!=null){
        str +=' <p class="borderb"><img src="../addons/yc_youliao/public/images/list_icon.png"><span class="noborder">'+v.address+'</span></p>';
    }
    str+='<h3>';
    if (v.isneedpay==1 && v.haspay==1) {
    str+='<span class="green">已支付￥'+v.needpay+'</span>';
    }else if(v.isneedpay==1 && v.haspay==0){
    str+='<span >待支付￥'+v.needpay+'</span>';
    }else{
    str+='<span>免费发布</span>';
    }

    if (v.status==0) {
        str+='<a href="javascript:;" class="current" onclick="admin_check_info(this,1,'+v.id+')">审核通过</a>';
        str+='<a href="javascript:;" onclick="admin_check_info(this,2,'+v.id+')" >审核不通过</a>';
    }else  if (v.status==1) {
        if (v.isding==1) {
            str+='<a href="javascript:;" onclick="admin_check_info(this,4,'+v.id+')" >取消置顶</a>';
        }else {
            str+='<a href="javascript:;" class="current" onclick="admin_dingtime(this,3,'+v.id+')">置顶</a> <input class="infoid" type="hidden"   value="'+v.id+'" name="">';
        }
        str+='<a href="javascript:;" class="current" onclick="admin_check_info(this,5,'+v.id+')">刷新</a>';
        str+='<a href="javascript:;" onclick="admin_check_info(this,6,'+v.id+')" >删除</a>';

    }


    str+='  </h3>  </li>';
    return str;
}
function fans_str(v) {
    var str="";
    str += '<li class="info-list">';
    str += '<img src="'+v.avatar+'">';
    str += '<div class="text">';
    str += '<h2>'+v.nickname+'</h2>';

    str += '<p>';
    if (v.shop_name !='' && v.shop_name !=null){
        str += '<i class="iconfont">&#xe668;</i>'+v.shop_name+'<em class="ml-15"></em> ';
    }
    str += '<i class="iconfont">&#xe647;</i>'+v.balance+'<em class="ml-15"><i class="iconfont">&#xe637;</i>'+v.credit+'</em> </p>';

    str += ' </div><div class="score" onclick="downscore(this)"><img src="../addons/yc_youliao/public/images/b_down.png" > ';
    str += '<div class="down-list-pro">';
    str += '<a href="'+createAppUrl('chat', 'display')+'&toopenid='+v.openid+'"><i class="iconfont" style="color: #4fc0ea">&#xe62c;</i>发送消息</a>';
    str += '<a href="'+createAppUrl('admin', 'fans_credit')+'&mid='+v.id+'&credit_type=2"><i class="iconfont" style="color: #F5628C">&#xe647;</i>充值余额</a>';
    str += '<a href="'+createAppUrl('admin', 'fans_credit')+'&mid='+v.id+'&credit_type=1"><i class="iconfont" style="color: #fea501">&#xe637;</i>充值积分</a>';
    str += '<a href="'+createAppUrl('admin', 'fans')+'&uid='+v.id+'&type=1&post=add"><i class="iconfont" style="color: #fea501">&#xe61d;</i>加入黑名单</a>';
    str += '</div></div> ';
    str += '</li>';
    return str;
}
function info_str(v,isshang){
    var str="";
    str += '<div class="mmsg">';
    str += '<div onclick="location.href=\''+createAppUrl('detail','display')+'&id='+v.id+'\'">'
    str += '<div class="nickname" >';
    str += '<img src="'+v.avatar+'">';
    str += '<span class="nick-name">'+v.nickname+'</span>';
        if (v.fmid!=0 ){
    str += '  <span class="moduname';
    if (Number(v.mid)%5==0){
        str += ' color0 ';
    }else if (Number(v.mid)%5==1){
        str += ' color1 ';
    }else if (Number(v.mid)%5==2){
        str += ' color2 ';
    }else if (Number(v.mid)%5==3){
        str += ' color3 ';
    }else if (Number(v.mid)%5==4){
        str += ' color4 ';
    }else if (Number(v.mid)%5==5){
        str += ' color5 ';
    }
      str +=' ">' +  v.modulename+'</span>';
       }
    str += ' </div>';
    str += '<a class="list-chat" href="'+createAppUrl('chat', 'display')+'&toopenid='+v.openid+'"><div class="span2 iconfont text-c dochat" >';
    str += '<img src="../addons/yc_youliao/public/images/g_chat.png" > <span class="pd-d">微聊</span></div></a>';
    str += '<div class="clearfix"></div>';
    str += '<div class="mtitle"';
    if(v.con.thumbs  ==  undefined){
        str += 'style="width: 100%"';
    }
    str += '><div class="title">';
    if(v.isding != undefined && v.isding ==1) {
        str += '<span class="zding">置顶</span>';
    }

     str+= v.con.title+'</div>';
    str += '<div class="info-input">';
    if(v.con.price != null && v.con.price != undefined){
        str += '<span class="redbox">￥'+v.con.price+'</span>';
    }
    if(v.con.xinshui != null && v.con.xinshui != undefined){
        str += '<span class="redbox">'+v.con.xinshui+'</span>';
    }
    if(v.con.feiyong != null && v.con.feiyong != undefined){
        str += '<span class="redbox">￥'+v.con.feiyong+'</span>';
    }
    if(v.con.yuanjia != null && v.con.yuanjia != undefined){
        str += '<span class="graybox line-through">'+v.con.yuanjia+'</span>';
    }
    if(v.con.huxing != null && v.con.huxing != undefined){
        str += '<span class="graybox">'+v.con.huxing+'</span>';
    }
    if(v.con.zhuangxiu != null && v.con.zhuangxiu != undefined){
        str += '<span class="graybox">'+v.con.zhuangxiu+'</span>';
    }
    if(v.con.age != null && v.con.age != undefined){
        str += '<span class="graybox">'+v.con.age+'岁</span>';
    }
    if(v.con.zwtitle != null && v.con.zwtitle != undefined){
        str += '<span class="graybox">'+v.con.zwtitle+'</span>';
    }
    if(v.con.qiwangzw != null && v.con.qiwangzw != undefined){
        str += '<span class="graybox">'+v.con.qiwangzw+'</span>';
    }
    if(v.con.xueli != null && v.con.xueli != undefined){
        str += '<span class="graybox">'+v.con.xueli+'</span>';
    }
    str +='</div><div>';
    if(v.con.cfcity != null && v.con.cfcity != undefined){
        str += '<div class="backbox">出发：'+v.con.cfcity+'</div>';
    }
    if(v.con.ddcity != null && v.con.ddcity != undefined){
        str += '<div class="backbox">目的：'+v.con.ddcity+'</div>';
    }
    if(v.con.gotime != null && v.con.gotime != undefined){
        str += '<div class="backbox">出行时间：'+v.con.gotime+'</div>';
    }
    str +='</div><div class="info-checkbox">';
    if(v.con.type != null && v.con.type != undefined){
        str += '<span class="greenbox">'+v.con.type+'</span>';
    }
    if(v.con.fuli != null && v.con.fuli != undefined){
        $.each(v.con.fuli, function (key, x) {
            str += '<span class="greenbox">'+x+'</span>';
        })

    }
    if(v.con.peizhi != null && v.con.peizhi != undefined){
        $.each(v.con.peizhi, function (key, x) {
            str += '<span class="greenbox">'+x+'</span>';
        })

    }
    str +='</div></div>';
    if(v.con.thumbs != null || v.con.thumbs != undefined){
        str += '<div class="mimg" >';
        str += '<img src="'+v.con.thumbs[0]+'" class="img2">';
        str +='</div>';
    }
    str += '</div>'
    str +='<div class="fr">'
    if(isshang==0){
        str += '<span class="shangWap" onclick="shang_show('+ v.id + ',\'' + v.openid + '\');">'
        str += '<span class="shang-icon"></span></span>'
    }

        +' <span class="graybox timer">';
    if(v.freshtime == null || v.freshtime == undefined){
        str +=v.freshtime;
    }else{
        str +=v.createtime;
    }
    str +='</span></div></div><div class="line"></div>';
    return str;
}
function black_str(v) {
    var str="";
    str += '<li class="info-list">';
    str += '<img src="'+v.avatar+'">';
    str += '<div class="text">';
    str += '<h2>'+v.nickname+'</h2>';

    str += '<p>';
    str += unixToDatetime(v.createtime)+'</p>';
    str += ' </div><div class="score" onclick="deleteBlack(this,'+v.uid+')"><img src="../addons/yc_youliao/public/images/delete.png" > ';
    str += '</div> ';
    str += '</li>';
    return str;
}
function redpackage_str(v) {
    var str = "";
    str += '<li class="list" style="border-bottom: 1px solid #eee">';
    str += '  <div class="c-left">';
    str += ' <div class="avatar"><img src="'+v.avatar+'"></div>';
    str += ' </div>';
    str += ' <div class="c-right">';
    str += ' <div  onclick="toshow('+v.red_id+')">';
    str += ' <div class="c-title" style="text-align: left;">';
    str += '<span class="name">'+v.nickname+'</span>';
    str += ' <span class="distance">'+v.distance+'km</span>';
    str += ' <span class="hot">'+v.total_amount+'元</span>';
    str += '</div>';
    str += '<div class="c-content" style="text-align: left;">'+v.content+'</div>';
    str += '</div>';
    if(v.xsthumb != null && v.xsthumb != undefined){
        str += '<div class="c-imgs my-gallery" style="text-align: left;">';
        $.each(v.xsthumb, function (key, x) {
            str += '<figure>'
            str += '<a href="' + x + '" class="gallery-a">'
            str += '<img class="img" src="' + x + '">';
            str += '</a>'
            str += '</figure>'

        })
        str += '</div>';
    }

    if(v.total_num==v.send_num){
        str += '<div class="gray">';
        str += '   <span class="gray">福利已抢光</span>';
    }else{
        str += '<div class="des">';
        str += '   <span>抢福利进行中</span>';
    }

    str += '   </div>';
    str += '   </div>';
    str += '  </li>';
    return str;
}
function red_record_str(type,v) {
    var str="";
    str += '<li class="list" ';
    if(v.red_id != null && v.red_id != undefined && type<2) {
        str += ' onclick="location.href='+createAppUrl('redpackage', 'showredpackage')+'&id='+v.red_id+'">';
    }else if(v.red_id == undefined && type<2) {
        str += ' onclick="location.href='+createAppUrl('redpackage', 'redpackage')+'">';
    }
    str +='<div class="d-left"><img src="'+v.avatar+'"></div>';
    str +='<div class="d-right">';
    str +='<div class="nameDes">';
    str +='<div class="name">'+v.nickname+'</div>';
    if(v.model != null && v.model != undefined) {
        str +='<div class="money">';
        if(v.model ==2){
            str +='口令红包';
        }else if(v.allocation_way ==1){
            str +='普通红包';
        }else if(v.allocation_way ==2){
            str +='拼手气红包';
        }
        str +='</div>';
     }
    str +='<div class="money">￥'+v.amount+'</div></div>';
    str +='<div class="time">'+unixToDatetime(v.create_time)+'</div>';
    if(type==1){
        str +='<div class="time">领取'+v.send_num+'/共'+v.total_num+'个</div> ';
    }
    str +='</div></li>';
    return str;
}
function shop_admin_str(v) {
    var str="";
    str += '<li class="info-list" onclick="location.href='+createAppUrl('shop_admin', 'admin')+'&post=add&admin_id='+v.admin_id+'">';
    str += '<img src="'+v.avatar+'">';
    str += '<div class="text">';

    if (v.nickname !='' && v.nickname !=null){
        str += '<h2>'+v.nickname+'</h2>';
    }else if (v.admin_name !='' && v.admin_name !=null){
        str += '<h2>'+v.admin_name+'</h2>';
    }
    str += '<p>';

    str += '<i class="iconfont">&#xe626;</i>权限：';
    if (v.admin_type ==1){
        str += '超级管理员';
    }else if (v.admin_type ==2){
        str += '操作员';
    } else if (v.admin_type ==3){
        str += '核销员';
    }
    str +='<em class="ml-15">状态：';
    if (v.status ==0){
        str += '正常';
    }else{
        str += '暂停';
    }
    str += ' </em> </p>';

    str += ' </div><div class="score" onclick="downscore(this)"><img src="../addons/yc_youliao/public/images/b_down.png" > ';
    str += '<div class="down-list-pro">';
    str += '<a href="'+createAppUrl('shop_admin', 'admin')+'&post=add&admin_id='+v.admin_id+'"><i class="iconfont" style="color: #4fc0ea">&#xe62d;</i>编辑</a>';
    str += '<a href="javascript:;" onclick="deleteAdmin(this,'+v.admin_id+');"><i class="iconfont" style="color: #fea501">&#xe68e;</i>删除</a>';
    str += '</div></div> ';
    str += '</li>';
    return str;
}

function shop_fans_str(v) {
    var str="";
    str += '<li class="info-list">';
    str += '<img src="'+v.avatar+'">';
    str += '<div class="text">';
    str += '<h2>'+v.nickname+'</h2>';

    str += '<p>';

    str += '<i class="iconfont">&#xe647;</i>消费：'+v.amount+'元<em class="ml-15"><i class="iconfont">&#xe637;</i>消费'+v.num+'次</em> </p>';

    str += ' </div>';
    str += '</li>';
    return str;
}
function admin_account_str(v) {
    var str="";
    str += '<li class="info-list" >';
    str += '<h2><div class="logo"> <img src="'+attachurl+v.logo+'"/>'+v.shop_name+'</div>';
    str+='</h2>';
    str +=' <p> <span class="red">提现金额：￥'+v.amount+'</p>';
    str +=' <p><span>手续费：￥'+v.transfer+'</span></p>';
    str +=' <p><span>提现方式：';
    if (v.paytype=='1' ) {
        str+='微信';
    }else if(v.paytype=='2'){
        str+='支付宝';
    }else if(v.paytype=='3'){
        str+='银行卡';
    }else if(v.paytype=='4'){
        str+='余额';
    }
    str +=' </span></p>';
    str += ' <p > <span>申请状态：';
    if (v.status=='1'){
        str += ' <em class="green">已提现</em>';
    }else if (v.status=='2'){
        str += ' <em class="red">已驳回</em>';
    }else{
        str += ' <em class="red">待审核</em>';
    }
    str += '</span> </p>';
    if( v.nickname!=null &&  v.nickname !='') {
        str += ' <p > <span>申请人：<img class="account-avatar" src="' + v.avatar + '"/>' + v.nickname + '</span> </p>';
    }
    str +=' <p > <span>申请时间：'+unixToDatetime(v.addtime)+'</span> </p>';
    if(v.check_admin!=null && v.check_admin !=''){
        str +=' <p > <span>处理人：<img class="account-avatar" src="'+v.check_avatar+'/>'+v.check_nickname+'</span> </p> ';
    }
    if(v.checktime!=null && v.checktime !=''){
        str +=' <p > <span>处理时间：'+unixToDatetime(v.checktime)+'</span> </p> ';
    }
    str +='  <h3>';
    str += '<a class="current" href="javascript:;" onclick="admin_check_account(this,1,' + v.cash_id + ')" >确认打款</a>';
    str += '<a href="'+createAppUrl('admin', 'account')+'&id='+v.cash_id+'" >查看详情</a>';

    str+='  </h3>  </li>';
    return str;
}
function withdraw_record_str(v) {
    var str="";
    str += '<li class="info-list" >';

    str +=' <p> <span class="red">提现金额：￥'+v.amount+'</p>';
    str +=' <p><span>手续费：￥'+v.transfer+'</span></p>';
    str +=' <p><span>提现方式：';
    if (v.paytype=='1' ) {
        str+='微信';
    }else if(v.paytype=='2'){
        str+='支付宝';
    }else if(v.paytype=='3'){
        str+='银行卡';
    }else if(v.paytype=='4'){
        str+='余额';
    }
    str +=' </span></p>';
        str += ' <p > <span>申请状态：';
        if (v.status=='1'){
            str += ' <em class="green">已提现</em>';
        }else if (v.status=='2'){
            str += ' <em class="red">已驳回</em>';
        }else{
        str += ' <em class="red">待审核</em>';
    }
        str += '</span> </p>';


    str +=' <p > <span>申请时间：'+unixToDatetime(v.addtime)+'</span> </p>';

    str +='  <h3>';
    ;
    str += '<a  class="current" href="'+createAppUrl('user', 'withdraw_record')+'&id='+v.cash_id+'" >查看详情</a>';

    str+='  </h3>  </li>';
    return str;
}
function account_str(type,flag,v) {
    var str="";
    str += '<li class="info-list">';
    str += '<div>';
    str += '<h2 class="redb">￥';
    if(type == '1'){
        str += v.amount;
        var url = createAppUrl('shop_admin', 'account') + '&id=' + v.cash_id;
        var time =unixToDatetime(v.addtime);
    }else {
        var time =unixToDatetime(v.createtime);
        if (flag == 0) {
            str += v.price;
            var url = createAppUrl('order', 'detail') + '&id=' + v.orderid;
        } else {
            str += v.paymoney;
            var url = createAppUrl('shop_admin', 'discount') + '&id=' + v.id;
        }
    }
    str +='</h2>';

    str += '<p>';
    str += ' <i class="iconfont">&#xe669;</i>'+v.ordersn;
    str += ' <i class="ml_15 iconfont">&#xe7b0;</i>'+time;
    str += '</p>';
    str += ' </div><div class="score" >';
    str += '';
    str += '<a href="'+url+'">';
    str += '<i class="iconfont" >&#xe604;</i></a>';

    str += '</div> ';
    str += '</li>';
    return str;
}

function goods_str(v) {
    var str="";
    str += '<li class="info-list"  onclick="location.href='+createAppUrl('shop_admin', 'goods')+'&type=1&id='+v.goods_id+'>';
    str += '<img src="'+attachurl+v.thumb+'">';
    str += '<div class="text">';
    str += '<h2>'+v.title+'</h2>';
    str += '<p class="red">';
    str += '售价：'+v.marketprice;
    if (v.time_money>0){
        str += '<em class="ml-15">秒杀价：'+v.time_money+'</em>';
    }
    if (v.groupprice>0){
        str += '<em class="ml-15">团购价：'+v.groupprice+'</em>';
    }
    str += '</p></div><div class="pro-list">';
    if (v.is_hot==1){
        str += '<i>首页推荐</i>';
    }
    if (v.is_time==1){
        str += '<i>限时秒杀</i>';
    }
    if (v.is_group==1){
        str += '<i>拼团</i>';
    }
    str += ' </div><div class="score" onclick="downscore(this)"><img src="../addons/yc_youliao/public/images/b_down.png" > ';
    str += '<div class="down-list-pro">';
    str += '<a href="'+createAppUrl('shop_admin', 'goods')+'&type=1&id='+v.goods_id+'"><i class="iconfont" style="color: #4fc0ea">&#xe62d;</i>编辑</a>';
    str += '<a href="javascript:;" onclick="deletegoods('+v.goods_id+',this);"><i class="iconfont" style="color: #F5628C">&#xe635;</i>删除</a>';

    str += '</div></div> ';
    str += '</li>';
    return str;
}
function order_info_str(v) {
    var str="";
    str += '<li class="space_list_li bg_white mb_10">';
    str += '<div class="my_dis_content f_14 c_999 am-cf mt_10 z">编号：' + v.ordersn + '</div>';
    str += '<div class="d_time">' + v.createtime + '</div>';
    str += '<div class="clearfix"></div>';
    str += '<div class="listDiv_group mr_10 mt_5 my_dis_group am-cf">';
    str += '<a href="' + createAppUrl('detail', 'display') + '&id=' + v.id + '">';
    str += ' <div class="listDiv_groupImg  mr_10">';
    if (v.con.thumbs) {
        str += '<img class= "radius_50" src = "' + attachurl+v.con.thumbs[0] + '" >';
    }
    str += '<h6 class="listDiv_groupH6 mt_5 cl">' + v.con.title + '</h6>';
    str += '<div >';
    if(v.infoprice >0){
        str += '<div class="m-5">支付：<span class="red">￥'+v.infoprice+'</span></div>';
    }else if(v.zdprice >0){
        str += '<div class="m-5">支付：<span class="red">￥'+v.zdprice+'</span></div>';
        if(v.dingtime!=null && v.dingtime !=''){
            str += '<div class="m-5">置顶至'+unixToDatetime(v.dingtime)+'</div>';
        }
    }

    str += '</div>';
    str += '</div>';
    str += ' </a>';
    str += '</div>';
    str += '<div class="my_dis_love am-cf">';
    if(v.nickname !='' && v.nickname !=null){
        str += '<span class="ml_15"><img src="'+v.avatar+'"> <em>'+v.nickname+'</em></span>';
    }
    str += '</div>';
    str += '<div class="clearfix"></div>';
    str += '</li>';
    return str;
}
function check_shop_str(v) {
    var str="";
    str += '<li class="info-list" >';
    str += '<h2><i></i><span>'+v.cate_name+'</span><em><img src="../addons/yc_youliao/public/images/g_time.png">';

    if (v.applytime != ''&& v.applytime != null ) {
        str+=unixToDatetime(v.applytime);
    }else{
        str+=unixToDatetime(v.starttime);
    }
    str+='</em></h2>';
    str +=' <p onclick="location.href='+createAppUrl('shop_admin', 'info')+'&shop_id='+v.shop_id+'&check=1><img src="'+v.logo+'"';
    str +=' <span>'+v.shop_name+'</span>';
    str +='</p>';
    if(v.area_name!='' && v.area_name!=null){
        str +=' <p class="borderb"><img src="../addons/yc_youliao/public/images/list_icon.png"><span class="noborder">'+v.area_name+'</span></p>';
    }
    str+='<h3><span class="label label-info">';
    if (v.f_type==1 ) {
        str+='店铺入驻';
    }else if(v.f_type==2){
        str+='首页推荐';
    }else if(v.f_type==3){
        str+=' 秒杀专场';
    }else if(v.f_type==4){
        str+=' 拼团';
    }else if(v.f_type==5){
        str+='优惠买单';
    }

    str+='</span>';
    if(v.status==1){
        str += '<a class="current" href="'+createAppUrl('shop_admin', 'display')+'&shop_id='+v.shop_id+'" >管理</a>';
        str += '<a href="javascript:;" onclick="admin_check_shop(this,2,' + v.shop_id + ')" >下架</a>';
    }else {
        str += '<a class="current" href="javascript:;" onclick="admin_check_shop(this,1,' + v.shop_id + ')" >审核通过</a>';
        str += '<a href="javascript:;" onclick="admin_check_shop(this,2,' + v.shop_id + ')" >审核不通过</a>';
    }

    str+='  </h3>  </li>';
    return str;
}
function renew_str(){
    var str="";
    str += '<li class="space_list_li bg_white mb_10">';
    str += '<div class="my_dis_content f_14 c_999 am-cf mt_10 z">编号：' + v.ordersn + '</div>';
    str += '<div class="d_time">' + v.createtime + '</div>';
    str += '<div class="clearfix"></div>';
    str += '<div class="listDiv_group mr_10 mt_5 my_dis_group am-cf">';
    str += '<a href="' + createAppUrl('shop_admin', 'renew_re') + '&shop_id=' + v.shop_id + '">';
    str += ' <div class="listDiv_groupImg  mr_10">';
    if (v.logo) {
        str += '<img class= "radius_50" src = "' + v.logo + '" >';
    } else {
        str += '<img src="../addons/yc_youliao/public/images/fabu_2.png">';
    }
    str += '<h6 class="listDiv_groupH6 mt_5 cl">' + v.shop_name + '</h6>';
    str += '<div class="list_desc ">';
    str += '<p class="red f_16 ml_15">' + v.price+'</p>';
    str += '</div>';
    str += '</div>';
    str += ' </a>';
    str += '</div>';
    str += '<div class="my_dis_love am-cf">';
    if(v.nickname !='' && v.nickname !=null){
        str += '<span class="ml_15"><img src="'+v.avatar+'"> <em>'+v.nickname+'</em></span>';
    }
    str += '</div>';
    str += '<div class="clearfix"></div>';
    str += '</li>';
    return str;
}
function mydiscount_str(v) {
    var str="";
    str += '<li class="space_list_li bg_white mb_10">';
    str += '<div class="my_dis_content f_14 c_999 am-cf mt_10 z">编号：' + v.ordersn + '</div>';
    str += '<div class="d_time">' + v.createtime + '</div>';
    str += '<div class="clearfix"></div>';
    str += '<div class="listDiv_group mr_10 mt_5 my_dis_group am-cf">';
    str += '<a href="' + createAppUrl('shop', 'display') + '&shop_id=' + v.shop_id + '">';
    str += ' <div class="listDiv_groupImg  mr_10">';
    if (v.logo) {
        str += '<img class= "radius_50" src = "' + v.logo + '" >';
    } else {
        str += '<img src="../addons/yc_youliao/public/images/shop.png">';
    }
    str += '<h6 class="listDiv_groupH6 mt_5 cl">' + v.shop_name + '</h6>';
    str += '<div class="list_desc ">';
    str += '<p class="red f_16 ml_15">' + v.paymoney + '<del class=" ml_15 c_999 f_12 ">' + v.aftermoney + '</del></p>';
    str += '</div>';
    str += '</div>';
    str += ' </a>';
    str += '</div>';
    str += '<div class="my_dis_love am-cf">';
    if(v.nickname !='' && v.nickname !=null){
        str += '<span class="ml_15"><img src="'+v.avatar+'"> <em>'+v.nickname+'</em></span>';
    }else{
    str += ' <a href="' + createAppUrl('shop', 'discount') + '&shop_id=' + v.shop_id + '" class="follow " dzapp-action="follow_uid_808012"><em>再买一单</em></a>';
    }
    str += '</div>';
    str += '<div class="clearfix"></div>';
    str += '</li>';
    return str;
}
function ring_str(v,isshang) {
    var str="";
    str += ' <div class="rlist">';
    str += ' <div class="box">';
    str += '<div class="my_dis_left am-cf" onclick="location.href='+createAppUrl('ring', 'detail')+'&id='+v.ring_id+'">';
    str += ' <div class="dis_left_pic">';
    str += ' <a href="">';
    str += '<img  src="' + v.avatar + '">';
    str += ' </a>';
    str += ' </div>';
    str += ' <div class="dis_left_info">';
    str += ' <h2 class="wrap">';
    str += ' <span class="">' + v.nickname + '</span>';
    str += ' <span class="f_12 c_999">';
    str += v.distance+'km</span>';
    str += '</h2>';
    str += '</div>';
    str += ' <div class="my_follow">';
    str += ' <div class="feed_follow">';
    if (v.isme==1) {
        str += ' <a href="javascript:;" onclick="delete_r(this,'
        str += v. ring_id+');" class="feed_delete "><em>删 除</em></a>';
    }else {
        str += ' <a href="javascript:;" onclick="guanzhu(this,'
        str += v. ring_id+');" class="follow "><em>';
        if (v.guanzhu == 1) {
            str +=' <span class="green">已关注</span>';
        }else{
            str += ' +关注';
        }
        str += '  </em></a>';
    }
    str += ' </div></div>';
    str += '  </div>';
    str += ' <div class="content">';
    str += '  <div class="main ring">';
    str += '   <p class="txt">';
    str += v.info;
    str += '</p>';
    if(v.xsthumb != null && v.xsthumb != undefined){
        str += '<div class="my-gallery">';
        $.each(v.xsthumb, function (key, x) {
            str += '  <figure><a href="' +  x + '" class="gallery-a " ><img class="pic img" ';
            str += ' src=' +  x + '>   </a></figure> ';
        })
        str += '</div>';
    }

    str += '  </div> ';
    str += ' <div class="info"> ';
    if(isshang==0){
        str += '<a class="comment-u" onclick="shang_show(' + v.ring_id + ');" ><span class="shang-icon" ></span> </a>'
    }

    str += '<span class="time">'+unix_to_datetime(v.addtime)+'</span> ';
    str += '<a class="comment-u" onclick="comment(this)" ><i class="iconfont">&#xe62c;</i> ';
    str += ' <span class="ml_3 pingnum"> '+v.pnum+'</span></a> ';
    str += ' <a class="praise';
    if(v.z != null ){
        $.each(v.z[0], function (key, d) {
            if(d.iszan==1) str += ' ye';
        })
    }
    str +='" onclick="zan(this,'+v.ring_id+');"><i class="iconfont">&#xe643;</i>';
    str += '<span class="ml_3 zanum">'+v.znum+'</span></a>';
    str += '</div>';
    str += ' <div class="text-box">';
    str += ' <textarea class="comment" placeholder="评论…" autocomplete="off"></textarea>';
    str += ' <button class="btn" onclick="ping(this,'+v.ring_id+');">回 复</button>';
    str += '  <span class="word"><span class="length">0</span>/140</span>';
    str += '     <div class="clearfix"></div>';
    str += '    </div>';

    if(v.z != null ){
        str += '<div class=" zan-total zan-avatar">';
        $.each(v.z[0], function (key, d) {
            str += '<img  src=' + d.avatar + '/>';
        })
    }else{
        str += ' <div class=" zan-avatar"> ';
    }
    str += '   </div>';
    str += ' <div class="clearfix"></div>';
    if(v.p){
        str += '<div class="comment-list">';
        $.each(v.p[0], function (key, d) {
            str += '<div class="comment-box" user="self">';
            str += '<img class="myhead" src=' + d.avatar + ' alt=""/>';
            str += '<div class="comment-content">';
            str += '<p class="comment-text"><span class="user">';
            str += d.nickname + '</span></p><span class="pingtext">' + d.info + '</span>';
            str += '<p class="comment-time">' +unix_to_datetime(d.addtime);
            if(d.isping==1){
                str += '<a href="javascript:;" class="comment-operate" onclick="cancelPing(this,' + v.ring_id + ')";><i class="iconfont">&#xe635;</i></a> ';
            }
            str += '</p></div></div>';
        })
    }
    str += '</div></div></div><div class="clearfix"></div>' ;
    return str;
}
function pagelist(page,url,content,list,op){
    $(content).dropload({
        scrollArea : window,
        loadDownFn : function(me){
            page++;
            var str="";
            $.ajax({
                type: 'GET',
                url: url+'&page='+page+'&isajax=1',
                dataType: 'json',
                success: function(data){
                    // 请求回来的数据如果小于0则锁住
                    var arrLen = data.length;
                    if(arrLen > 0){
                        if(op=="mydiscount"){
                        $.each(data.list, function (index, v) {
                              str+=  mydiscount_str(v);
                        })
                        }else if(op=="list"){
                                var adv_type=$('#adv_type').val();
                                var btn=$('#btn').val();
                                str+= appentList( data, adv_type, app_link, attachurl, btn,data.logo);

                        }else if(op=="ring"){
                            $.each(data.list, function (index, v) {
                                str+=  ring_str(v,data.isshang);
                                photoSwipe();
                                getImageSize();
                            })
                        }else if(op=="order"){
                            $.each(data.list, function (index, v) {
                                str+=  order_str(v);
                            })
                        }else if(op=="admin_info"){
                            $.each(data.list, function (index, v) {
                                str+=  admin_info_str(v);

                            })
                        }else if(op=="check_shop"){
                            $.each(data.list, function (index, v) {
                                str+=  check_shop_str(v);

                            })
                        }else if(op=="fans"){
                            if(data.type==1){
                                $.each(data.list, function (index, v) {
                                    str+=  black_str(v);
                                })
                            }else{
                            $.each(data.list, function (index, v) {
                                str+=  fans_str(v);
                            })
                            }
                        }else if(op=="order_info"){
                            $.each(data.list, function (index, v) {
                                str+=  order_info_str(v);

                            })
                        }else if(op=="goods"){
                            $.each(data.list, function (index, v) {
                                str+= goods_str(v);

                            })
                        }else if(op=="account"){
                            $.each(data.list, function (index, v) {
                                str+=  account_str(data.type,data.flag,v);

                            })
                        }else if(op=="admin_account"){
                            $.each(data.list, function (index, v) {
                                str+=  admin_account_str(v);

                            })
                        }else if(op=="shop_fans"){
                            $.each(data.list, function (index, v) {
                                str+=  shop_fans_str(v);

                            })
                        }else if(op=="shop_admin"){
                            $.each(data.list, function (index, v) {
                                str+=  shop_admin_str(v);

                            })
                        }else if(op=="red_record"){
                            $.each(data.list, function (index, v) {
                                str+=  red_record_str(data.type,v);

                            })

                        }else if(op=="redpackage"){
                            $.each(data.list, function (index, v) {
                                str+=  redpackage_str(v);

                            })
                        }else if(op=="withdraw_record"){
                            $.each(data.list, function (index, v) {
                                str+=  withdraw_record_str(v);

                            })
                        }else if(op=="renew") {
                            $.each(data.list, function (index, v) {
                                str += renew_str(v);
                            })
                        }
                        // 如果没有数据
                    }else if(! $(content).hasClass('.nopicDiv')){
                        str ='<div class="nopicDiv"> <img class="nopic" src="../addons/yc_youliao/public/images/tuan_pic3.png" /><span class="nonetext">亲，暂时没有更多了~</span></div>';
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                    // 为了测试，延迟1秒加载
                    $('.listloading').remove();
                        // 插入数据到页面，放到最后面
                        $(list).append(str);
                        //重新处理圈子滑动图片的方法
                        if(op=="ring" || op=="redpackage"){
                            // photoSwipe();
                            // getImageSize();
                        }
                        // 每次数据插入，必须重置
                        me.resetload();

                },
                error: function(xhr, type){
                    // alert('Ajax error!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });
}
function getMsgReq(page,url,content,list){
    $(content).dropload({
        scrollArea : window,
        loadDownFn : function(me) {
        page++;
        var str="";
    $.ajax({
        url: url+'&page='+page+'&isajax=1',
        type: "get",
        dataType: 'json',
        success:function(data){
            var arrLen = data.length;
           if(arrLen > 0){
                $.each(data.list, function (index, v) {
                    str+= info_str(v,data.isshang);

                })
            }else if(data.str != null && data.str != ''){  // 自定义
                str+=data.str;
            }else {//无数据
                str +='<div class="nopicDiv"> <img class="nopic" src="../addons/yc_youliao/public/images/tuan_pic3.png" /><span class="nonetext">亲，暂时没有更多啦~</span></div>';
                // 锁定
                me.lock();
                // 无数据
                me.noData();
            }
            setTimeout(function(){
                // 插入数据到页面，放到最后面
                $(list).append(str);
                // 每次数据插入，必须重置
                me.resetload();
            },1000);
        },
        error: function(xhr, type){
            // alert('Ajax error!');
            // 即使加载出错，也得重置
            me.resetload();
        }

    });
}
});
}
function getPageReq(page,url,content,list){
    $(content).dropload({
        scrollArea : window,
        loadDownFn : function(me) {
            page++;
            var str="";
            $.ajax({
                url: url+'&page='+page+'&isajax=1',
                type: "get",
                dataType: 'json',
                success:function(data){
                    var arrLen = data.length;
                    if(arrLen > 0){
                            str+= data.str;
                    }else {//无数据
                        str +='<div class="nopicDiv"> <img class="nopic" src="../addons/yc_youliao/public/images/tuan_pic3.png" /><span class="nonetext">亲，暂时没有更多啦~</span></div>';
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                    setTimeout(function(){
                        // 插入数据到页面，放到最后面
                        $(list).append(str);
                        // 每次数据插入，必须重置
                        me.resetload();
                    },1000);
                },
                error: function(xhr, type){
                    // alert('Ajax error!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }

            });
        }
    });
}
function ajaxReq(url){
    var page=0;
    var adv_type=$('#adv_type').val();
    var btn=$('#btn').val();
    $.ajax({
        type: 'get',
        url: url,
        data: { page: page},
        dataType: 'json',
        success: function (data) {

            var str="";
            if(data.status=='1') {
                str = appentList( data, adv_type, app_link, attachurl, btn,data.logo);
            }else{
                str ='<div class="nopicDiv"><img class="nopic" src="../addons/yc_youliao/public/images/tuan_pic3.png" /><span class="nonetext">亲，暂时没有更多了~</span></div>';
            }
            $('.NotUesed2').html(str);

        }
    })


}

function getChildCate(id){
    $('#child').html('');
    $('#child').show();
    var url=createAppUrl('ajax_req', 'getChildCate');
    url=url+'&id='+id;
    $.ajax({
        url: url,
        type: "get",
        dataType: 'json',
        success:function(data){
            if(data.len>0){
                var str='';
                var req_url = createAppUrl('edit', 'display')+'&mid=';
                str+='<div class="labelbox">';
                str+='<div class="labeltitle">请选择发布类别</div>';
                $.each(data.list, function (index, v) {
                    str += '<a href="' + req_url  +v.id+'">';
                    if(v.thumb != null || v.thumb != undefined){
                        str += '<img class="icon" src="'+v.thumb+'"/>';
                    }

                    str +=v.name+ '</a>';
                })
                str+='</div>';
                $('#child').html(str);
            }else{
                window.location.href = createAppUrl('edit', 'display')+'&mid='+id;
            }
        }
    })
}