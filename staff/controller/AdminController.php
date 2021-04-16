<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\controller;

use cmf\controller\PluginBaseController;
use plugins\staff\model\IndexModel;
use plugins\staff\validate\IndexValidate;

class AdminController extends PluginBaseController
{
    public $model;
    public $validate;
    public $sexs = ["0" => "保密", "1" => "男", "2" => "女"];

    public function initialize()
    {
        $adminId = cmf_get_current_admin_id();
        if (!empty($adminId)) {
            $this->assign("admin_id", $adminId);
        } else {
            $this->error('未登录');
        }
        $this->model = new IndexModel();
        $this->validate = new IndexValidate();
    }

    /**
     * 人员管理
     * @adminMenu(
     *     'name'   => '人员管理',
     *     'parent' => 'admin/Plugin/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '人员管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            if ($this->validate->scene('staff')->check($param)) {
                $where['si.status'] = 1;
                $where['si.name'] = $param['name'];
                $where['si.phone'] = $param['phone'];
                $search = $this->model->search($where);
                if (!$search) {
                    $this->error('未查询到相关人员');
                }
                $this->assign('sex', $this->sexs[$search['sex']]);
                $this->assign('search', $search);
                $this->assign('param', $param);
            } else {
                $this->error($this->validate->getError());
            }
        }
        return $this->fetch('/admin');
    }
}