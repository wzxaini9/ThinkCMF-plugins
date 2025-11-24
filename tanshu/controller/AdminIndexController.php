<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\tanshu\controller;

use cmf\controller\PluginAdminBaseController;


class AdminIndexController extends PluginAdminBaseController
{

    /**
     * 获取新闻
     * @adminMenu(
     *     'name'   => '获取新闻',
     *     'parent' => 'admin/Plugin/default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '获取新闻',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $type = $this->request->param('type','头条');
        $channel = cache('channel_'.$type);
        if (!$channel) {
            $size = 40;//默认10，最大40
            $start = ($this->request->param("page", 1, "intval") - 1) * $size;
            $config = cmf_get_plugin_config('Tanshu');
            $channelRes = cmf_curl_get($config['host'] . '/api/toutiao/v1/index?' . http_build_query(['key' => $config['secret'], 'type' => $type, 'start'=>$start,'num' => $size]));
            $channelRes = json_decode($channelRes, true);
            if ($channelRes && $channelRes['code'] == 1) {
                $channel = $channelRes['data'];
                cache('channel_'.$type, json_encode($channel), 3600);
            }
        } else {
            $channel = json_decode($channel, true);
        }
        $this->assign("types", ["头条", "新闻", "国内", "国际", "政治", "财经", "体育", "娱乐", "军事", "教育", "科技", "NBA", "股票", "星座", "女性", "育儿"]);//https://www.tanshuapi.com/market/detail-85
        $this->assign("data", $channel);
        return $this->fetch('/admin_index');
        //api/toutiao_v2/v1/channel
        //type:["国内焦点","国际焦点","军事焦点","财经焦点","互联网焦点","房产焦点","汽车焦点","体育焦点","娱乐焦点","游戏焦点","教育焦点","女人焦点","科技焦点","社会焦点","国内最新","台湾最新","港澳最新","国际最新","军事最新","财经最新","理财最新","宏观经济最新","互联网最新","房产最新","汽车最新","体育最新","国际足球最新","国内足球最新","CBA最新","综合体育最新","娱乐最新","电影最新","游戏最新","教育最新","女人最新","美容护肤最新","情感两性最新","健康养生最新","科技最新","数码最新","电脑最新","科普最新","社会最新","旅游最新","电商最新","物流最新","创业最新","育儿最新","家政最新"]
    }
}
