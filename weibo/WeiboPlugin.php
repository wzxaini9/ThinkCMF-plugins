<?php
/**
 * Created by PhpStorm.
 * User: Powerless
 * Blog: https://www.wzxaini9.cn/
 * Date: 2019/4/24
 * Time: 14:10
 */

namespace plugins\weibo;

use cmf\lib\Plugin;
use plugins\weibo\lib\SaeTClientV2;

class WeiboPlugin extends Plugin
{

    public $info = [
        'name'        => 'Weibo',
        'title'       => '微博授权',
        'description' => '文章自动同步新浪微博',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '2.0.0',
        'demo_url'    => 'https://weibo.com/83117850',
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

    //实现portal_admin_after_save_article钩子方法
    public function portalAdminAfterSaveArticle($param)
    {
        $article = $param['article'];
        $id = $article['id'];
        $excerpt = '【' . $article['post_title'] . '】' . $article['post_excerpt'];
        $config = $this->getConfig();
        if (!empty($config['access_token']) && $config['synchronize']) {
            $weibo = new SaeTClientV2($config['app_key'], $config['app_secret'], $config['access_token']);
            $msg = mb_substr($excerpt, 0, $config['content_length']) . cmf_url('portal/Article/index', ['id' => $id], false, true);
            trace($msg, 'log');
            $response = $weibo->share($msg,false,get_client_ip());
            trace($response, 'info');
        }
    }

    //实现portal_admin_article_edit_view_right_sidebar钩子方法
    public function portalAdminArticleEditViewRightSidebar()
    {
        $config = $this->getConfig();
        $this->assign($config);
        echo $this->fetch('widget');
    }
}