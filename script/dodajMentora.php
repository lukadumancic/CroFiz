<?php
include "Funkcije.php";
	session_start();
	if(prijavljen()==="True"){
		$conn=conn();
		$sql="UPDATE `korisnici` SET `mentorid`='".$_SESSION["idMentor"]."' WHERE `id`='".getId($_SESSION["korisnickoIme"])."'";
		$conn->query($sql);
		$conn->close();
		obavijesti($_SESSION["idMentor"], '<a href="Profil.php?nick='.$_SESSION['korisnickoIme'].'">'.$_SESSION['korisnickoIme'].'</a> vas dodaje kao mentora');
		
		dodatnaPostignuca("mentor",$_SESSION["userId"]);
		
		dodatnaPostignuca("ucenici",$_SESSION["idMentor"]);
		
	}
	header("Location: http://82.132.7.168/Profil.php?nick=".getNick($_SESSION["idMentor"]));
	die();
	?>
