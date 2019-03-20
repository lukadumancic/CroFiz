<?php
include "Funkcije.php";
	session_start();
	if(prijavljen()==="True"){
		$conn=conn();
		$sql="UPDATE informacije SET prijatelji = CONCAT(prijatelji, '".$_SESSION["idPrijatelj"]."|') WHERE idkorisnik='".$_SESSION['userId']."'";
		$conn->query($sql);
		$conn->close();
		echo $_SESSION["idPrijatelj"];
		obavijesti($_SESSION["idPrijatelj"], '<a href="Profil.php?nick='.$_SESSION['korisnickoIme'].'">'.$_SESSION['korisnickoIme'].'</a> vas dodaje na listu prijatelja');
					
	}
	header("Location: http://82.132.7.168/Profil.php?nick=".getNick($_SESSION["idPrijatelj"]));
	die();
?>
