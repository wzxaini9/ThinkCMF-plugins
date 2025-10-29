<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace plugins\comment\validate;

use think\Validate;

class CommentValidate extends Validate
{
    protected $rule = [
        'object_id'  => 'require',
        'table_name' => 'require',
        'content'    => 'require',
    ];

    protected $message = [
        'object_id.require'  => '参数错误，评论对象ID不能为空',
        'table_name.require' => '参数错误',
        'content.require'    => '内容不能为空',
    ];

}