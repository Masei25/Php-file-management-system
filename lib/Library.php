<?php

require "Connect.php";

class Library
{

    public $connection = null;

    public function __construct()
    {
        $this->connection = (new Connect())->getConnect();
    }

    public function login($username, $password)
    {
        $statement = "SELECT id FROM users WHERE username=:username AND password=:password";

        try {
            $query = $this->connection->prepare($statement);
            $query->bindParam("username",$username,PDO::PARAM_STR);
            $query->bindParam("password",$password,PDO::PARAM_STR);
            $query->execute();
            
            if($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->id;
            }

        } catch (\PDOExeption $e) {
            exit($e->getMessage());
        }
    }

    public function register($firstname, $lastname, $username, $password)
    {
        $user_check = "SELECT username FROM users WHERE username='$username' ";
        $result = $this->connection->query($user_check);
        $result->fetchAll(\PDO::FETCH_ASSOC);

        if($result->rowCount() > 0) {
            return header('Location: '.$_SERVER['HTTP_REFERER']);
            alert("File upload successful");
        }
        
        $statement = "INSERT INTO users (firstname,lastname,username,password) 
                        VALUES (:firstname,:lastname,:username,:password)";
        
        try {
            $statement = $this->connection->prepare($statement);
            
            $statement->exec([
                'firstname' => $firstname['firstname'],
                'lastname' => $lastname['lastname'],
                'username' => $username['username'],
                'passwprd' => $password['password']
            ]);
            return $statement;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function Auth($name)
    {
        if(isset($_SESSION[$name])) {
            return header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id) 
    {
        $statement = "DELETE FROM upload WHERE id = :id";

        try {
            $this->connection->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}