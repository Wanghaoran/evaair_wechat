<?php
class WechatmsgWidget extends Action {

    public $msgTypes = array(
        'text' => array(
            'ACTION_NAME' => 'execText',
        ),
        'image' => array(
            'ACTION_NAME' => '',
        ),
        'voice' => array(
            'ACTION_NAME' => '',
        ),
        'video' => array(
            'ACTION_NAME' => '',
        ),
        'location' => array(
            'ACTION_NAME' => 'execLocations',
        ),
        'link' => array(
            'ACTION_NAME' => '',
        ),
        'event' => array(
            'childEvent' => array(
                'subscribe' => array(
                    'ACTION_NAME' => 'execSubscribe',
                ),
                'unsubscribe' => array(
                    'ACTION_NAME' => 'execUnsubscribe',
                ),
                'CLICK' => array(
                    'ACTION_NAME' => 'execClick',
                    'EventKey' => array(
                        'FLIGHT_TIME' => 'execClick_FLIGHT_TIME',//班机时刻表
                        'FLIGHT_TIME_NOW' => 'execClick_FLIGHT_TIME_NOW',//班机实际到离
                        'MY_EVAAIR' => 'execClick_MY_EVAAIR',//我的长荣航班
                        'EVAAIR_DONOT_KNOW' => 'execClick_EVAAIR_DONOT_KNOW',//你所不知的长荣
                        'EVAAIR_TAIWAN' => 'execClick_EVAAIR_TAIWAN',//搭长荣 游台湾
                        'EVAAIR_AIR' => 'execClick_EVAAIR_AIR',//长荣超萌彩绘机
                        'SALE_ACTIVITY' => 'execClick_SALE_ACTIVITY',//优惠活动
                        'EVAAIR_TRAVEL' => 'execClick_EVAAIR_TRAVEL',//无限万里游
                        'CONTACE_ME' => 'execClick_CONTACE_ME',//与我联系
                    ),
                ),
                'LOCATION' => array(
                    'ACTION_NAME' => '',
                ),
            ),
        ),
    );



    public function checkMsg($postStr){
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);


        $MsgType = strval($postObj -> MsgType);
        $Event = strval($postObj -> Event);

        if($MsgType == 'event'){
            $action_name = $this -> msgTypes[$MsgType]['childEvent'][$Event]['ACTION_NAME'];
        }else{
            $action_name = $this -> msgTypes[$MsgType]['ACTION_NAME'];
        }

