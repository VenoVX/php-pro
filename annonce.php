<?php
require("class/database.php");
session_start();
$db = new database();
#Get Annoncen Inhalt
$stmtgetAnnoncen = $db->getConnection()->prepare("select id, titel, beschreibung, preis, FSRubrik, FSUser from annonce where id like :id;");
$stmtgetAnnoncen->bindParam(':id', $_GET['id']);
$stmtgetAnnoncen->execute();
$annonce = $stmtgetAnnoncen->fetch();

#Get Rubrik Beschreibung
$stmtgetRubrik = $db->getConnection()->prepare("select beschreibung from rubrik where id like :fsrubrik");
$stmtgetRubrik->bindParam(':fsrubrik', $annonce['FSRubrik']);
$stmtgetRubrik->execute();
$rubrik = $stmtgetRubrik->fetch();

#Get Bilder
$stmtgetBilder = $db->getConnection()->prepare("Select dtname from bilder where FSAnnonce like :idannonce");
$stmtgetBilder->bindParam(':idannonce', $annonce['id']);
$stmtgetBilder->execute();
$bilderName = $stmtgetBilder->fetchall();

#Get User
$stmtgetUser = $db->getConnection()->prepare("Select email from user where id like :userid");
$stmtgetUser->bindParam(':userid', $annonce['FSUser']);
$stmtgetUser->execute();
$user = $stmtgetUser->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Annonce</title>
    <link rel="stylesheet" type="text/css" href="w3-schools.css">
    <link rel="stylesheet" type="text/css" href="kleinanzeigen.css">
</head>
<body>
<header class="w3-center">
    <h1 class="w3-indigo">Annonce</h1>
    <div class="w3-row">
        <form action='kleinanzeigen.php' method='post'>
            <button type="submit" name="send" class="w3-btn-block w3-indigo w3-quarter backbutton">Zurück</button>
        </form>
        <?php
            if(isset($_GET['change']) || !empty($_GET['change']))
            {
                $_SESSION['annonce'] = $annonce;
                echo "<form action='annonce_change.php' method='post'>";
                echo "<button type='submit' name='change' class='w3-btn-block w3-indigo w3-quarter backbutton'>ändern</button>";
                echo "</form>";
            }
        ?>
        </div>
</header>
<main class="w3-margin">
        <?php
        if(!isset($_SESSION['userid']) || empty($_SESSION['userid']))
        {
            $userName = $user['email'];
            echo "<div class='divPadding w3-row'>";
            echo "<h2 class='w3-text-indigo'>Benutzer</h2>";
            echo "<p class='w3-text'>$userName</p>";
            echo "</div>";
        }
        ?>
        <div class="w3-row divPadding">
            <h2 class="w3-text-indigo">Titel</h2>
            <p class="w3-text"><?php echo $annonce['titel'];?></p>
        </div>
        <div class="w3-row divPadding">
            <h2 class="w3-text-indigo">Rubrik</h2>
            <p><?php echo $rubrik['beschreibung'];?></p>
        </div>
        <div class="w3-row divPadding">
            <h2 class="w3-text-indigo">Preis</h2>
            <p><?php echo $annonce['preis'];?>€</p>
        </div>
        <div class="w3-row divPadding">
            <h2 class="w3-text-indigo">Beschreibung</h2>
            <p><?php echo $annonce['beschreibung'];?></p>
        </div>
        <div class="w3-row">
            <?php
            foreach ($bilderName as $row)
            {
                $bildName = $row['dtname'];
                echo "<div class='w3-half divPadding'>";
                echo "<img src='../uploads/$bildName'  alt='Bild' class='w3-image'>";
                echo "</div>";
            }
            ?>
        </div>
</main>
</body>
</html>