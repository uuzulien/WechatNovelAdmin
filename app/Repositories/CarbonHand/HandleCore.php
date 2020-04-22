<?php


namespace App\Repositories\CarbonHand;

class HandleCore
{
    /**
     * @param string $time 输入时间
     * @param string $format 格式化时间
     * @return array 获取一个月的所有时间
     */
    public static function getMonth($time = '', $format='Y-m-d')
    {
        $time = $time != '' ? strtotime($time) : time();
        //获取当前周几
        $week = date('d', $time);
        $date = [];
        for ($i = 1; $i <= date('t', $time); $i++) {
            $date[$i] = date($format, strtotime('+' . $i - $week . ' days', $time));
        }
        return $date;
    }

    /**
     * @param null $time
     * @param null $diffNum
     * @param string $format
     * @return array 获取一个月的所有时间
     */
    public static function getRealMonth($time = null, $diffNum = null, $format='Y-m-d')
    {
        $time = $time ? strtotime($time) : time();
        $diffNum = $diffNum ? (int)date('d',$time) : date('t', $time);
        //获取当前周几
        $week = date('d', $time);
        $date = [];
        for ($i = 1; $i <= $diffNum; $i++) {
            $date[$i] = date($format, strtotime('+' . $i - $week . ' days', $time));
        }
        return $date;
    }

    /**
     * @param null $timeOfMonth
     * @param null $currentOfMonth
     * @param string $format
     * @return bool 判断是否当月
     */
    public function isCurrentMonth($timeOfMonth = null,$currentOfMonth = null, $format='Y-m')
    {
        $timeOfMonth = $timeOfMonth ? strtotime($timeOfMonth) : time();
        $currentOfMonth = $currentOfMonth ? strtotime($currentOfMonth) : time();

        if (date($format, $timeOfMonth) == date($format, $currentOfMonth)) {
            return true;
        }

        return false;
    }
}
