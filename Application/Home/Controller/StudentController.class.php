<?php
namespace Home\Controller;
use Think\Controller;
class StudentController extends Controller {
    
    public function show(){
        $instId = session('instId');
        $student = new \Home\Model\StudentModel();
        $studentList = $student->queryAllStudentsByInstId($instId);
        $this->assign('studentList',$studentList);
        $this->display();
    }
    
    public function saveStudent($name,$mobile){
        $instId = session('instId');
        $student = new \Home\Model\StudentModel();
        $result = $student->saveStudent($name,$mobile,$instId);
        if(!empty($result)){
           $data = 'ok'; 
        }else{
            $data = "false";
        }
        $this->ajaxReturn($data);
    }
    
    public function updateStudent($studentId,$name,$mobile){
        $instId = session('instId');
        $student = new \Home\Model\StudentModel();
        $studentList = $student->updateStudentByStudentId($studentId,$name,$mobile,$instId);
        $data = 'ok'; 
        $this->ajaxReturn($data);
    }
    
    public function deleteStudent($studentId){
        $instId = session('instId');
        $student = new \Home\Model\StudentModel();
        $studentList = $student->deleteScheduleByStudentId($studentId,$instId);
        $data = 'ok'; 
        $this->ajaxReturn($data);
    }
}