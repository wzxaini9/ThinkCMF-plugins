<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\model;

use think\Db;

class OperationDb
{
    public function createDb()
    {
        $staff = "
            CREATE TABLE IF NOT EXISTS `staff_info` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(16) NOT NULL DEFAULT '' COMMENT '姓名',
              `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别0:未设置1：男2：女',
              `work_id` int(11) NOT NULL DEFAULT '0' COMMENT '工作表ID',
              `image` varchar(255) NOT NULL DEFAULT '' COMMENT '照片',
              `phone` varchar(16) NOT NULL DEFAULT '' COMMENT '电话',
              `province` varchar(8) NOT NULL DEFAULT '' COMMENT '省',
              `city` varchar(16) NOT NULL DEFAULT '' COMMENT '市',
              `area` varchar(16) NOT NULL DEFAULT '' COMMENT '区',
              `supplement` varchar(128) NOT NULL DEFAULT '' COMMENT '补充地址',
              `work_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '工作备注',
              `especially_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '特别备注',
              `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否删除 1:未删除，0:已删除',
              `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
              `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              PRIMARY KEY (`id`),
              KEY `idx_wid` (`work_id`),
              KEY `idx_name` (`name`,`phone`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $work = "            
            CREATE TABLE IF NOT EXISTS `work_info` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `start_time` datetime NOT NULL COMMENT '开始时间',
              `end_time` datetime NOT NULL COMMENT '结束时间',
              `unit` varchar(32) NOT NULL DEFAULT '' COMMENT '单位',
              `department` varchar(32) NOT NULL DEFAULT '' COMMENT '部门',
              `position` varchar(32) NOT NULL DEFAULT '' COMMENT '职务',
              `phone` varchar(16) NOT NULL DEFAULT '' COMMENT '电话',
              `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否删除 1:未删除，0:已删除',
              `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
              `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              PRIMARY KEY (`id`),
              KEY `idx_unit` (`unit`,`department`,`position`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        Db::execute($staff);
        Db::execute($work);
        return true;
    }

    public function renameDb()
    {
        $staff = "RENAME TABLE `staff_info` TO staff_info_".time().";";
        $work = "RENAME TABLE `work_info` TO work_info_".time().";";
        Db::execute($staff);
        Db::execute($work);
        return true;
    }
}