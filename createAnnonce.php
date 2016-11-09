<?php
require_once("class/annonce.php");
require_once("class/errorMessage.php");
require_once("class/bildUpload.php");
session_start();
$inputField = array("titel", "preis", "beschreibung");
$error = new errorMessage();


$inputIsSet = false;
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
    $annonce = new annonce();
    $annonce->createAnnonce($_POST['titel'], $_POST['beschreibung'], $_POST['preis'], $_SESSION['userid'], $_POST['rubrik']);

    if (!$_FILES['bild1']['name']  == "" ||!$_FILES['bild2']['name']  == "")
    {
        if($_FILES['bild1']['error'] == 0 && $_FILES['bild2']['error'] != 0)
        {
            $bu = new bildUpload();
            $bu->setAnnoncenID($annonce->getIDAnnonce($_POST['titel']));
            $bu->upload($_FILES['bild1']);
        }
        elseif ($_FILES['bild1']['error'] == 0 && $_FILES['bild2']['error'] == 0)
        {
            $bu = new bildUpload();
            $bu->setAnnoncenID($annonce->getIDAnnonce($_POST['titel']));
            $bu->upload($_FILES['bild1'], $_FILES['bild2']);
        }

    }

    header("Location: kleinanzeigen.php");
    exit();
}
?>