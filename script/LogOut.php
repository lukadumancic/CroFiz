<?php
	//Pokretanje sessiona
	session_start();
	//Ako nisu postavljene session varijable tada ih treba postaviti
	$_SESSION["nick"]="*%test%*";
	$_SESSION["pass"]="*%test%*";
?>
<script>
window.location='Connectihno.php';
</script>