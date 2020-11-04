<?php
	include "Funkcije.php";
	include "session.php";
	if(prijavljen()==="True"){
				if(isset($_POST["id"])){
					
					$conn=conn();
					
					$sql="INSERT INTO `objavetema` (`idkorisnik`, `idzadatak`, `objava`,`kor`,`bodovi`) VALUES ('".$_SESSION['userId']."', '".$_POST["id"]."', '".$_POST["objava"]."','|','0')";
					$conn->query($sql);
					
					dodatnaPostignuca("odgovor",$_SESSION["userId"]);
					
					$conn->close();
				}
				else{
					echo "-1";
				}
	}
				
		header("Location: http://34.121.205.40/Tema.php?id=".$_POST["id"]);
		die();	
			
	?>
