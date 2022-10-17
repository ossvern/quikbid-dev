<?php
class Db
{
    public static function getConnection()
    {
        $params_path = ROOT.'/pages/inc/config/db_params.php';
        $params = include($params_path);
//        $dsn = "mysqli:host={$params['host']};dbname={$params['dbname']}";
//        $db = new PDO($dsn, $params['user'], $params['password']);
        $db = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);
        $db->set_charset("utf8");
        return $db;
    }
}