<?php
include "Funkcije.php";
include "session.php";
		  
				if(isset($_POST["userOrPass"])){
					if($_POST["userOrPass"]!==""){
						$conn=conn();
						

						$sql="INSERT INTO zaboravljeno (`zab`) VALUES ('".$_POST["userOrPass"]."')";

						$conn->query($sql);

						$conn->close();
						$_SESSION['poruka']="Provjerite email";
					}
				}
				else{
					$_SESSION['poruka']="Greška";
				}
				header("Location: http://82.132.7.168/Main.php");
				die();
				
			?>
		
		

		