<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.chaosii.xin All rights reserved.
// +----------------------------------------------------------------------
// | Author: chaosii <liyv1314@sina.com>
// +----------------------------------------------------------------------
return [
    'app_key'        => [
        'title' => 'App Key',
        'type'  => 'text',
        'value' => '',
        'tip'   => '微博开放平台对应应用下的App Key'
    ],
    'app_secret'     => [
        'title' => 'App Secret',
        'type'  => 'text',
        'value' => '',
        'tip'   => '微博开放平台对应应用下的App Secret'
    ],
    'callback_url'   => [
        'title' => '回调地址',
        'type'  => 'text',
        'value' => '',
        'tip'   => '需要和 <a href="https://open.weibo.com/" target="view_window">微博开放平台</a>中 ->应用信息->高级信息->OAuth2.0 授权设置中设置的授权回调页相同'
    ],
    'content_length' => [
        'title' => '博文长度',
        'type'  => 'number',
        'value' => '90',
        'tip'   => '微博长度最大为140个字符（包含网址），请自行计算实际发送字数'
    ],
    'synchronize'    => [
        'title'   => '自动发微博',
        'type'    => 'radio',
        'options' => [
            '1' => '开启',// 值=>显示
            '0' => '关闭',
        ],
        'value'   => '0',
        'tip'     => '所有文章修改保存操作都将发布一条微博，每次修改后需要重新授权。'
    ],
];
