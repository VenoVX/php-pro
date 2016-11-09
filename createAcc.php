<?php
    require_once("class/user.php");
    require_once("class/errorMessage.php");

    $inputField = array("frName", "secName", "email", "password", "secPassword", "street", "houseNumber", "wohnort");
    $error = new errorMessage();
    foreach ($inputField as $fieldName)
    {
            if(!isset($_POST[$fieldName]) || empty($_POST[$fieldName]))
            {
                $error->errorInputIsEmpty();
                break;
            }
            else {
                $inputIsSet = true;
                break;
            }
    }
    if ($inputIsSet)
    {
        $user = new user();
        $user->createUser($_POST["frName"], $_POST["secName"], $_POST["email"], $_POST["password"], $_POST["secPassword"], $_POST["street"], $_POST["houseNumber"], $_POST['wohnort']);
        header("Location: kleinanzeigen.php");
        exit();
    }
?>