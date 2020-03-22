<?php


namespace App\Components;

use \PDO;

class Db
{
    public static function connect() : PDO
    {
        $params = include 'App/config/db.php';

        return new PDO("mysql:host={$params['host']};dbname={$params['name']};charset=UTF8",
            $params['user'], $params['password'], $params['options']);
    }
}
