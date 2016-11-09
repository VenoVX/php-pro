<?php
include("config.php");
class database
{
    private  $conn;
    function __construct()
    {
        $this->connect(dbHost, myDB, port, user, pw);
    }

    function connect($dbHost, $myDB, $port, $user, $pw)
    {
        try{
            $this->conn = new PDO("mysql:host=$dbHost; dbname=$myDB; port=$port", $user, $pw);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES 'utf8'");


        }catch(Exception $e){
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
    function getConnection()
    {
        return $this->conn;
    }
}
?>