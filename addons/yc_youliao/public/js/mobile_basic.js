$(function(){
        // $('#return-top').hide();

            $(window).scroll(function(){
                if($(window).scrollTop()>100){
                    // $('#return-top').fadeIn(300);

                    $('#home-hd-bar').css('background','rgba(0,0,0,.3)');
                    $('.am-header').css('background','rgba(0,0,0,.3)');
                }else{
                    //$('#return-top').fadeOut(200);
                    $('#home-hd-bar').css('background','none');
                    $('.am-header').css('background','#fff');
                }

            });
            $('#return-top').click(function(){

                $('body,html').animate({scrollTop:0},200);
                return false;

            })
    $('#header-more').click(function(){
        $('.slide').toggle();
    })
    $('#intro').click(function(){
        $('#intro-detail').toggle();
    })


    $('.banner-search').click(function(){
        $('.search-form').toggle();
        temp1=$(".search-form").is(":hidden");//是否隐藏
        if(temp1){
            $('.info-content').css('margin' , "55px 0 0 0");
        }else{
            $('.info-content').css('margin' , "0");
        }
    })
    temp1=$(".search-form").is(":hidden");//是否隐藏
    if(temp1){
        $('.info-content').css('margin' , "55px 0 0 0");
    }else{
        $('.info-content').css('margin' , "0");
    }


    var num = $('.notice_active').find('li').length;
    if(num > 1){
        var time=setInterval('timer(".notice_active")',3500);
        $('.gg_more a').mousemove(function(){
            clearInterval(time);
        }).mouseout(function(){
            time = setInterval('timer(".notice_active")',3500);
        });
    }

    $(".news_ck").click(function(){
        location.href = $(".notice_active .notice_active_ch").children(":input").val();
    })

    $('.retrie dt a').click(function(){
        var $t=$(this);
        if($t.hasClass('up')){
            $(".retrie dt a").removeClass('up');
            $('.downlist').hide();
            $('.mask').hide();
        }else{
            $(".retrie dt a").removeClass('up');
            $('.downlist').hide();
            $t.addClass('up');
            $('.downlist').eq($(".retrie dt a").index($(this)[0])).show();
            $('.mask').show();
        }
    });
    $(".area ul li a:contains('"+$('#area').text()+"')").addClass('selected');
    $(".wage ul li a:contains('"+$('#wage').text()+"')").addClass('selected');


    $('#messagelist .item').click(function(){
        $('#messagelist .item').removeClass('now');
        $(this).addClass('now');
        $('.tab').hide();
        $('.tab').eq($(this).index()).show();
    });
    $('#messagelist .item').eq(0).click();

    $('.shuoming').click(function(){
        $(".groupdetail").toggle();

    })


    $('#order_qr_code').click(function(){
        var url =$('#order_qr_url').text();
        showBigImage(url,$('#order_qr_code'));

    });

    $('.mui-table-view-cell').click(function() {
        //给当前点击增加样式
        $(".mui-pull-right").attr("src","../addons/yc_youliao/public/images/radio_a.png");
        $(this).find(".mui-pull-right").attr("src","../addons/yc_youliao/public/images/radio_b.png");
    });

    $('#js-wx').click(function() {
        $('.input_pay').addClass('none');
        $('#paytype').val('1');
    });
    $('#js-ye').click(function() {
        $('.input_pay').addClass('none');
        $('#paytype').val('4');
    });
    $('#js-alipay').click(function() {
        $('.input_pay').removeClass('none');
        $('#alipay').show();
        $('#bank').hide();
        $('#paytype').val('2');
    });
    $('#js-bank').click(function() {
        $('.input_pay').removeClass('none');
        $('#bank').show();
        $('#alipay').hide();
        $('#paytype').val('3');
    });




    });


//创建cookie
function setCookie(name, value, expires, path, domain, secure) {
    var cookieText = encodeURIComponent(name) + '=' + encodeURIComponent(value);
    if (expires instanceof Date) {
        cookieText += '; expires=' + expires;
    }
    if (path) {
        cookieText += '; expires=' + expires;
    }
    if (domain) {
        cookieText += '; domain=' + domain;
    }
    if (secure) {
        cookieText += '; secure';
    }
    document.cookie = cookieText;
}

