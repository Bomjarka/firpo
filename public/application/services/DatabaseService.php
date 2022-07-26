<?php

class DatabaseService
{
    /**
     * Берём рабочую БД из .env
     *
     */
    public static function getDatabase()
    {
        (new DotEnv(__DIR__ . '/../../../.env'))->load();
        $databaseType = getenv('DATABASE');

        switch ($databaseType) {
            case 'postgres':
                return new PostgresqlDatabase();
            case 'mysql':
                return MySQLDatabase::getDbh();
        }

        return new Exception('Wrong database type');
    }

    public static function getDefaultBool()
    {
        if (self::getDatabase() == new PostgresqlDatabase()) {
            return true;
        } elseif (self::getDatabase() == new MySQLDatabase()) {
            return 1;
        }

        return false;
    }
}