<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace plugins\comment\model;
//Demo插件英文名，改成你的插件英文就行了
use think\Model;

//Demo插件英文名，改成你的插件英文就行了,插件数据表最好加个plugin前缀再加表名,这个类就是对应“表前缀+plugin_demo”表
class CommentModel extends Model
{

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'comment';

    /**
     * 关联 user表
     * @return $this
     */
    public function user()
    {
        return $this->belongsTo('UserModel', 'user_id');
    }

    /**
     * 关联 user表
     * @return $this
     */
    public function toUser()
    {
        return $this->belongsTo('UserModel', 'to_user_id');
    }

    /**
     * content 自动转化
     * @param $value
     * @return string
     */
    public function getContentAttr($value)
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($value));
    }

    /**
     * content 自动转化
     * @param $value
     * @return string
     */
    public function setContentAttr($value)
    {

        $config = \HTMLPurifier_Config::createDefault();
        if (!file_exists(RUNTIME_PATH . 'HTMLPurifier_DefinitionCache_Serializer')) {
            mkdir(RUNTIME_PATH . 'HTMLPurifier_DefinitionCache_Serializer');
        }

        $config->set('Cache.SerializerPath', RUNTIME_PATH . 'HTMLPurifier_DefinitionCache_Serializer');
        $purifier = new \HTMLPurifier($config);
        $cleanHtml = $purifier->purify(cmf_replace_content_file_url(htmlspecialchars_decode($value), true));
        return htmlspecialchars($cleanHtml);
    }

    public function createDb()
    {
        $prefix = config('database.connections.mysql.prefix');
        $sqls = cmf_split_sql(dirname(__DIR__) . '/data/comment.sql', $prefix, env('DATABASE_CHARSET', 'utf8mb4'));
        return $sqls;
    }

    public function renameDb()
    {
        $prefix = config('database.connections.mysql.prefix');
        $name = $this->getName();
        $tableName = $prefix . $name;
        $sql = "RENAME TABLE `" . $tableName . "` TO " . $tableName . "_" . time() . ";";
        return $sql;
    }
}
