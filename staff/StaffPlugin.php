<?php
/**
 * User: Powerless
 * Date: 2020/8/1
 * Blog: https://wzxaini9.cn
 */

namespace plugins\staff;

use cmf\lib\Plugin;
use plugins\staff\model\OperationDb;

class StaffPlugin extends Plugin
{
    public $info = [
        'name'        => 'Staff',
        'title'       => '员工管理',
        'description' => '员工信息管理系统',
        'status'      => 1,
        'author'      => 'Powerless',
        'version'     => '1.0',
        'demo_url'    => 'https://wzxaini9.cn',
        'author_url'  => 'https://wzxaini9.cn'
    ];

    public $operation;
    public function __construct()
    {
        parent::__construct();
        $this->operation = new OperationDb();
    }

    public function install()
    {
        return $this->operation->createDb();
    }

    public function uninstall()
    {
        return $this->operation->renameDb();
    }

}