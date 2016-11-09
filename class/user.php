<?php

require("database.php");
require_once("errorMessage.php");

class user
{
    private $db;
    protected $error;
    protected $count;
    function __construct()

    {
        $this->count = 0;
        $this->db = new database();
        $this->error = new errorMessage();
    }
    function createUser($vorName, $nachName, $email, $passwort, $secPasswort, $strasse, $hausNummer, $wohnort)
    {
        if($this->checkPassword($passwort, $secPasswort) && $this->checkEmail($email) && $this->regExCheck($vorName, $nachName, $email, $strasse, $hausNummer))
        {
            $fsort = $this->getIDOrt($wohnort);
            $hashPasswort = $this->hashPassword($passwort);
            $stmtCreateUser = $this->db->getConnection()->prepare("Insert INTO user (vorname, nachname, email, passwort, strasse, hausnummer, FSOrt)
            VALUES (:vorname, :nachname, :email, :passwort, :strasse, :hausnummer, :wohnort);");
            $stmtCreateUser->bindParam(':vorname', $vorName);
            $stmtCreateUser->bindParam(':nachname', $nachName);
            $stmtCreateUser->bindParam(':email', $email);
            $stmtCreateUser->bindParam(':passwort', $hashPasswort);
            $stmtCreateUser->bindParam(':strasse', $strasse);
            $stmtCreateUser->bindParam(':hausnummer', $hausNummer);
            $stmtCreateUser->bindParam(':wohnort', $fsort);

            $stmtCreateUser->execute();
        }
    }
    function getIDOrt($wohnort)
    {
        $stmtGetFS = $this->db->getConnection()->prepare("select id from wohnort where ort like :ort;");
        $stmtGetFS->bindParam(':ort', $wohnort);
        $stmtGetFS->execute();
        $idrow = $stmtGetFS->fetch();
        return $idrow['id'];
    }
    function hashPassword($passwort)
    {
        return password_hash($passwort, PASSWORD_DEFAULT);
    }
    function checkPassword($passwort, $secPasswort)
    {
     if($passwort === $secPasswort)
     {
         return true;
     }
     else
     {
         $this->error->errorPasswordNotEqual($passwort, $secPasswort);
         return false;
     }
    }
    function checkHashedPassword($email, $passwort)
    {
        $stmtCheckHashPassword = $this->db->getConnection()->prepare("select * from user where email like :email;");
        $stmtCheckHashPassword->bindParam(':email', $email);
        $stmtCheckHashPassword->execute();
        $user = $stmtCheckHashPassword->fetch();

        if($email === $user["email"])
        {
            if(password_verify($passwort, $user["passwort"]))
            {
                return $user;
            }
            else
            {
                $this->error->errorPasswordFalse();
            }
        }
        else
        {
            $this->error->emailDoesntExists($email);
        }
    }
    function checkEmail($email)
    {
        $stmtCheckEmail = $this->db->getConnection()->prepare("Select email from user where email like :email;");
        $stmtCheckEmail->bindParam(':email', $email);
        $stmtCheckEmail->execute();
        if($stmtCheckEmail->rowCount() === 0)
        {
            return true;
        }
        else
        {
            $this->error->errorEmailExists($email);
            return false;
        }
    }
    function regExCheck($vorName, $nachName, $email, $strasse, $hausNummer)
    {
        $nameRegex = "/[öäüÖÄÜA-z]+[öäüÖÄÜA-z]*/";
        $emailRegex = "/[öäüÖÄÜA-z0-9]+[.-_]*[öäüÖÄÜA-z]*@[öäüÖÄÜA-z.]+[öäüÖÄÜA-z]/";
        $strasseRegex = "/[öäüÖÄÜA-z ]+/";
        $hausNummerRegex = "/[0-9]+[a-z]*/";

        if(preg_match($nameRegex, $vorName)==0)
        {
            $this->error->errorUserData($vorName);
            return false;
        }
        elseif(preg_match($nameRegex, $nachName)==0)
        {
            $this->error->errorUserData($nachName);
            return false;
        }
        elseif (preg_match($emailRegex, $email)==0)
        {
            $this->error->errorUserData($email);
            return false;
        }
        elseif (preg_match($strasseRegex, $strasse)==0)
        {
            $this->error->errorUserData($strasse);
            return false;
        }
        elseif (preg_match($hausNummerRegex, $hausNummer)==0)
        {
            $this->error->errorUserData($hausNummer);
            return false;
        }
        else
        {
            return true;
        }
    }
}
