<?php
namespace Home\Behaviors;
class AuthCheckBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$return){
        $uri = $_SERVER["REQUEST_URI"];
        if(strpos($uri,'/User/login') == true){
            $return = true;
        }else{
            $tId = session('tId');
            if(!empty($tId)){
                $return = true;
            }else{
                $return = false;
            }
        }
        return $return;
    }
}