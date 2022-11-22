<?php
include "ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";


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

    //Checks if the user already exists in the database, by checking for matching emails

    protected function CheckPassword($email, $password)
    {
        $getUserDatabaseCheck = new CreateArrayCheckQuery();
        $queryStatement = $this->GetAllDataQuery($email);
        $queryStatement->execute([$email]);
        $hashedPassword = $getUserDatabaseCheck->GetAssocArray($queryStatement);
        //Uses password_verify to check if the password given, and the hash stored are the same. Returns boolean value
        $boolPasswordCheck = password_verify($password, $hashedPassword[0]["userPassword"]);
        return $boolPasswordCheck;
    }


    protected function getUserFromDB($email, $password)
    {
        // Gets the record in the database, where the email matches the one stored.
        $queryStatement = $this->GetAllDataQuery($email);
        $queryStatement->execute([$email]);
        //Checks if the query statement can excecute, to stop more serious problems later
        $getUserDatabaseCheck = new CreateArrayCheckQuery();
        $getUserDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        //Checks if the password matches
        $passwordCheck = $this->CheckPassword($email, $password);
        //If the password doesn't match, it redirects the user to the login page, and adds incorrectPassword to the url
        if ($passwordCheck === false) {
            $queryStatement = null;
            header("location: ../../Pages/login.php?error=incorrectPassword");
            exit();
        }
        //Gets an associative array of key value pairs which contain the user details
        $userArray = $getUserDatabaseCheck->GetAssocArray($queryStatement);
        session_start();
        $_SESSION["userarray"] = $userArray;
        $_SESSION["userid"] = $userArray[0]["userID"];
        $_SESSION["useremail"] = $userArray[0]["userEmail"];
        $_SESSION["userfirstname"] = $userArray[0]["userFirstName"];
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
        //Checks to see if the account exists in the database or not. If it does, it returns true, and if not, then false.
        $getUserDatabaseCheck = new CreateArrayCheckQuery();
        $queryStatement = $this->GetAllDataQuery($this->email);
        $queryStatement->execute();
        $getUserDatabaseCheck->CheckifExcecutableQuery($queryStatement);
        if ($queryStatement->rowCount() === 0) {
            return false;
        } else {
            return true;
        }
    }

    public function errorHandlingAndLogin()
    {
        //If the email doesn't exist in the database, then redirects the user with the error message in url
        if ($this->ExistingAccount() === false) {
            header("location: ../../Pages/login.php?error=userNotExists");
            exit();
        }
        // gets user data from the database and starts the session.
        $this->getUserFromDB($this->email, $this->password);
    }
}


