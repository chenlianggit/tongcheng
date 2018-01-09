function fetchbyajax1(url,value1,op){
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'id':value1,'op':op},
        success:function(data){
            if(data.status=='1'){
                var content="";
                $.each(data.list,function(k,v){
                    content+=("<option value='"+v.id+"'>"+v.name+"</option>");
                })
                $('select[name="ccate_id"]').html(content);
            }else{
                tip(data.str);
                tip_close();
            }

        }
    });

}

function fetchbyajax2(url,value1,op){
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'id':value1,'op':op},
        success:function(data){
            if(data.status=='1'){
                var content="";
                $.each(data.list,function(k,v){
                    content+=("<option value='"+v.id+"'>"+v.name+"</option>");

                })


                $('select[name="area_id"]').html(content);

            }else{
                tip(data.str);
                tip_close();
            }

        }
    });

}

function fetchbyajax3(url,value1,op){
    $.ajax({
        type:'post',
        url:url,
        dataType: 'json',
        data:{'id':value1,'op':op},
        success:function(data){
            if(data.status=='1'){
                var content="";
                $.each(data.list,function(k,v){
                    content+=("<option value='"+v.id+"'>"+v.name+"</option>");

                })


                $('select[name="business_id"]').html(content);

            }else{
                tip(data.str);
                tip_close();
            }

        }
    });

}
function checkform(){
    var x = $("#map_x").val();
    var y = $("#map_y").val();
    var n = $("#name").val();
    var t = $('input[name="telphone"]').val();
    var r = $('input[name="manage"]').val();
    var area_id= $('select[name="area_id"]').val();
    var business_id= $('select[name="business_id"]').val();
    var city_id= $('select[name="city_id"]').val();
    var ccate_id= $('select[name="ccate_id"]').val();
    var pcate_id= $('select[name="pcate_id"]').val();
    if(n==""){
        tip("请填写店铺名称");
        tip_close();
        return false;
    }
    if(t==""){
        tip("请填写联系电话");
        tip_close();
        return false;
    }
    if(r==""){
        tip("请填写联系人");
        tip_close();
        return false;
    }
    if(pcate_id==0){
        tip("请选择行业分类");
        tip_close();
        return false;
    }
    // if(ccate_id==0){
    //     tip("请选择行业子类");
    //     tip_close();
    //     return false;
    // }
    if(city_id==0){
        tip("请选择城市");
        tip_close();
        return false;
    }
    // if(area_id==0){
    //     tip("请选择区域");
    //     tip_close();
    //     return false;
    // }
    // if(business_id==0){
    //     tip("请选择商圈");
    //     tip_close();
    //     return false;
    // }
    // if(x=="" || y==""){
    //     tip("城市坐标不能为空");
    //     tip_close();
    //     return false;
    // }
    if(n==""){
        tip("名称不能为空");
        tip_close();
        return false;
    }
    if(vailPhone()!=true){
        return false;
    }
}
//验证手机号
function vailPhone(){
    var phone = jQuery("#phone").val();
    var flag = false;
    var message = "";
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    if(phone == ''){
        message = "请输入正确格式的手机号码！";
    }else if(phone.length !=11){
        message = "请输入有效的手机号码！";
    }else if(!myreg.test(phone)){
        message = "请输入有效的手机号码！";
    }else{
        flag = true;
    }
    if(!flag){
        //提示错误效果
        jQuery("#phoneP").html("");
        jQuery("#phoneP").html("<i class=\"icon-error ui-margin-right10\">&nbsp;<\/i>"+message);
        jQuery("#phone").focus();
    }else{
        jQuery("#phoneP").html("");
    }
    return flag;
}


function getImageSize(){
    var _w = parseInt($(window).width());//获取浏览器的宽度
    $(".my-gallery img").each(function(i){
        var img = $(this);
        var realWidth;//真实的宽度
        var realHeight;//真实的高度
//这里做下说明，$("<img/>")这里是创建一个临时的img标签，类似js创建一个new Image()对象！
        $("<img/>").attr("src", $(img).attr("src")).load(function() {
            /*
             如果要获取图片的真实的宽度和高度有三点必须注意
             1、需要创建一个image对象：如这里的$("<img/>")
             2、指定图片的src路径
             3、一定要在图片加载完成后执行如.load()函数里执行
             */
            realWidth = this.width;
            realHeight = this.height;
//如果真实的宽度大于浏览器的宽度就按照100%显示
            if(realWidth>=_w){
                $(img).parent(".gallery-a").attr('data-size','800x1140');
            }
            else{//如果小于浏览器的宽度按照原尺寸显示
                $(img).parent(".gallery-a").attr('data-size', realWidth+'x'+realHeight);
            }
        });
    });
}
function getShopQr(url) {
    showBigImage(url,$('#qr_code'));
}

function checkAdmin(){
    var openid= $('#openid').val();
    if (openid=="") {
        tip( '请选择管理员!');
        tip_close();
        return false;
    }

    var admin_type= $("input[name='admin_type']:checked").val();//radio
    if(admin_type==undefined || admin_type==0 || admin_type==""){
        tip( '请选择管理员类型!');
        tip_close();
        return false;
    }
    if( admin_type !=3){
        var passport= $('#passport').val();
        if (passport=="") {
            tip( '用户名不能为空!');
            tip_close();
            return false;
        }
        var password= $('#password').val();
        if (password=="") {
            tip( '密码不能为空!');
            tip_close();
            return false;
        }

    }


}
function checkAdmin_role(){
    var openid= $('#openid').val();
    if (openid=="") {
        tip( '请选择管理员!');
        tip_close();
        return false;
    }


}
function select_saler(obj,data){
    $('body').find('#picc').attr('src',data.avatar);
    $('#nickname').val(data.nickname);
    $('#openid').val(data.openid);
    $('#avatar').val(data.avatar);
    $('#modal-module-menus').modal('hide');
    $('.modal-dialog').hide();
}


