<?php
require_once("database.php");
require_once("errorMessage.php");

class rubrik
{
    private $db;
    private $error;


    function __construct()
    {
        $this->db = new database();
        $this->error = new errorMessage();
    }
    function getIDRubrik($rubrikName)
    {
        $stmtGetFS = $this->db->getConnection()->prepare("select id from rubrik where beschreibung like :beschreibung;");
        $stmtGetFS->bindParam(':beschreibung', $rubrikName);
        $stmtGetFS->execute();
        $idrow = $stmtGetFS->fetch();
        return $idrow['id'];
    }
}