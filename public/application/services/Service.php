<?php

class Service
{
    protected static $database;

    public function __construct($database)
    {
        self::$database = $database;
    }
}