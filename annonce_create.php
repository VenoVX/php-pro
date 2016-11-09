<?php
    require("class/database.php");
    $db = new database();
    $stmtgetRubrik = $db->getConnection()->prepare("select beschreibung from rubrik;");
    $stmtgetRubrik->execute();
    $rubrik = $stmtgetRubrik->fetchall();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Neue Annonce</title>
    <link rel="stylesheet" type="text/css" href="w3-schools.css">
    <link rel="stylesheet" type="text/css" href="kleinanzeigen.css">
</head>
<body>
<header class="w3-center">
    <h1 class="w3-indigo">Neue Annonce erstellen</h1>
    <form action="kleinanzeigen.php" method="post">
        <div class="w3-row">
            <button type="submit" name="send" class="w3-btn-block w3-indigo w3-quarter backbutton">Zurück</button>
        </div>
    </form>
</header>
<main class="w3-margin">
    <form action="createAnnonce.php" method="post" enctype="multipart/form-data">
        <div class="w3-row divPadding">
            <label for="annonceName">
                Titel
            </label>
            <input type="text" name="titel" id='titel'  class="w3-input">
        </div>
        <div class="w3-row divPadding">
            <label for="rubrik">
                Rubrik
            </label>
            <select name="rubrik" id="rubrik" size="1" class="w3-select">
                <?php
                    foreach ($rubrik as $items)
                    {
                        $item=$items['beschreibung'];
                        echo "<option>$item</option>";
                    }
                ?>
            </select>
        </div>
        <div class="w3-row divPadding">
            <label for="preis">
                Preis in €
            </label>
            <input type="text" name="preis" id='preis'  class="w3-input">
        </div>
        <div class="w3-row divPadding">
            <label for="beschreibung">
                Beschreibung
            </label>
            <textarea rows="5" cols="50" name="beschreibung" id="beschreibung" class="w3-input"></textarea>
        </div>
        <div class="w3-row divPadding">
            <label for="bild1">
                Bild
            </label>
            <input type="file" name="bild1" id='bild1'  class="upload">
        </div>
        <div class="w3-row divPadding">
            <label for="bild2">
                Bild
            </label>
            <input type="file" name="bild2" id='bild2'  class="upload">
        </div>
        <div class="w3-row divPadding">
            <button type="submit" name="send" class="w3-btn-block w3-indigo">Abschicken</button>
        </div>
    </form>

</main>
</body>
</html>