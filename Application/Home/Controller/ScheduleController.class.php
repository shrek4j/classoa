<?php
namespace Home\Controller;
use Think\Controller;
class ScheduleController extends Controller {

    public function show($tId=0){
        $instId = session('instId');
        $teacher = new \Home\Model\TeacherModel();
        $teacherList = $teacher->queryAllTeachersByInstId($instId);

        if(count($teacherList) > 0){
            if($tId == 0){
                $tId = $teacherList[0]['teacher_id'];   
            }
            session('tId',$tId);
            
            $schedule = new \Home\Model\ScheduleModel();
            $scheduleList = $schedule->queryByTeacherId($tId);
            $thisMonday = getThisMonday();
            $dateList = getDateList(10);
            $this->assign('thisMonday',$thisMonday);
            $this->assign('dateList',$dateList);
            $this->assign('scheduleList',$scheduleList);
            $this->assign('teacherList',$teacherList);
            $this->assign('tId',$tId);
        }
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

function getDateList($total){
    $thisMonday = getThisMonday();
    //默认添加三个月的，10周
    $dateList[0] = $thisMonday;
    for($i=1;$i<$total;$i++){
        $dateList[$i] = getAnyMonday($thisMonday,$i);
    }
    return $dateList;
}

function getThisMonday(){
    $timestamp=0;
    $is_return_timestamp=false;
    static $cache ;  
    $id = $timestamp.$is_return_timestamp;  
    if(!isset($cache[$id])){  
        if(!$timestamp) $timestamp = time();  
        $monday_date = date('Ymd', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400));  
        if($is_return_timestamp){  
            $cache[$id] = strtotime($monday_date);  
        }else{  
            $cache[$id] = $monday_date;  
        }  
    }  
    return $cache[$id];
}  

function getAnyMonday($anyMonday,$weekCount){
    $anyDate = strtotime($anyMonday);
    $thismonday = $anyDate + 7*86400*$weekCount;
    return date('Ymd',$thismonday);
}