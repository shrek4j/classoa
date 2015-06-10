<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function login(){
        $this->display();
    }
    
    public function logout(){
        
    }
    
    public function doLogin($loginname,$password){
        $user = new \Home\Model\UserModel();
        $result = $user->queryUser($loginname,$password);
        if(!empty($result) && count($result) == 1){
            session('userId',$result[0]['user_id']);
            session('instId',$result[0]['inst_id']);
            $this->success('登陆成功', '/index.php/Home/Schedule/show',2);
        }else{
            $this->error('登陆失败');
        }    
    }
}