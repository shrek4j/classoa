<?php
namespace Home\Controller;
use Think\Controller;
class ScheduleController extends Controller {
    
    public function show($teacherId=0){
        $schedule = D('$Schedule');
        $scheduleList = $schedule->queryByTeacherId($teacherId);
        $this->assign('scheduleList',$scheduleList);
        $this->display();
    }
    
    public function save($userId=0){
        
    }
}