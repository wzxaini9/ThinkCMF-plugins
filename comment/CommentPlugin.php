<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\comment;

use cmf\lib\Plugin;
use plugins\comment\model\CommentModel;
use think\facade\Db;

class CommentPlugin extends Plugin
{

    public $info = [
        'name'        => 'Comment',
        'title'       => '评论插件',
        'description' => '评论插件',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '2.0.0',
        'demo_url'    => 'https://www.wzxaini9.cn/',
        'author_url'  => 'https://www.wzxaini9.cn/'
    ];

    public $hasAdmin = 1;//插件是否有后台管理界面
    public $commentModel;

    public function __construct()
    {
        parent::__construct();
        $this->commentModel = new CommentModel();
    }

    // 插件安装
    public function install()
    {
        $sqls = $this->commentModel->createDb();
        foreach ($sqls as $k => $v) {
            Db::execute($v);
        }
        return true;
    }

    // 插件卸载
    public function uninstall()
    {
        $sql = $this->commentModel->renameDb();
        Db::execute($sql);
        return true;
    }

    //实现的comment钩子方法
    public function comment($param)
    {
        $comments = $this->commentModel
            ->where([
                "table_name"  => $param['table_name'],
                "object_id"   => $param['object_id'],
                "status"      => 1,
                'delete_time' => 0
            ])
            ->order('create_time DESC')
            ->paginate(10, false, ['var_page' => 'comment_page']);
        $config = $this->getConfig();
        $this->assign($config);
        $this->assign('param', $param);
        $this->assign('user', cmf_get_current_user());
        $this->assign('comments', $comments);
        $this->assign('page', $comments->render());
        return $this->fetch('widget');
    }

}
