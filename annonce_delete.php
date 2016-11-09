<?php
require("class/database.php");
session_start();
$db = new database();
$stmtgetAnnoncen = $db->getConnection()->prepare("select titel from annonce;");
$stmtgetAnnoncen->execute();
$annoncen = $stmtgetAnnoncen->fetchall();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Annoncen löschen</title>
    <link rel="stylesheet" type="text/css" href="w3-schools.css">
    <link rel="stylesheet" type="text/css" href="kleinanzeigen.css">
</head>
<body>
<header>
    <h1 class="w3-indigo">Annoncen Löschen</h1>
    <form action="kleinanzeigen.php" method="post">
        <div class="w3-row">
            <button type="submit" name="send" class="w3-btn-block w3-indigo w3-quarter backbutton">Zurück</button>
        </div>
    </form>
</header>
<main class="w3-margin">
    <div class="divPadding w3-row">
        <p class="w3-large">Hier können sie ihre Annoncen löschen.</p>
    </div>
    <div class="divPadding">
        <form action="deleteAnnonce.php" method="POST" class="formPadding">
                <?php
                foreach ($annoncen as $items)
                {
                    $item=$items['titel'];
                    echo "<input type='radio' name='annonce' value='$item' class='w3-row w3-large w3-check w3-indigo'>$item</br></input>";
                }
                ?>

    </div>
    <div class="w3-row divPadding">
        <button type='submit' name='$item' value='$item' class='w3-btn-block w3-indigo'>Löschen</button>
    </div>
    </form>
</main>
</body>
</html>
