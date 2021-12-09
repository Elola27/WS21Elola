<?php session_start(); 
    if (!isset($_SESSION['rola'])){
        echo "<script type='text/javascript'> window.location='Layout.php' </script>";
    }else{
        if ($_SESSION['rola']!="Admin"){
            echo "<script type='text/javascript'> window.location='Layout.php' </script>";
        }
    }     
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script type="text/javascript">
      function aldatuEgoera(a){
        balioak=a.split(",");
        xhro = new XMLHttpRequest();
        xhro.onreadystatechange=function(){
        //alert("Galdera gehitzen");
            if (xhro.status==200){
            //document.getElementById("emaitza").innerHTML=xhro.responseText;
                location.reload();
                //alert("Ongi joan da");
            }
        }
        xhro.open("POST","changeusersstate.php",true);
        xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhro.send("eposta="+balioak[0]+"&egoera="+balioak[1]);
        }

    function ezabatu(a){
        xhro = new XMLHttpRequest();
        xhro.onreadystatechange=function(){
        //alert("Galdera gehitzen");
            if (xhro.status==200){
            //document.getElementById("emaitza").innerHTML=xhro.responseText;
                location.reload();
                //alert("Ongi joan da");
            }
        }
        xhro.open("POST","removeUser.php",true);
        xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhro.send("eposta="+a);
        }
  </script>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1" style="display: flex">
        <div style="overflow-y: scroll; overflow-x: scroll">
            <table style="width:100%; border-collapse:collapse;" >
                <thead>
                    <th>Eposta</th>
                    <th>Gakoa</th>
                    <th>Egoera</th>
                    <th>Irudia</th>
                    <th>Permutatu</th>
                    <th>Ezabatu</th>
                </thead>
                <tbody>
                    <?php include 'DbConfig.php';
                    //function taulaSortu() {
                        global $zerbitzaria, $erabiltzailea, $gakoa, $db;
                        $nireSQLI = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

                        if($nireSQLI->connect_error) {
                            die("DB-ra konexio bat egitean errore bat egon da: " . $nireSQLI->connect_error);
                        }

                        $ema = $nireSQLI->query("SELECT Eposta, Pasahitza, Egoera, Irudia FROM dbt51_user WHERE Eposta!='admin@ehu.es'");

                        for ($x = 0; $x < $ema->num_rows; $x++){
                            $ema->data_seek($x);
                            $datuak = $ema->fetch_assoc();
                            echo "<tr>";
                            echo "<td>" . $datuak['Eposta'] . "</td>";
                            echo "<td>" . $datuak['Pasahitza'] . "</td>";
                            echo "<td id='egoera'>" . $datuak['Egoera'] . "</td>";
                            if ($datuak['Irudia'] != null) {
                                echo "<td>" . '<img src="data:image/*;base64,' . base64_encode($datuak['Irudia']) . '" height=75 width=75"/>' . "</td>";
                            } else {
                                echo "<td>" . '<img src="../images/default_argazkia.png" height=75 width=75"/>' . "</td>";
                            }?>
                            <td> <input type='button' id='Permutatu' value='<?php if ($datuak['Egoera']=="Aktibo") echo "ON"; else echo "OFF"?>' onclick="aldatuEgoera('<?php if ($datuak['Egoera']=='Aktibo') echo $datuak['Eposta'].',OFF'; else echo $datuak['Eposta'].',ON';?>');"></td>
                            <td> <input type='button' id='Ezabatu' value='Ezabatu' onclick="ezabatu('<?php echo $datuak['Eposta']?>')"></td>
                            </tr>
                            <!--if ($datuak['Egoera']=="Aktibo"){
                                echo "<td> <input type='button' id='Permutatu' value='ON' onclick="aldatuEgoera('.$datuak['Eposta'].');"></td>";
                            }else{
                                echo "<td> <input type='button' id='Permutatu' value='OFF' </td>";
                            }
                            echo "<td><input type='button' id='Ezabatu' value='Ezabatu' ></td>";
                            echo "</tr>";-->
                            <?php
                            
                        }?>
                   <!-- //}
                    taulaSortu();-->
                    
                </tbody>
            </table>
        </div> 
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
