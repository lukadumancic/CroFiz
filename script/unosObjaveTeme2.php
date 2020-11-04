<?php
			include "Funkcije.php";
			include "session.php";
			if(prijavljen()==="True"){
				if(isset($_POST["id"])){
					
					$conn=conn();
					
					$sql="SELECT DISTINCT idkorisnik FROM crofiz.objavetemaforum where idforum='".$_POST["id"]."'";
					$rez=$conn->query($sql);
					if($rez->num_rows>0){
						while($row=$rez->fetch_assoc()){
							if($row["idkorisnik"]!=$_SESSION["userId"]){
								obavijesti($row["idkorisnik"],'<a href="Profil.php?nick='.$_SESSION['korisnickoIme'].'">'.$_SESSION['korisnickoIme'].'</a> odgovara na <a href="Tema2.php?id='.$_POST["id"].'">temu</a>');
							}
						}
					}
					
					$sql="INSERT INTO `objavetemaforum` (`idkorisnik`, `idforum`, `objava`,`kor`,`bodovi`) VALUES ('".$_SESSION['userId']."', '".$_POST["id"]."', '".$_POST["objava"]."','|','0')";
					$conn->query($sql);
					
					dodatnaPostignuca("odgovor",$_SESSION["userId"]);
					
					$conn->close();
				}
				else{
					
				}
			}
			header("Location: http://crofiz.com/Tema2.php?id=".$_POST["id"]);
			die();	
				
			
	?>
