<?php defined('IN_IA') or exit('Access Denied');?><div class="swiper-container i-channalWap" id="indexChannal">
    <div class="swiper-wrapper i-channalCon">
    </div>
    <div class="swiper-pagination"></div>
</div>
<script>
    $(function () {
        $.ajax({
            url: createAppUrl('ajax_req', 'getChanne'),
            success: function (res) {
                var str = ''
                var data = JSON.parse(res)
                var list = data.list
                var moduLen = 1
                var temp
                if (list.length <= 8) {
                    str += '<div class="swiper-slide clearfix i-channalWapT less">'
                    for (var i = 0; i < list.length; i++) {
                        if( list[i].autourl==''){
                            str += '<a class="i-channalBtn" href="'+ createAppUrl('msglist', 'display') +'&flag=1&id='+ list[i].id +'">';

                        }else{
                            str += '<a class="i-channalBtn" href="'+list[i].autourl +'">';
                        }
                        str += ' <div class="i-iconWap"> <img class="i-icon" src="'+ list[i].thumb+'" alt="'+ list[i].name +'"></div>\
                    <p class="text">'+ list[i].name +'</p>\
                    </a>'
                    }
                    str += '</div>'
                }else{
                    moduLen = Math.ceil(list.length / 10)
                    for(var i = 0; i < moduLen; i++) {
                        str += '<div class="swiper-slide clearfix i-channalWapT more">'
                        temp = i == moduLen - 1 ? list.length - i * 10 : 10
                        for(var j = 0; j < temp; j++) {
                            if( list[i*10 + j].autourl==''){
                                str += '<a class="i-channalBtn" href="'+ createAppUrl('msglist', 'display') +'&flag=1&id='+ list[i*10 + j].id +'">';
                            }else{
                                str += '<a class="i-channalBtn" href="'+ list[i*10 + j].autourl +'">';
                            }
                            str += '<div class="i-iconWap"><img class="i-icon" src="'+ list[i*10 + j].thumb+'" alt="'+ list[i*10 + j].name +'"></div>\
                    <p class="text">'+ list[i*10 + j].name +'</p>\
                    </a>'
                        }
                        str += '</div>'
                    }
                }
                $('#indexChannal .swiper-wrapper').append($(str))
                var mySwiper = new Swiper('#indexChannal', {
                    autoplay: 5000,//可选选项，自动滑动
                    pagination : moduLen > 1 ? '.swiper-pagination' : false
                })
                if(moduLen > 1){
                    $('.i-channalCon').css('padding-bottom','10px');
                }


            }
        })
    })
</script>