<?php
/**
 * User: Powerless
 * Date: 2020/8/2
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\validate;

use think\Validate;

class IndexValidate extends Validate
{
    protected $rule = [
        'name'              => 'require|chsAlphaNum|max:16',
        'phone'             => 'require|integer|between:13000000000,19999999999',
        'department'        => 'require|chsAlphaNum|max:64',
        'position'          => 'require|chsAlphaNum|max:64',
    ];
    protected $field = [
        'name'              => '姓名',
        'phone'             => '手机号',
        'department'        => '部门',
        'position'          => '职务',
    ];
    protected $message = [
        'phone.between'     => "请输入真实手机号",
    ];
    protected $scene = [
        'staff'            => ['name','phone'],
        'work'            => ['name','position'],
    ];

}