<?php

class ReqInfo
{
    static public function mapReq($cfg)
    {//获取地理位置信息
        $ak = $cfg['mapak'];
        if (empty($ak)) {
            return 'https://api.map.baidu.com/geocoder/v2/?ak=sUgbA9k3BkDWbGZwHWP6EAhe6DaR4z6N&output=json&pois=1';
        } else {
            return 'https://api.map.baidu.com/geocoder/v2/?output=json&pois=1&ak=' . $ak;
        }

    }

    static public function mapUrl($cfg)
    {//获取地图

        $ak = $cfg['mapak'];
        if (empty($ak) || $ak=='') {
            return "https://api.map.baidu.com/api?v=2.0&ak=sUgbA9k3BkDWbGZwHWP6EAhe6DaR4z6N&s=1";
        } else {
            return 'https://api.map.baidu.com/api?v=2.0&s=1&ak=' . $ak;
        }

    }

    static public function chagexy($cfg)
    {//获取计算后的坐标
        $ak = $cfg['mapak'];
        if (empty($ak) || $ak=='') {
            return 'https://api.map.baidu.com/geoconv/v1/?ak=sUgbA9k3BkDWbGZwHWP6EAhe6DaR4z6N&from=1&to=5&s=1';
        } else {
            return 'https://api.map.baidu.com/geoconv/v1/?from=1&s=1&to=5&ak=' . $ak;
        }


    }

    static public function weatherreq()
    {
        return 'http://wthrcdn.etouch.cn/weather_mini?city=';

    }

    static public function msgNum($cfg)
    {
        $shownum = intval($cfg['showChannelNum']);
        if (empty($shownum)) {
            $shownum =5;
        }
        return $shownum;
    }
    static public function num()
    {
        global $_GPC;
        $num= intval(empty($_GPC['num']) ? 10 : $_GPC['num']);
        return $num;
    }
    static public function page()
    {
        global $_GPC;
        $page = intval(empty($_GPC['page']) ? 0 : $_GPC['page']);
        return $page;
    }
    static public function pageIndex()
    {
        global $_GPC;
        $page = intval(empty($_GPC['page']) ? 1 : $_GPC['page']);
        $num=self::num();
        $start = ($page-1)*$num;
        return $start;

    }
}
?>