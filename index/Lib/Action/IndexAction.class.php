<?php
class IndexAction extends Action {
    public function index(){
        $echoStr = $_GET["echostr"];
        echo $echoStr;
    }
}