//获取cookie
function getCookie(name) {
    var cookieName = encodeURIComponent(name) + '=';
    var cookieStart = document.cookie.indexOf(cookieName);
    var cookieValue = null;
    if (cookieStart > -1) {
        var cookieEnd = document.cookie.indexOf(';', cookieStart);
        if (cookieEnd == -1) {
            cookieEnd = document.cookie.length;
        }
        cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length, cookieEnd));
    }
    return cookieValue;
}

//删除cookie
function unsetCookie(name) {
    document.cookie = name + "= ; expires=" + new Date(0);
}

function showlist(){
    $("#showlist").toggle();
    $("#add").toggle();
    $("#xadd").toggle();
}

    function timer(opj){
        $(opj).find('ul').animate({
            marginTop : "-50px"
        },500,function(){
            $(this).css({marginTop : "0"}).find("li:first").appendTo(this);
        })
    }

function qiandao(url){
    $.ajax({
        type:'post',
        url: url,
        dataType: 'json',
        data:{'op':'display'},
        success:function(data){
            if(data.status=='1'){
                tip(data.str);
                $('.qiandao').text('今日已签到');
                tip_close();
            }else{
                tip(data.str);
                tip_close();
            }

        }
    });
}

function changeColor(x){

    //删除其他事件的css样式
    $('.name').removeClass('listactive');
    $('.leftnav').removeClass('listactive2');
    //增加点击样式
    $(x).children("div").addClass("listactive");


}
function changeColor2(x){

    //删除其他事件的css样式
    $('.name').removeClass('listactive');
    $('.leftnav').removeClass('listactive2');
    //增加点击样式
    $(x).addClass("listactive2");


};



function comment(obj){
    $(obj).parents('.rlist').find('.text-box').toggle();
}
function zan(obj,id){
    var url=createAppUrl('ring', 'display');
    ajax_req(obj,url,id,'zan');
}
function ping(obj,id){
    var url=createAppUrl('ring', 'ping');
    ajax_req(obj,url,id,'ping');
}

function delete_r(obj,id){
    var url=createAppUrl('ring', 'delete');
    ajax_req(obj,url,id,'delete');
}
function cancelPing(obj,id){
    var url=createAppUrl('ring', 'cancelPing');
    ajax_req(obj,url,id,'cancelPing');
}
function guanzhu(obj,id){
    var url=createAppUrl('ring', 'guanzhu');
    ajax_req(obj,url,id,'guanzhu');
}
function ajax_req(obj,url,id,op) {
    var info=$(obj).parents('.rlist').find('.comment').val();
    $.ajax({
        type: 'post',
        url: url,
        dataType: 'json',
        data: {'id': id, 'op': op,'info': info},
        success: function (data) {
            if (data.status == '1') {
                if(op=="delete"){
                    $(obj).parents('.rlist').remove();
                }else if(op=="zan"){
                    $(obj).toggleClass('ye');
                    var zanum= $(obj).children('.zanum').html();
                    if(data.add==1){
                        var n=parseInt(zanum)+1;
                        var str= '<img src="'+data.avatar+'"/>';
                        if(!$(obj).parents('.rlist').hasClass('zan-total')){
                            $(obj).parents('.rlist').find('.zan-avatar').addClass('zan-total');
                        }
                        $(obj).parents('.rlist').find('.zan-avatar').prepend(str);
                    }else if(data.add==0){
                        if(parseInt(zanum)>0){
                            var n=parseInt(zanum)-1;
                        }

                        var str="";
                        if(data.num !="0"){
                            $.each(data.avatar,function(index,value){
                                str += '<img src="'+value.avatar+'"/>';
                            })

                        }else{
                            $(obj).parents('.rlist').find('.zan-avatar').removeClass('zan-total');
                        }
                        $(obj).parents('.rlist').find('.zan-avatar').html(str);

                    }
                    $(obj).children('.zanum').html(n);

                }else if(op=="ping"){
                    var pingnum= $(obj).parents('.rlist').find('.pingnum').html();
                    var n=parseInt(pingnum)+1;
                    $(obj).parents('.rlist').find('.pingnum').html(n);
                    $('.text-box').hide();
                    var str ='<div class="comment-box">';
                    str += '<img class="myhead" src="'+data.avatar+'"/>';
                    str +='<div class="comment-content">';
                    str +='<p class="comment-text"><span class="user">';
                    str += data.nickname+'</span></p><span class="pingtext">'+data.info+'</span>';
                    str +='<p class="comment-time">'+data.time;
                    str +='<a href="javascript:;" class="comment-operate" onclick="cancelPing(this,'+id+')";><i class="iconfont">&#xe635;</i></a></p></div></div>';
                    if(!$(obj).parents('.rlist').hasClass('comment-list')){
                        $(obj).parents('.rlist').find('.comment_flag').addClass('comment-list');
                    }
                    $(obj).parents('.rlist').find('.comment-list').prepend(str);

                }else if(op=="cancelPing"){
                    var pingnum= $(obj).parents('.rlist').find('.pingnum').html();
                    var n=parseInt(pingnum)-1;
                    $(obj).parents('.rlist').find('.pingnum').html(n);
                    $(obj).parents('.comment-box').remove();
                }else if(op=="guanzhu"){
                    if(data.guans=="1"){
                        $(obj).html('<span class="green">已关注</span>');
                    }else{
                        $(obj).html('+关注');
                    }

                }

            }else if(data.status == '0' && data.str !=""){
                tip(data.str);
                tip_close();
            } else {
                tip('系统繁忙，请您稍候再试');
                tip_close();
            }

        }
    });

}


