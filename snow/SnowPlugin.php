<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\snow;

use cmf\lib\Plugin;

class SnowPlugin extends Plugin
{

    public $info = [
        'name'        =>'Snow',
        'title'       =>'圣诞雪花',
        'description' =>'圣诞雪花',
        'status'      =>1,
        'author'      => 'Powerless',
        'version'     => '1.0.1',
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
        $config = $this->getConfig();
        $this->assign($config);
        echo $this->fetch('widget');
    }

}