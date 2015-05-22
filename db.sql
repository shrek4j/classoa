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