<?php

function ezabatu($a){
    include 'DbConfig.php';

    $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

    if ($nireSQLI->connect_error)
    {
        return "<b style='color: red'>DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error . "</b><br/>";
    }

    $sqlInsertQuestion = "DELETE FROM dbt51_user  WHERE Eposta='$a'";
    echo "<p>" . $sqlInsertQuestion . "</p>";

    if (!$nireSQLI->query($sqlInsertQuestion))
    {
        return '<b style="color: red">Errorea: ' . $nireSQLI->error . "</b><br/>";
    }
}
echo "<p>" . ezabatu($_POST['eposta'])."</p>";
?>