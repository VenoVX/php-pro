<?php
require_once("class/annonce.php");
require_once("class/database.php");
require_once ("class/bildUpload.php");

session_start();
$inputField = array("titel","rubrik", "preis", "beschreibung");
$error = new errorMessage();
$paramIsSet = array();

$inputIsSet = false;
foreach ($inputField as $fieldName)
{
    if(!isset($_POST[$fieldName]) || empty($_POST[$fieldName]))
    {
        $paramIsSet[$fieldName] = $_SESSION['annonce'][$fieldName];
    }
    else {
        $paramIsSet[$fieldName] = $_POST[$fieldName];
    }
}
$annonce = new annonce();
$bu = new bildUpload();
$annonce->changeAnnonce($_SESSION['annonce']['id'], $paramIsSet['titel'], $paramIsSet['beschreibung'], $paramIsSet['preis'], $paramIsSet['rubrik']);


    if (!$_FILES['bild1']['name']  == "" ||!$_FILES['bild2']['name']  == "")
    {
        if($_FILES['bild1']['error'] == 0 && $_FILES['bild2']['error'] != 0)
        {
            $bu->setAnnoncenID($annonce->getIDAnnonce($paramIsSet['titel']));
            $bu->upload($_FILES['bild1']);
        }
        elseif ($_FILES['bild1']['error'] == 0 && $_FILES['bild2']['error'] == 0)
        {

            $bu->setAnnoncenID($annonce->getIDAnnonce($paramIsSet['titel']));
            $bu->upload($_FILES['bild1'], $_FILES['bild2']);
        }
    }
foreach ($_POST['bild'] as $bildid)
{
    $bu->deletePicture($bildid);

}
header("Location: myAnnonce.php");
exit();


?>