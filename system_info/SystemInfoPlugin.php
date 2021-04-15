<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\system_info;

use cmf\lib\Plugin;
use think\facade\Db;

class SystemInfoPlugin extends Plugin
{

    public $info = [
        'name'        => 'SystemInfo',
        'title'       => '系统信息',
        'description' => '系统信息',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '2.0.0',
        'demo_url'    => 'https://www.wzxaini9.cn/',
        'author_url'  => 'https://www.wzxaini9.cn/'
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

    public function adminDashboard()
    {

        $mysql = Db::query("select VERSION() as version");
        $mysql = $mysql[0]['version'];
        $mysql = empty($mysql) ? lang('UNKNOWN') : $mysql;

        $version = cmf_version();

        //server infomation
        $info = [
            lang('OPERATING_SYSTEM')      => PHP_OS,
            lang('OPERATING_ENVIRONMENT') => $_SERVER["SERVER_SOFTWARE"],
            lang('PHP_VERSION')           => PHP_VERSION,
            lang('PHP_RUN_MODE')          => php_sapi_name(),
            lang('PHP_VERSION')           => phpversion(),
            lang('MYSQL_VERSION')         => $mysql,
            'ThinkPHP'                    => cmf_thinkphp_version(),
            'ThinkCMF'                    => "{$version} <a href=\"http://www.thinkcmf.com\" target=\"_blank\">访问官网</a>",
            lang('UPLOAD_MAX_FILESIZE')   => ini_get('upload_max_filesize'),
            lang('MAX_EXECUTION_TIME')    => ini_get('max_execution_time') . "s",
            //TODO 增加更多信息
            lang('DISK_FREE_SPACE')       => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        ];
        $this->assign('server_info', $info);

        return [
            'width'  => 12,
            'view'   => $this->fetch('widget'),
            'plugin' => 'SystemInfo'
        ];
    }

}