<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace plugins\staff\validate;

use think\Validate;

class StaffValidate extends Validate
{
    protected $rule = [
        'id'                => 'require|integer|gt:0',
        'name'              => 'require|chsAlphaNum|max:16',
        'phone'             => 'require|integer|between:13000000000,19999999999',
        'sex'               => 'require|integer|between:0,2',
        'work_id'           => 'require|integer|gt:0',
        'province'          => 'chsAlphaNum|max:32',
        'city'              => 'chsAlphaNum|max:32',
        'area'              => 'chsAlphaNum|max:32',
        'supplement'        => 'chsAlphaNum|max:128',
        'work_remark'       => 'chsAlphaNum|max:255',
        'especially_remark' => 'chsAlphaNum|max:255',
    ];
    protected $field = [
        'id'                => 'ID',
        'name'              => '姓名',
        'phone'             => '手机号',
        'sex'               => '性别',
        'work_id'           => '工作组',
        'province'          => '省',
        'city'              => '市',
        'area'              => '区',
        'supplement'        => '补充地址',
        'work_remark'       => '工作备注',
        'especially_remark' => '特别备注',
    ];
    protected $message = [
        'phone.between' => "请输入真实手机号",
        'sex.between'   => "请选择正确的性别",
        'work_id.gt'    => '请选择工作组',
    ];
    protected $scene = [
        'add'    => ['name', 'sex', 'phone', 'work_id', 'province', 'city', 'area', 'supplement', 'work_remark', 'especially_remark'],
        'edit'   => ['id', 'name', 'sex', 'phone', 'work_id', 'province', 'city', 'area', 'supplement', 'work_remark', 'especially_remark'],
        'status' => ['id'],
    ];
}