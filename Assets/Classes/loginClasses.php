<?php
include "ini.php";


//Inherited from the db connector class. This class focuses on interacting with the database
class LoginQuery extends dbConnector
{
//Next 2 functions create queries that access the database and return them. These queries are used to stop SQL injection by utilising placeholders "?"

    protected function GetAllDataQuery($email)
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM userLogins WHERE userEmail = ?;");
        $queryStatement->bindParam(1,$email);
        return $queryStatement;
    }

    protected function GetAssocArray($queryStatement)
    {
        $temp = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
        return $temp;
    }


    //Next function returns error message if the database doesnt excecute the query properly
    protected function CheckifExcecutableQuery($email)
    {    
        $queryStatement = $this->GetAllDataQuery($email);
        if (!$queryStatement->execute()) {
            $queryStatement = null;
            header("location: ../../Pages/login.php?error=failedToExcecute");
            exit();
        } 
        $queryStatement = null;
        
    }

    //Checks if the user already exists in the database, by checking for matching emails

    protected function CheckPassword($email, $password)
    {
        $queryStatement = $this->GetAllDataQuery($email);
        $queryStatement->execute([$email]);
        $hashedPassword = $this->GetAssocArray($queryStatement);
        $boolPasswordCheck = password_verify($password, $hashedPassword[0]["userPassword"]);
        return $boolPasswordCheck;
    }


    protected function getUserFromDB($email, $password)
    {
        $queryStatement = $this->GetAllDataQuery($email);
        $queryStatement->execute([$email]);
        $this->CheckifExcecutableQuery($email);
        $passwordCheck = $this->CheckPassword($email, $password);
        if ($passwordCheck === false) {
            $queryStatement = null;
            header("location: ../../Pages/login.php?error=incorrectPassword");
            exit();
        }
        $userArray = $this->GetAssocArray($queryStatement);
        session_start();
        $_SESSION["userarray"] = $userArray;
        $_SESSION["userid"] = $userArray[0]["userID"];
        $_SESSION["useremail"] = $userArray[0]["userEmail"];
        $_SESSION["userfirstname"] = $userArray[0]["userFirstName"];
        $_SESSION["userpassword"] = $userArray[0]["userPassword"];
        $_SESSION["userisadmin"] = $userArray[0]["userIsAdmin"];
        $queryStatement = null;
    }
}



//This is the class that takes in the data and then does some error handling. If it passes everything, it adds the user to the database
class LoginController extends LoginQuery {
    //Initialising attributes
    var $email;
    var $password;

    //Constructor for signup controller
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    protected function ExistingAccount()
    {
        $queryStatement = $this->GetAllDataQuery($this->email);
        $queryStatement->execute();
        $this->CheckifExcecutableQuery($this->email);
        if ($queryStatement->rowCount() === 0) {
            return false;
        } else {
            return true;
        }
    }

    public function errorHandlingAndLogin()
    {
        if ($this->ExistingAccount() === false) {
            header("location: ../../Pages/login.php?error=userNotExists");
            exit();
        }
        $this->getUserFromDB($this->email, $this->password);
    }



}


