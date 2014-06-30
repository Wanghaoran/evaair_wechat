<?php
class IndexAction extends Action {

    /*
    public function _before_index(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = C('WECHAT_TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if($tmpStr != $signature ){
            return false;
        }
    }
    */

    public function index(){

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        /*
        if(!empty($postStr)){
            R('Wechatmsg/checkMsg', array($postStr), 'Widget');
        }else{
            echo '';
            exit;
        }
        */

        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

        file_put_contents('1.txt', $postStr);

        $fromUserName = $postObj -> FromUserName;
        $toUserName = $postObj -> ToUserName;
        $content = '长荣航空官方微信建设中...';
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

}