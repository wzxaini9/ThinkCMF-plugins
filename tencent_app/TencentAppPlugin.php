<?php
/**
 * User: Powerless
 * Date: 2021/4/15
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
        'version'     => '2.0.0',
        'demo_url'    => 'https://www.wzxaini9.cn/',
        'author_url'  => 'https://www.wzxaini9.cn/'
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