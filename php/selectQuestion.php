<?php
    session_start();
    include 'DbConfig.php';

    $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

    //var_dump($_POST["erantzundakoak"]);
    //AND GalderaID NOT IN ('".$str."')
    if ($nireSQLI->connect_error)
    {
        return "<b style='color: red'>DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error . "</b><br/>";
    }
    
    //$str=$_POST["erantzundakoak"];
    
    /*for ($i=0; $i<count($str);$i++){
        echo "<script> console.log('".$str[$i]."')</script>";
    }*/
    /*if ($_POST['erantzundakoak']!=null){
    $str=implode(",",$_POST["erantzundakoak"]);
        $str=$_POST["erantzundakoak"];
        $ema = "SELECT * FROM dbt51_questions WHERE Arloa='".$_POST["gaia"]."'AND GalderaID NOT IN ('".$str."') ORDER BY RAND() LIMIT 1;";
    }else{
         $ema = "SELECT * FROM dbt51_questions WHERE Arloa='".$_POST["gaia"]."' ORDER BY RAND() LIMIT 1;";
    }*/
    $gaia=$_POST["gaia"];
    $str=$_POST["erantzundakoak"];
    $str=str_replace(',', "','",$str);
    /*if ($str!=""){
        $str=implode("', '",$_POST["erantzundakoak"]);
    }*/
    //$str=implode(",",$str);
    //$str=json_encode($str);
    //$str=str_replace('"[\"',"','",$str);
    //$str=str_replace('"]/"',"','",$str);
    //$str=json_encode($_SESSION["erantzundakoak"]);
    $ema = "SELECT * FROM dbt51_questions WHERE Arloa =".$gaia." AND GalderaID NOT IN ('" .$str. "') ORDER BY RAND() LIMIT 1";
   
    //echo "<p>" . $sqlInsertQuestion . "</p>";
    if (!$emaitza=$nireSQLI->query($ema))
    {
        echo "<script> console.log('".$nireSQLI->error."')</script>";
        echo '<b style="color: red">Errorea:'. $nireSQLI->error . "</b><br/>";
        echo $nireSQLI->error;
    }else{
        if ($emaitza->num_rows==1){
            $emaitza->data_seek(0);
            $datuak = $emaitza->fetch_assoc();
            $emaitz=$datuak["GalderaID"].";".$datuak["Eposta"].";".$datuak["Galdera"].";".$datuak["erZuzena"].";".$datuak["erOkerra1"].";".$datuak["erOkerra2"].";".$datuak["erOkerra3"].";".$datuak["Argazkia"].";".$ema;
        }else{
            $emaitz="Ez dago galdera gehiago datu-basean";
        }
            
            //$emaitza=$datuak[0];
        echo $emaitz;
    }
?>