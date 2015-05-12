<?php
namespace Home\Model;
use Think\Model;
class SchdeuleModel extends Model {
    //调用配置文件中的数据库配置1
    protected $connection = 'DB_CONFIG1';
    
    public function queryByTeacherId($teacherId){
        $querySql = "select st.*,s.* from classoa.classoa_schedule_template st 
                                        join classoa.classoa_student_schedule_rela ssr on st.schedule_id = ssr.sched_id 
                                        join classoa.classoa_student s on ssr.stud_id = s.stud_id
                                        WHERE st.teacher_id = ".$teacherId." ORDER BY st.day_of_week ASC,st.start_time ASC";
        $Model = new \Think\Model();
        $scheduleList = $Model->query($querySql);  
        return $scheduleList;
    }
}

