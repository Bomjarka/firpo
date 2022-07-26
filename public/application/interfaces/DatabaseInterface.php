<?php

interface DatabaseInterface
{

    /**
     * Подключение к БД.
     */
    public static function getDbh();

    /**
     * Закрытие соединения.
     */
    public static function destroy();


    /**
     * Получение ошибки запроса.
     */
    public static function getError();


    /**
     * Возвращает структуру таблицы в виде ассоциативного массива.
     */
    public static function getStructure($table);


    /**
     * Добавление в таблицу, в случаи успеха вернет вставленный ID, иначе 0.
     */
    public static function add($query, $param = array());

    /**
     * Выполнение запроса.
     */
    public static function set($query, $param = array());

    /**
     * Получение строки из таблицы.
     */
    public static function getRow($query, $param = array());


    /**
     * Получение всех строк из таблицы.
     */
    public static function getAll($query, $param = array());

    /**
     * Получение значения.
     */
    public static function getValue($query, $param = array(), $default = null);

    /**
     * Получение столбца таблицы.
     */
    public static function getColumn($query, $param = array());
}