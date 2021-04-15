<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-21021 https://www.wzxaini9.cn/ All rights reserved.
// +----------------------------------------------------------------------
// | Author: Powerless <wzxaini9@gmail.com>
// +----------------------------------------------------------------------

namespace plugins\admin_journal\controller;

use cmf\controller\PluginAdminBaseController;


class AdminIndexController extends PluginAdminBaseController
{

    protected function initialize()
    {
        parent::initialize();
        $adminId = cmf_get_current_admin_id(); //获取后台管理员id，可判断是否登录
        if (!empty($adminId)) {
            if (!$this->checkAccess($adminId)) {
                $this->error("您没有访问权限！");
            }
            $this->assign('admin_id', $adminId);
        } else {
            if ($this->request->isAjax()) {
                $this->error("您还没有登录！", url("admin/Public/login"));
            } else {
                header("Location:" . url("admin/Public/login"));
                exit();
            }
        }
    }

    /**
     * 操作日志
     * @adminMenu(
     *     'name'   => '操作日志',
     *     'parent' => 'admin/Plugin/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '操作日志',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $data = $this->request->param();
        $date = isset($data['time']) ? $data['time'] : date('Y-m-d');
        $filename = CMF_ROOT . 'data/journal/' . $date . '.log';
        $logs = [];
        if (file_exists_case($filename)) {
            fopen($filename, "r");
            $num = count(file($filename));
            $file_hwnd = fopen($filename, "r");
            $content = explode("\r\n", fread($file_hwnd, filesize($filename)));  // 读去文件全部内容
            fclose($file_hwnd);
            foreach ($content as $k => $v) {
                if ($v) {
                    $logs[$k] = json_decode($v, true);
                }
            }
        } else {
            $num = 0;
        }
        $this->assign("content", array_reverse($logs, true));
        $this->assign('time', $date);
        $this->assign("num", $num);
        return $this->fetch('/admin_index');
    }

    /**
     *  检查后台用户访问权限
     * @param int $userId 后台用户id
     * @return boolean 检查通过返回true
     */
    private function checkAccess($userId)
    {
        // 如果用户id是1，则无需判断
        if ($userId == 1) {
            return true;
        }

        $pluginName = $this->request->param('_plugin');
        $controller = $this->request->param('_controller');
        $controller = cmf_parse_name($controller, 1);
        $action = $this->request->param('_action');

        return cmf_auth_check($userId, "plugin/{$pluginName}/$controller/$action");
    }
}
