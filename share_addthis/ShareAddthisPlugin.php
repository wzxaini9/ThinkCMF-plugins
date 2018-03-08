<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Powerless <wzxaini9@gmail.com>
// +----------------------------------------------------------------------
namespace plugins\share_addthis;

use cmf\lib\Plugin;

class ShareAddthisPlugin extends Plugin
{

    public $info = [
        'name'=>'ShareAddthis',
        'title'=>'分享效果',
        'description'=>'页面分享插件',
        'status'=>1,
        'author'=>'ThinkCMF',
        'version'=>'1.0',
        'demo_url'    => 'http://demo.thinkcmf.com',
        'author_url'  => 'http://www.thinkcmf.com'
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

    //实现的footer钩子方法
    public function footerStart($param)
    {
        echo $this->fetch('widget');
    }

}