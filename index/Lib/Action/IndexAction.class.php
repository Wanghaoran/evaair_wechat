<?php
class IndexAction extends Action {
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


    public function index(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if(!empty($postStr)){
            R('Wechatmsg/checkMsg', array($postStr), 'Widget');
        }else{
            echo '';
            exit;
        }

    }


}