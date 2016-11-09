<?php
#Import von Klasse: Database.php errorMessage.php rubrik.php
require("database.php");
require_once("errorMessage.php");
require_once("rubrik.php");
#Klasse Annonce
class annonce
{
    #Deklaration
    private $db;
    private $error;
    private $rubrik;
    function __construct()
    {
        #Zuweisung/Erzeugen neuer Objekte
        $this->db = new database();
        $this->error = new errorMessage();
        $this->rubrik = new rubrik();
    }
    #Erstellt neue Annonce
    function createAnnonce($titel, $beschreibung, $preis, $userid, $rubrikName)
    {
        #Checkt ob Titel schon vorhanden in der DB
        if($this->checkTitle($titel))
        {
            #Holt sich id Rubrikid -> siehe Klasse Rubrik.php
            $rubrikid= $this->rubrik->getIDRubrik($rubrikName);
            #Bereitet das SQL Statement vor -> siehe Klasse Database.php
            $stmtCreateAnnonce = $this->db->getConnection()->prepare("Insert INTO annonce (titel, beschreibung, preis, FSUser, FSRubrik)
           VALUES (:titel, :beschreibung, :preis, :fsuser, :fsrubrik);");
            #Fügt bindParameter hinzu (Platzhalter)
            $stmtCreateAnnonce->bindParam(':titel', $titel);
            $stmtCreateAnnonce->bindParam(':beschreibung', $beschreibung);
            $stmtCreateAnnonce->bindParam(':preis', $preis);
            $stmtCreateAnnonce->bindParam(':fsuser', $userid);
            $stmtCreateAnnonce->bindParam(':fsrubrik', $rubrikid);
            #Führt das Statment aus
            $stmtCreateAnnonce->execute();
        }

    }
    #Löscht Annonce anhand vom Titel
    function deleteAnnonce($titel)
    {
        #Bereitet das SQL Statement vor -> siehe Klasse Database.php
        $stmtGetFS = $this->db->getConnection()->prepare("Delete from annonce where titel like :titel;");
        #Fügt bindParameter hinzu (Platzhalter)
        $stmtGetFS->bindParam(':titel', $titel);
        #Führt das Statment aus
        $stmtGetFS->execute();
    }
    #Stellt die AnnoncenID bereit, holt diese sich von der Datenbank
    function getIDAnnonce($annoncenName)
    {
        #Bereitet das SQL Statement vor -> siehe Klasse Database.php
        $stmtGetFS = $this->db->getConnection()->prepare("select id from annonce where titel like :titel;");
        #Fügt bindParameter hinzu (Platzhalter)
        $stmtGetFS->bindParam(':titel', $annoncenName);
        #Führt das Statment aus
        $stmtGetFS->execute();
        #Speichert die Zeile in einem Array = $idrow
        $idrow = $stmtGetFS->fetch();
        return $idrow['id'];
    }
    #Checkt ob Titel in DB vorhanden
    function checkTitle($titel)
    {
        #Bereitet das SQL Statement vor -> siehe Klasse Database.php
        $stmtCheckTitle = $this->db->getConnection()->prepare("Select titel from annonce where titel like :titel;");
        #Fügt bindParameter hinzu (Platzhalter)
        $stmtCheckTitle->bindParam(':titel', $titel);
        #Führt das Statment aus
        $stmtCheckTitle->execute();
        #Prüft wie oft die Zeile/Titel exisitiert
        if($stmtCheckTitle->rowCount() === 0)
        {
            return true;
        }
        else
        {
            #Aufruf ErrortitleExists mit Titel als ÜbergabeParameter -> Siehe Error Klasse
            $this->error->errortitleExists($titel);
            return false;
        }
    }
    #Gibt die Annonce zurück anhand vom Titel und UserID
    function showAnnonce($titel, $userid)
    {
            #Bereitet das SQL Statement vor -> siehe Klasse Database.php
            $stmtGetAnnonce = $this->db->getConnection()->prepare("select * from annonce where titel like :titel AND FSUser like :userid;");
            #Fügt bindParameter hinzu (Platzhalter)
            $stmtGetAnnonce->bindParam(':titel', $titel);
            $stmtGetAnnonce->bindParam(':userid', $userid);
            #Führt das Statment aus
            $stmtGetAnnonce->execute();
            #Bildet ein Array aus allen passenden Zeilen Array=$annonce
            $annonce = $stmtGetAnnonce->fetchall();
            return $annonce;
    }
    #Methode zum ändern der Annonce
    function changeAnnonce($id, $titel, $beschreibung, $preis, $rubrikName)
    {
        #Holt sich id Rubrikid -> siehe Klasse Rubrik.php
        $rubrikid= $this->rubrik->getIDRubrik($rubrikName);
        #Bereitet das SQL Statement vor -> siehe Klasse Database.php
        $stmtUpdateAnnonce = $this->db->getConnection()->prepare("Update annonce Set titel=:titel, beschreibung=:beschreibung, preis=:preis, FSRubrik=:fsrubrik where id=:id;");
        #Fügt bindParameter hinzu (Platzhalter)
        $stmtUpdateAnnonce->bindParam(':titel', $titel);
        $stmtUpdateAnnonce->bindParam(':beschreibung', $beschreibung);
        $stmtUpdateAnnonce->bindParam(':preis', $preis);
        $stmtUpdateAnnonce->bindParam(':id', $id);
        $stmtUpdateAnnonce->bindParam(':fsrubrik', $rubrikid);
        #Führt das Statment aus
        $stmtUpdateAnnonce->execute();
    }
}
?>