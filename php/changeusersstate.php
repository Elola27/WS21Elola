<?php

function aldatuegoera($a,$b){
    include 'DbConfig.php';

    $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

    if ($nireSQLI->connect_error)
    {
        return "<b style='color: red'>DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error . "</b><br/>";
    }

    $egoera;
    if($b=="ON"){
        $egoera="Aktibo";
    }else{
        $egoera="Blokeatuta";
    }
    $sqlInsertQuestion = "UPDATE dbt51_user SET Egoera='$egoera' WHERE Eposta='$a'";
    echo "<p>" . $sqlInsertQuestion . "</p>";

    if (!$nireSQLI->query($sqlInsertQuestion))
    {
        return '<b style="color: red">Errorea: ' . $nireSQLI->error . "</b><br/>";
    }
}
echo "<p>" . aldatuegoera($_POST['eposta'],$_POST['egoera'])."</p>";
?>