<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
 

    <script type="text/javascript">
        function zihurtatuEgokitasuna(){
            if (document.getElementById("kodea").value=="kodea"){
                var testua;
                testua="<form id=berria action='' method='post'>";
                testua+="<h1> Bete ezazu ondorengo hau kontuaren pasahitza aldatzeko</h1>";
                testua+="<label for ='kodea'> Pasahitz berria:</label> ";
                testua+="<input type='text' id='kodea' name='kodea'></br>";
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
        <form id="berreskurapen" action='' method="post" >
            <label for ="posta"> Sartu eman zaizun kodea:</label> </br>
            <input type="text" id="kodea" name="kodea"> 
        </form>
        <input type="button" id="submit" value="Berreskuratu pasahitza" onclick="zihurtatuEgokitasuna()">
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>

<?php
    if (isset($_POST['kodea'])){
        $pasahitz=$_POST['kodea'];
        $pasahitzerrepikatu=$_POST['kodea2'];
        if (strcmp($pasahitz,$pasahitzerrepikatu)==0){
            include 'DbConfig.php';
            include 'DbConfig.php';
            $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

            if($nireSQLI->connect_error) {
                die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
            }
            //$pass=crypt($datuak["pasahitza"]);                //$pass==$tabladatuak[1]
            $ema = $nireSQLI->query(" UPDATE dbt51_user SET Pasahitza=".$pasahitz." WHERE Eposta = '".$posta."'");
        }else{
            echo "<script> alert('Emadako pasahitzak ezberdinak dira') </script>";
        }
    }


//desenkriptatu eta lortu elementu bakoitza, konparatau eta zuzen badaude barrua

?>

