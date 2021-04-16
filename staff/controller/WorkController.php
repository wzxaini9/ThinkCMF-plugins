<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\staff\model\WorkModel;
use plugins\staff\validate\WorkValidate;

class WorkController extends PluginAdminBaseController
{
    public $model;
    public $validate;
    public $size = 15;

    public function initialize()
    {
        $adminId = cmf_get_current_admin_id();
        if (!empty($adminId)) {
            $this->assign("admin_id", $adminId);
        } else {
            $this->error('未登录');
        }
        $this->model = new WorkModel();
        $this->validate = new WorkValidate();
    }

    public function index()
    {
        $param = $this->request->param();
        $where['status'] = 1;
        if (!empty($param['unit'])) {
            $where['unit'] = $param['unit'];
        }
        if (!empty($param['department'])) {
            $where['department'] = $param['department'];
        }
        if (!empty($param['position'])) {
            $where['position'] = $param['position'];
        }
        list($lists, $page) = $this->model->lists($param, $where, $this->size);
        $this->assign('lists', $lists);
        $this->assign('page', $page);
        $this->assign('param', $param);
        return $this->fetch('/work/index');
    }

    public function add()
    {
        return $this->fetch('/work/add');
    }

    public function addPost()
    {
        $param = $this->request->param();
        if ($this->validate->scene('add')->check($param)) {
            $where['unit'] = $param['unit'];
            $where['department'] = $param['department'];
            $where['position'] = $param['position'];
            $where['status'] = 1;
            $lists = $this->model->selectLists($where);
            if (!count($lists)) {
                $id = $this->model->add($param);
                $this->success('添加成功！', cmf_plugin_url('Staff://work/edit', ['id' => $id]));
            } else {
                $this->error('单位、部门、职务不可重复');
            }
        } else {
            $this->error($this->validate->getError());
        }
    }

    public function edit()
    {
        $id = $this->request->param('id');
        $info = $this->model->info($id);
        $this->assign('info', $info);
        return $this->fetch('/work/edit');
    }

    public function editPost()
    {
        $param = $this->request->param();
        if ($this->validate->scene('edit')->check($param)) {
            $where[] = ['id', '<>', $param['id']];
            $where[] = ['unit', '=', $param['unit']];
            $where[] = ['department', '=', $param['department']];
            $where[] = ['position', '=', $param['position']];
            $where[] = ['status', '=', 1];
            $lists = $this->model->selectLists($where);
            if (!count($lists)) {
                $this->model->edit($param);
                $this->success('更新成功！', cmf_plugin_url('Staff://work/index'));
            } else {
                $this->error('单位、部门、职务不可重复');
            }
        } else {
            $this->error($this->validate->getError());
        }
    }

    public function status()
    {
        $param = $this->request->param();
        if ($this->validate->scene('status')->check($param)) {
            $this->model->status($param['id'], 0);
            $this->success('删除成功！', cmf_plugin_url('Staff://work/index'));
        } else {
            $this->error($this->validate->getError());
        }
    }
}