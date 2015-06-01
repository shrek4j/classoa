<?php
namespace Home\Controller;
use Think\Controller;
class ScheduleController extends Controller {

    public function show(){
        $tId = session('tId');
        
        $schedule = new \Home\Model\ScheduleModel();
        $scheduleList = $schedule->queryByTeacherId($tId);
        
        $this->assign('scheduleList',$scheduleList);
        $this->display();
    }
    
    public function updateSchedule($schedId,$dayOfWeek,$startTime,$endTime){
        $tId = session('tId');
        
        $schedule = new \Home\Model\ScheduleModel();
        $result = $schedule->updateScheduleByTId($tId,$schedId,$dayOfWeek,$startTime,$endTime);
        if($result == 1){
           $data = 'ok'; 
        }else{
            $data = "false";
        }
        $this->ajaxReturn($data);
    }
    
    public function saveSchedule($classTag,$dayOfWeek,$startTime,$endTime){
        $tId = session('tId');
    
        $schedule = new \Home\Model\ScheduleModel();
        $result = $schedule->saveScheduleByTId($tId,$classTag,$dayOfWeek,$startTime,$endTime);
        if(empty($result)){
            $result = "false";
        }else{
            
        }
        $this->ajaxReturn($result);
    }
    
    public function deleteSchedule($schedId){
        $tId = session('tId');
        
        $schedule = new \Home\Model\ScheduleModel();
        $result = $schedule->deleteScheduleByTId($tId,$schedId);
        if($result == 1){
            $result = true;
        }else{
            $result = false;
        }
        $this->ajaxReturn($result);
    }
    
}