function unix_to_datetime(unix) {
    var d = new Date(unix * 1000);    //根据时间戳生成的时间对象
    var date =
        (d.getMonth() + 1) + "-" +
        (d.getDate()) + " " +
        (d.getHours()) + ":" +
        (d.getMinutes());

    return date;
}
function unixToDatetime(unix) {
    var d = new Date(unix * 1000);    //根据时间戳生成的时间对象
    var date = (d.getFullYear()) + "-" +
        (d.getMonth() + 1) + "-" +
        (d.getDate()) + " " +
        (d.getHours()) + ":" +
        (d.getMinutes());

    return date;
}


    function retime(total_time){
    var days = parseInt(total_time/86400)
    var remain = parseInt(total_time%86400);
    var hours = parseInt(remain/3600)
    var remain = parseInt(remain%3600);
    var mins = parseInt(remain/60);
    var secs = parseInt(remain%60);
    var ret = "";
    if(days>0){
        days = days+"";
        if(days.length<=1) { days="0"+days;}
        ret+="<span class='day'>"+days+" </span>天 ";
    }
    if(hours>0){
        hours = hours+"";
        if(hours.length<=1) { hours="0"+hours;}
        ret+="<span class='hour'>"+hours+" </span> "+":";
    }
    if(mins>0){
        mins = mins+"";
        if(mins.length<=1) { mins="0"+mins;}
        ret+="<span class='min'>"+mins+" </span> "+":";
    }

    secs = secs+"";
    if(secs.length<=1) { secs="0"+secs;}
    ret+="<span class='sec'>"+secs+" </span> ";
    return ret;
}


function optionlabel(){
    $(".hint").css({"display":"block"});
    $(".box").css({"display":"block"});
}
function option_selected(){
    var ret= {
        no: "",
        all: []
    };
    if(!hasoption){
        return ret;
    }
    $(".optionid").each(function(){
        ret.all.push($(this).val());
        if($(this).val()==''){
            ret.no = $(this).attr("title");
            return false;
        }
    })
    return ret;
}

function noNumbers(e)
{
    var keynum
    var keychar
    var numcheck
    if(window.event) // IE
    {
        keynum = e.keyCode
    }
    else if(e.which) // Netscape/Firefox/Opera
    {
        keynum = e.which
    }
    keychar = String.fromCharCode(keynum);
//判断是数字,且小数点后面只保留两位小数
    if(!isNaN(keychar)){
        var index=e.currentTarget.value.indexOf(".");
        if(index >= 0 && e.currentTarget.value.length-index >2){
            return false;
        }
        return true;
    }
//如果是小数点 但不能出现多个 且第一位不能是小数点
    if("."== keychar ){
        if(e.currentTarget.value==""){
            return false;
        }
        if(e.currentTarget.value.indexOf(".") >= 0){
            return false;
        }
        return true;
    }
    return false  ;
}



