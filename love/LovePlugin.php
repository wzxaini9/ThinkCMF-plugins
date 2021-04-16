<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\love;

use cmf\lib\Plugin;

class LovePlugin extends Plugin
{

    public $info = [
        'name'        => 'Love',
        'title'       => '点击桃心',
        'description' => '点击桃心',
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

    //实现的footer钩子方法
    public function footerStart($param)
    {
        echo $this->fetch('widget');
    }

}