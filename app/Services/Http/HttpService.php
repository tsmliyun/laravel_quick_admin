<?php

namespace App\Services\Http;


use App\Logs\QALog;

abstract class HttpService
{
    private $logName;
    private $apiUrl;
    private $childClassName;

    public function __construct()
    {
        $this->logName        = $this->getLogName();
        $this->apiUrl         = $this->getApiUrl();
        $this->childClassName = get_called_class();
    }

    public abstract function getLogName();

    public abstract function getApiUrl();


    /**
     * 发送HTTP POST请求
     * @param string $url
     * @param array $data
     * @param string $method
     * @return bool|mixed
     */
    public function httpPost(string $url = '', array $data = [], string $method = 'POST')
    {
        $url = $this->apiUrl . $url;
        QALog::info(__METHOD__ . $this->childClassName . ' http post start', ['url' => $url, 'postData' => $data], $this->logName);
        try {
            $jsonData = json_encode($data);
            $curl     = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($jsonData)
            ]);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //https 请求
            if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }
            $result    = curl_exec($curl);
            $errorCode = curl_errno($curl);
            curl_close($curl);
            if (!empty($errorCode)) {
                QALog::error(__METHOD__ . $this->childClassName . ' http post error', ['url' => $url, 'postData' => $data, 'error_code' => $errorCode, 'response' => $result], $this->logName);
                return null;
            }
            QALog::info(__METHOD__ . $this->childClassName . ' http post success', ['url' => $url, 'postData' => $data, 'response' => $result], $this->logName);
            return json_decode($result, true);
        } catch (\Exception $exception) {
            $errorData = [
                'msg'   => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data'  => [
                    'url'      => $url,
                    'postData' => $data
                ]
            ];
            QALog::error(__METHOD__ . $this->childClassName . ' http post fail', ['errorData' => $errorData], $this->logName);
            return null;
        }
    }

    /**
     * httpGet
     * @param string $url
     * @return mixed|null
     */
    public function httpGet(string $url = '')
    {
        $url = $this->apiUrl . $url;
        QALog::info(__METHOD__ . $this->childClassName . ' http get start', ['url' => $url], $this->logName);
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            //https 请求
            if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }
            $response  = curl_exec($ch);
            $errorCode = curl_errno($ch);
            curl_close($ch);
            if (!empty($errorCode)) {
                QALog::error(__METHOD__ . $this->childClassName . ' http get error', ['url' => $url, 'error_code' => $errorCode, 'response' => $response], $this->logName);
                return null;
            }
            QALog::info(__METHOD__ . $this->childClassName . ' http get end', ['url' => $url, 'response' => $response], $this->logName);
            return $response;
        } catch (\Exception $e) {
            $errorLog = [
                'msg'   => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data'  => [
                    'url' => $url,
                ]
            ];
            QALog::error(__METHOD__ . $this->childClassName . ' http get fail', ['error' => $errorLog], $this->logName);
            return null;
        }
    }


}
