<?php
namespace Home\Controller;
use Think\Controller;
class TeacherController extends Controller {
    
    public function show(){
        $instId = session('instId');
        $teacher = new \Home\Model\TeacherModel();
        $teacherList = $teacher->queryAllTeachersByInstId($instId);
        $this->assign('teacherList',$teacherList);
        $this->display();
    }
    
    public function saveTeacher($name,$mobile){
        $instId = session('instId');
        $teacher = new \Home\Model\TeacherModel();
        $result = $teacher->saveTeacher($name,$mobile,$instId);
        if(!empty($result)){
           $data = 'ok'; 
        }else{
            $data = "false";
        }
        $this->ajaxReturn($data);
    }
    
    public function updateTeacher($teacherId,$name,$mobile){
        $instId = session('instId');
        $teacher = new \Home\Model\TeacherModel();
        $teacherList = $teacher->updateTeacherByTeacherId($teacherId,$name,$mobile,$instId);
        $data = 'ok'; 
        $this->ajaxReturn($data);
    }
    
    public function deleteTeacher($teacherId){
        $instId = session('instId');
        $teacher = new \Home\Model\TeacherModel();
        $teacherList = $teacher->deleteScheduleByTeacherId($teacherId,$instId);
        $data = 'ok'; 
        $this->ajaxReturn($data);
    }
}