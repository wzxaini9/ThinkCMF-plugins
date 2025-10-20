<?php
/**
 * Created by PhpStorm.
 * User: Powerless
 * Blog: https://www.wzxaini9.cn/
 * Date: 2019/4/24
 * Time: 16:13
 */

namespace plugins\weibo\controller;

use app\admin\model\PluginModel;
use cmf\controller\PluginAdminBaseController;
use plugins\weibo\lib\SaeTOAuthV2;

class AdminIndexController extends PluginAdminBaseController
{
    /**
     * 微博授权管理
     * @return mixed|string
     * @throws \Exception
     */
    public function index()
    {
        $config = $this->getPlugin()->getConfig();
        $auth = new SaeTOAuthV2($config['app_key'], $config['app_secret']);
        $url = $auth->getAuthorizeURL($config['callback_url']);
        $config['location'] = $url;
        if (empty($config['time'])) {
            $config['time'] = 0;
        }
        $this->assign('config', $config);
        return $this->fetch('/authorization_index');
    }

    /**
     * 检查后台用户访问权限
     * @param $userId
     *
     * @return bool
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