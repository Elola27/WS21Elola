<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
 

    <script type="text/javascript">
        function zihurtatuEgokitasuna(a){
            var eposta,kodea,data,zatiak;
            alert(a);
            zatia="<?php 
                 include 'DbConfig.php';
                 $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
     
                 if($nireSQLI->connect_error) {
                     die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
                 }
                 $ema = $nireSQLI->query("SELECT berreskurapen_kode, iraungitzeData FROM dbt51_user WHERE Eposta = '".openssl_decrypt($_GET['i'],'aes128','WS21Elola')."'");
                 if (($tabladatuak = $ema->fetch_row()) != null) {
                     echo $tabladatuak[0].";".$tabladatuak[1];
                 }
                ?>";
            atalak=zatia.split(";");  
            //eposta=zatiak[0];
            //kodea=zatiak[1];
            //data=zatiak[2];
            alert(atalak[0]);
            alert(atalak[1]);
            alert(data);
            alert(document.getElementById("kodea").value);
            if (document.getElementById("kodea").value==kodea && data>=date('Y-m-d H:i:s')){
                var testua;
                testua="<form id=berria action='' method='post'>";
                testua+="<h1> Bete ezazu ondorengo hau kontuaren pasahitza aldatzeko</h1>";
                testua+="<input type='hidden' name='posta' value="+eposta+">";
                testua+="<label for ='pasahitz'> Pasahitz berria:</label> ";
                testua+="<input type='text' id='pasahitz' name='pasahitz'></br>";
                testua+="<label for ='kodea2'> Errepikatu pasahitza:</label> ";
                testua+="<input type='text' id='kodea2' name='kodea2'></br>"; 
                testua+="<input type='submit' id='submit' value='Aldatu pasahitza'>";       
                testua+="</form>"
                        
                document.getElementById("berreskuratu").innerHTML=testua;
            }else{
                alert("Emandako kodea ez da egokia");
            }
        }
    </script>
</head>
<body>
<?php include 'Menus.php'?>
  
  <section class="main" id="s1">
    <div id="berreskuratu">
        <label for ="kodea"> Sartu eman zaizun kodea:</label> </br>
        <input type="text" id="kodea" name="kodea"> 
        <input type="button" id="klik" value="Berreskuratu pasahitza" onclick="zihurtatuEgokitasuna('<?php echo openssl_decrypt($_GET['i'],'aes128','WS21Elola') ;?>')">
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>

<?php
    if (isset($_POST['pasahitz'])){
        $pasahitz=$_POST['pasahitz'];
        $pasahitzerrepikatu=$_POST['kodea2'];
        if (strcmp($pasahitz,$pasahitzerrepikatu)==0){
            include 'DbConfig.php';
            include 'DbConfig.php';
            $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

            if($nireSQLI->connect_error) {
                die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
            }
            $pass=crypt($pasahitz);
            $ema = $nireSQLI->query(" UPDATE dbt51_user SET Pasahitza='".$pass."' WHERE Eposta = '".$posta."'");
            if ($ema){
                echo "<script> alert('Zure pasahitza aldatu da, login pantailara eramango zaizu') </script>";
                echo "<script type='text/javascript'> window.location='LogIn.php' </script>";
            }
        }else{
            echo "<script> alert('Emadako pasahitzak ezberdinak dira') </script>";
        }
    }


//desenkriptatu eta lortu elementu bakoitza, konparatau eta zuzen badaude barrua

?>

                        
            <!--eposta=
                $dekrypt=$_GET["i"];
                $zatiak=openssl_decrypt($dekrypt,'aes128','WS21Elola');
                $atalak=explode(";",$zatiak);
                echo $zatiak[0];
        
            kodea=
                $dekrypt=$_GET["i"];
                $zatiak=openssl_decrypt($dekrypt,'aes128','WS21Elola');
                $atalak=explode(";",$zatiak);
                echo $zatiak[1];
            
            data = 
                $dekrypt=$_GET["i"];
                $zatiak=openssl_decrypt($dekrypt,'aes128','WS21Elola');
                $atalak=explode(";",$zatiak);
                echo $zatiak[2];
    
 