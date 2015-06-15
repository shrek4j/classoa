<?php
namespace Home\Model;
use Think\Model;
class TeacherModel extends Model {
    protected $connection = 'DB_CONFIG1';//调用配置文件中的数据库配置1
    protected $autoCheckFields =false;//模型和数据表无需一一对应
    
    public function queryAllTeachersByInstId($instId){
        $querySql = "select * from classoa_teacher where inst_id=".$instId." and status=1 order by teacher_id asc";
        $teacherList = $this->query($querySql);
        return $teacherList;
    }
    
    public function saveTeacher($name,$mobile,$instId){
        $sql = "insert into classoa_teacher(name,mobile,inst_id) values('".$name."','".$mobile."',".$instId.")";
        $this->execute($sql);
        $queryIdSql = "SELECT @@IDENTITY as teacher_id";
        return $this->query($queryIdSql);
    }
    
    public function updateTeacherByTeacherId($teacherId,$name,$mobile,$instId){
        $querySql = "UPDATE classoa_teacher SET name='".$name."',mobile='".$mobile."' WHERE teacher_id=".$teacherId." and inst_id=".$instId;
        return $this->execute($querySql);  
    }
    
    public function deleteScheduleByTeacherId($teacherId,$instId){
        $querySql = "UPDATE classoa_teacher SET status=0 WHERE teacher_id=".$teacherId." and inst_id=".$instId;
        return $this->execute($querySql);  
    }
}

