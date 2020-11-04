<?php
include "Funkcije.php";
session_start();
	if(prijavljen()=="True"){
		if(isset($_POST["ime"]) and isset($_POST["tekst"])){
			
			
			$conn=conn();
			
			$sql="INSERT INTO `forum` (`ime`, `tekst`, `idkorisnik`) VALUES ('".$_POST['ime']."', '".$_POST['tekst']."', '".$_SESSION['userId']."');";
			$conn->query($sql);
			$sql="select id from forum where idkorisnik='".$_SESSION['userId']."' order by id desc limit 1";
			$rez=$conn->query($sql);
			$row=$rez->fetch_assoc();
			$conn->close();
			
			dodatnaPostignuca("tema",$_SESSION["userId"]);
			
			header("Location: http://crofiz.com/Tema2.php?id=".$row["id"]);
			die();
		}
	}
	header("Location: http://crofiz.com/Forum.php");
	die();

?>