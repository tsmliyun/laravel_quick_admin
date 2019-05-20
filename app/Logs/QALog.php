<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/28
 * Time: 下午9:56
 */

namespace App\Logs;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @method static info(string $method, array $content, string $filename)
 * @method static warn(string $method, array $content, string $filename)
 * @method static debug(string $method, array $content, string $filename)
 * @method static error(string $method, array $content, string $filename)
 */
class QALog
{
    /**
     * @var $_log_instance
     */
    protected static $_log_instance;

    /**
     * 获取log实例
     *
     * @param $key
     * @return mixed
     * @throws \Exception
     * @author wadd
     */
    public static function getLogInstance($key)
    {
        if (!isset(static::$_log_instance[$key]) || static::$_log_instance[$key] === null) {
            $logInstance = new Logger(env('APP_LOGNAME'));

            $handler = new StreamHandler(storage_path("logs/" . date('Y-m-d') . '/') . $key . "-" . date('Y-m-d') . '.log');
            $handler->setFormatter(new QALogFormatter(null, null, true, true));
            $logInstance->pushHandler($handler);
            static::$_log_instance[$key] = $logInstance;
        }
        return static::$_log_instance[$key];
    }

    /**
     * @param  string $method 可用方法: debug|info|notice|warning|error|critical|alert|emergency
     * @param  array $args 调用参数 第一个参数错误信息，第二个参数为context数组，第三个参数为文件名
     *
     * @throws \Exception
     * @author wadd
     */
    public static function __callStatic(string $method, array $args)
    {
        $message = (string)$args[0];
        $context = isset($args[1]) ? $args[1] : [];
        $context = is_array($context) ? $context : [$context];
        $filename = isset($args[2]) ? $args[2] : 'log';
        $instance = static::getLogInstance($filename);
        $instance->$method($message, $context);
    }
}