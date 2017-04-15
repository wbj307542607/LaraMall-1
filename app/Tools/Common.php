<?php

namespace App\Tools;


class Common
{
    /**
     * 数组转换对象
     *
     * @param $e
     * @return object|void
     * @author zhangyuchao
     */
    public static function arrayToObject($e)
    {

        if (gettype($e) != 'array') return;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object')
                $e[$k] = (object)self::arrayToObject($v);
        }

        return (object)$e;
    }

    /**
     * 对象转换数组
     *
     * @param $e
     * @return array|void
     * @author zhangyuchao
     */
    public static function objectToArray($e)
    {
        $e = (array)$e;
        foreach ($e as $k => $v) {
            if (gettype($v) == 'resource') return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = (array)self::objectToArray($v);
        }

        return $e;
    }

    /**
     * 处于登录状态下的操作日志信息拼装
     *
     * @param int $operator_id
     * @param string $username
     * @param string $ip
     * @param string $url
     * @param array $param
     * @param string $substance
     * @return array
     * @author zhangyuchao
     */
    public static function logMessageForInside($operator_id = 0, $username = '', $ip = '', $url = '', array $param, $substance = '')
    {
        return [
            'operator_id' => $operator_id,
            'username' => $username,
            'time' => date('Y-m-d,H:i:s', time()),
            'login_ip' => $ip,
            'url' => $url,
            'param' => $param,
            'content' => $substance
        ];
    }

    /**
     * 处于未登录状态下的操作日志信息拼装
     *
     * @param string $ip
     * @param string $url
     * @param array $param
     * @param string $substance
     * @return array
     * @author zhangyuchao
     */
    public static function logMessageForOutside($ip = '', $url = '', array $param, $substance = '')
    {
        return [
            'time' => date('Y-m-d,H:i:s', time()),
            'login_ip' => $ip,
            'url' => $url,
            'param' => $param,
            'content' => $substance
        ];
    }
}
