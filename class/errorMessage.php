<?php

class errorMessage
{
    function errorUserData($falseData)
    {
        echo "$falseData ist leer oder entspricht nicht den Anforderungen eines gesunden Menschenverstands";
        echo "<a href='./kleinanzeigen.php'>zur Hauptseite</a>";
        exit;
    }
    function errorPasswordNotEqual($passwort, $secPasswort)
    {
        echo "Die Passwörter: $passwort und $secPasswort stimmen nicht überein";
        echo "<a href='./acc_create.php'>Zurück</a>";
        exit;
    }
    function errorEmailExists($email)
    {
        echo "<p>Ein Account mit der Email: $email existiert schon.</p>";
        echo "<a href='./acc_create.php'>Zurück</a>";
        exit;
    }
    function errorInputIsEmpty()
    {
        echo "Einige Felder sind nicht ausgefüllt. Bitte beachten sie, dass alle Felder Pflichtfelder sind";
        echo "<a href='./kleinanzeigen.php'>Zurück</a>";
        exit;
    }
    function emailDoesntExists($email)
    {
        echo "Die Email Adresse: $email ist nicht in der DB vorhanden";
        echo "<a href='./login.php'>Zurück</a>";
        exit;
    }
    function errorPasswordFalse()
    {
        echo "Das eingebene Passwort ist falsch";
        echo "<a href='./login.php'>Zurück</a>";
        exit;
    }
    function messageLoggout($userName)
    {
        echo "<p>Der Benutzer $userName wird ausgeloggt</p>";
        echo "<a href='./kleinanzeigen.php'>zur Hauptseite</a>";
        exit;
    }
    function errortitleExists($titel)
    {
        echo "Der Titel $titel existiert schon";
        echo "<a href='./annonce_create.php'>Zurück</a>";
        exit;
    }
}