<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\qq_captcha\controller;

use app\admin\model\RoleUserModel;
use app\admin\model\UserModel;
use cmf\controller\PluginBaseController;

class AdminLoginController extends PluginBaseController
{
    /**
     * 登录验证
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function doLogin()
    {
        $loginAllowed = session("__LOGIN_BY_CMF_ADMIN_PW__");
        if (empty($loginAllowed)) {
            $this->error(lang('outlaw_login'), cmf_get_root() . '/');
        }
        //腾讯防水墙验证
        $ticket = $this->request->param('ticket');
        $randstr = $this->request->param('randstr');

        $qqVerify = $this->qqCaptchaVerify($ticket, $randstr);

        if ($qqVerify->response == 0) {
            $this->error($qqVerify->err_msg);
        }
        //用户名、密码验证
        $name = $this->request->param("username");
        if (empty($name)) {
            $this->error(lang('USERNAME_OR_EMAIL_EMPTY'));
        }
        $pass = $this->request->param("password");
        if (empty($pass)) {
            $this->error(lang('PASSWORD_REQUIRED'));
        }
        if (strpos($name, "@") > 0) {//邮箱登陆
            $where['user_email'] = $name;
        } else {
            $where['user_login'] = $name;
        }

        $result = UserModel::where($where)->find();

        if (!empty($result) && $result['user_type'] == 1) {
            if (cmf_compare_password($pass, $result['user_pass'])) {
                $groups = RoleUserModel::alias("a")
                    ->join('role b', 'a.role_id =b.id')
                    ->where(["user_id" => $result["id"], "status" => 1])
                    ->value("role_id");
                if ($result["id"] != 1 && (empty($groups) || empty($result['user_status']))) {
                    $this->error(lang('USE_DISABLED'));
                }
                //登入成功页面跳转
                session('ADMIN_ID', $result["id"]);
                session('name', $result["user_login"]);
                $data = [];
                $data['last_login_ip'] = get_client_ip(0, true);
                $data['last_login_time'] = time();
                $token = cmf_generate_user_token($result["id"], 'web');
                if (!empty($token)) {
                    session('token', $token);
                }
                UserModel::where('id', $result['id'])->update($data);
                cookie("admin_username", $name, 3600 * 24 * 30);
                session("__LOGIN_BY_CMF_ADMIN_PW__", null);
                $this->success(lang('LOGIN_SUCCESS'), url("admin/Index/index"));
            } else {
                $this->error(lang('PASSWORD_NOT_RIGHT'));
            }
        } else {
            $this->error(lang('USERNAME_NOT_EXIST'));
        }
    }

    /**
     * 腾讯防水墙验证
     * @param $ticket
     * @param $randstr
     * @return mixed
     */
    private function qqCaptchaVerify($ticket, $randstr)
    {
        $config = $this->getPlugin()->getConfig();
        $data = [
            "aid"          => $config['app_id'],
            "AppSecretKey" => $config['app_secret_key'],
            "Ticket"       => $ticket,
            "Randstr"      => $randstr,
            "UserIP"       => get_client_ip()
        ];
        $url = "https://ssl.captcha.qq.com/ticket/verify";
        $res = $this->post_request($url, $data);
        return @json_decode($res);
    }


    public static $connectTimeout = 2;
    public static $socketTimeout = 2;

    /**
     * @param $url
     * @param string $postdata
     * @return bool|false|string
     */
    private function post_request($url, $postdata = '')
    {
        if (!$postdata) {
            return false;
        }

        $data = http_build_query($postdata);
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$connectTimeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$socketTimeout);

            //不可能执行到的代码
            if (!$postdata) {
                curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            } else {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            $data = curl_exec($ch);

            if (curl_errno($ch)) {
                $err = sprintf("curl[%s] error[%s]", $url, curl_errno($ch) . ':' . curl_error($ch));
                trigger_error($err);
            }

            curl_close($ch);
        } else {
            if ($postdata) {
                $opts = array(
                    'http' => array(
                        'method'  => 'POST',
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data) . "\r\n",
                        'content' => $data,
                        'timeout' => self::$connectTimeout + self::$socketTimeout
                    )
                );
                $context = stream_context_create($opts);
                $data = file_get_contents($url, false, $context);
            }
        }

        return $data;
    }


}
