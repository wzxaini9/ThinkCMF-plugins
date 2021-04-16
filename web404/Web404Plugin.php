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

    // 插件安装
    public function install()
    {
        cmf_set_dynamic_config([
            'app' => [
                'exception_tmpl' => CMF_ROOT . 'public/plugins/web404/404.html' // 404页面可自定义修改
            ]
        ]);
        return true;//安装成功返回true，失败false
    }

    // 插件卸载
    public function uninstall()
    {
        // 动态修改异常页面路径
        cmf_set_dynamic_config([
            'app' => [
                'exception_tmpl' => CMF_ROOT . 'vendor/topthink/framework/src/tpl/think_exception.tpl'
            ]
        ]);
        return true;//卸载成功返回true，失败false
    }
}