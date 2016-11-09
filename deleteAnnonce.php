<?php
require_once("class/annonce.php");
require_once("class/errorMessage.php");
require_once("class/bildUpload.php");

$annonce = new annonce();
$bu = new bildUpload();

    $bu->deleteAllPictures($annonce->getIDAnnonce($_POST['annonce']));
    $annonce->deleteAnnonce($_POST['annonce']);
    header("Location: annonce_delete.php");
    exit();
?>