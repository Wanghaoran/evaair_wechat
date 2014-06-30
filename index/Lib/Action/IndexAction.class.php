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


        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if(!empty( $keyword ))
            {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                echo "Input something...";
            }

        }else {
            echo "";
            exit;
        }

    }

        private function checkSignature()
        {
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];

            $token = C('WECHAT_TOKEN');
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                return true;
            }else{
                return false;
            }
        }


        /*
                $content = '长荣航空官方微信建设中...';

                file_put_contents('1.txt', time());

                $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

                if(!empty($postStr)){
                    R('Wechatmsg/checkMsg', array($postStr), 'Widget');
                }else{
                    echo '';
                    exit;
                }


        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);


        $fromUserName = $postObj -> FromUserName;
        $toUserName = $postObj -> ToUserName;


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
        */


}