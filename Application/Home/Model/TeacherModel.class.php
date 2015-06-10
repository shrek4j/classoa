<?php
namespace Home\Model;
use Think\Model;
class TeacherModel extends Model {
    protected $connection = 'DB_CONFIG1';//调用配置文件中的数据库配置1
    protected $autoCheckFields =false;//模型和数据表无需一一对应
    
    public function queryAllTeachersByInstId($instId){
        $querySql = "select * from classoa_teacher where inst_id=".$instId." order by teacher_id asc";
        $teacherList = $this->query($querySql);
        return $teacherList;
    }
    
}

