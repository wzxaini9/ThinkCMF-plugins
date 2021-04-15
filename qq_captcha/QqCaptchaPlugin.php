<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\qq_captcha;

use cmf\lib\Plugin;

class QqCaptchaPlugin extends Plugin
{

    public $info = [
        'name'        => 'QqCaptcha',
        'title'       => '腾讯防水墙',
        'description' => '后台登录页验证码修改为腾讯防水墙',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.1.0'
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

    public function adminLogin()
    {
        $source = "https://api.wzxaini9.cn/test/image";
        $json = file_get_contents($source);
        $arr = json_decode($json, true);
        $this->assign($arr);
        $config = $this->getConfig();
        $this->assign($config);
        return $this->fetch('widget');
    }

}