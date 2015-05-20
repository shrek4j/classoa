<?php
namespace Home\Model;
use Think\Model;
class ScheduleModel extends Model {
    protected $connection = 'DB_CONFIG1';//调用配置文件中的数据库配置1
    protected $autoCheckFields =false;//模型和数据表无需一一对应
    
    public function queryByTeacherId($teacherId){
        $querySql = "select st.* from classoa.classoa_schedule_template st 
                                        WHERE st.teacher_id = ".$teacherId." ORDER BY st.day_of_week ASC,st.start_time ASC";
        $scheduleList = $this->query($querySql);  
        return $scheduleList;
    }
    
    public function queryByScheduleId($scheduleId){
         $querySql = "select ssr.*,s.* from classoa.classoa_student_schedule_rela ssr 
                                        left join classoa.classoa_student s on ssr.stud_id = s.stud_id
                                        WHERE ssr.sched_id = ".$scheduleId;
        $scheduleList = $this->query($querySql);  
        return $scheduleList;
    }
}

