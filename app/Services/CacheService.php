<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/5
 * Time: 下午6:28
 */

namespace App\Services;


use Illuminate\Support\Facades\Redis;

class CacheService
{

    const RETRIEVE_PWD_TOKEN = 'user:retrieve:pwd:token:';

    public static function getTest()
    {
        return Redis::get('li');
    }

    public static function setTest()
    {
        Redis::setex('li', 3600, 'yun');
    }


    /**
     * getUuidEncrypt
     * @param string $key
     * @return mixed
     * @user yun.li
     * @time 2019/1/16 下午5:02
     */
    public static function getRetrievePwdToken(string $key)
    {
        return Redis::get(self::RETRIEVE_PWD_TOKEN . $key);
    }

    /**
     * setUuidEncrypt
     * @param string $key
     * @param string $value
     * @param int $timestamp
     * @user yun.li
     * @time 2019/1/16 下午5:02
     */
    public static function setRetrievePwdToken(string $key, string $value, int $timestamp = 3600)
    {
        Redis::setex(self::RETRIEVE_PWD_TOKEN . $key, $timestamp, $value);
    }

    /**
     * delRetrievePwdToken
     * @param string $key
     * @user yun.li
     * @time 2019/5/19 下午4:35
     */
    public static function delRetrievePwdToken(string $key)
    {
        Redis::del(self::RETRIEVE_PWD_TOKEN . $key);
    }


}