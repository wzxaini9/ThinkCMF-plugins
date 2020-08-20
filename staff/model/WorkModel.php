<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\model;

use think\Model;

class WorkModel extends Model
{
    public function selectLists($where)
    {
        $lists = $this->table("work_info")->field('id,unit,department,position')->where($where)->select()->toArray();
        return $lists;
    }

    public function lists($param,$where,$size)
    {
        $lists = $this->table("work_info")
            ->where($where)
            ->order('id','DESC')
            ->paginate($size)
            ->toArray();
        $page = $this->table("work_info")->where($where)->paginate($size)->appends($param)->render();
        return [$lists,$page];
    }

    public function info($id)
    {
        $info = $this->table("work_info")->where('id','=',$id)->find();
        return $info;
    }

    public function add($param)
    {
        $insert["unit"] = $param['unit'];
        $insert["department"] = $param['department'];
        $insert["position"] = $param['position'];
        $insert["phone"] = $param['phone'];
        $insert["start_time"] = $param['start_time'];
        $insert["end_time"] = $param['end_time'];
        $id = $this->table('work_info')->insertGetId($insert);
        return $id;
    }

    public function edit($param)
    {
        $update["department"] = $param['department'];
        $update["position"] = $param['position'];
        $update["phone"] = $param['phone'];
        $update["start_time"] = $param['start_time'];
        $update["end_time"] = $param['end_time'];
        $this->table('work_info')->where('id','=',$param['id'])->update($update);
        return $param['id'];
    }

    public function status($id,$status)
    {
        $this->table('work_info')->where('id','=',$id)->update(['status'=>$status]);
        return $id;
    }
}