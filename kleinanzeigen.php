<?php
require("class/database.php");
session_start();
$db = new database();
$stmtgetRubrik = $db->getConnection()->prepare("select beschreibung from rubrik;");
$stmtgetRubrik->execute();
$rubrik = $stmtgetRubrik->fetchall();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kleinanzeigen</title>
    <link rel="stylesheet" type="text/css" href="w3-schools.css">
    <link rel="stylesheet" type="text/css" href="kleinanzeigen.css">
</head>
<body>
    <header>
        <h1 class="w3-indigo">Kleinanzeigen</h1>
    </header>
    <main>
        <div class="w3-row">
            <form action="showAnnoncen.php" method="POST" class="w3-col l8 m8 s12" id="search">
                <div class="w3-twothird">
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
                <div class="w3-third">
                    <button type="submit" name="sendSearch" class=" w3-indigo w3-btn">Suche</button>
                </div>
            </form>
            <?php
        if(isset($_SESSION['userid']) || !empty($_SESSION['userid']))
        {
            echo "<div class=\"dropdown w3-col l2 m2 s12\">
                  <button class=\"dropbtn w3-indigo w3-btn-block\">Annoncen</button>
                  <div class=\"dropdown-content\">
                <a href=\"annonce_create.php\"class=\"w3-indigo\">Neue Annonce</a>
                <a href=\"myAnnonce.php\" class=\"w3-indigo\">Meine Annonce</a>
                <a href=\"annonce_delete.php\" class=\"w3-indigo\">Annonce löschen</a>
                </div>
                </div>
                <form action=\"logout.php\" method=\"POST\" class=\"w3-col l2 m2 s12 formPadding\">
                <button type=\"submit\" name=\"loggout\" class=\"w3-btn-block w3-indigo\">Logout</button>
        </form>";
        }
        else
        {
            echo "<form action=\"login.html\" method=\"POST\" class=\"w3-col l2 m2 s12 formPadding\">
                <button type=\"submit\" name=\"logIn\" class=\"w3-btn-block w3-indigo \">Anmelden</button>
                </form>
                <form action=\"acc_create.php\" method=\"POST\" class=\"w3-col l2 m2 s12 formPadding\">
                <button type=\"submit\" name=\"register\" class=\"w3-btn-block w3-indigo \">Registrieren</button>
                </form>";
        }
            ?>
        </div>
    </main>
</body>
</html>