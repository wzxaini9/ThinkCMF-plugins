<?php

/**
 * User: Powerless
 * Date: 2019/11/17
 * Blog: https://wzxaini9.cn
 */

namespace plugins\tencent_app;

use cmf\lib\Plugin;

class TencentAppPlugin extends Plugin
{

    public $info = [
        'name'        => 'TencentApp',
        'title'       => '腾讯小程序',
        'description' => '腾讯小程序管理工具',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.0',
        'demo_url'    => 'https://wzxaini9.cn',
        'author_url'  => 'https://wzxaini9.cn'
    ];

    // 插件安装
    public function install()
    {
        return true;//安装成功返回true，失败false
    }

    // 插件卸载
    public function uninstall()
    {
        return true;//卸载成功返回true，失败false
    }


}