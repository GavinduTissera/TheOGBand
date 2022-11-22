<?php
include "ini.php";
include "C:/xampp\htdocs\ComputerScienceNEA\RootFolder\Assets\Classes/CreateArrayCheckQuery.php";

//Inherited from the db connector class. This class focuses on interacting with the database
class SignupQuery extends dbConnector
{


    public function addUserToDBQuery()
    {
        //Utilisies placeholders "?" to prevent SQL injection
        $queryStatement = $this->connectTodb()->prepare("INSERT INTO userLogins (userEmail, userFirstName, userPassword, userIsAdmin) VALUES (?, ?, ?, ?)");
        return $queryStatement;
    }

    //Gets the record from the database for an email that matches the one given
    protected function GetAllDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM userLogins WHERE userEmail = ?;");
        return $queryStatement;
    }
    

    //Hashes the password and excecutes the query to add it to the database.
    protected function addUserToDB($email, $firstname, $password, $isAdmin)
    {
        try {
            $queryStatement = $this->addUserToDBQuery();
            //Hashes the password and stores it in the database. The hashed password is always 60 characters long.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $queryStatement->execute([$email, $firstname, $hashedPassword, $isAdmin]);
        //Checks if the email already exists and if it does, outputs a userAlreadyExists redirect
        } catch (\PDOException $exception) {    
            if ($exception->errorInfo[1] === 1062) {
                $queryStatement = null;
                header("location: ../../Pages/login.php?error=userAlreadyExists");
                exit();
            }
            //If there is a server or database error then a redirect with failedToExecutre happens.
            $queryStatement = null;
            header("location: ../../Pages/login.php?error=failedToExcecute");
            exit();
        }
        $queryStatement = null;
    }

}

//This is the class that takes in the data and then does some extra error handling. If it passes everything, it adds the user to the database
class SignupController extends SignupQuery {
    //Initialising attributes
    var $email;
    var $firstname;
    var $password;
    var $repeatPassword;
    var $isAdmin;

    //Constructor for signup controller
    public function __construct($email, $firstname, $password, $repeatPassword, $isAdmin)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->password = $password;
        $this->repeatPassword = $repeatPassword;
        $this->isAdmin = $isAdmin;
    }

    // === ERROR HANDLING ===

    //If the password and repeat password don't match then it sends it to errorHandlingAndSignup() to give an error message
    private function passwordMatchCheck()
    {
        if ($this->password !== $this->repeatPassword) {
            return false;
        } 
        return true;
    }

    public function errorHandlingAndSignup()
    {
        if ($this->passwordMatchCheck() === false) {
            header("location: ../../Pages/login.php?error=passwordsDontMatch");
            exit();
        } 
        //Adds the user to the database, and gets the data from it.
        $this->addUserToDB($this->email, $this->firstname, $this->password, $this->isAdmin); 
        $queryStatement = $this->GetAllDataQuery($this->email);
        $queryStatement->execute([$this->email]);
        $getArray = new CreateArrayCheckQuery();
        //Creates an associative array, and saves the details in session variables
        $userArray = $getArray->GetAssocArray($queryStatement);
        
        session_start();
        $_SESSION["userid"] = $userArray[0]["userID"];
        $_SESSION["useremail"] = $userArray[0]["userEmail"];
        $_SESSION["userfirstname"] = $userArray[0]["userFirstName"];
        $_SESSION["userisadmin"] = $userArray[0]["userIsAdmin"];
        
    }
}
