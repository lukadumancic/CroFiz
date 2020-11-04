<?php 
	include "Funkcije.php";
	include "session.php";

	if(prijavljen()=="True"){
		if(profesor2()){
			if(isset($_POST["naslov"]) and isset($_POST["tekst"]) and isset($_POST["rjesenje"]) and isset($_POST["mjerna"])){
				$conn=conn();
				$sql="INSERT INTO `primljenizadaci` (`naslov`, `tekst`, `mjernajedinica`, `rjesenje`, `idkorisnik`, `br`) VALUES ('".$_POST["naslov"]."', '".$_POST["tekst"]."', '".$_POST["mjerna"]."', '".$_POST["rjesenje"]."','".$_SESSION['userId']."','0')";
				$conn->query($sql);
				$conn->close();
				$_SESSION["poruka"]="Hvala! Vaš zadatak ćemo brzo obraditi!";
				
				$_SESSION["postignuce"]=1;
				$_SESSION["vrsta"]="slanje";
			}
		}
	}
	
	
	header("Location: http://localhost/SlanjeZadataka.php");
	die();


?>