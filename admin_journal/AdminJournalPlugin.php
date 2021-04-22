<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

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

    public function adminInit()
    {
        $request = request();
        $url = $request->url();
        $menuName = $url = parse_url($url, PHP_URL_PATH);
        $url = str_replace('.html', '', $url);
        $url = str_replace('_', '', $url);
        $url = substr($url, '1');
        $url = strtolower($url);
        $urlArr = explode('/', $url);
        $path = '';
        foreach ($urlArr as $k => $v) {
            if (!$k && $v == 'plugin') $v .= '/';    //菜单表中钩子插件路径会有斜杠/
            $path .= $v;
        }
        $adminId = cmf_get_current_admin_id();
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
                $method = $request->method();
                $menuName = "[$method]" . $menus[$path];
            }
        }
        $time = time();
        $this->assign("js_debug", APP_DEBUG ? "?v=$time" : "");
        $data = $request->request();
        unset($data['s']);
        $array_log = [$adminId, session('name'), date('H:i:s'), get_client_ip(), $menuName, $data];
        $filename = CMF_ROOT . 'data/journal/';
        !is_dir($filename) && mkdir($filename, 0755, true);
        $file_hwnd = fopen($filename . date('Y-m-d') . ".log", "a+");
        fwrite($file_hwnd, json_encode($array_log) . "\r\n");
        fclose($file_hwnd);
    }

}
