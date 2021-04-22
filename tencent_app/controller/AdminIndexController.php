<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\tencent_app\controller;

use cmf\controller\PluginAdminBaseController;

class AdminIndexController extends PluginAdminBaseController
{
    /**
     * 小程序管理
     * @adminMenu(
     *     'name'   => '小程序管理',
     *     'parent' => 'admin/Plugin/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '小程序管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {

        $appSettings = cmf_get_option('tencent_app_settings');

        $apps = empty($appSettings['apps']) ? [] : $appSettings['apps'];

        $this->assign('apps', $apps);

        return $this->fetch('/admin_index');
    }

}
