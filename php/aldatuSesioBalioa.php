<?php 
    session_start();
    //var_dump($_POST);
    //var_dump($_GET);
    //var_dump($_REQUEST);
    $galdera=$_POST['id'];
    if (!isset($_SESSION["erantzundakoak"])){
        $_SESSION["erantzundakoak"]=[];
    }
    $erantzunak=$_SESSION["erantzundakoak"];
    array_push($erantzunak,$galdera);
    $_SESSION["erantzundakoak"]=$erantzunak;
    echo implode(",",$_SESSION["erantzundakoak"]);//json_encode($_SESSION["erantzundakoak"]);
    //echo $_SESSION["erantzundakoak"];
?>
