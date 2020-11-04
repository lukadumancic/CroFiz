<?php
	if(isset($_POST["poruka"]) and isset($_POST["primatelji"]) and isset($_POST["naslov"])){
		include "Funkcije.php";
		session_start();
		$conn=conn();
		
		$l=explode(",",$_POST["primatelji"]);
		$idPosiljatelj=$_SESSION["userId"];
		for($i=0;$i<sizeof($l);$i++){
			$sql="INSERT INTO `poruke` (`poruka`, `naslov`, `posiljatelj`, `primatelj`, `pogledano`) VALUES ('".$_POST["poruka"]."','".$_POST["naslov"]."' , '$idPosiljatelj', '".getId($l[$i])."', '0')";
			$conn->query($sql);
			$_SESSION["poruka"]="Poslano!";
		}
		$conn->close();
		
			
		
	}
	else{
		$_SESSION["poruka"]="Neuspjelo slanje poruke!";
	}
	header("Location: http://localhost/Poruke.php");
	die();
?>