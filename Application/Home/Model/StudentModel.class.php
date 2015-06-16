<?php
namespace Home\Model;
use Think\Model;
class StudentModel extends Model {
    protected $connection = 'DB_CONFIG1';//调用配置文件中的数据库配置1
    protected $autoCheckFields =false;//模型和数据表无需一一对应
    
    public function queryAllStudentsByInstId($instId){
        $querySql = "select * from classoa_student where inst_id=".$instId." and status=1 order by student_id asc";
        $studentList = $this->query($querySql);
        return $studentList;
    }
    
    public function saveStudent($name,$mobile,$instId){
        $sql = "insert into classoa_student(name,mobile,inst_id) values('".$name."','".$mobile."',".$instId.")";
        $this->execute($sql);
        $queryIdSql = "SELECT @@IDENTITY as student_id";
        return $this->query($queryIdSql);
    }
    
    public function updateStudentByStudentId($studentId,$name,$mobile,$instId){
        $querySql = "UPDATE classoa_student SET name='".$name."',mobile='".$mobile."' WHERE student_id=".$studentId." and inst_id=".$instId;
        return $this->execute($querySql);  
    }
    
    public function deleteScheduleByStudentId($studentId,$instId){
        $querySql = "UPDATE classoa_student SET status=0 WHERE student_id=".$studentId." and inst_id=".$instId;
        return $this->execute($querySql);  
    }
}

