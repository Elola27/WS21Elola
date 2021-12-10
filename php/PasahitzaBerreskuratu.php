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
                $kodea=md5($posta).rand(10);
                $message.="Kodea honakoa da:".$kodea;
                $timestamp      = time() + 60 * 60 * 24;
                $iraungi=date("Y-m-d H:i:s",$timestamp);
                $kripto=$posta.";".$kodea.";".$iraungi;
                $kriptografiatua=openssl_encrypt($kripto,'aes128','WS21Elola');
                $message.="<a href='sw.ikasten.io/~oelola001/WS21Elola/php/berreskurapena.php?i=.$kriptografiatua'";
                $mail=mail($posta,'Pasahitz berreskurapena',$message);
                
                //$ema2=$nireSQLI->query("UPDATE dbt51_user SET berreskurapen_kode='".$kodea."',iraungitzeData='".date("Y-m-d H:i:s",$timestamp)."' WHERE Eposta='".$posta."'");
                if($mail){
                    echo "<script> alert('".$kodea."')</script>";
                    echo "<script> alert('".$posta."')</script>";
                    echo "<script> alert('".$iraungi."')</script>";
                    echo "<script> alert(Kodea bidalil da')</script>";

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