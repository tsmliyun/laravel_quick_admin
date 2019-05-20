<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/5
 * Time: 下午5:01
 */

namespace App\Services;

use App\Logs\QALog;
use Exception;
use Illuminate\Mail\Message;
use Mail;

class MailService
{

    const LOG_FILE = 'email';

    /**
     * 发送邮件
     * @param array $data
     * @return bool
     * @user yun.li
     * @time 2019/5/5 下午5:04
     */
    public static function sendMail($data = [])
    {
        $format = !empty($data['format']) && in_array($data['format'], ['raw', 'html', 'text']) ? $data['format'] : 'raw';
        $to = is_array($data['to']) ? $data['to'] : [$data['to']];
        $to = array_filter($to, function ($t) {
            return !empty($t);
        });
        $subject = $data['subject'];
        $data['data'] = !isset($data['data']) ? [] : $data['data'];
        $attachments = '';
        if (!empty($data['attachments'])) {
            $attachments = is_array($data['attachments']) ? $data['attachments'] : [$data['attachments']];
        }
        $hostName = gethostname();
        $subject .= '(服务器名称:' . $hostName . ')';
        QALog::info('邮件发送', [$data], self::LOG_FILE);
        try {
            Mail::send([$format => $data['body']], $data['data'], function (Message $message) use ($subject, $to, $attachments) {
                $message->to(array_unique(array_merge((array)$to, config('crm.mail_list.crm_engineer'))))
                    ->subject($subject);
                if ($attachments) {
                    foreach ($attachments as $attachment) {
                        $message->attach($attachment);
                    }
                }
            });
            if (Mail::failures()) {
                throw new Exception('下列地址发送失败：' . json_encode(Mail::failures()));
            }
        } catch (Exception $e) {
            QALog::error('邮件发送失败', ['message' => $e->getMessage()], self::LOG_FILE);
        }
        return true;
    }

}