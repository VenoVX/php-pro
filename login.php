<?php
require_once("class/errorMessage.php");
require_once("class/user.php");
session_start();
$inputField = array("email", "password");
$error = new errorMessage();
foreach ($inputField as $fieldName)
{
    if(!isset($_POST[$fieldName]) || empty($_POST[$fieldName]))
    {
        $error->errorInputIsEmpty();
        $inputIsSet = false;
        break;
    }
    else {
        $inputIsSet = true;
        break;
    }
}
if($inputIsSet)
{
    $user = new user();
    $userData = $user->checkHashedPassword($_POST['email'], $_POST['password']);
    if(isset($userData['id']) || !empty($userData['id']))
    {
        $_SESSION['userid'] = $userData['id'];
        $_SESSION['userName'] = $userData['email'];
        header("Location: kleinanzeigen.php");
        exit();
    }
    else
    {
        "fehlgeschlagen";
    }
}
?>