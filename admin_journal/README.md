# ThinkCMF-admin_journal
ThinkCMF-管理后台操作日志插件
1.0.0说明
https://www.thinkcmf.com/appstore/plugin/143.html
解压至项目public\plugins\目录下即可。
已在5.0.180123 版测试通过

1.0.1说明
调整log文件储存目录至data/journal/
防止清除缓存的时候吧操作记录删除.

1.1.0说明
修改plugins\admin_journal\controller\AdminIndexController
由于5.0.180123之前旧版本没有
PluginAdminBaseController
所以改为
PluginBaseController
以兼容旧版本

1.1.1说明
更新作者和链接地址

1.1.2说明
在操作记录中提交的汉字不再转码。方便查看

1.2.0说明
操作记录中操作类型改为菜单名称显示