<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/16
 * Time: 上午10:01
 */

namespace App\Services;


use App\Jobs\UpdateCustomerGroupJob;
use App\Logs\QALog;

class QueueService
{
    const CRM_QUEUE_NAME = 'crm_queue';
    const LOG_FILE = 'queue_log';

    /**
     * 异步计算会员分组
     * @param $data
     * @user yun.li
     * @time 2019/5/16 上午10:10
     */
    public function updateCustomerGroup($data)
    {
        try {
            QALog::info(__METHOD__ . '=== start ===', $data, self::LOG_FILE);
            dispatch((new UpdateCustomerGroupJob($data))->onQueue(self::CRM_QUEUE_NAME));
        } catch (\Exception $e) {
            $errLog = [
                'data' => $data,
                'errMsg' => $e->getMessage()
            ];
            QALog::error(__METHOD__, $errLog, self::LOG_FILE);
        }
    }


}