function setImagePreview() {
    var preview, img_txt, localImag, file_head = document.getElementById("file_head"),
        picture = file_head.value;
    if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("您上传的图片格式不正确，请重新选择！"),
        !1;
    if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) preview.style.display = "block",
        preview.style.width = "63px",
        preview.style.height = "63px",
        preview.src = window.navigator.userAgent.indexOf("Chrome") >= 1 || window.navigator.userAgent.indexOf("Safari") >= 1 ? window.webkitURL.createObjectURL(file_head.files[0]) : window.URL.createObjectURL(file_head.files[0]);
    else {
        file_head.select(),
            file_head.blur(),
            img_txt = document.selection.createRange().text,
            localImag = document.getElementById("localImag"),
            localImag.style.width = "63px",
            localImag.style.height = "63px";
        try {
            localImag.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)",
                localImag.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = img_txt
        } catch(f) {
            return alert("您上传的图片格式不正确，请重新选择！"),
                !1
        }
        preview.style.display = "none",
            document.selection.empty()
    }
    return document.getElementById("DivUp").style.display = "block",
        !0
}

function getObjectURL(file) {
    var url = null ;
    if (window.createObjectURL!=undefined) { // basic
        url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}
function createAppUrl(dostr,opstr,obj){
    var str = '&do='+dostr+'&op='+opstr;
    for(t in obj){
        str += '&'+t+'='+obj[t];
    }
    return window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry'+str+'&m=yc_youliao';
}
function changeline(value1){
    $('select[name="ccate_id"]').find("option").remove();
    var op='changeline';
    var url=createAppUrl('ajax_req',op);
    fetchbyajax1(url,value1,op);
}
function changearea(value1){
    $('select[name="area_id"]').find("option").remove();
    $('select[name="business_id"]').find("option").remove();
    var op='changearea2';
    var url=createAppUrl('ajax_req',op);
    fetchbyajax2(url,value1,op);
}
function changebusiness(value1){
    $('select[name="business_id"]').find("option").remove();
    var op='changebusiness';
    var url=createAppUrl('ajax_req',op);
    fetchbyajax3(url,value1,op);
}
function changlocation(city_id,city_name,area_id,area_name){
    var op='change';
    var url=createAppUrl('location',op);
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'city_id':city_id,'area_id':area_id,'city_name':city_name,'area_name':area_name},
        success:function(data){
            if(data.status=='1'){
                tip('位置切换成功');
                tip_close();
                window.location.href = document.referrer;
            }else{
                tip('位置切换失败，请您稍候再试吧');
                tip_close();
            }

        }
    });
}

function changeadd(lat,lng){
    var op='changexy';
    var url=createAppUrl('changeadd',op);
    $.ajax({
        type: 'POST',
        url: url,
        data: {lat: lat, lng:lng,a_jax:'1'},
        dataType: 'json',
        success: function (data) {
            if(data.status=='1'){
                tip('位置切换成功');
                tip_close();
                $('.locatioaddress').text(data.address);
                $('.formatted').text(data.formatted_address);
                window.location.href = document.referrer;
            }else{
                tip('位置切换失败，请您稍候再试');
                tip_close();
            }
        }
    });
}

