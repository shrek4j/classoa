<?php
namespace Home\Controller;
use Think\Controller;
class ScheduleController extends Controller {
    
    public function show($tId){
        $schedule = new \Home\Model\ScheduleModel();
        $scheduleList = $schedule->queryByTeacherId($tId);
        print_r($scheduleList);
        
        $this->assign('scheduleList',$scheduleList);
        $this->display();
    }
    
    public function save($userId=0){
        
    }
}