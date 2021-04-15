<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-21021 https://www.wzxaini9.cn/ All rights reserved.
// +----------------------------------------------------------------------
// | Author: Powerless <wzxaini9@gmail.com>
// +----------------------------------------------------------------------

return [
    'app_id'         => [
        'title'   => 'AppID',
        'type'    => 'number',
        'value'   => '2086546024',
        'tip'     => '腾讯防水墙(<a href="https://007.qq.com" target="_blank">免费申请</a>)',
        "rule"    => [
            "require" => true
        ],
        "message" => [
            "require" => '腾讯防水墙AppID不能为空'
        ],
    ],
    'app_secret_key' => [
        'title'   => 'AppSecretKey',
        'type'    => 'text',
        'value'   => '0JVmnWXNC9Vd4P0UHeuOMMA**',
        'tip'     => '<a href="//wzxaini9.cn" target="_blank">Powerless</a>已注册此插件，可直接使用',
        "rule"    => [
            "require" => true
        ],
        "message" => [
            "require" => '腾讯防水墙AppSecretKey不能为空'
        ],
    ]
];
					