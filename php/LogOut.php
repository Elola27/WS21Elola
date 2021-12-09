<?php
	session_start();
	session_destroy();
	echo "<script> alert('Saioa itxi egin da.') </script>";
	echo "<script type='text/javascript'> window.location='Layout.php'</script>";
	
	//header ('Location:Layout.php');
?>