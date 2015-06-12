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
}