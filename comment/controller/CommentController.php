<?php
/**
 * User: Powerless
 * Date: 2021/4/15
 * Blog: https://wzxaini9.cn
 */

namespace plugins\comment\controller;

use cmf\controller\PluginAdminBaseController;
use plugins\comment\model\CommentModel;
use think\facade\Db;

class CommentController extends PluginAdminBaseController
{
    public function add()
    {
        if (!cmf_is_user_login()) {
            $this->error('请登录！');
        }
        $commentModel = new CommentModel();
        $data = $this->request->param();
        $result = $this->validate($data, 'Comment');
        if ($result !== true) {
            $this->error($result);
        }
        $url = base64_decode($data['url']);
        $arrUrl = json_decode($url, true);
        $user = cmf_get_current_user();
        $fullName = empty($user['user_nickname']) ? $user['user_login'] : $user['user_nickname'];
        $fullName = empty($fullName) ? '' : $fullName;
        $objectId = intval($data['object_id']);
        $userId = cmf_get_current_user_id();
        $commentData = [
            'parent_id'   => intval($data['parent_id']),
            'user_id'     => $userId,
            'to_user_id'  => intval($data['to_user_id']),
            'object_id'   => $objectId,
            'create_time' => time(),
            'status'      => 1,
            'type'        => 1,
            'table_name'  => $data['table_name'],
            'full_name'   => $fullName,
            'email'       => $user['user_email'],
            'url'         => $url,
            'content'     => $data['content'],
        ];

        $commentModel->save($commentData);
        $commentModel->save(['path' => '0-' . $commentModel->id]);
        cmf_user_action('comment');
        $commentContent = htmlspecialchars($commentModel->content);
        $strUrl = cmf_url($arrUrl['action'], $arrUrl['param'], true, true);
        try {
            $pk = Db::name($data['table_name'])->getPk();
            Db::name($data['table_name'])->where([$pk => $objectId])->inc('comment_count');
            $receiverId = Db::name($data['table_name'])->where([$pk => $objectId])->value('user_id');
            if ($receiverId != cmf_get_current_user_id()) {
                $object = [
                    'id'    => $objectId,
                    'url'   => $arrUrl,
                    'title' => $data['object_title']
                ];

                $notificationType = empty($data['to_user_id']) ? 1 : 2; //通知类型;1评论，2回复
                Db::name('user_notification')->insert([
                    'sender_id'   => $userId,
                    'sender_name' => $fullName,
                    'receiver_id' => $receiverId,
                    'content'     => $commentContent,
                    'object'      => json_encode($object),
                    'type'        => $notificationType,
                    'create_time' => time(),
                    'status'      => 1
                ]);
                $receiver = Db::name('user')->where(['id' => $receiverId])->find();
                if (!empty($receiver['user_email'])) {
//                    $subject = 'ThinkCMF提醒:有人在『' . $data['object_title'] . '』回复了您!';
//                    $content = "Hi,<br>有人在<a href=\"{$strUrl}\">『{$data['object_title']}』</a>回复了您!<br>{$strUrl}";
//                    cmf_send_email($receiver['user_email'], $subject, $content);
                }
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        if (!empty($data['to_user_id']) && $data['to_user_id'] != cmf_get_current_user_id() && $data['to_user_id'] != $receiverId) {
            try {
                $receiverId = $data['to_user_id'];
                $object = [
                    'id'    => $objectId,
                    'url'   => $arrUrl,
                    'title' => $data['object_title']
                ];
                $notificationType = empty($data['to_user_id']) ? 1 : 2; //通知类型;1评论，2回复
                Db::name('user_notification')->insert([
                    'sender_id'   => $userId,
                    'sender_name' => $fullName,
                    'receiver_id' => $receiverId,
                    'content'     => $commentContent,
                    'object'      => json_encode($object),
                    'type'        => $notificationType,
                    'create_time' => time(),
                    'status'      => 1
                ]);
                $receiver = Db::name('user')->where(['id' => $receiverId])->find();
                if (!empty($receiver['user_email'])) {
//                    $subject = 'ThinkCMF提醒:有人在『' . $data['object_title'] . '』回复了您!';
//                    $content = "Hi,<br>有人在<a href=\"{$strUrl}\">『{$data['object_title']}』</a>回复了您!<br>{$strUrl}";
//                    cmf_send_email($receiver['user_email'], $subject, $content);
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        $this->success('评论成功！', '', ['id' => $commentModel->id]);

    }

}
