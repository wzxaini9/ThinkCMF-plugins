<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\staff\model\StaffModel;
use plugins\staff\model\WorkModel;
use plugins\staff\validate\StaffValidate;

class StaffController extends PluginAdminBaseController
{
    public $model;
    public $work;
    public $validate;
    public $size = 15;
    public $sexs = ["0"=>"保密","1"=>"男","2"=>"女"];
    public $province = ["北京"=>"北京","上海"=>"上海","天津"=>"天津","重庆"=>"重庆","广东"=>"广东",
                        "福建"=>"福建","湖北"=>"湖北","湖南"=>"湖南","河北"=>"河北","河南"=>"河南",
                        "山西"=>"山西","陕西"=>"陕西","江苏"=>"江苏","浙江"=>"浙江","安徽"=>"安徽",
                        "江西"=>"江西","山东"=>"山东","辽宁"=>"辽宁","吉林"=>"吉林","黑龙江"=>"黑龙江",
                        "四川"=>"四川","贵州"=>"贵州","云南"=>"云南","西藏"=>"西藏","甘肃"=>"甘肃",
                        "青海"=>"青海","宁夏"=>"宁夏","新疆"=>"新疆","广西"=>"广西","内蒙古"=>"内蒙古",
                        "海南"=>"海南","香港"=>"香港","澳门"=>"澳门","台湾"=>"台湾"];

    public function initialize()
    {
        $adminId = cmf_get_current_admin_id();
        if (!empty($adminId)) {
            $this->assign("admin_id", $adminId);
        } else {
            $this->error('未登录');
        }
        $this->model = new StaffModel();
        $this->work = new WorkModel();
        $this->validate = new StaffValidate();
    }

    public function index()
    {
        $param = $this->request->param();
        $where['status'] = 1;
        if(!empty($param['name'])) {$where['name'] = ['like',"%".$param['name']."%"];}
        if(!empty($param['phone'])) {$where['phone'] = $param['phone'];}
        list($lists,$page) = $this->model->lists($param,$where,$this->size);
        $this->assign('lists', $lists);
        $this->assign('page', $page);
        $this->assign('param', $param);
        $this->assign('sexs', $this->sexs);
        return $this->fetch('/staff/index');
    }

    public function add()
    {
        $this->assign('sexs', $this->sexs);
        $where['status'] = 1;
        $workLists = $this->work->selectLists($where);
        $this->assign('workLists', $workLists);
        $this->assign('province', $this->province);
        return $this->fetch('/staff/add');
    }

    public function addPost()
    {
        $param = $this->request->param();
        if ($this->validate->scene('add')->check($param)) {
            $where['name'] = $param['name'];
            $where['phone'] = $param['phone'];
            $where['status'] = 1;
            $lists = $this->model->selectLists($where);
            if(!count($lists)){
                $id = $this->model->add($param);
                $this->success('添加成功！', cmf_plugin_url('Staff://staff/edit', ['id' => $id]));
            }else{
                $this->error('姓名、手机号不可重复');
            }
        }else{
            $this->error($this->validate->getError());
        }
    }

    public function edit()
    {
        $id = $this->request->param('id');
        $info = $this->model->info($id);
        $this->assign('info', $info);
        $where['status'] = 1;
        $workLists = $this->work->selectLists($where);
        $this->assign('workLists', $workLists);
        $this->assign('sexs', $this->sexs);
        $this->assign('province', $this->province);
        return $this->fetch('/staff/edit');
    }

    public function editPost()
    {
        $param = $this->request->param();
        if ($this->validate->scene('edit')->check($param)) {
            $where['id'] = ['neq',$param['id']];
            $where['name'] = $param['name'];
            $where['phone'] = $param['phone'];
            $where['status'] = 1;
            $lists = $this->model->selectLists($where);
            if(!count($lists)){
                $this->model->edit($param);
                $this->success('更新成功！', cmf_plugin_url('Staff://staff/index'));
            }else{
                $this->error('姓名、手机号不可重复');
            }
        }else{
            $this->error($this->validate->getError());
        }
    }

    public function status()
    {
        $param = $this->request->param();
        if ($this->validate->scene('status')->check($param)) {
            $this->model->status($param['id'],0);
            $this->success('删除成功！', cmf_plugin_url('Staff://staff/index'));
        }else{
            $this->error($this->validate->getError());
        }
    }
}