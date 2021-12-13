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

    <script type="text/javascript">
        function lortuGaldera(a){
        xhro = new XMLHttpRequest();
        xhro.onreadystatechange=function(){
        //alert("Galdera gehitzen");
            if (xhro.status==200){
                //document.getElementById("galderaEremua").innerHTML=xhro.responseText;
                var galdera=xhro.responseText;
                gal=galdera.split(";");
                document.getElementById("galderaeremua").innerHTML=gal[0];
            }
        }
        xhro.open("POST","selectQuestion.php",true);
        xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //xhro.send("gaia="+a+"&erantzunda="+b);
        //erantzundakoa=document.getElementById("ezkutua").val;
        //erantzundakoak=JSON.parse(erantzundakoa);
        xhro.send("gaia="+a);
        }
    </script>
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1" style="display: flex">
        <div>
                    <?php include 'DbConfig.php';

                        global $zerbitzaria, $erabiltzailea, $gakoa, $db;
                        $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

                        if($nireSQLI->connect_error) {
                            die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
                        }

                        $ema = $nireSQLI->query("SELECT DISTINCT Arloa FROM dbt51_questions");

                        for ($x = 0; $x < $ema->num_rows; $x++){
                            $ema->data_seek($x);
                            $datuak = $ema->fetch_assoc();
                            ?>
                            <input type='button' id='Gaia' value='<?php echo $datuak["Arloa"];?>' onclick="lortuGaldera('<?php echo $datuak['Arloa'];?>');">
                            <?php
                        }?>
        </div>
        <input type="hidden" id="ezkutua" value="0"/>
        <div id="galderaeremua">
            Hemen agertuko dira hautatutako gaiaren inguruko galderak
        </div>
    </section>
    <?php include '../html/Footer.html' ?>
</body>
</html>