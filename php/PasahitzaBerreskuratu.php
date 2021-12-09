<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
 
</head>
<body>
<?php include 'Menus.php'?>
  
  <section class="main" id="s1">
    <div>
        <form id="berreskurapen" action="" method="post" >
            <label for ="posta"> Sartu zure erabiltzailearen posta elektronikoa:</label> </br>
            <input type="text" id="posta" name="posta"> 
            <input type="submit" id="submit" value="Bidali berreskurapen kodea">
        </form>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>

<?php 
    if (isset($_POST["posta"])){
        $posta=$_POST["posta"];
        if ($posta!= ""){
            include 'DbConfig.php';
            $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

            if($nireSQLI->connect_error) {
                die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
            }
            //$pass=crypt($datuak["pasahitza"]);                //$pass==$tabladatuak[1]
            $ema = $nireSQLI->query("SELECT * FROM dbt51_user WHERE Eposta = '".$posta."'");
            if (($tabladatuak = $ema->fetch_row()) != null) {
                //echo "<script> alert('".$posta."')</script>";
                $message="Mezu hau eskatu da zure Quizz-eko kontuko pasahitza berrezartzeko. \n";
                $message.="Jarraian agertzen den link-ean klik eginik hemen jasoko duzun kodea sartu eta pasahitza aldatzeko aukera emango dizu \n";
                $message.="Kodea honakoa da:";
                $message.="<a href='sw.ikasten.io/~oelola001/WS21Elola/php/PasahitzaBerreskuratu.php?'";
                //$headers="From: laguntza@localhost.com";
                //$laguntza="laguntza@localhost.com";
                $mail=mail($posta,'Pasahitz berreskurapena',$message);
                if($mail){
                    echo "<script> alert('Kodea bidalil da')</script>";
                }else{
                    $errorMessage= error_get_last()['message'];
                    echo "<script> console.log('".$errorMessage."')</script>";
                }
            }else{
                echo "<script> alert('Posta elektroniko horretarako erregistrorik ez dago') </script>";
            }
        }else{
            echo "<script> alert('Eremu hutsa bidali da, mesedez bete') </script>";
        }
    }
//lortu beharrezko baliok, encryptatu eta mezua mail bidali, link-a encryptauta eongoa

// bi elementuk separauta . baten bidez, gero encryptatu ta link-en sartu 
//stackoverflow.com/questions/4570980/generating-a-random-code-in-php

?>