<?php
/**
 * Created by PhpStorm.
 * User: Powerless
 * Blog: https://www.wzxaini9.cn/
 * Date: 2019/4/24
 * Time: 16:05
 */

namespace plugins\weibo\controller;

use app\admin\model\PluginModel;
use app\user\model\ThirdPartyUserModel;
use app\user\model\UserModel;
use cmf\controller\PluginBaseController;
use plugins\weibo\lib\OAuthException;
use plugins\weibo\lib\SaeTClientV2;
use plugins\weibo\lib\SaeTOAuthV2;

class CallbackController extends PluginBaseController
{
    public function login()
    {
        $redirect = $this->request->param("redirect");
        if (empty($redirect)) {
            $redirect = $this->request->server('HTTP_REFERER');
        } else {
            if (strpos($redirect, '/') === 0 ||
                strpos($redirect, 'http') === 0) {
            } else {
                $redirect = base64_decode($redirect);
            }
        }
        if (!empty($redirect)) {
            session('login_http_referer', $redirect);
        }
        if (cmf_is_user_login()) { //已经登录时直接跳到首页
            return redirect($this->request->root() . '/');
        } else {
//            $oauth= new Oauth();
//            $oauth->qq_login();
        }
    }

    public function weibobinding()
    {
        $redirect = $this->request->param("redirect");
        if (empty($redirect)) {
            $redirect = $this->request->server('HTTP_REFERER');
        } else {
            if (strpos($redirect, '/') === 0 ||
                strpos($redirect, 'http') === 0) {
            } else {
                $redirect = base64_decode($redirect);
            }
        }
        if (!empty($redirect)) {
            session('login_http_referer', $redirect);
        }

        $state = md5(uniqid(rand(), TRUE));
        $id = $this->request->param('id', 0);
        session($state, hexdec($id) - date('Ymd'));
        $config = $this->getPlugin()->getConfig();
        $auth = new SaeTOAuthV2($config['app_key'], $config['app_secret']);
        $url = $auth->getAuthorizeURL($config['callback_url'], 'code', $state);
        $this->redirect($url);
    }

    public function binding()
    {
        $config = $this->getPlugin()->getConfig();
        if ($config) {
            $auth = new SaeTOAuthV2($config['app_key'], $config['app_secret']);
            $code = $this->request->param('code', 0);
            if ($code) {
                try {
                    $keys['code'] = $code;
                    $keys['redirect_uri'] = $config['callback_url'];
                    $accessToken = $auth->getAccessToken('code', $keys);
                    $state = $this->request->param('state', 0);
                    if ($state) {
                        $client = new SaeTClientV2($config['app_key'], $config['app_secret'], $accessToken['access_token']);
                        $weiboData = $client->show_user_by_id($accessToken['uid']);
                        if ($weiboData["gender"] == "m") {
                            $weiboData["gender"] = 1;
                        } else if ($weiboData["gender"] == "f") {
                            $weiboData["gender"] = 2;
                        } else {
                            $weiboData["gender"] = 0;
                        }
                        $uid = session($state);
                        $watermark['user_id'] = $uid;
                        $watermark['unionid'] = $weiboData['id'];
                        $watermark['openid'] = $weiboData['id'];
                        $watermark['appid'] = $config['app_key'];
                        $watermark['ip'] = $this->getIp();
                        $watermark['time'] = time();
                        $this->userInfo($weiboData, $watermark);
                        $session_login_http_referer = session('login_http_referer');
                        $redirect = empty($session_login_http_referer) ? $this->request->root() : $session_login_http_referer;
                        $this->redirect($redirect);
                    } else {
                        $config['time'] = time();
                        $config = array_merge($config, $accessToken);
                        $pluginModel = new PluginModel();
                        $pluginName = $this->getPlugin()->getName();
                        $pluginModel->where('name',  $pluginName)->update(['config' => json_encode($config)]);
                    }
                    $this->success('更新成功!');
                } catch (OAuthException $e) {
                    $this->error('更新失败!');
                }
            }
        }
    }

    public function userInfo($data, $watermark)
    {
        $thirdUser['openid'] = $watermark['openid'];
        $thirdPartyUserModel = new ThirdPartyUserModel();
        $third = $thirdPartyUserModel->field('id,user_id,union_id')->where($thirdUser)->find();
        if ($third) {
            $this->editUser($data, $watermark, $third);
            $thirdPartyUserModel->where('id', $third['id'])->inc('login_times');
        } else {
            $this->addUser($data, $watermark);
        }
    }

    private function addUser($data, $watermark)
    {
        if ($watermark['user_id']) {
            $uid = $watermark['user_id'];
        } else {
            $user['sex'] = $data['gender'];
            $user['user_nickname'] = htmlspecialchars($data['screen_name']);
            $user['avatar'] = empty($data['avatar_hd']) ? $data['avatar_large'] : $data['avatar_hd'];
            $user['user_type'] = 2;
            $user['user_url'] = $data['url'];
            $user['signature'] = $data['description'];
            $user['last_login_ip'] = $watermark['ip'];
            $user['last_login_time'] = $watermark['time'];
            $user['create_time'] = $watermark['time'];
            $area['province'] = $data['province'];
            $area['city'] = $data['city'];
            $area['location'] = $data['location'];
            $user['more'] = json_encode($area, JSON_UNESCAPED_UNICODE);
            $userModel = new UserModel();
            $uid = $userModel->insertGetId($user);
        }
        $thirdUser = [
            'user_id'         => $uid,
            'nickname'        => htmlspecialchars($data['screen_name']),
            'openid'          => $watermark['openid'],
            'login_times'     => 1,
            'third_party'     => 'weibo',
            'app_id'          => $watermark['appid'],
            'last_login_ip'   => $watermark['ip'],
            'last_login_time' => $watermark['time'],
            'create_time'     => $watermark['time'],
            'union_id'        => $watermark['unionid'],
            'more'            => json_encode($watermark)
        ];
        $thirdPartyUserModel = new ThirdPartyUserModel();
        $thirdPartyUserModel->insert($thirdUser);
        return $uid;
    }

    private function editUser($data, $watermark, $third)
    {
        $thirdUser = [
            'last_login_ip'   => $watermark['ip'],
            'last_login_time' => $watermark['time'],
            'more'            => json_encode($data)
        ];

        $thirdPartyUserModel = new ThirdPartyUserModel();
        $thirdPartyUserModel->where('id', $third['id'])->update($thirdUser);

        $user['last_login_ip'] = $watermark['ip'];
        $user['last_login_time'] = $watermark['time'];
        $area['province'] = $data['province'];
        $area['city'] = $data['city'];
        $area['location'] = $data['location'];
        $user['more'] = json_encode($area, JSON_UNESCAPED_UNICODE);
        $userModel = new UserModel();
        $userModel->where('id', $third['user_id'])->update($user);
    }

    public function getIp()
    {
        $request = request();
        $realip = $request->ip(0, true);
        return $realip;
    }
}