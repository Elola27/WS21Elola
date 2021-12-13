<?php
    include 'DbConfig.php';

    $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);


    //AND GalderaID NOT IN ('".$str."')
    if ($nireSQLI->connect_error)
    {
        return "<b style='color: red'>DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error . "</b><br/>";
    }
    $str=implode(",",$_POST["erantzundakoak"]);
    $ema = "SELECT * FROM dbt51_questions WHERE Arloa='".$_POST["gaia"]."' ORDER BY RAND() LIMIT 1;";
    echo "<p>" . $sqlInsertQuestion . "</p>";
    if ($emaitza=$nireSQLI->query($ema))
    {
        echo '<b style="color: red">Errorea: ' . $nireSQLI->error . "</b><br/>";
    }else{
        for ($x = 0; $x < $emaitza->num_rows; $x++){
            $emaitza->data_seek($x);
            $datuak = $emaitza->fetch_assoc();
            //$emaitza=$datuak[0].";".$datuak[1].";".$datuak[2].";".$datuak[3].";".$datuak[4].";".$datuak[5].";".$datuak[6].";".$datuak[7].";".$datuak[8].";".$datuak[9].";".$datuak[10].";".$datuak[11];
            $emaitza=$datuak[0];
        }
        echo $emaitza;
    }
?>