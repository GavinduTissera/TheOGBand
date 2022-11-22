<?php 

//Class is usually inherited from, to allow connectTodb to be used in all files that require a database connection
class dbConnector {

    public function connectTodb()
    {
        //Connects to the database (mysql) with PDO
        $username = "root";
        $password = "";
        $dbHandler = new \PDO("mysql:host=localhost;dbname=ogband;charset=utf8mb4", $username, $password);
        //Helps with error handling
        $dbHandler->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $dbHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbHandler;            
    }
}