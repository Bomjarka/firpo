<?php

class Model
{
    protected static $database;

    public function __construct()
    {
        self::$database = DatabaseService::getDatabase();
    }
}