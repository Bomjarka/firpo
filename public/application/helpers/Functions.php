<?php

class Functions
{
    /**
     * Получает рандомную строку из заданного алфавита
     *
     * @return string
     */
    public function getRandomString(): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';

        return InputHelper::processInputValue(substr(str_shuffle($chars), 0, rand(5, 10)));
    }

    /**
     * @return mixed
     */
    public function isAdminExists($database)
    {
        $bool = DatabaseService::getDefaultBool();
        $adminExistsQuery = "SELECT * FROM administrators where is_active = '$bool'";

        return $database::getRow($adminExistsQuery);
    }
}