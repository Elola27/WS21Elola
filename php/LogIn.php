<?php session_start(); 
    if (isset($_SESSION['rola'])){
        echo "<script type='text/javascript'> window.location='Layout.php' </script>";
    }    
?>
<!DOCTYPE html>
<html>
<head>
    <?php include '../html/Head.html'?>
    <?php include 'DbConfig.php'?>
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1" style="display: flex">
        <div>
            <form id="loginF" name="loginF" method="post">
                <!-- Eposta -->
                <label for="eposta">Eposta (*):</label>
                <input type="text" id="eposta" name="eposta"><br>

                <!-- Pasahitza -->
                <label for="pasahitza">Pasahitza (*):</label>
                <input type="password" id="pasahitza" name="pasahitza"><br>

                <!-- Galdera igorri -->
                <input type="submit" name="submit" id="submit" value="Saioa hasi"><br>
            </form>
            <?php
            
            if (!empty($_POST)){
                $datuak = $_POST;
                global $zerbitzaria, $erabiltzailea, $gakoa, $db;
                
                try{
                    $dsn = "mysql:host=$zerbitzaria;dbname=$db";
                    $dbh= new PDO($dsn,$erabiltzailea,$gakoa);
                    $stmt= $dbh->prepare("SELECT * FROM dbt51_user WHERE Eposta = ? ");
                    $stmt->bindParam(1,$datuak["eposta"]);

                    $stmt->execute();
                    $bezeroak=$stmt->fetchAll(PDO::FETCH_OBJ);
                    if ($bezeroak!=null){
                        foreach($bezeroak as $bezero){
                            if ($bezero->Eposta==$datuak["eposta"] && hash_equals($bezero->Pasahitza,crypt($datuak["pasahitza"],$bezero->Pasahitza)) && $bezero->Egoera=="Aktibo" ){
                                session_start();
                                $_SESSION['eposta']=$bezero->Eposta;
                                $_SESSION['irudia']=$bezero->Direktorioa;
                                $_SESSION['rola']=$bezero->Mota;
                                /*echo "<script> console.log('".$bezero->Eposta."')</script>";
                                echo "<script> console.log('".$bezero->Egoera."')</script>";
                                echo "<script> console.log('".$bezero->Pasahitza."')</script>";
                                echo "<script> console.log('".crypt($datuak["pasahitza"])."')</script>";*/
                                echo"<script> alert('Ongi etorri webgunera ".$tabladatuak[0]."') </script>";
                                echo "<script type='text/javascript'> window.location='Layout.php' </script>";
                            }else{
                                echo "<script> alert('Ez duzu baimenik erabiltzaile horrekin saioa hasteko!')</script>";
                                if (hash_equals($bezero->Pasahitza,crypt($datuak["pasahitza"],$bezero->Pasahitza))==false){
                                echo "<script> console.log('".$bezero->Eposta."')</script>";
                                echo "<script> console.log('".$bezero->Egoera."')</script>";
                                echo "<script> console.log('".$bezero->Pasahitza."')</script>";
                                //echo "<script> console.log('".crypt($datuak["pasahitza"])."')</script>";
                                }
                                
                            }
                        }

                    }else{
                        echo"<script> alert('Datu horiekin ez zaude erregistratua! Saiatu berriro!') </script>";
                        echo "<script> alert('".$bezero->Eposta==$datuak["eposta"]."')</script>";
                                echo "<script> alert('".$bezero->Egoera!="Aktibo"."')</script>";
                                echo "<script> alert('".hash_equals($bezero->Pasahitza, crypt($datuak["pasahitza"],$bezero->Pasahitza))."')</script>";
                    }
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
                $dbh=null;
                /*$nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

                if($nireSQLI->connect_error) {
                    die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
                }
                //$pass=crypt($datuak["pasahitza"]);
                //$pass==$tabladatuak[1]
                $ema = $nireSQLI->query("SELECT Eposta, Pasahitza, Direktorioa,Mota, Egoera FROM dbt51_user WHERE Eposta = '".$_POST["eposta"]."'");
                if (($tabladatuak = $ema->fetch_row()) != null) {
                    if ($datuak["eposta"] == $tabladatuak[0] &&  hash_equals($tabladatuak[1],crypt($datuak["pasahitza"],$tabladatuak[1]))&& $tabladatuak[4]!="Blokeatuta") {
                        session_start();
                        $_SESSION['eposta']=$tabladatuak[0];
                        $_SESSION['irudia']=$tabladatuak[2];
                        $_SESSION['rola']=$tabladatuak[3];
                        /*echo '<script> alert("Logeatu egin zara, '.$tabladatuak["eposta"].'") </script>';
                        header("location: Layout.php?eposta=".$tabladatuak[0]."&irudia=".$tabladatuak[2]);
                        echo"<script> alert('Ongi etorri webgunera ".$tabladatuak[0]."') </script>";
                        //echo "<script type='text/javascript'> window.location='Layout.php?eposta=".$tabladatuak[0]."&irudia=".$tabladatuak[2]."&rola=".$tabladatuak[3]."'</script>";
                        echo "<script type='text/javascript'> window.location='Layout.php' </script>";
                    } else {
                        echo"<script> alert('Datu horiekin ez zaude erregistratua! Saiatu berriro!') </script>";
                        //echo '<p style="color: red"> Zure erabiltzailea edo pasahitza ez dira zuzenak. </p>';
                    }
                } else {
                    echo '<p style="color: red"> Erabiltzailea ez da existitzen.</p>';
                }*/

            }
            ?>
        </div>
    </section>
    <?php include '../html/Footer.html' ?>
</body>
</html>