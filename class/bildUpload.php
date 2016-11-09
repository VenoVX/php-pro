<?php
#Import der Klassen Database.php
require_once("database.php");
require_once("errorMessage.php");

class bildUpload
{
    #Deklaration $db und $annoncenid
    private $db;
    private $annoncenid;
    function __construct()
    {
        #Erzeugt neues Datenbank-Objekt
        $this->db = new database();
    }
    #Ladet das Bild hoch
    function upload()
    {
        #Sammelt alle übergebene Parameter und speichert diese als Array in $files
        $files= func_get_args();
        #Checkt ob Dateien auch Bilder
        if($this->checkDataType($files))
        {
            #Aufruf changeDIr ÜbergabeParameter $files
            $this->changeDir($files);
            $this->writeInDB($files);
        }
        else
        {
            echo "kein bild";
        }

    }
    #Löscht alle Bilder anhand des Fremschlüssels der Annonce, wird benutzt wenn Annonce gelöscht wird
    function deleteAllPictures($FSAnnonce)
    {
        #Neuer Pfad für Bilder
        $fileDir = "/var/www/public/uploads/";
        #Bereitet SQL Statement vor -> siehe Datenbank.php
        #Statement= holt sich alle Dateinamen anhand FSAnnonce
        $stmtGetName = $this->db->getConnection()->prepare("Select dtname from bilder where FSAnnonce like :id;");
        #Fügt bindParameter hinzu (Platzhalter)
        $stmtGetName->bindParam(":id", $FSAnnonce);
        #Führt Statement aus
        $stmtGetName->execute();
        #Speichert alle passenden Zeilen als Array=$rows
        $rows = $stmtGetName->fetchall();
        #Hab kein Bock mehr ab hier keine Kommis mehr d:^)
        foreach ($rows as $item)
        {
            $path = $fileDir . $item['dtname'];
            unlink($path);
        }

        $stmtDeleteAll = $this->db->getConnection()->prepare("Delete from bilder where FSAnnonce like :FSAnnonce;");
        $stmtDeleteAll->bindParam(':FSAnnonce', $FSAnnonce);
        $stmtDeleteAll->execute();

    }
    function deletePicture($bildid)
    {
        $stmtDeletePicture = $this->db->getConnection()->prepare("Delete from bilder where id like :id;");
        $stmtDeletePicture->bindParam(':id', $bildid);
        $stmtDeletePicture->execute();
    }
    function setAnnoncenID($annoncenID)
    {
        $this->annoncenid = $annoncenID;
    }
    function writeInDB($files)
    {
        foreach ($files as $file)
        {
            $stmtBild = $this->db->getConnection()->prepare("Insert INTO bilder (dtname, FSAnnonce)
           VALUES (:dtname, :FSAnnonce);");
            $stmtBild->bindParam(':dtname', $file['name']);
            $stmtBild->bindParam(':FSAnnonce', $this->annoncenid);


            $stmtBild->execute();
        }
    }
    function checkDataType($files)
    {
        $dataTypes = array("image/png", "image/jpeg");
        if(count($files) == 2)
        {
            if (in_array( $files['0']['type'] , $dataTypes ) && in_array( $files['1']['type'] , $dataTypes ))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if (in_array( $files['0']['type'] , $dataTypes ))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    }
    function changeDir($files)
    {
        $uploaddir = '/var/www/public/uploads/';
        foreach ($files as $file)
        {
            $uploadfile = $uploaddir . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $uploadfile);
        }
    }
}
?>