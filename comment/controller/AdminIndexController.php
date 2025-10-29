<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\comment\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\comment\model\CommentModel;

class AdminIndexController extends PluginAdminBaseController
{
    public $comment;

    public function initialize()
    {
        parent::initialize();
        $this->comment = new CommentModel();
    }

    /**
     * 评论列表
     * @adminMenu(
     *     'name'   => '评论列表',
     *     'parent' => 'admin/Plugin/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '评论列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $where['delete_time'] = 0;
        $comments = $this->comment->where($where)->order("id DESC")->paginate(10);
        $page = $comments->render();
        $this->assign("page", $page);
        $this->assign("comments", $comments);
        return $this->fetch('/admin_index');
    }

    public function delete()
    {
        $id = $this->request->param("id", 0, "intval");
        $where['id'] = $id;
        $data['delete_time'] = time();
        $data['status'] = 2;
        $this->comment->where($where)->update($data);
        if ($data) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    public function cancelBan()
    {
        $id = input('param.id', 0, 'intval');
        if ($id) {
            $this->comment->where(["id" => $id, "status" => 0])->update(["status" => 1]);
            $this->success("评论审核成功！", '');
        } else {
            $this->error('数据传入失败！');
        }
    }

    public function ban()
    {
        $id = input('param.id', 0, 'intval');
        if ($id) {
            $result = $this->comment->where(["id" => $id, "status" => 1])->update(["status" => 0]);
            if ($result) {
                $this->success("评论已切换成未审核！", '');
            } else {
                $this->error('评论切换失败,评论不存在！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
}