function admin_check_info(obj,status,id,dingtime){
    if(status==6){
        confirm('删除后不可恢复，确定要删除吗？');
    }
    var op='check_info';
    var url=createAppUrl('admin',op);
    $.ajax({
        type: 'POST',
        url: url,
        data: {'status': status,'id':id,'dingtime':dingtime},
        dataType: 'json',
        success: function (data) {
            if(data.status=='1'){
                // 1审核通过 2审核未通过 3置顶 4取消置顶 5刷新 6删除
                if(status<=2 ){
                    $(obj).parents('.info-list').remove();
                    tip('审核操作成功');
                }else if(status==3){
                    $(obj).removeClass(".mui-calendar-picker")
                    $(obj).attr('onclick','admin_check_info(obj,4,'+id+',"");');
                    $(obj).text('取消置顶');
                    tip('置顶成功');
                }else if(status==4){
                    $(obj).text('置顶');
                    tip('取消置顶成功');
                }else if(status==5){
                    tip('刷新成功');
                }else if(status==6){
                    $(obj).parents('.info-list').remove();
                    tip('删除成功');
                }
                tip_close();
            }else{
                tip('操作失败，请您稍候再试');
                tip_close();
            }
        }
    });
}
function admin_check_shop(obj,status,id){
    if(status==6){
        confirm('删除后不可恢复，确定要删除吗？');
    }
    var op='check_shop_result';
    var url=createAppUrl('admin',op);
    $.ajax({
        type: 'POST',
        url: url,
        data: {'status': status,'id':id},
        dataType: 'json',
        success: function (data) {
            if(data.status=='1'){
                // 1审核通过 2审核未通过  6删除
                if(status<=2 ){
                    $(obj).parents('.info-list').remove();
                    tip('审核操作成功');
                    window.location.href = createAppUrl('admin','check_shop');
                }else if(status==6){
                    $(obj).parents('.info-list').remove();
                    tip('删除成功');
                    tip_close();
                }
                tip_close();
            }else{
                tip('操作失败，请您稍候再试');
                tip_close();
            }
        }
    });
}
function refresh_info(obj,id){
    var op='refresh';
    var url=createAppUrl('mylocal',op);
    $.ajax({
        type: 'POST',
        url: url,
        data: {'id':id},
        dataType: 'json',
        success: function (data) {
            tip(data.message);
            tip_close();
            $(obj).remove();

        }
    });
}

function getSearchUrl(url){
    var keyword = $("#keyword").val();
    var starttime = $("#starttime").val();
    var endtime = $("#endtime").val();
    if(keyword!=''){
        url=url+'&keyword='+keyword;
    }
    if(starttime!=''){
        url=url+'&starttime='+starttime;
    }
    if(endtime!=''){
        url=url+'&endtime='+endtime;
    }
    return url;
}

// 会员
function downscore(obj){
    $(obj).children('.down-list-pro').toggle();
}
function noNumbers(e)
{
    var keynum
    var keychar
    var numcheck
    if(window.event){
        keynum = e.keyCode
    }else if(e.which) {
        keynum = e.which
    }
    keychar = String.fromCharCode(keynum);
//判断是数字,且小数点后面只保留两位小数
    if(!isNaN(keychar)){
        var index=e.currentTarget.value.indexOf(".");
        if(index >= 0 && e.currentTarget.value.length-index >2){
            return false;
        }
        return true;
    }
//如果是小数点 但不能出现多个 且第一位不能是小数点
    if("."== keychar ){
        if(e.currentTarget.value==""){
            return false;
        }

        if(e.currentTarget.value.indexOf(".") >= 0){
            return false;
        }
        return true;
    }
    return false  ;
}

function getCredit(type,mid){ //充值
    var acceptname = $("input[name='acceptname']").val();
    if (!acceptname) {
        tip('请输入金额');
        tip_close();
    }

        $.ajax({
            type:'post',
            url:createAppUrl('admin', 'fans_credit'),
            dataType: 'json',
            data:{'fee':acceptname,'credit_type':type,'isajax':'1','mid':mid},
            success:function(data){
                if(data.status=='1'){
                    tip('操作成功');
                    tip_close();
                    if(type==1){
                        $('#credit1').text(data.fee);
                    }else{
                        $('#credit2').text(data.fee);
                    }

                }else{
                    tip('充值失败，请您稍候再试');
                    tip_close();
                }

            }
        });

}

