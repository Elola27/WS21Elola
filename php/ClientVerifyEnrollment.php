<?php
$soapclient1 = new SoapClient('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl');					
$matrikulatutaWS = $soapclient1->egiaztatuE($_GET["eposta"]);	
echo $matrikulatutaWS;			
?>