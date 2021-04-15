<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-21021 https://www.wzxaini9.cn/ All rights reserved.
// +----------------------------------------------------------------------
// | Author: Powerless <wzxaini9@gmail.com>
// +----------------------------------------------------------------------

namespace plugins\admin_journal;

use app\admin\model\AdminMenuModel;
use cmf\lib\Plugin;

class AdminJournalPlugin extends Plugin
{
    public $info = [
        'name'        => 'AdminJournal',
        'title'       => '操作日志',
        'description' => '后台操作日志',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.3.0',
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

    public function adminInit()
    {
        $url = $menuName = request()->url();
        $str = explode('/', $url);
        $path = '';
        $adminId = cmf_get_current_admin_id();
        foreach ($str as $k => $v) {
            if ($k < 3) {
                $path .= str_replace('_', '', $v);
            }
        }
        $path = strtolower($path);
        $menus = cache('menus_' . $adminId, '', null, 'menus');
        if (empty($menus)) {
            $result = AdminMenuModel::field('app,name,controller,action')->order(["app" => "ASC", "controller" => "ASC", "action" => "ASC"])->select();
            $menusTmp['adminmainindex'] = '后台首页';
            foreach ($result as $item) {
                $indexTmp = strtolower($item['app'] . $item['controller'] . $item['action']);
                $menusTmp[$indexTmp] = $item['name'];
            }
            cache('menus_' . $adminId, $menusTmp, null, 'menus');
        } else {
            if (!empty($menus[$path])) {
                $menuName = $menus[$path];
            }
        }
        $time = time();
        $this->assign("js_debug", APP_DEBUG ? "?v=$time" : "");
        $array_log = [$adminId, session('name'), date('H:i:s'), get_client_ip(), $menuName, request()->param()];
        $filename = CMF_ROOT . 'data/journal/';
        !is_dir($filename) && mkdir($filename, 0755, true);
        $file_hwnd = fopen($filename . date('Y-m-d') . ".log", "a+");
        fwrite($file_hwnd, json_encode($array_log) . "\r\n");
        fclose($file_hwnd);
    }

}
