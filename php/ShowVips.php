<?php session_start(); 
    if (!isset($_SESSION['rola'])){
        echo "<script type='text/javascript'> window.location='Layout.php' </script>";
    }else{
        if ($_SESSION['rola']!="Irakaslea"){
            echo "<script type='text/javascript'> window.location='Layout.php' </script>";
        }
    }     
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
</head>
<body>
<?php include 'Menus.php'?>
  
  <section class="main" id="s1">
    <h3> VIP erabiltzaileen zerrenda REST erabiliz</h3>
    <?php 
    $ch=curl_init();
    $url="https://sw.ikasten.io/~T51/REST/vipusers/";
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $str=curl_exec($ch);
    //echo "<script> alert('.$str.') </script>";
    echo $str;
    ?>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