        if(!$action_name){
            echo '';
            exit;
        }else{
            $this -> $action_name($postObj);
        }

    }


    //文本消息
    public function execText($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = '长荣航空官方微信建设中...';
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //关注事件
    public function execSubscribe($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = "感谢您关注长荣航空！\r\n您的旅程是长荣航空最重要的事！\r\n点击屏幕下方三个选单，我们将提供您更多服务内容！\r\n✈航班服务✈ 给你第一手的航班资讯\r\n✈知晓长荣✈ 你还不认识长荣吗？点击了解更多！\r\n✈会员服务✈ 长荣航空是星空联盟成员之一，在这给你最新的会员优惠信息\r\n欢迎您也关注我们的新浪微博<a href='http://weibo.com/3483881701'>http://weibo.com/3483881701</a>";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //取消关注事件
    public function execUnsubscribe($postObj){
        echo '';
        exit;
    }

    //点击菜单
    public function execClick($postObj){
        $EventKey = strval($postObj -> EventKey);
        $action_name = $this -> msgTypes['event']['childEvent']['CLICK']['EventKey'][$EventKey];
        if(!$action_name){
            $fromUsername = $postObj -> FromUserName;
            $toUsername = $postObj -> ToUserName;
            $content = '长荣航空官方微信建设中...';
            $this -> responseText($toUsername, $fromUsername, $content);
            exit;
        }else{
            $this -> $action_name($postObj);
        }
    }

    //班机时刻表
    public function execClick_FLIGHT_TIME($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '班机时刻表',
                'description' => '您可以通过班机表定时刻表功能，查询由长荣(BR)以及立荣(B7)所飞航的国际航班。',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIMZVYVSXAqFVlibD4FFLAbLRKCYRH43em7ehwKfJNHSKDuSkicfh8CNQQ/0',
                'url' => 'http://m.evaair.com/A2/TimetableSearch.aspx?Lang=zh-cn',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //班机实际到离
    public function execClick_FLIGHT_TIME_NOW($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '班机实际到离',
                'description' => '今天要搭机吗？还是您要到机场接机呢？ 您可以透过班机实际到离服务，查询长荣(BR)与立荣航空(B7)最新的班机动态。',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIUIbHXdfy9uWKyibVoxhg3yaoWqe4Bw76ib4XUZpo930e0bxkbG9ibQLFQ/0',
                'url' => 'http://m.evaair.com/A3/FlightstatusSearch.aspx?Lang=zh-cn',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //我的长荣航班
    public function execClick_MY_EVAAIR($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '我的长荣航班',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIicpO8XzyhlHq895F7ATwXjv64YwffMEQThhGZwS9BVFQeqUjFT0v5iaQ/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200284794&idx=1&sn=f47ce68c289c59d42af5c7b5d73d8fe5#rd',
            ),
            array(
                'title' => '【行程管理】登入订位代码，进行选位以及报到等功能',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIJiaYpRibw4iap1iaXXtsvU5URer1AtBbwyXe0IDpbc1Bu4Hg0BrChjxw0Q/0',
                'url' => 'http://m.evaair.com/A5/MyTripStatus.aspx?Lang=zh-cn',
            ),
            array(
                'title' => '【网络报到】先行上网报到，节省柜台报到时间',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIpBs94r5HlSiadVe5MfSbyYk4bBjIVsiblibxtTeF2Fv3GkuHiaMUaGuicicw/0',
                'url' => 'http://m.evaair.com/A4/CheckinStatus.aspx?Lang=zh-cn',
            ),
            array(
                'title' => '【网络选餐】预定你愛的机上美食吧！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxI64BsXzCyIAT0kbutWMIibtNJ8oySeicmDaibD5ficQQoicWGalHEPlrdZww/0',
                'url' => 'http://m.evaair.com/A12/FlightMealSearch.aspx?Lang=zh-cn',
            ),
            array(
                'title' => '【班机短信服务】用手机收简讯（短信）掌握班机状况！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxI8Sutcz2UyCkuqlkHlba66Q9h1DAz8OjZMsqV9nWmRc0licaUBw0ufTw/0',
                'url' => 'http://m.evaair.com/A10/FlightNotificationInfo.aspx?Lang=zh-cn',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //你所不知的长荣
    public function execClick_EVAAIR_DONOT_KNOW($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '你所不知的长荣',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIC5uHWJH9s6ApnNdgzlYj5Xcw6oJicJjs8K0G1xuchIibHDqmvkeFxkZA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285181&idx=1&sn=99ab1fa6da1a9ba6ab82ef47f13d3a98#rd',
            ),
            array(
                'title' => '长荣航空曾经搭载过的国宝级动物明星，你造都有谁吗？',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxI7QhiaNeB3Zs4GHYoHK9iclTegiagl0tuoJhiab6G3uHl9dWqffREpDqXEw/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285181&idx=2&sn=13781b649bc9c7a31eae5b9c6ef242dc#rd',
            ),
            array(
                'title' => '做有台湾特色的飞机！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIdvVIyEH07bI4iaPJO6Vlue8cdnicz1XPAq89jvAnCH4xmxrPpclakVTA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285181&idx=3&sn=dc23c3265aa624df46edde95868458ac#rd',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //搭长荣 游台湾
    public function execClick_EVAAIR_TAIWAN($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '长荣/立荣两岸三地航班 飞行任遨游',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIev9SZT46RJlHKn9DmLM4cPwd0J192Z7Vcq2NCCAcGLJldrH9GjiboNA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200244422&idx=1&sn=2701640b306fb714d54146c8ba0aca4a#rd',
            ),
            array(
                'title' => '2014台湾最想去的赏萤景点',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIlje0mEIHQ8Dica0CfmFK9SyLLbFYdnU8z2dStjaYaM82Am8A5NvoSBQ/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200244422&idx=2&sn=2a955aa4191b0651f8a7807fbd886eba#rd',
            ),
            array(
                'title' => '走，看海去',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxI1MV3MEianxMaynZejxQew5GCHyJs8Xd9k3vOUJvib8MIdmH2l8wxVNgA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200244422&idx=3&sn=0204a675aeea35ada32c678a27442645#rd',
            ),
            array(
                'title' => '松山-浦东航线开航 每周飞航3班',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIoQoFEcAbqicWfd2PPOK7cgWV85GrnSyA76ic6DmHFVuIwsgd6dZdiaVdA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200244422&idx=4&sn=c676a75eefe6bd6c47257dd0b7879a95#rd',
            ),

        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //长荣超萌彩绘机
    public function execClick_EVAAIR_AIR($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '搭乘 Hello Kitty Jet 开始幸福的旅程',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIiayOfe5GnKKicIlmXgscNtkHeV2wP1r88nUg2Dra1eGM9payj1ic1hUcw/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285035&idx=1&sn=241f0d5470c3dc662e4da2964e0e3457#rd',
            ),
            array(
                'title' => '520，带她搭乘Hello Kitty彩绘机！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIicmrKayMH7MwiaZOibavaHGibxZNAzTfujYMxvwM5vHz0ZUPSGyotZv47g/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285035&idx=2&sn=f0e1d81f88f32683988b8be681313708#rd',
            ),

        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);

    }

    //优惠活动
    public function execClick_SALE_ACTIVITY($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '长荣/立荣航空，大咖“飞”你莫属！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIznsA7rnPD2PjaGXfNQXPbPvwLp4eMjf1ONoHswINcickO1fTIUEJLaw/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285230&idx=1&sn=5dba2d91d9556755762e855303b07d27#rd',
            ),
            array(
                'title' => 'MILES & CASH 哩程抵票款功能更好用咯！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIJuMj3EXia4A5CehUhyX3U6VZEib5dXRyKMlbkibN0eeJta8icxY4jK4ytg/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285230&idx=2&sn=7d23ac38d050d7be6877679a332864bf#rd',
            ),
            array(
                'title' => '上海/杭州出发提前40天购票优惠CNY200！',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIDeFRVGhQn85SKHBS29g89hUaTj8iaJkwBuiaA3LcaN7M51VIj4vObEbA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285230&idx=3&sn=f2e699e7c0efb007abf54e52b35a6707#rd',
            ),
            array(
                'title' => '青岛-台湾（台北/高雄）-青岛往返提前40天出票促销',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIocSarvKlljYTSAflaWrmIXfMtzsXjI3uoyAjPM4cyjSrlT2WjZpqicQ/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285230&idx=4&sn=8534e2a952c621372a0e8423d28d7a4d#rd',
            ),

        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }


    //无限万里游
    public function execClick_EVAAIR_TRAVEL($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '关于无限万哩游',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww1UzKerHB6C8hN0drDRUicoK3wTIlozarPbJQRqt2WibmO5LJ34Xo3EicjjJ2iaEuvzvJaLickiamKTtGNg/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285349&idx=1&sn=6b6eaa68346b7e0e4b852a61b66c91f9#rd',
            ),
            array(
                'title' => '【我的会员卡】查询哩程数据等功能，随时掌握累计情况',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww1UzKerHB6C8hN0drDRUicoK8jFCxPLhM2entX8WtXR85tNBXRBpxumDCBKoIiclxqKaUFSEtLjYx3A/0',
                'url' => 'http://m.evaair.com/A6/EvergreenClub.aspx?Lang=zh-cn',
            ),

        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //与我联系
    public function execClick_CONTACE_ME($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '与我联系',
                'description' => '如有订位、票务、网站、报到、行李与机场服务等相关问题， 欢迎与我们联系。',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/oVBNsPvJww2qNJ6mztHTt2ibaEibm1icNxIvOny0Zsib48U7MjVHRF9PeIHQEhmEOZE4DCp220suzHXAsibU8fGibiazA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzQzODM0Mw==&mid=200285408&idx=1&sn=98755d08a4e961ef5ddddfb3b2314b80#rd',
            ),

        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }







    /*


    //搭长荣 游台湾
    public function execClick_EVAAIR_TAIWAN($postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '',
                'description' => '',
                'picurl' => '',
                'url' => '',
            ),

        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }
    */

    /*
    //微信提交用户位置
    public function execLocation($postObj){

        $fromUsername = $postObj -> FromUserName;
        $Latitude = strval($postObj -> Latitude);
        $Longitude = strval($postObj -> Longitude);
        $Precision = strval($postObj -> Precision);

        //获取mid
        $mid = R('Reservation/openidtomid', array($fromUsername), 'Widget');

        $MemberLocation = M('MemberLocation');

        if($id = $MemberLocation -> field('id') -> where(array('mid' => $mid)) -> find()){
            //如果有数据则更新用户信息
            $data = array();
            $data['id'] = $id['id'];
            $data['mid'] = $mid;
            $data['time'] = time();
            $data['Latitude'] = $Latitude;
            $data['Longitude'] = $Longitude;
            $data['Precision'] = $Precision;
            $MemberLocation -> save($data);
        }else{
            //没数据则创建
            $data = array();
            $data['mid'] = $mid;
            $data['time'] = time();
            $data['Latitude'] = $Latitude;
            $data['Longitude'] = $Longitude;
            $data['Precision'] = $Precision;
            $MemberLocation -> add($data);
        }

        echo '';
        exit;

    }

    //用户主动上报位置
    public function execLocations($postObj){
        $fromUsername = $postObj -> FromUserName;
        $Latitude = strval($postObj -> Location_X);
        $Longitude = strval($postObj -> Location_Y);

        //获取mid
        $mid = R('Reservation/openidtomid', array($fromUsername), 'Widget');

        $MemberLocation = M('MemberLocation');

        if($id = $MemberLocation -> field('id') -> where(array('mid' => $mid)) -> find()){
            //如果有数据则更新用户信息
            $data = array();
            $data['id'] = $id['id'];
            $data['mid'] = $mid;
            $data['time'] = time();
            $data['Latitude'] = $Latitude;
            $data['Longitude'] = $Longitude;
            $MemberLocation -> save($data);
        }else{
            //没数据则创建
            $data = array();
            $data['mid'] = $mid;
            $data['time'] = time();
            $data['Latitude'] = $Latitude;
            $data['Longitude'] = $Longitude;
            $MemberLocation -> add($data);
        }

        //执行路径算法
        $this -> LBSLocation($Latitude, $Longitude, $postObj);

    }

    //附近酒店算法
    public function LBSLocation($Latitude, $Longitude, $postObj){
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;

        //获取地点所在城市
        $json_str = file_get_contents('http://api.map.baidu.com/geocoder/v2/?ak=' . C('baidu_ak') . '&location=' . $Latitude . ',' . $Longitude . '&output=json');
        $json_arr = json_decode($json_str, true);
        $city = $json_arr['result']['addressComponent']['city'];


        //查询该城市的所有酒店
        $Hotel = M('Hotel');
        $result = $Hotel -> field('id,englishName,chineseName,Latitude,Longitude,TencentMapLink,address,tel') -> where(array('city' => $city)) -> select();


        if(!$result){
            $content = "您所在的区域还没有凯悦集团旗下酒店，您可回复【1】与“凯悦管家”取得联系并获得相关帮助";
            $this -> responseText($toUsername, $fromUsername, $content);
            return;
        }

        //计算距离
        foreach($result as $key => $value){
            $earthRadius = 6367000; //approximate radius of earth in meters

            $lat1 = ($Latitude * pi() ) / 180;
            $lng1 = ($Longitude * pi() ) / 180;

            $lat2 = ($value['Latitude'] * pi() ) / 180;
            $lng2 = ($value['Longitude'] * pi() ) / 180;

            $calcLongitude = $lng2 - $lng1;
            $calcLatitude = $lat2 - $lat1;
            $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
            $calculatedDistance = $earthRadius * $stepTwo;

            $result[$key]['distance'] = round($calculatedDistance/1000, 2);
        }


        //根据距离排序
        usort($result, function($a, $b){

            if ($a['distance'] == $b['distance'])
            {
                return 0;
            }
            else if ($a['distance'] < $b['distance'])
            {
                return -1;
            }
            else {
                return 1;
            }

        });


        //整合发送消息
        $content = '';
        foreach($result as $value){
            $content .= "●" . $value["chineseName"] . "\n";
            $content .= "酒店地址：" . $value["address"] . "\n";
            $content .= "<a href='" . $value['TencentMapLink'] . "'>查看地图</a>\n";
            $content .= "酒店电话：" . $value["tel"] . "\n";
            $content .= "距离我的距离" . $value["distance"] . "公里\n";
            $content .= "<a href='http://m.hyatt.com/mt/www.hyatt.com/hyatt/index.jsp?un_jtt_v_find_hotel=yes&un_jtt_v_unLanguage=zh-Hans&src=wechat'>酒店预定</a>\n（您也可点击“微预订”菜单中的“订房在线服务”进行预订）\n";
            $content .= "\n\n";
        }
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    */





    /*
    //点击菜单－酒店预定
    public function execClick_RESERVATION_HOTEL($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_RESERVATION_HOTEL', '酒店预定'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = " 欢迎使用”凯悦管家“在线订房服务，在这里您不仅无需任何订房费用，更可享受最优惠房价保证\n●如需微管家人工帮助，请回复【1】\n ●自助服务请点击<a href='http://m.hyatt.com/mt/www.hyatt.com/hyatt/index.jsp?un_jtt_v_find_hotel=yes&un_jtt_v_unLanguage=zh-Hans&src=wechat'>继续</a>";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //点击菜单－我的订单
    public function execClick_MY_ORDER($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_MY_ORDER', '我的订单'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = " ●如需微管家人工帮助，请回复【1】\n ●自助服务请点击<a href='https://m.hyatt.com/mt/www.hyatt.com/search_reservations?un_jtt_v_unLanguage=zh-Hans&src=wechat'>继续</a>";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //点击菜单－附近酒店
    public function execClick_NEARBY_HOTEL($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_NEARBY_HOTEL', '附近酒店'), 'Widget');

        $fromUsername = $postObj -> FromUserName;

        $MemberLocation = M('MemberLocation');
        $mid = R('Reservation/openidtomid', array($fromUsername), 'Widget');

        //获取地点详情
        $result = $MemberLocation -> field('Latitude,Longitude,time') -> where(array('mid' => $mid)) -> find();
        //没有位置信息或者位置信息已失效
        if(!$result || $result['time'] < time() - 7200){
            $toUsername = $postObj -> ToUserName;
            $content = "没有获取到您的位置信息，可以发送您的“位置”查找附近酒店\n方法：点击下方“键盘“切换到输入框，点击”+“，选择”位置“，发送给我就能查到您附近的酒店啦";
            $this -> responseText($toUsername, $fromUsername, $content);
        }

        //执行路径算法
        $this -> LBSLocation($result['Latitude'], $result['Longitude'], $postObj);

    }

    //点击菜单－常见问题
    public function execClick_COMMON_QUESTION($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_COMMON_QUESTION', '常见问题'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = " 常见问题功能正在建设中...";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //点击菜单－订房在线服务
    public function execClick_RESERVATION_ONLINE($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_RESERVATION_ONLINE', '订房在线服务'), 'Widget');
        R('Reservation/index', array($postObj), 'Widget');
    }

    //点击菜单－金护照－加入金护照
    public function execClick_JOIN_MEMBER($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_JOIN_MEMBER', '加入金护照'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = "加入“凯悦金护照”，开启在全球任何一家凯悦酒店享受专属礼遇和无日期限制的免费房晚礼遇\n●如需微管家人工帮助，请回复【2】\n ●自助服务请点击<a href='https://m.hyatt.com/mt/www.hyatt.com/un_join_gp?un_jtt_v_unLanguage=zh-Hans&src=wechat'>继续</a>";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //点击菜单－金护照－会员权益
    public function execClick_MEMBER_EQUITY($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_MEMBER_EQUITY', '会员权益'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '加入“凯悦金护照”，尊享更多会员礼遇',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJ5jhVjPPgdphedciajcFNlXD7p80XfyKiafjt28Wk1NXiaMRicT3uscvVqhiaOjYplF9Mo9FPJ0pR0PibA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325711&idx=1&sn=99f6b240d3fafad3d6b53b8d5cd7774d#rd',
            ),
            array(
                'title' => '金卡',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJ5jhVjPPgdphedciajcFNlXAHEGIicJemncyS9ic1SqHniaFFichqdlX29drolf9nBp8osxuT6RXN2dEw/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325711&idx=2&sn=aa5f75b73a65c5dfc1aea2512be26973#rd',
            ),
            array(
                'title' => '白金卡',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJ5jhVjPPgdphedciajcFNlXOx5l9oALIWdlOORBXkJjQaeiadgsIFqOO1431icYgUic1D7y3riaQ48OXA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325711&idx=3&sn=e60914d8ba7a03d769a14d1fde6096f6#rd',
            ),
            array(
                'title' => '钻石卡',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJ5jhVjPPgdphedciajcFNlXzQKREsqVW7yoic90uSaJToMUBuYjFvoic8c5SADN5I41YOTfnuTfmxLQ/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325711&idx=4&sn=a9a6ac7d0979416f7fb70468c40f4bb9#rd',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //点击菜单－金护照－会员专属优惠
    public function execClick_MEMBER_SALE($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_MEMBER_SALE', '会员专属优惠'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '全新会员权益，更多会员礼遇',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJBiaWiaFse8niczhicKBibpEagEX4yIkj59DxSSN7HZj48U99qphguZFky8jKfggneI8YNI0blpKG2uOw/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325708&idx=1&sn=be02c6c5a658c51fee56e9c4874cc2de#rd',
            ),
            array(
                'title' => '尊享八折优惠',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJBiaWiaFse8niczhicKBibpEagEFM9MsWFWhcMh5fdDXBGwBnguMK5aggVk7nlIq7jqbUuztwt4EOQicPg/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325708&idx=2&sn=f61476ac808fa5b5dbdc0e0d26048687#rd',
            ),
            array(
                'title' => '免费住宿如此简单',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJBiaWiaFse8niczhicKBibpEagEia0NTOkzvCBviaO5icPaic1anChbQm7ZRGYnk9nVo1yYHa6J8IgoIpI78Q/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325708&idx=3&sn=a0d9f44c37969c82f21bbac1cae32f96#rd',
            ),
            array(
                'title' => '尊享国航三倍里程',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMIl5Fo1ic1rjCpTSlfQ10qIW4UuGOYayNPODxsiaMVNicvzstDnYV9ljwnIAj5Thm5PpOQkjP8IWqvfQ/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200325708&idx=4&sn=f48bfd8e6e8d7be01a01544aac99b778#rd',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);
    }

    //点击菜单－金护照－查询兑换积分
    public function execClick_MEMBER_SCORE($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_MEMBER_SCORE', '查询兑换积分'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = " ●如需微管家人工帮助，请回复【2】\n ●如需自助查询积分，请点击<a href='https://m.hyatt.com/mt/www.hyatt.com/un_join_gp?un_jtt_v_unLanguage=zh-Hans&src=wechat'>此处</a>\n ●如需自助兑换积分，请点击<a href='http://www.hyatt.com/gp/zh-Hans/awards/index.jsp&src=wechat'>继续</a>";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    //点击菜单－金护照－会员在线服务
    public function execClick_MEMBER_ONLINE($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_MEMBER_ONLINE', '会员在线服务'), 'Widget');
        R('Member/index', array($postObj), 'Widget');
    }

    //点击菜单－悦享凯悦－我们的品牌
    public function execClick_ABOUT_HYATT($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_ABOUT_HYATT', '我们的品牌'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $Articles = array(
            array(
                'title' => '凯悦酒店集团',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMLNp7MMFztd0cibkznZZdRrxKZ5xbgE6OFlqCGvvI62gJUYQhv7q3klK3k0Tib0CibwfMqDSdVELfOvg/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=1&sn=7179319411f652cf8ad86336b557f719#rd',
            ),
            array(
                'title' => '柏悦酒店 Park Hyatt',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJtOPSyUj1gan6ag2xJnhnsKWJmlGfribIu6MBWgv4Vt1UNNDm3iaQQROictpe7ylQOjicBNfXgv9iaX8w/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=2&sn=c4baf60ba1f795062a08513dcf87f4b7#rd',
            ),
            array(
                'title' => '安达仕酒店 Andaz',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJtOPSyUj1gan6ag2xJnhnsaBcXbzkQ8eAACtW969sTkG5rjSdIX9gSRFQ8Z8OJP1sFx1ZIDic0yyQ/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=3&sn=97b93536cd5bf5541506c12c36cd24da#rd',
            ),
            array(
                'title' => '君悦酒店 Grand Hyatt',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJtOPSyUj1gan6ag2xJnhnsXRzje0ybUlSjEdrIc7Ccmhty9IhdSCPvbzctanlF77lDfOxKXgJG1w/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=4&sn=c7364f9559c48039b56c32e063dbe22b#rd',
            ),
            array(
                'title' => '凯悦酒店 Hyatt Regency',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJtOPSyUj1gan6ag2xJnhnslVROrbNOgPGZTO6y0Ef0eMF2ZyNoAsNVU7qbOoosIFOpDdV6icUgiaAA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=5&sn=d45dde859558d4042232001e52037ae1#rd',
            ),
            array(
                'title' => '凯悦嘉轩酒店 Hyatt Place',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJtOPSyUj1gan6ag2xJnhnsRUFCeBAx0P5DYN7iaQUMIbWeEs882RibrZ7IzkFzgzY0NPazMPhV05rA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=6&sn=4128c6a5565b9b35962ce118adacefa2#rd',
            ),
            array(
                'title' => '凯悦嘉寓酒店 Hyatt House',
                'description' => '',
                'picurl' => 'http://mmbiz.qpic.cn/mmbiz/mYuJJNBClMJtOPSyUj1gan6ag2xJnhnsMgYGp8MrWADbVnA2JP8yowvoHWY5SJs9vYkYz6skOkPX5FuuoXp5YA/0',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzA5ODA3MjMxOA==&mid=200272926&idx=7&sn=fa9e7ace80163e1a2c2e5ec701dcf640#rd',
            ),
        );

        $this -> responseNews($toUsername, $fromUsername, $Articles);

    }

    //点击菜单－悦享凯悦－最新优惠
    public function execClick_NEW_SALE($postObj){
        //记录数量
        R('Public/statisMenuNum', array('execClick_NEW_SALE', '最新优惠'), 'Widget');
        $fromUsername = $postObj -> FromUserName;
        $toUsername = $postObj -> ToUserName;
        $content = " ●如需微管家人工帮助，请回复【2】\n ●自助服务请点击<a href='http://m.hyatt.com/mt/www.hyatt.com/hyatt/specials/offers-landing.jsp?language=zh-Hans&src=wechat'>继续</a>";
        $this -> responseText($toUsername, $fromUsername, $content);
    }

    */

    //回复文本消息
    public function responseText($toUserName, $fromUserName, $content){
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $fromUserName, $toUserName, time(), 'text', $content);
        echo $resultStr;
        exit;
    }

    //回复图文消息
    public function responseNews($toUserName, $fromUserName, $Articles){
        $textTpl = "<xml>
                    <ToUserName><![CDATA[" . $fromUserName . "]]></ToUserName>
                    <FromUserName><![CDATA[" . $toUserName . "]]></FromUserName>
                    <CreateTime>" . time() . "</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>" . count($Articles) . "</ArticleCount>
                    <Articles>";

        foreach($Articles as $value){
            $textTpl .= "<item>
                         <Title><![CDATA[" . $value['title'] . "]]></Title>
                         <Description><![CDATA[" . $value['description'] . "]]></Description>
                         <PicUrl><![CDATA[" . $value['picurl'] . "]]></PicUrl>
                         <Url><![CDATA[" . $value['url'] . "]]></Url>
                         </item>";
        }

        $textTpl .= "</Articles>
                     </xml>";

        echo $textTpl;
        exit;

    }
}