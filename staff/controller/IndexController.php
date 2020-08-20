<?php
/**
 * User: Powerless
 * Date: 2020/8/2
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\controller;

use cmf\controller\PluginBaseController;
use plugins\staff\model\IndexModel;
use plugins\staff\validate\IndexValidate;

class IndexController extends PluginBaseController
{
    public $model;
    public $validate;
    public $sexs = ["0"=>"保密","1"=>"男","2"=>"女"];

    public function __construct()
    {
        parent::__construct();
        $this->model = new IndexModel();
        $this->validate = new IndexValidate();
    }

    public function index()
    {
        return $this->fetch('/index');
    }

    public function staffInfo()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            if ($this->validate->scene('staff')->check($param)) {
                $where['si.status'] = 1;
                $where['si.name'] = $param['name'];
                $where['si.phone'] = $param['phone'];
                $search = $this->model->search($where);
                $this->assign('sex', $this->sexs[$search['sex']]);
                $this->assign('search', $search);
                $this->assign('param', $param);
            }else{
                $this->error($this->validate->getError());
            }
        }
        return $this->fetch('/staff_info');
    }

    public function work()
    {
        return $this->fetch('/work');
    }

    public function workInfo()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            if ($this->validate->scene('work')->check($param)) {
                $where['si.status'] = 1;
                $where['si.name'] = $param['name'];
                $where['wi.position'] = $param['position'];
                $search = $this->model->search($where);
                $this->assign('search', $search);
                $this->assign('param', $param);
            }else{
                $this->error($this->validate->getError());
            }
        }
        return $this->fetch('/work_info');
    }
}