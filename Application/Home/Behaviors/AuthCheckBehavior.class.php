<?php
namespace Home\Behaviors;
class AuthCheckBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$return){
        $uri = $_SERVER["REQUEST_URI"];
        if(strpos($uri,'/User/login') || strpos($uri,'/User/doLogin')){//在这里写列表，可以不做检查
            $return = true;
        }else{
            $userId = session('userId');
            if(!empty($userId)){
                $return = true;
            }else{
                 header('Content-Type: text/html; charset=utf-8');
                 redirect(U('User/login', array('url' => $_SERVER['HTTP_REFERER'])), 3, '需要登录，3秒后跳转。。。');
            }
        }
    }
}