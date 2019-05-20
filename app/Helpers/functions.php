<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 上午11:58
 */

/**
 * 格式化分页返回内容
 * @param $rows
 * @param $totalCount
 * @param $page
 * @param $pageCount
 * @return array
 * @user yun.li
 * @time 2019/4/30 下午1:04
 */
if (!function_exists('formatPage')) {
    function formatPage($rows, $totalCount, $page, $pageCount)
    {
        return [
            'page' => $page,
            'pageSize' => count($rows),
            'totalCount' => $totalCount,
            'totalPages' => ceil($totalCount / $pageCount),
            'rows' => $rows,
        ];
    }
}

/**
 * 验证邮箱
 */
if (!function_exists('verify_email')) {
    function verify_email(string $email): bool
    {
        if (!preg_match('/^[\w\.]+@\w+\.\w+$/i', $email)) {
            return false;
        }
        return true;
    }
}

