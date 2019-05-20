<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/18
 * Time: 上午10:26
 */

namespace App\Services;


use App\Logs\QALog;
use Maatwebsite\Excel\Facades\Excel;

class UtilService
{

    const LOG_FILE = 'crm';
    const EXCEL_TYPE = 'xlsx';
    const FILE_PATH = '/app/uploads/crm_tmp/';

    /**
     * 导出excel
     * @param string $fileName
     * @param array $exportData
     * @user yun.li
     * @time 2019/5/18 上午10:27
     */
    public static function exportExcel($fileName = '', $exportData = [])
    {
        try {
            Excel::create($fileName, function ($excel) use ($exportData, $fileName) {
                $excel->sheet($fileName, function ($sheet) use ($exportData) {
                    $sheet->rows($exportData);
                });
            })->export(self::EXCEL_TYPE);
        } catch (\Exception $e) {
            $data = [
                'fileName'    => $fileName,
                'exportData'  => $exportData,
                'error_msg'   => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ];
            QALog::error(__METHOD__ . '.导出EXCEL错误', $data, self::LOG_FILE);
        }
    }

    /**
     * 生成Excel保存到服务器
     * @param string $fileName
     * @param array $exportData
     * @user yun.li
     * @time 2019/5/18 上午10:39
     */
    public static function storeExcel($fileName = '', $exportData = [])
    {
        try {
            Excel::create($fileName, function ($excel) use ($exportData, $fileName) {
                $excel->sheet($fileName, function ($sheet) use ($exportData) {
                    $sheet->rows($exportData);
                });
            })->store(self::EXCEL_TYPE, storage_path() . self::FILE_PATH);
        } catch (\Exception $e) {
            $data = [
                'fileName'    => $fileName,
                'exportData'  => $exportData,
                'error_msg'   => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ];
            QALog::error(__METHOD__ . '.生成EXCEL错误', $data, self::LOG_FILE);
        }
    }


}