<?php
/**
 * User: Powerless
 * Date: 2020/8/2
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\model;

use think\Model;

class IndexModel extends Model
{
    public function search($where)
    {
        $info = $this->table("staff_info si")
            ->field('si.id,si.name,si.sex,si.image,si.phone as sphone,si.province,si.city,si.area,si.supplement,si.work_remark,si.especially_remark,wi.unit,wi.department,wi.position,wi.phone as wphone,wi.start_time,wi.end_time')
            ->join(['work_info'=>'wi'],'si.work_id = wi.id','LEFT')
            ->where($where)
            ->order('si.id','DESC')
            ->find();
        return $info;
    }
}