<?php //session_start();   
    /*if (isset($_SESSION['rola'])){
        echo "<script type='text/javascript'> window.location='Layout.php' </script>";
    }*/   
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-
1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <?php include '../html/Head.html'?>
    <?php include 'DbConfig.php'?>

    <script type="text/javascript">
        var elems1 ="<?php
                if (!isset($_SESSION['erantzundakoak'])){
                    echo "[]";
                }else{
                    echo implode(", " ,$_SESSION["erantzundakoak"]);
                }?>;";
        function lortuGaldera(a){ 
        elems=null; 
        
        xhro = new XMLHttpRequest();
        xhro.onreadystatechange=function(){
        //alert("Galdera gehitzen");
            if (xhro.status==200 && xhro.readyState==4){
                //document.getElementById("galderaEremua").innerHTML=xhro.responseText;
                var galdera=xhro.responseText;
                gal=galdera.split(";");
                if (gal != "Ez dago galdera gehiago datu-basean") {
                //document.getElementById("galderaeremua").innerHTML=gal[0];
                document.getElementById("Konprobatu").disabled=false;
                document.getElementById("hautatugaia").innerHTML=a;
                document.getElementById("GaiEzkutua").value=a;
                document.getElementById("galderatestua").innerHTML=gal[0]+".-"+gal[2];
                if (gal[8]===""){
                    document.getElementById("irudia").src="../images/default_argazkia.png";
                }else{
                    document.getElementById("irudia").src=gal[7];
                }
                document.getElementById("gaiak").style.visibility="hidden";
                document.getElementById("Egile").innerHTML=gal[1];
                document.getElementById("radiobutton").innerHTML='<input type="radio" id="ona" name="fav_language" value='+gal[3]+'>'+
                        '<label for="ona">'+gal[3]+'</label><br>'+
                        '<input type="radio" id="txarra" name="fav_language" value='+gal[4]+'>'+
                        '<label for="txarra">'+gal[4]+'</label><br>'+
                        '<input type="radio" id="txarra" name="fav_language" value='+gal[5]+'>'+
                        '<label for="txarra">'+gal[5]+'</label></br>'+
                        '<input type="radio" id="txarra" name="fav_language" value='+gal[6]+'>'+
                        '<label for="txarra">'+gal[6]+'</label>';
                xhro1 = new XMLHttpRequest();
                xhro1.onreadystatechange=function(){
                    if (xhro1.status==200 && xhro1.readyState==4){
                         alert(xhro1.responseText);
                        elems1=xhro1.responseText;
                        alert(elems1);
                    }
                }
                xhro1.open("POST","aldatuSesioBalioa.php",true);
                xhro1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhro1.send("id="+gal[0]);
            }else{
                alert(xhro.responseText);
                document.getElementById("Hurrengoa").disabled=true;
                document.getElementById("Konprobatu").disabled=true;
                //document.getElementById("ona").style.disabled=true;
                document.getElementById("radiobutton").disabled=true;
                document.getElementById("erantzuna").innerHTML="";
                document.getElementById("irudia").innerHTML="";
                document.getElementById("Egile").innerHTML="";
            }
            }
        }
        //elems=JSON.parse(document.getElementById("ezkutua").value);
        /*elems=<?php /*session_start();
        if (!isset($_SESSION['erantzundakoak'])){
            echo json_encode([]);
        }/*else{
            echo json_encode($_SESSION['erantzundakoak']);
        }*/?>;+*/
            //alert("Hutsa da");
        elems=<?php 
                if (!isset($_SESSION['erantzundakoak'])){
                    echo "[]";
                }else{
                    echo implode(", " ,$_SESSION["erantzundakoak"]);
                }?>; 
        if (elems1!=null){
            elems=elems1;
        }
        alert(elems1);
        alert(elems);
        xhro.open("POST","selectQuestion.php",true);
        xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //xhro.send("gaia="+a+"&erantzunda="+b);
        //erantzundakoa=document.getElementById("ezkutua").val;
        //erantzundakoak=JSON.parse(erantzundakoa);
        xhro.send("gaia='"+a+"'&erantzundakoak="+elems);
        }

        function lortuHurrengoa(){
            b=document.getElementById("GaiEzkutua").value;
            //alert(b);
            lortuGaldera(b);
            document.getElementById("Hurrengoa").disabled=true;
        }

        function zihurtatuEmaitza(){
            document.getElementById("Hurrengoa").disabled=false;
            if (document.getElementById("ona").checked === true){
                document.getElementById("erantzuna").innerHTML="Zorionak, asmatu duzu galderaren erantzuna";
                x=parseInt(document.getElementById("Asmatuak").innerHTML,10);
                document.getElementById("Asmatuak").innerHTML= x+ 1;
            }else{
                console.log(document.getElementById("ona").value);
                document.getElementById("erantzuna").innerHTML="Ez duzu asmatu, erantzun zuzena honakoa da:<br>" + document.getElementById("ona").value;
                x=parseInt(document.getElementById("Hutsak").innerHTML,10);
                document.getElementById("Hutsak").innerHTML= x+ 1;
            }
            document.getElementById("Konprobatu").disabled=true;
            //xhro1 = new XMLHttpRequest();
            /*id=document.getElementById("galderatestua").innerHTML
            id=id.split(".-");
            id=id[0];
            /*xhro1.open("POST","aldatuSesioBalioa.php",false);
            xhro1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhro1.send("id="+id);
            $.ajax({
                type:"POST",
                url:"aldatuSesioBalioa.php",
                data:"id="+id,
                success:function(){
                    alert("Ongi joan da");
                },
                async:false,
            });*/

        }

        function amaituSaiakera(){
            asmatuak=parseInt(document.getElementById("Asmatuak").innerHTML);
            hutsak=parseInt(document.getElementById("Hutsak").innerHTML);
            //document.getElementById("gaiak").style.visibility="visible";
            testua="Hauek izan dira partida honen emaitzak:\n";
            testua+="Asmatuak: " + asmatuak + "\n";
            testua+="Hutsak: " + hutsak;
            document.getElementById("gaiak").style.visibility="visible";
            document.getElementById("Hutsak").innerHTML=0;
            document.getElementById("Asmatuak").innerHTML=0;
            document.getElementById("hautatugaia").innerHTML="";
            alert(testua);

        }
    </script>
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1" style="display: block">
        <div id="gaiak">
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
        Hautatutako gaia: <span id="hautatugaia"></span>
        <p>
        <b> Asmatuak: <span id="Asmatuak">0</span></b>
        <b> Huts egindakoak:<span id="Hutsak">0</span> </b>    
        </p>            
        <input type="hidden" id="GaiEzkutua"/>
        <input type="hidden" id="ezkutua" value="[]"/>
        <input type="button" value="Amaitu saiakera" onclick="amaituSaiakera();">
        <div id="galderaeremua" width="100%" display="inline-block">
                 <div class="row">
                    <div class="col">
                        <div id="galderatestua">Galdera testua</div>
                        <div id="radiobutton">
                        <input type="radio" id="html" name="fav_language" value="HTML" disabled>
                        <label for="html">Erantzun 1</label><br>
                        <input type="radio" id="css" name="fav_language" value="CSS" disabled >
                        <label for="css">Erantzun 2</label><br>
                        <input type="radio" id="javascript" name="fav_language" value="JavaScript" disabled>
                        <label for="javascript">Erantzun 3</label></br>
                        <input type="radio" id="a" name="fav_language" value="JavaScript" disabled>
                        <label for="a">Erantzun 4</label>
                        </div>
                        </br></br>
                        <span id="erantzuna"> Textu honen tokian adieraziko da zure erantzuna zuzena izan den ala ez</span>
                    </div>
                    <div class="col">
                        <img src="../images/a.png" id="irudia" width="25%">
                        <p> Irudiaren deskripzioa </p>
                        Egilea:<span id="Egile">Adibidea</span>
                    </div>
                </div>
                <p></p>
                <input type="button" id="Konprobatu" value="Konprobatu erantzuna" onclick="zihurtatuEmaitza()" disabled>
                <input type="button" id="Hurrengoa" value="Hurrengo galdera" onclick="lortuHurrengoa()" disabled>
        </div>
    </section>
    <?php include '../html/Footer.html' ?>
</body>
</html>