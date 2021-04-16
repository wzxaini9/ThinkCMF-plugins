<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\validate;

use think\Validate;

class WorkValidate extends Validate
{
    protected $rule = [
        'id'         => 'require|integer|gt:0',
        'unit'       => 'require|chsAlphaNum|max:64',
        'department' => 'require|chsAlphaNum|max:64',
        'position'   => 'require|chsAlphaNum|max:64',
        'phone'      => 'require|alphaDash|max:16',
    ];
    protected $field = [
        'id'         => 'ID',
        'unit'       => '单位',
        'department' => '部门',
        'position'   => '职务',
        'phone'      => '监督电话',
    ];
    protected $scene = [
        'add'    => ['unit', 'department', 'position', 'phone'],
        'edit'   => ['id', 'unit', 'department', 'position', 'phone'],
        'status' => ['id'],
    ];

}