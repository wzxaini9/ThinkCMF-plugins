<?php

/**
 * User: Powerless
 * Date: 2019/11/17
 * Blog: https://wzxaini9.cn
 */

namespace plugins\tencent_app\controller;

use cmf\controller\PluginAdminBaseController;

class AdminAppController extends PluginAdminBaseController
{

    /**
     * 添加小程序
     * @adminMenu(
     *     'name'   => '添加小程序',
     *     'parent' => 'AdminIndex/index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加小程序',
     *     'param'  => ''
     * )
     */
    public function add()
    {

        return $this->fetch();
    }

    /**
     * 添加小程序提交保存
     * @adminMenu(
     *     'name'   => '添加小程序提交保存',
     *     'parent' => 'AdminIndex/index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '添加小程序提交保存',
     *     'param'  => ''
     * )
     */
    public function addPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, "AdminApp");

        if ($result !== true) {
            $this->error($result);
        }

        $appSettings = cmf_get_option('tencent_app_settings');

        $appSettings['apps'][$data['app_id']] = $data;

        cmf_set_option('tencent_app_settings', $appSettings);

        $this->success('添加成功！', cmf_plugin_url('TencentApp://AdminApp/edit', ['id' => $data['app_id']]));


    }

    /**
     * 编辑小程序
     * @adminMenu(
     *     'name'   => '编辑小程序',
     *     'parent' => 'AdminIndex/index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑小程序',
     *     'param'  => ''
     * )
     */
    public function edit()
    {
        $appId = $this->request->param('id');

        $appSettings = cmf_get_option('tencent_app_settings');

        $this->assign('app', $appSettings['apps'][$appId]);

        return $this->fetch();
    }

    /**
     * 编辑小程序提交保存
     * @adminMenu(
     *     'name'   => '编辑小程序提交保存',
     *     'parent' => 'AdminIndex/index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '编辑小程序',
     *     'param'  => ''
     * )
     */
    public function editPost()
    {
        $data = $this->request->param();

        $result = $this->validate($data, "AdminApp");

        if ($result !== true) {
            $this->error($result);
        }

        $appSettings = cmf_get_option('tencent_app_settings');

        $appSettings['apps'][$data['app_id']] = $data;

        cmf_set_option('tencent_app_settings', $appSettings);

        $this->success('保存成功！');
    }

    /**
     * 删除小程序
     * @adminMenu(
     *     'name'   => '删除小程序',
     *     'parent' => 'AdminIndex/index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除小程序',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $appId = $this->request->param('id');

        $appSettings = cmf_get_option('tencent_app_settings');

        unset($appSettings['apps'][$appId]);

        cmf_set_option('tencent_app_settings', $appSettings);

        $this->success('删除成功！');
    }

}
