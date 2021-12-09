<?php session_start(); 
  if (isset($_SESSION['rola'])){
    echo "<script type='text/javascript'> window.location='Layout.php' </script>";
  }

?>
<!DOCTYPE html>
<html>
<head>
<?php include '../html/Head.html'?> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="../js/ShowImageInForm.js"></script>
  <script  language="JavaScript">
         function egiaztatuMatrikula(){
          eposta=document.getElementById("eposta").value;
          xhro = new XMLHttpRequest();
          xhro.onreadystatechange=function(){
        //alert("Galdera gehitzen");
          if (xhro.status==200){
            //document.getElementById("emaitza").append("Ondo joan da");
            if (xhro.responseText === "BAI"){
              document.getElementById("submit").disabled=false;
              document.getElementById("egiaztapen").innerHTML=" Matrikulatuta dago eposta hau";
              document.getElementById("egiaztapen").style="color:green";
            }else{
              document.getElementById("submit").disabled=true;
              document.getElementById("egiaztapen").innerHTML=" Matrikulatu gabe dago eposta hau";
              document.getElementById("egiaztapen").style="color:red";
            }
            
            //alert("Galdera ongi gorde da");
          }
        //Datuak bidali
          xhro.open("GET","ClientVerifyEnrollment.php?eposta="+eposta,true);
          xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhro.send("");
          //document.getElementById("submit").disabled=false;
          
        }
          $(document).ready(function(){
                    $.betetadagoen = function()
                    {   
                        if (($("#eposta").val().length>0) && ($("#deitura").val().length>0) && ($("#pasahitz").val().length>0) && ($("#pasahitzerrepikapen").val().length>0) &&  ($('input[name=mota]').is(":checked")))
                        {
                            return true;
                        } 
                        else 
                        {
                            return false;
                        }
                    }
                    /*$.epostakonprobatu = function()
                    {
                        var balioa= $("#eposta").val();
                        if (balioa.match((/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(eus|es)$/)) || balioa.match((/^[a-zA-Z]\.[a-zA-Z]+@ehu\.(eus|es)$/)))
                        {
                            return true;
                        } 
                        else 
                        {
                            return false;
                        }
                    }*/
                    $.deiturak = function(){
                      var deitura=$("#deitura").val();
                      if (deitura.match(/^([A-Z]([a-z]+)(\s[A-Z]([a-z]+)\s?)+)+$/)){
                        return true;
                      }else{
                        return false;
                      }
                    }

                    $('#submit').click(function(){
                        if ($.betetadagoen()){
                            //if ($.epostakonprobatu()){ 
                              if ($.deiturak()){
                                return true;  
                              } else{
                                alert("Deituren formatua ez da egokia");
                                return false;
                              }     
                            /*}else {
                                alert("Erabilitako e-posta elektronikoa okerra da");
                                return false;
                            }*/
                        }else {
                            alert("Hutsuneak daude, bete itzazu!");
                            return false;
                        }});
              })
</script>
</head>
<body> 
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
      <form id="register" name="register" action="" method="post" onreset="hide_image()" enctype="multipart/form-data">
          <h1> Sartu beharrezko datuak erregistroa burutzeko mesedez </h1>
          <p> Erabiltzaile mota(*): 
        <input type="radio" id="irakasle" name="mota" value="Irakaslea">
        <label for="irakasle">Irakaslea</label>
        <input type="radio" id="ikasle" name="mota" value="Ikaslea">
        <label for="ikasle">Ikaslea</label> </br>
        <label for="eposta"> Eposta (*): </label>
        <input type="text" id="eposta" name="eposta" onchange="egiaztatuMatrikula()"> <span id="egiaztapen"></span></br>
        <label for="deitura"> Deitura [izen-abizenak] (*): </label>
        <input type="text" id="deitura" name="deitura"><br>
        <label for="pasahitz"> Pasahitza (*): </label>
        <input type="password" id="pasahitz" name="pasahitz"><br>
        <label for="pasahitzerrepikapen"> Pasahitza errepikatu (*): </label>
        <input type="password" id="pasahitzerrepikapen" name="pasahitzerrepikapen"><br>
        Perfileko irudia sartzeko (Hautazkoa):
        <input type="file" accept="image/*" name="irudia" id="irudia" onchange="show_image(this, 'reset')"><br>      

        <input type="reset" value="Hustu" id="reset">
        <input type="submit" value="Igorri galdera" id="submit" disabled>
      </form>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>

<?php
if (isset($_POST['eposta'])){
  $dir = "";
  if ($_FILES["irudia"]["tmp_name"] != "") {
    $irudia = file_get_contents($_FILES["irudia"]["tmp_name"]);
    $izena = explode(".", $_FILES['irudia']['name']);
    $dir = "../images/erabiltzaileak/" . str_replace("@", ".", $_POST["eposta"]) .".". $izena[sizeof($izena)-1];
    if (!empty($irudia)){
      file_put_contents($dir, $irudia);
    }
  }
  $irudia = "";
  if ($_FILES["irudia"]["tmp_name"] != "") {
    $irudiaIzen = $_FILES["irudia"]["tmp_name"];
    $irudia = addslashes(file_get_contents($irudiaIzen));
  }
    //echo "console.log($irudia)";
  echo "<script> console.log('$dir') </script>";
  $pasahitz=$_POST['pasahitz'];
  $pasahitzerrepikatu=$_POST['pasahitzerrepikapen'];
  if (strlen($pasahitz)>=8){
    if (strcmp($pasahitz,$pasahitzerrepikatu)==0){
    include 'DbConfig.php';

    try{
      $dsn = "mysql:host=$zerbitzaria;dbname=$db";
      $dbh= new PDO($dsn,$erabiltzailea,$gakoa);
      $stmt= $dbh->prepare("INSERT INTO dbt51_user (Eposta,Deiturak,Pasahitza,Mota,Irudia,Direktorioa) VALUES (?,?,?,?,?,?)");
      //echo "<script> console.log('$stmt') </script>"; 
      //$egoera="Aktibo";
      $crypto=crypt($pasahitz);
      $stmt->bindParam(1,$_POST['eposta']);
      $stmt->bindParam(2,$_POST['deitura']);
      $stmt->bindParam(3,$crypto);
      $stmt->bindParam(4,$_POST['mota']);
      $stmt->bindParam(5,$irudia);
      $stmt->bindParam(6,$dir);
      //$stmt->bindParam(7,$egoera);

    
      if ($stmt->execute()){
        echo "<script> alert('Erabiltzaile berria sortuta') </script>";
        echo "<script type='text/javascript'> window.location='Layout.php' </script>";
      }else{

        echo "<script> console.log('".$stmt->queryString."')</script>";

        echo "<script> console.log('".$stmt->errorCode()."')</script>";
        echo "<script> console.log('".$dbh->errorInfo()[1]."')</script>";
        //echo "<script> console.log('".$dbh->errorInfo()."') </script>"; 
        print_r($dbh->errorInfo());
      }
      $dbh=null;
  }catch(PDOException $e){
    if ($e->getCode()==23000)
      echo "<script> console.log('".$e->getMessage()."')</script>";
  }
  
    /*$niresqli=new mysqli($zerbitzari,$erabiltzailea,$gakoa,$db);
    if ($niresqli->connect_errno){
      echo"<script> alert('Konexioa ez da ireki') </script>";
      //echo ("die('Huts egin du konexioak MySQL-ra: ('.$niresqli->connect_errno . ')'. $niresqli->connect_error);");
    }
    $pasahitza=crypt($pasahitz);
    if(!$niresqli->query("INSERT INTO dbt51_user(Eposta,Deiturak,Pasahitza,Mota,Irudia,Direktorioa) VALUES ('$_POST[eposta]','$_POST[deitura]','$pasahitza','$_POST[mota]','$irudia', '$dir')")){
      //echo"<script> alert('Dagoeneko erabiltzaile bat sortuta dago emandako datuekin (eposta berdinekoa)')</script>";  
      $mezua = str_replace("'", "\'", $niresqli->error);
      echo "<script>alert('Errorea datu-basean: $mezua')</script>";
      //echo "<script> alert('Dagoeneko posta horretarako erabiltzailea sortuta dago') </script>";
    }else{
      echo "<script> alert('Erabiltzaile berria sortuta') </script>";
      echo "<script type='text/javascript'> window.location='Layout.php' </script>";
    }
    mysqli_close($niresqli);*/
    
    }else{
      echo "<script> alert('Emandako bi pasahitzak ezberdinak dira')</script>";
    }
  }else{
    echo "<script> alert('Emandako pasahitzaren luzera 8 baino txikiagoa da') </script>";
  }
}
/*if (isset($_POST['mota']) && isset($_POST['eposta']) && isset($_POST['deitura']) && isset($_POST['pasahitz']) && isset($_POST['pasahitzerrepikapen'])){
    $pasahitz=$_POST['pasahitz'];
    $pasahitzerrepikatu=$_POST['pasahitzerrepikapen'];
    //$preg="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    if(strcmp($pasahitz,$pasahitzerrepikatu)==0 && strlen($pasahitz)>=8){
      include 'DbConfig.php';
      $niresqli=new mysqli($zerbitzari,$erabiltzailea,$gakoa,$db);
      if ($niresqli->connect_errno){
        echo"<script> alert('Konexioa ez da ireki') </script>";
        //echo ("die('Huts egin du konexioak MySQL-ra: ('.$niresqli->connect_errno . ')'. $niresqli->connect_error);");
      }
      $sql_Quiz = "SELECT * FROM dbt51_user WHERE Eposta='$eposta'";

      $ema = $esteka-> query($sql_Quiz);

      if ($ema->num_rows==0){
        if(!$niresqli->query("INSERT INTO dbt51_user(Eposta,Deiturak,Pasahitza,Mota) VALUES ('$_POST[eposta]','$_POST[deitura]','$_POST[pasahitz]','$_POST[mota]')")){
          echo "<script> alert('Errorea datuak sartzerako orduan:('.$niresqli->errno.')' .$niresqli->error') </script>";
        }else{
          //phpAlert("Erabiltailea sortu da, ongi etorri!");
          header('location:Layout.php');
          echo "<script> alert('Ongi etorri!, hemen sakatu hasierako orrira joateko') </script>";
          echo "<p><a href='layout.html'> Home </a>";
			    mysqli_close($esteka);
        }
      }else{
        echo"<script>alert'Dagoeneko erabiltzailea sortuta dago'</script>";
      }
    }else{
    echo "<script> echo'Pasahitzak 8ko luzera izan behar du, eta gutxienez letra xehe bat, larri bat eta zenbaki bat eraman behar ditu' </script>";
    }
}/*else{
    echo "<script> alert('Arazoa dago, ez dira hutsune guztiak bete') </script>";
}*/
?>