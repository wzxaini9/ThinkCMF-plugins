<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\model;

use think\Model;

class StaffModel extends Model
{
    public function selectLists($where)
    {
        $lists = $this->table("staff_info")->field('id,name')->where($where)->select()->toArray();
        return $lists;
    }

    public function lists($param,$where,$size)
    {
        $lists = $this->table("staff_info")
            ->where($where)
            ->order('id','DESC')
            ->paginate($size)
            ->toArray();
        $page = $this->table("staff_info")->where($where)->paginate($size)->appends($param)->render();
        return [$lists,$page];
    }

    public function info($id)
    {
        $info = $this->table("staff_info")->where('id','=',$id)->find();
        return $info;
    }

    public function add($param)
    {
        $insert["name"] = $param['name'];
        $insert["sex"] = $param['sex'];
        $insert["work_id"] = $param['work_id'];
        $insert["phone"] = $param['phone'];
        $insert["province"] = $param['province'];
        $insert["city"] = $param['city'];
        $insert["area"] = $param['area'];
        $insert["supplement"] = $param['supplement'];
        $insert["work_remark"] = $param['work_remark'];
        $insert["especially_remark"] = $param['especially_remark'];
        $insert["image"] = $param['image'];
        $id = $this->table('staff_info')->insertGetId($insert);
        return $id;
    }

    public function edit($param)
    {
        $update["sex"] = $param['sex'];
        $update["work_id"] = $param['work_id'];
        $update["phone"] = $param['phone'];
        $update["province"] = $param['province'];
        $update["city"] = $param['city'];
        $update["area"] = $param['area'];
        $update["supplement"] = $param['supplement'];
        $update["work_remark"] = $param['work_remark'];
        $update["especially_remark"] = $param['especially_remark'];
        $update["image"] = $param['image'];
        $this->table('staff_info')->where('id','=',$param['id'])->update($update);
        return $param['id'];
    }

    public function status($id,$status)
    {
        $this->table('staff_info')->where('id','=',$id)->update(['status'=>$status]);
        return $id;
    }
}