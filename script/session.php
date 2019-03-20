<?php
	//Pokretanje sessiona
	session_start();
	//Ako nisu postavljene session varijable tada ih treba postaviti
	if(!isset($_SESSION["host"])){$_SESSION["host"]="82.132.7.168";}
	if(!isset($_SESSION["korisnickoIme"])){$_SESSION["korisnickoIme"]="*%test%*";}
	if(!isset($_SESSION["zaporka"])){$_SESSION["zaporka"]="*%test%*";}
	if(prijavljen()=="True"){
		$_SESSION["userId"]=idGet($_SESSION["korisnickoIme"]);
	}
	
	if(isset($_POST["logOut"])){
		$_SESSION["korisnickoIme"]="*%test%*";
		$_SESSION["zaporka"]="*%test%*";
		$_SESSION["dvobojId"]=NULL;
	}
	
	else{
		$_SESSION["help"]=False;
	}
?>