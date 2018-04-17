<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 https://www.wzxaini9.cn/ All rights reserved.
// +----------------------------------------------------------------------
// | Author: Powerless <wzxaini9@gmail.com>
// +----------------------------------------------------------------------

namespace plugins\admin_journal;

use cmf\lib\Plugin;

class AdminJournalPlugin extends Plugin
{
    public $info = [
        'name'        => 'AdminJournal',
        'title'       => '操作日志',
        'description' => '后台操作日志',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.1.0',
        'demo_url'    => 'https://www.wzxaini9.cn/',
        'author_url'  => 'https://www.wzxaini9.cn/'
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

    public function adminInit()
    {
        $time=time();
        $this->assign("js_debug",APP_DEBUG?"?v=$time":"");
        $array_log = [cmf_get_current_admin_id(),session('name'),date('H:i:s'),get_client_ip(),request()->url(),request()->param()];
        $filename = CMF_ROOT . 'data/journal/';
        !is_dir($filename) && mkdir($filename, 0755, true);
        $file_hwnd=fopen($filename.date('Y-m-d').".log","a+");
        fwrite($file_hwnd,json_encode($array_log)."\r\n");
        fclose($file_hwnd);
    }

}
