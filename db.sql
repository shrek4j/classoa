CREATE TABLE `classoa_institute` (
  `inst_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`inst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `classoa_student` (
  `stud_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(20) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `balance` int(10) DEFAULT '0' COMMENT '余额',
  `inst_id` int(10) NOT NULL,
  PRIMARY KEY (`stud_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `classoa_student_schedule_rela` (
  `sched_id` int(10) NOT NULL,
  `stud_id` int(10) NOT NULL,
  `fee_per_hour` int(5) NOT NULL DEFAULT '0' COMMENT '每小时费用'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `classoa_teacher` (
  `teacher_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(10) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `inst_id` int(10) DEFAULT NULL COMMENT 'FK_classoa_institute',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `classoa_schedule_template` (
  `schedule_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `teacher_id` int(10) NOT NULL COMMENT '老师ID',
  `day_of_week` int(1) NOT NULL COMMENT '1-7 星期一-星期日',
  `start_time` varchar(10) NOT NULL COMMENT '开始时间  ''07:30''',
  `end_time` varchar(10) NOT NULL COMMENT '结束时间  ''09:30''',
  `class_tag` varchar(50) DEFAULT NULL COMMENT '课程标签',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注信息',
  `monday_of_effect_week` int(8) DEFAULT NULL COMMENT '生效那周的第一天 yyyy-MM-dd',
  `monday_of_expire_week` int(8) NOT NULL DEFAULT '20991231' COMMENT '失效那周的第一天',
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;


CREATE TABLE `classoa_schedule_adjust` (
  `schedule_adjust_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `schdeule_id` int(10) NOT NULL COMMENT 'schedule_template主键',
  `is_regular` int(1) NOT NULL DEFAULT '1' COMMENT '1:正式的 0:临时的（只生效一次）',
  `monday_of_effect_week` date DEFAULT NULL COMMENT '生效那周的第一天 yyyyMMdd',
  `from_date` date DEFAULT NULL COMMENT '将哪天的',
  `to_date` date DEFAULT NULL COMMENT '迁移到哪天',
  PRIMARY KEY (`schedule_adjust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;