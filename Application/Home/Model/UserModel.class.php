<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
    protected $connection = 'DB_CONFIG1';//调用配置文件中的数据库配置1
    protected $autoCheckFields =false;//模型和数据表无需一一对应
    
    public function queryUser($loginname,$password){
        $querySql = "select * from classoa_user where user_name='".$loginname."' and user_pwd='".md5($password)."'";
        $userList = $this->query($querySql);
        return $userList;
    }
    
}

