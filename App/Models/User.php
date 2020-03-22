<?php

namespace App\Models;

use App\Components\Db;

class User
{
    public static function add($name, $email) : int
    {
        $db = Db::connect();

        $query = $db->prepare("INSERT INTO users (name, email) VALUES (?,?)");
        $query->execute([$name, $email]);

        $result = $db->lastInsertId();

        return $result;
    }

    public static function checkAdminData($name, $password) : bool
    {
        $db = Db::connect();
        $sql = 'SELECT * FROM users WHERE name = ? AND password = ? AND is_admin=1';

        $query = $db->prepare($sql);
        $query->execute([$name, $password]);

        $user = $query->fetch();

        return $user ? true : false;
    }

    public static function authAdmin()
    {
        $_SESSION['user'] = 'admin';
    }

    public static function isAdmin() : bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user'] === 'admin');
    }

    public static function checkEmail($email) : bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function checkName($name) : bool
    {
        return (mb_strlen($name) >= MIN_LENGTH_NAME && mb_strlen($name) <= MAX_LENGTH_NAME);
    }

    public static function checkUserExists($email)
    {
        $db = Db::connect();

        $query = $db->prepare('SELECT id FROM users WHERE email = ?');
        $query->execute([$email]);

        $result = $query->fetch();

        return $result;
    }
}