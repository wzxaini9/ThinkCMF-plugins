<?php
/**
 * Created by PhpStorm.
 * User: Powerless
 * Blog: https://www.wzxaini9.cn/
 * Date: 2019/4/24
 * Time: 14:10
 */

namespace plugins\baidu;

use cmf\lib\Plugin;
class BaiduPlugin extends Plugin
{

    public $info = [
        'name'        => 'Baidu',
        'title'       => '百度搜索资源平台',
        'description' => '文章自动提交百度收录',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.0.0',
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

    //实现portal_admin_after_save_article钩子方法
    public function portalAdminAfterSaveArticle($param)
    {
        $article = $param['article'];
        if(!empty($article['post_status'])) {
            $urls = [cmf_url('portal/Article/index', ['id' => $article['id']], false, true)];
            $config = $this->getConfig();
            $api = 'http://data.zz.baidu.com/urls?site='.$config['site'].'&token='.$config['token'];
            $ch = curl_init();
            $options =  [
                CURLOPT_URL => $api,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => implode("\n", $urls),
                CURLOPT_HTTPHEADER => ['Content-Type: text/plain']
            ];
            curl_setopt_array($ch, $options);
            curl_exec($ch);
        }
    }
}