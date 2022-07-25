<?php
include "ini.php";

//Inherited from the db connector class. This class focuses on interacting with the database
class SignupQuery extends dbConnector
{


    public function addUserToDBQuery()
    {
        //Utilisies placeholders "?" to prevent SQL injection
        $queryStatement = $this->connectTodb()->prepare("INSERT INTO users (userEmail, userFirstName, userPassword, userIsAdmin) VALUES (?, ?, ?, ?)");
        return $queryStatement;
    }

    protected function GetAllDataQuery()
    {
        $queryStatement = $this->connectTodb()->prepare("SELECT * FROM users WHERE userEmail = ?;");
        return $queryStatement;
    }

    protected function GetAssocArray($queryStatement)
    {
        $temp = $queryStatement->fetchAll(\PDO::FETCH_ASSOC);
        return $temp;
    }
    

    //Hashes the password and excecutes the query to add it to the database.
    protected function addUserToDB($email, $firstname, $password, $isAdmin)
    {
        try {
            $queryStatement = $this->addUserToDBQuery();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $queryStatement->execute([$email, $firstname, $hashedPassword, $isAdmin]);
        //Checks if the email already exists and if it does, outputs a userAlreadyExists redirect
        } catch (\PDOException $exception) {    
            if ($exception->errorInfo[1] === 1062) {
                $queryStatement = null;
                header("location: ../../Pages/login.php?error=userAlreadyExists");
                exit();
            }
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

    //If the password and repeat password don't match then it sends it to errorHandling() to give an error message
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

        if (strlen(trim($this->password) < 6)) {
            header("location: ../../Pages/login.php?error=passwordsLengthError");
            exit();
        }
        $this->addUserToDB($this->email, $this->firstname, $this->password, $this->isAdmin); 
        $queryStatement = $this->GetAllDataQuery($this->email);
        $queryStatement->execute([$this->email]);
        $userArray = $this->GetAssocArray($queryStatement);
        
        session_start();
        $_SESSION["userid"] = $userArray[0]["userID"];
        echo "userid";
        $_SESSION["useremail"] = $userArray[0]["userEmail"];
        $_SESSION["userfirstname"] = $userArray[0]["userFirstName"];
        $_SESSION["userpassword"] = $userArray[0]["userPassword"];
        $_SESSION["userisadmin"] = $userArray[0]["userIsAdmin"];
        
    }
}