function recharge(){
    var acceptname = $("input[name='acceptname']").val();
    if (!acceptname) {
        tip('请输入金额');
        tip_close();
        return false;
    }
    var url=createAppUrl('balance', 'post');
    $('#oneSaveAddr').attr('href',url+"&money="+acceptname);
}
function change_pic(u){
    var imgObj = document.getElementById("option_pic");
    if(imgObj.getAttribute("src",2)!=u){
        imgObj.src=u;
    }
}

function deletegoods(id,obj){
    var url=createAppUrl('shop_admin','goods');
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'type':2,'id':id},
        success:function(data){
            if(data.status=='1') {
                tip('删除成功');
                tip_close();
                $(obj).parents('.info-list').remove();
            }else{
                tip('删除失败，请稍候再试');
                tip_close();
            }
        }
    });
}

function deleteCate(id,obj){
    var url=createAppUrl('shop_admin','cate');
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'type':2,'id':id},
        success:function(data){
            if(data.status=='1') {
                tip('删除成功');
                tip_close();
                $(obj).parents('.info-list').remove();
            }else{
                tip('删除失败，请稍候再试');
                tip_close();
            }
        }
    });
}



function checkTransfer(pro,op){
    var paytype=$('#paytype').val();
    var aAccount=$('#alipay-account').val();
    var min=Number($('#transfer_min').text());
    var max=Number($('#transfer_max').text());
    var aName=$('#alipay-name').val();
    var bAccount=$('#bank-num').val();
    var bName=$('#bank-realname').val();
    var bbranch=$('#bank-branch').val();
    var money=Number($('#money').val());
    var balance=Number($('#shop-balance').text());
    var confirm_money=Number($('#confirm_money').text());
    if(money<min || money>max){
        tip('请提现金额不能小于'+min+'元，大于'+max+'元');
        tip_close();
        return false;
    }
    if(confirm_money>balance){
        tip('余额不足');
        tip_close();
        return false;
    }
    if(paytype==''){
        tip('请选择提现方式');
        tip_close();
        return false;
    }else if(paytype=='2' && (aAccount=='' || aName=='')){
        tip('请检查支付宝账号和姓名');
        tip_close();
        return false;
    }else if(paytype=='3' && (bAccount=='' || bName=='' || bbranch=='')){
        tip('请检查银行卡账号、姓名、开户行');
        tip_close();
        return false;
    }
    var url=createAppUrl(pro,op);
    url=url+'&submit_post=1';
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'money':money,'paytype':paytype,'alipay_account':aAccount,'alipay_name':aName,'bank_num':bAccount,'bank_realname':bName,'bank_branch':bbranch},
        success:function(data){
            if(data.status=='1') {
                tip('提交成功，请您耐心等待处理结果');
                tip_close();
                var acc=(balance-confirm_money).toFixed(2);
                $('#shop-balance').text(acc);
                if(op=='account'){
                    setTimeout(function () {
                        window.location.href = createAppUrl('shop_admin','account')+'&type=1';
                    }, 2000);
                }else{
                    setTimeout(function () {
                        window.location.href = createAppUrl('user','display')+'&type=1';
                    }, 2000);
                }


            }else{
                tip(data.str);
                tip_close();
            }
        }
    });

}

function admin_check_account(obj,type,id,openid){
    var url=createAppUrl('ajax_req','recash');
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {id:id,type:type,openid:openid},
        success:function(data){
            if (data.status == 1) {
                $('.account-btn').hide();
                $(obj).parents('.info-list').remove();
                if(type==1){
                    tip('提现操作成功');
                }else{
                    tip('驳回现申请操作成功');
                }
                tip_close();
                //window.location.href = createAppUrl('admin','account')+'&id='+id;
            }else{
                tip(data.str);
                tip_close();
            }

        }
    });
}

function showModal(){
    $('.modal-dialog').toggle();
}
function search_members_app() {
    if( $.trim($('#search-kwd').val())==''){
        tip('请输入关键词');
        tip_close();
        return;
    }
    $("#module-menus").html("正在搜索....")
    var url=createAppUrl('shop_admin','query');
    $.get(url, {
        keyword: $.trim($('#search-kwd').val())
    }, function(dat){
        $('#module-menus').html(dat);
    });
}

