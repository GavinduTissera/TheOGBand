<?php 

class dbConnector {

    public function connectTodb()
    {
        $username = "root";
        $password = "";
        $dbHandler = new \PDO("mysql:host=localhost;dbname=ogband;charset=utf8mb4", $username, $password);
        $dbHandler->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $dbHandler->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbHandler;

            
    }

    


}