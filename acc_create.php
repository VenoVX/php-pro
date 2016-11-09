<?php
require("class/database.php");
$db = new database();
$stmtgetOrte = $db->getConnection()->prepare("select DISTINCT ort  from wohnort;");
$stmtgetOrte->execute();
$orte = $stmtgetOrte->fetchall();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="w3-schools.css">
    <link rel="stylesheet" type="text/css" href="kleinanzeigen.css">


    <title>Account Erstellen</title>
  </head>
  <body>
     <header class="w3-center">
       <h1 class="w3-indigo">Account Erstellen</h1>
       <form action="kleinanzeigen.php" method="post">
         <div class="w3-row">
           <button type="submit" name="send" class="w3-btn-block w3-indigo w3-quarter backbutton">Zurück</button>
         </div>
       </form>
     </header>
  <main class="w3-margin">
    <form action="createAcc.php" method="post">
      <div class="w3-row">
        <div class="w3-half divPadding">
          <label for="frName" class="w3-margin-bottom">
            Vorname
          </label>
          <input type="text" name="frName" id='frName' placeholder="Max" class="w3-input">
        </div>
        <div class="w3-half divPadding">
          <label for="secName" class="">
            Nachname
          </label>
          <input type="text" name="secName" id='secName' placeholder="Mustermann" class="w3-input">
        </div>
      </div>
      <div class="w3-row divPadding">
        <label for="email">
          E-mail Adresse
        </label>
        <input type="text" name="email" id='email' placeholder="max.mustermann@gmail.de" class="w3-input">
      </div>
      <div class="w3-row">
        <div class="w3-half divPadding">
          <label for="password">
            Passwort
          </label>
          <input type="password" name="password" id='password' placeholder="********" class="w3-input">
        </div>
        <div class="w3-half divPadding">
          <label for="secPassword">
            Passwort erneut eingeben
          </label>
          <input type="password" name="secPassword"  id='secPassword' placeholder="********" class="w3-input">
        </div>
      </div>
      <div class="w3-row">
        <div class="w3-twothird divPadding">
          <label for="street">
            Straße
          </label>
          <input type="text" name="street" id='street' placeholder="Berslauer Str." class="w3-input">
        </div>
        <div class="w3-third divPadding">
          <label for="houseNumber">
            Hausnummer
          </label>
          <input type="text" name="houseNumber" id='houseNumber' placeholder="31" class="w3-input">
        </div>
      </div>
      <div class="w3-row divPadding">
        <select name="wohnort" id="wohnort" size="1" class="w3-select">
          <?php
          foreach ($orte as $items)
          {
            $item=$items['ort'];
            echo "<option>$item</option>";
          }
          ?>
          </select>
      </div>
      <div class="w3-row divPadding">
        <button type="submit" name="send" class="w3-btn-block w3-indigo">Abschicken</button>
      </div>
    </form>

  </main>
  </body>
</html>
