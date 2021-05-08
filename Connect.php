<?php

class Connect 
{
    private $connect;

    public function __construct()
    {
        $dbhost = 'localhost';
        $dbname = 'uploaddb';
        $dbuser = 'root';
        $dbpass = '';

        try {
            $this->connect = new \PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnect() 
    {
        return $this->connect;
    }
}