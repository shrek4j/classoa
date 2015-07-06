<?php
namespace Home\Model;
use Think\Model;
class ScheduleModel extends Model {
    protected $connection = 'DB_CONFIG1';//调用配置文件中的数据库配置1
    protected $autoCheckFields =false;//模型和数据表无需一一对应
    
    public function queryByTeacherId($teacherId,$effectMonday){
        $querySql = "select st.* from classoa_schedule_template st 
                                        WHERE st.teacher_id = ".$teacherId." and monday_of_effect_week <= ".$effectMonday." and monday_of_expire_week > ".$effectMonday." 
                                        ORDER BY st.day_of_week ASC,st.start_time ASC";
        $scheduleList = $this->query($querySql);
        return $scheduleList;
    }
    
    public function queryByScheduleId($scheduleId){
         $querySql = "select ssr.*,s.* from classoa_student_schedule_rela ssr 
                                        left join classoa_student s on ssr.stud_id = s.stud_id
                                        WHERE ssr.sched_id = ".$scheduleId;
        $scheduleList = $this->query($querySql);
        return $scheduleList;
    }
    
    public function updateScheduleByTId($tId,$schedId,$dayOfWeek,$startTime,$endTime){
        $querySql = "UPDATE classoa_schedule_template SET day_of_week=".$dayOfWeek.",start_time='".$startTime."',end_time='".$endTime."' WHERE teacher_id=".$tId." and schedule_id=".$schedId;
        return $this->execute($querySql);  
    }
    
    public function saveScheduleByTId($tId,$classTag,$dayOfWeek,$startTime,$endTime,$thisMonday){
        $sql = "insert into classoa_schedule_template(teacher_id,day_of_week,start_time,end_time,class_tag,monday_of_effect_week) values(".$tId.",".$dayOfWeek.",'".$startTime."','".$endTime."','".$classTag."',".$thisMonday.")";
        $this->execute($sql);
        $queryIdSql = "SELECT @@IDENTITY as schedId";
        return $this->query($queryIdSql);
    }
    
    public function deleteScheduleByTId($tId,$schedId,$expireMonday){
        $sql = "update classoa_schedule_template set monday_of_expire_week=".$expireMonday." where teacher_id=".$tId." and schedule_id=".$schedId;
        return $this->execute($sql);
    }
    
    public function updateClassTagBySchedId($tId,$schedId,$classTag){
        $querySql = "UPDATE classoa_schedule_template SET class_tag='".$classTag."' WHERE teacher_id=".$tId." and schedule_id=".$schedId;
        return $this->execute($querySql);  
    }
}