function deleteAdmin(obj,id){
   var url=createAppUrl('shop_admin', 'admin');
    $.ajax({
        type:'post',
        url: url,
        dataType: 'json',
        data:{'post':'delete','admin_id':id},
        success:function(data){
            if(data.status=='1'){
                tip('删除成功');
                $(obj).parents('li.info-list').remove();
                tip_close();
            }else{
                tip('删除失败，请您稍候再试');
                tip_close();
            }

        }
    });
}

function deleteBlack(obj,uid){
    var url=createAppUrl('admin', 'fans');
    $.ajax({
        type:'post',
        url: url,
        dataType: 'json',
        data:{'post':'delete','uid':uid,'type':1,'isajax':1},
        success:function(data){
            if(data.status=='1'){
                tip('删除成功');
                $(obj).parents('li.info-list').remove();
                tip_close();
            }else{
                tip('删除失败，请您稍候再试');
                tip_close();
            }

        }
    });
}


function searchBtn(id){
    $('#lists').text('');
    var search_input=$("#searchinput").val();
    if(search_input=='')return;
    //同城信息
    var page = -1;
    var url=createAppUrl('msglist', 'display');
    url=url+'&keyword='+search_input+'&id='+id;
    getMsgReq(page,url,'#lists','#lists');

}

function doConfirm(shop_id,oid){ //确认核销
    var url=createAppUrl('verification', 'submit');
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'oid':oid,'shop_id':shop_id},
        success:function(data){
            tip(data.str);
            tip_close();
        }
    });


}

function order_qr_code(url,obj){
    showBigImage(url,$(obj));
}

function uploadImgByWx(options) { // options参数为url , toLen 到达指定长度9时, success成功回掉
    var images = {
        localIds: [],
    }
    wx.chooseImage({
        count: 9, // 最多选3张
        sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
        success: function(res) {
            images.localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            var i = 0; var length = images.localIds.length;
            var upload = function() {
                wx.uploadImage({
                    localId:'' + images.localIds[i],
                    isShowProgressTips: 1,
                    success: function(res) {
                        var serverId = res.serverId;
                        $.ajax({
                             url: options.url,
                             type:'post', 
                             data:{
                                media_id:serverId,
                             },
                             dataType:'json',
                             success:function(data){
                                len++;
                                if(len==9){
                                    options.toLen()
                                }
                                if (data.error == 1) {
                                    alert(data.message);
                                } else {
                                    options.success(data)
                                }  
                             }
                        });
                        //如果还有照片，继续上传
                        i++;
                        if (i < length) {
                            upload();
                        }
                }
                });
            };
            upload();
        }
    });
}
function getMap(lng, lat, address, url) {
    // 百度坐标转GCJ-0坐标
    var point = ["{$shop['lng']}","{$shop['lat']}"]
    var x_pi = 3.14159265358979324 * 3000.0 / 180.0
    var x = lng - 0.0065, y = lat - 0.006;  
    var z = Math.sqrt(x * x + y * y) - 0.00002 * Math.sin(y * x_pi);  
    var theta = Math.atan2(y, x) - 0.000003 * Math.cos(x * x_pi);  
    // 转换成功的坐标
    var gg_lon = z * Math.cos(theta);  
    var gg_lat = z * Math.sin(theta);  
    wx.openLocation({

        latitude: parseFloat(gg_lat), // 纬度，浮点数，范围为90 ~ -90

        longitude: parseFloat(gg_lon), // 经度，浮点数，范围为180 ~ -180。

        name: '', // 位置名

        address: address, // 地址详情说明

        scale: 18, // 地图缩放级别,整形值,范围从1~28。默认为最大

        fail: function (err) {
            window.location.href = url
        },
        success: function (res) {
        }
    });
}


function deleteorder(obj,shopid,id){
    var url=createAppUrl('order', 'delete');
    $.ajax({
        type:'post',
        url: url,
        dataType: 'json',
        data:{'shop_id':shopid,'id':id},
        success:function(data){
            if(data.status=='1'){
                $(obj).parents('.space_list_li').remove();
                tip('删除成功');
                tip_close();
            }else{
                tip('订单不存在，或已删除');
                tip_close();
            }

        }
    });

}