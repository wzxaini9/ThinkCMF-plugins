<?php
/**
 * User: Powerless
 * Date: 2025/11/21
 * Blog: https://wzxaini9.cn
 */

return [
    'host' => [
        'title'   => '接口域名',
        'type'    => 'text',
        'value'   => 'https://api.tanshuapi.com',
        'tip'     => '接口主域名',
        "rule"    => [
            "require" => true
        ],
        "message" => [
            "require" => 'SecretKey不能为空'
        ],
    ],
    'secret' => [
        'title'   => 'SecretKey',
        'type'    => 'text',
        'value'   => '',
        'tip'     => '<a href="//www.tanshuapi.com/" target="_blank">注册获取key</a>',
        "rule"    => [
            "require" => true
        ],
        "message" => [
            "require" => 'SecretKey不能为空'
        ],
    ]
];
					