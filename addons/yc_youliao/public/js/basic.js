require.config({
    urlArgs: "v=" +  (new Date()).getTime(), //getHours
    paths: {
        'weixinJs':  '/addons/yc_youliao/public/js/weixinJs',
        'common':  '/addons/yc_youliao/public/js/common'

    },

});
 function createWebUrl(dostr,opstr,obj){
    var str = '&do='+dostr+'&op='+opstr;
    for(t in obj){
        str += '&'+t+'='+obj[t];
    }
    return window.sysinfo.siteroot+'web/index.php?i='+window.sysinfo.uniacid+'&c=site&a=entry'+str+'&m=yc_youliao';
}
function createAppUrl(dostr,opstr,obj){
    var str = '&do='+dostr+'&op='+opstr;
    for(t in obj){
        str += '&'+t+'='+obj[t];
    }
    return window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry'+str+'&m=yc_youliao';
}

function clearNoNum(obj){
    //修复第一个字符是小数点 的情况.
    if(obj.value !=''&& obj.value.substr(0,1) == '.'){
        obj.value="";
    }

    obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数
    if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
        if(obj.value.substr(0,1) == '0' && obj.value.length == 2){
            obj.value= obj.value.substr(1,obj.value.length);
        }
    }
}
function checkphone(phone){
    var flag = false;
    var reg0 =  /^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;   //判断 固话
    var reg1 =/^((\(\d{2,3}\))|(\d{3}\-))?(13|15|18)\d{9}$/;                     //判断 手机
    if (reg0.test(phone)) flag=true;
    if (reg1.test(phone)) flag=true;
    if(!flag){
        tip("电话号码，格式不对");
        tip_close();
        return false;
    }
}
$(document).ready(function(){
        $("tr:first").addClass("trhead");//第一行
        $("tr:even").addClass("tr-2");//偶数行
    $(".orderblock").click(function() {
        $(".order-by-input").toggle();
        $(".orderblock").toggle();
    });
    $(".dis_randomopen").click(function() {
        $(".dis_random").show();
        $(".dis_other").hide();
    });
    $(".dis-zk-c").click(function() {
        $(".dis_random").hide();
        $(".dis-money").hide();
        $(".dis_other").show();
        $(".dis-zk").show();

    });
    $(".dis-money-c").click(function() {
        $(".dis_random").hide();
        $(".dis-zk").hide();
        $(".dis_other").show();
        $(".dis-money").show();

    });

    $('.add_a_inco').click(function(){
        var valueinput =  $(this).prev().find('input');
        var value = valueinput.val();
        if(value == ''){
            tip('请先在输入框输入标签名称');tip_close();return false;
        }
        var str = '<label><input type="checkbox" name="inco[]" value="'+value+'" checked="checked"> '+value+'</label>';
        $(this).parents('.input_form').find('.inco_append_box').append(str);
        valueinput.val('').focus();
    });
    $('.admintype-3').click(function(){
        $('.password').css('display','none');
    });
    $('.admintype-1').click(function(){
        $('.password').css('display','block');
    });



    });

$(".op-toggle-1").click(function() {
    $(".cotent-toggle").show();
});
$(".op-toggle-2").click(function() {
    $(".cotent-toggle").hide();

});


function opstatus(shop_id,op,opt){
    var url=createWebUrl('ajax_req',op);
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'shop_id':shop_id,'opt':opt},
        success:function(data){
            tip(data.str);
            tip_close();
            window.location.reload();

        }
    });
}
function adminstatus(admin_id,op,opt){
    var url=createWebUrl('ajax_req',op);
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'admin_id':admin_id,'opt':opt},
        success:function(data){
            tip(data.str);
            tip_close();
            window.location.reload();

        }
    });
}
function changeline(value1){
    $('select[name="ccate_id"]').find("option").remove();
    var op='changeline';
    var url=createWebUrl('ajax_req',op);
    fetchbyajax1(url,value1,op);
}
function changearea(value1){
    $('select[name="area_id"]').find("option").remove();
    $('select[name="business_id"]').find("option").remove();
    var op='changearea2';
    var url=createWebUrl('ajax_req',op);
    fetchbyajax2(url,value1,op);
}
function changebusiness(value1){
    $('select[name="business_id"]').find("option").remove();
    var op='changebusiness';
    var url=createWebUrl('ajax_req',op);
    fetchbyajax3(url,value1,op);
}


function copyit(){
        $('.copyurl').zclip({
            path: './resource/components/zclip/ZeroClipboard.swf',
            copy: function(){
                return $(this).attr('data-url');
            },
            afterCopy: function(){
                $('.copyurl').off();
                tip('复制成功');
                tip_close();
            }
        });



}
function randomOpen(){
    $('.qiandao_des').css('display','block');
    $('.qiandao_des').html('此处填随机签到最大整数积分');
}
function randomClose(){
    $('.qiandao_des').css('display','none');
}


function search_members() {
    if( $.trim($('#search-kwd').val())==''){
        tip('请输入关键词');
        tip_close();
        return;
    }
    $("#module-menus").html("正在搜索....")
    var url=createWebUrl('shop_admin','query');
    $.get(url, {
        keyword: $.trim($('#search-kwd').val())
    }, function(dat){
        $('#module-menus').html(dat);
    });
}
function check_account(obj,type,id){
    var url=createWebUrl('ajax_req','recash');
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {id:id,type:type},
        success:function(data){
            if (data.status == 1) {
                if(type==1){
                    tip('提现操作成功');
                }else{
                    tip('驳回现申请操作成功');
                }
                tip_close();
                $(obj).parents('tr').remove();
            }else{
                tip(data.str);
                tip_close();
            }
        }
    });
}
function showEnterPrice(){
    $("#enterPrice").show();
    $("#renewPrice").show();
}
function hideEnterPrice(){
    $("#enterPrice").hide();
    $("#renewPrice").hide();
}
function renewPrice(){
    $("#renewPrice").show();
    $("#enterPrice").hide();
}