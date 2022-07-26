<?php

class PostgresqlDatabase
{
    public static $dsn = 'pgsql:dbname=postgres;host=postgres';
    public static $user = 'postgres';
    public static $pass = 'postgres';

    /**
     * Объект PDO.
     */
    public static $dbh = null;

    /**
     * Statement Handle.
     */
    public static $sth = null;

    /**
     * Выполняемый SQL запрос.
     */
    public static $query = '';

    public function __construct(){
        self::getDbh();
    }

    public static function getDbh()
    {
        if (!self::$dbh) {
            try {
                self::$dbh = new PDO(
                    self::$dsn,
                    self::$user,
                    self::$pass
                );
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            } catch (PDOException $e) {
                exit('Error connecting to database: ' . $e->getMessage());
            }
        }

        return self::$dbh;
    }

    /**
     * Закрытие соединения.
     */
    public static function destroy()
    {
        self::$dbh = null;
        return self::$dbh;
    }

    /**
     * Получение ошибки запроса.
     */
    public static function getError()
    {
        $info = self::$sth->errorInfo();
        return (isset($info[2])) ? 'SQL: ' . $info[2] : null;
    }

    /**
     * Возвращает структуру таблицы в виде ассоциативного массива.
     */
    public static function getStructure($table)
    {
        $res = array();
        foreach (self::getAll("SHOW COLUMNS FROM {$table}") as $row) {
            $res[$row['Field']] = (is_null($row['Default'])) ? '' : $row['Default'];
        }

        return $res;
    }

    /**
     * Добавление в таблицу, в случаи успеха вернет вставленный ID, иначе 0.
     */
    public static function add($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        return (self::$sth->execute((array) $param)) ? self::getDbh()->lastInsertId() : 0;
    }

    /**
     * Выполнение запроса.
     */
    public static function set($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        return self::$sth->execute((array) $param);
    }

    /**
     * Получение строки из таблицы.
     */
    public static function getRow($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Получение всех строк из таблицы.
     */
    public static function getAll($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получение значения.
     */
    public static function getValue($query, $param = array(), $default = null)
    {
        $result = self::getRow($query, $param);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    /**
     * Получение столбца таблицы.
     */
    public static function getColumn($query, $param = array())
    {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetchAll(PDO::FETCH_COLUMN);
    }
}