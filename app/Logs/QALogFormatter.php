<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/28
 * Time: 下午9:57
 */

namespace App\Logs;


use Monolog\Formatter\LineFormatter;
use Ramsey\Uuid\Uuid;

class QALogFormatter extends LineFormatter
{

    const SIMPLE_FORMAT = "[%datetime%] %channel%.%level_name%: [%requestId%] %message% %context% %extra%" . PHP_EOL;

    protected static $requestId;

    public function __construct($format = null, $dateFormat = null, $allowInlineLineBreaks = false, $ignoreEmptyContextAndExtra = false)
    {
        $this->format = $format ?: static::SIMPLE_FORMAT;
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $output = parent::format($record);
        if (false !== strpos($output, '%requestId%')) {
            $output = str_replace('%requestId%', $this->stringify($this->getXRequestId()), $output);
        }
        return $output;
    }

    /**
     * getXRequestId
     * @return mixed
     * @throws
     */
    private function getXRequestId()
    {
        if (static::$requestId) {
            return static::$requestId;
        }
        static::$requestId = 'Request_ID:' . (($_SERVER['X-Request-Id'] ?? Uuid::uuid4()) . 'local1');
        return static::$requestId;
    }
}