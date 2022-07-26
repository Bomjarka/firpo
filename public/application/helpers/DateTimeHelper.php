<?php

class DateTimeHelper
{
    /**
     *Возвращает текущую дату и время
     *
     * @return false|string
     */
    public static function getCurrentDateTime()
    {
        return date('Y/m/d h:i:s', time());
    }
}