<?php
require "Connect.php";

class Library
{

    public $connection = null;

    public function __construct()
    {
        $this->connection = (new Connect())->getConnect();
    }

    public function login($userinput, $password)
    {
        $statement = "SELECT * FROM users WHERE username=:userinput OR email=:userinput";

        try {
            $query = $this->connection->prepare($statement);
            $query->bindParam(":userinput", $userinput, PDO::PARAM_STR);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($query->rowCount() > 0) {
                if ($userinput == $result['username'] || $userinput == $result['email']) { 
                    if (password_verify($password, $result['password'])) {
                        if(!isset($_SESSION)){
                            session_start();
                        }
                        $_SESSION['id'] = $result['id'];
                        aredirect("Login successful...", "welcome.php");
                    }
                    alert("Incorrect details!!");
                }
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
            
            $statement = $this->connection->exec([
                'firstname' => $firstname['firstname'],
                'lastname' => $lastname['lastname'],
                'username' => $username['username'],
                'passwprd' => $password['password']
            ]);
            dd($statement);
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