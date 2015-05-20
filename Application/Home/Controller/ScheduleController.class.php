<?php
namespace Home\Controller;
use Think\Controller;
class ScheduleController extends Controller {
    
    public function show($tId){
        $schedule = new \Home\Model\ScheduleModel();
        $scheduleList = $schedule->queryByTeacherId($tId);
        
        $this->assign('scheduleList',$scheduleList);
        $this->display();
    }
    
    public function saveSchedule($schedId,$dayOfWeek,$startTime,$endTime){
        session('tId',1);
        $tId = session('tId');
        
        if($tId != 0){
            $schedule = new \Home\Model\ScheduleModel();
            $result = $schedule->updateScheduleByTId($tId,$schedId,$dayOfWeek,$startTime,$endTime);
            if($result == 1){
               $data = 'ok'; 
            }else{
                $data = "false";
            }
            $this->ajaxReturn($data);
        }
        
    }
}