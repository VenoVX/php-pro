<?php
require("class/database.php");
$db = new database();
#Get Rubrik Beschreibung
$stmtgetRubrik = $db->getConnection()->prepare("select id from rubrik where beschreibung like :beschreibung");
$stmtgetRubrik->bindParam(':beschreibung', $_POST['rubrik']);
$stmtgetRubrik->execute();
$rubrik = $stmtgetRubrik->fetch();

#Get Anonncen where Rubrik is correct
$stmtgetAnnoncen = $db->getConnection()->prepare("select titel, id from annonce where FSRubrik like :fsrubrik;");
$stmtgetAnnoncen->bindParam(':fsrubrik', $rubrik['id']);
$stmtgetAnnoncen->execute();
$annoncen = $stmtgetAnnoncen->fetchall();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meine Annonce</title>
    <link rel="stylesheet" type="text/css" href="w3-schools.css">
    <link rel="stylesheet" type="text/css" href="kleinanzeigen.css">
</head>
<body>
<header class="">
    <h1 class="w3-indigo">Meine Annoncen</h1>
    <form action="kleinanzeigen.php" method="post">
        <div class="w3-row">
            <button type="submit" name="send" class="w3-btn-block w3-indigo w3-quarter backbutton">Zurück</button>
        </div>
    </form>
</header>
<main class="w3-margin">
    <div class="w3-row divPadding">
        <div class="divPadding w3-row">
            <ul class="w3-ul w3-large">
                <?php
                foreach ($annoncen as $items)
                {
                    $item=$items['titel'];
                    echo "<li class='w3-indigo w'><a href=\"annonce.php?id=" . $items['id'] . "\">$item</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</main>
</body>
</html>
