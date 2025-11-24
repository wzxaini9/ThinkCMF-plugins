<?php

namespace plugins\tanshu;

use cmf\lib\Plugin;

class TanshuPlugin extends Plugin
{

    public $info = [
        'name'        => 'Tanshu',
        'title'       => '新闻拉取',
        'description' => '新闻搜索',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.0.0'
    ];

    public $hasAdmin = 1;//插件是否有后台管理界面
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