<?php

/**
 * User: Powerless
 * Date: 2019/11/17
 * Blog: https://wzxaini9.cn
 */

namespace plugins\tencent_app\validate;

use think\Validate;

class AdminAppValidate extends Validate
{
    protected $rule = [
        'name'       => 'require|max:32',
        'app_id'     => 'require|max:32',
        'app_secret' => 'require|max:32',
        'app_type'   => 'require|max:16'
    ];

    protected $message = [
        'name.require'       => "小程序名称不能为空！",
        'app_id.require'     => "小程序App Id不能为空!",
        'app_secret.require' => '小程序App Secret不能为空!',
        'app_type.require'   => '小程序类型不能为空!',
        'name.max'           => "小程序名称不能超过32个字符！",
        'app_id.max'         => "小程序App Id不能超过32个字符!",
        'app_secret.max'     => '小程序App Secret不能超过32个字符!',
        'app_type.max'       => '小程序类型不能超过16个字符!',
    ];


}