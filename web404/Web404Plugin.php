<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\web404;

use cmf\lib\Plugin;

class Web404Plugin extends Plugin
{

    public $info = [
        'name'        => 'Web404',
        'title'       => '404错误页面插件',
        'description' => '自定义的404错误页面',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '2.0.0'
    ];

    public $hasAdmin = 0;//插件是否有后台管理界面

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
	public function appBegin()
	{
		config('exception_tmpl',PLUGINS_PATH.'web404/404.html');
	}
}