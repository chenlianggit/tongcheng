<?php

/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2017/10/30
 * Time: 10:49
 */
class Merchant
{

    /*
     * 请求参数说明
     * $query查询内容
     *$lat纬度
     * $lng经度
     * $radius 附近范围单位米
     * $industry_type 查找类型 有cater代表美食，hotel代表酒店,life代表生活
     * $pagesize 每页显示条数，最大二十
     * $page_num  页数
     * $ak 百度的ak字符串
     *
     * 返回参数说明
     * status 状态
     * message 状态描述
     *total  查询出来的总记录
     * data  详情记录
     *      name  店名
     *      address 地址
     *      telephone  电话
     *      lng          经度
     *      lat          纬度
     *      distance     距离当前位置多远，单位米
     *      price        平均消费价格
     * */
    public static function getMerchants($query,$lat,$lng,$radius,$industry_type,$pagesize,$page_num,$ak){

        $url = "http://api.map.baidu.com/place/v2/search?query=".$query."&location=".$lat.",".$lng.
            "&radius=".$radius."&scope=2&filter=industry_type:".$industry_type."|sort_name:distance|sort_rule:1&output=json&page_size=".
            $pagesize."&page_num=".$page_num."&ak=";

        if(!empty($ak)){
            $url = $url.$ak;
        }else{
            $url = $url."sUgbA9k3BkDWbGZwHWP6EAhe6DaR4z6N";
        }
        $content = self::file_get_content($url);

        $content_json = json_decode($content,TRUE);

        $list = array();
        $list['status']= $content_json['status'];
        $list['message']= $content_json['message'];
        $list['total'] = $content_json['total'];

        $list_ch = array();
        if(!empty($content_json['results'])){
            foreach($content_json['results'] as $k=>$v){
                $list_ch[$k]['name'] = $v['name'];
                $list_ch[$k]['address'] = $v['address'];
                $list_ch[$k]['telephone'] = $v['telephone'];
                $list_ch[$k]['lng'] = $v['location']['lng'];
                $list_ch[$k]['lat'] = $v['location']['lat'];
                $list_ch[$k]['distance'] = $v['detail_info']['distance'];
                $list_ch[$k]['price'] = $v['detail_info']['price'];
//                $fh= self::file_get_content($v['detail_info']['detail_url']);
//                $reg_tag = '/http:\/\/.*.jpg/';
//                $ret = preg_match_all($reg_tag, $fh, $match_result);
//                $list_ch[$k]['logo_url'] = $match_result[0];
            }
        }
    $list['data'] = $list_ch;
    return $list;
    }

    static function file_get_content($url) {
        if (function_exists('file_get_contents')) {
            $file_contents = @file_get_contents($url);
        }
        if ($file_contents =='') {
            $ch = curl_init();
            $timeout = 30;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }

}