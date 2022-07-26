<?php

class SQLTestQueryService extends Service
{
    /**
     * Выводит повторяющиеся email из таблицы users
     *
     * @return array|false
     */
    public static function getAllPeopleWithPetsOlderThreeYears()
    {
        $getAllPeopleQuery = "SELECT * FROM pet_owners WHERE exists(SELECT 1 FROM pets WHERE age > 3) ORDER BY id";

        $result = self::$database::getAll($getAllPeopleQuery);

        return $result;
    }
}