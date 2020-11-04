<?php
			//Upload skripte
			include "Funkcije.php";
			include "session.php";
			if(prijavljen()=="True"){
			if(isset($_POST['upload'])){
				$brojx=2;
				if(!isset($_POST['odabrano'])){
					if(isset($_SESSION['idGrupeDokumenit'])){
						$brojx=3;
						$_POST['odabrano']=$_SESSION['idGrupeDokumenit'];
					}
				}
				if(glava()){
					$fileName = $_FILES['userfile']['name'];
					$tmpName  = $_FILES['userfile']['tmp_name'];
					$fileSize = $_FILES['userfile']['size'];
					$fileType = $_FILES['userfile']['type'];
					
					$conn=conn();
					
						//Ako je slika
						if(strpos($fileType,"mage")){
							$data= addslashes($_FILES['userfile']['tmp_name']);
							$name= addslashes($_FILES['userfile']['name']);
							$data= file_get_contents($data);
							$data= base64_encode($data);
							$sql="INSERT INTO skripte (name, size, type, content ,idkorisnik, br, x,grupa) ".
							"VALUES ('".$_POST['ime']."', '$fileSize', '$fileType', '$data', '".$_SESSION['userId']."','0','".$brojx."','".$_POST['odabrano']."')";
							$conn->query($sql);
						}
						else{
							$fp      = fopen($tmpName, 'r');
							$content = fread($fp, filesize($tmpName));
							$content = addslashes($content);
							fclose($fp);
							
							if(!get_magic_quotes_gpc()){
								$fileName = addslashes($fileName);
							}
							$sql="INSERT INTO skripte (name, size, type, content ,idkorisnik,br,x,grupa) ".
							"VALUES ('".$_POST['ime']."', '$fileSize', '$fileType', '$content', '".$_SESSION['userId']."','0','".$brojx."','".$_POST['odabrano']."')";
							$conn->query($sql);
						}
					
					$sql="select idkor from grupe where id='".$_POST['odabrano']."'";
					$rez=$conn->query($sql);
					$s=$rez->fetch_assoc();
					$l=explode("|",$s["idkor"]);
					

					for($i=0;$i<sizeof($l);$i++){
						obavijesti($l[$i],"<a href=\"Profil.php?nick=".$_SESSION["korisnickoIme"]."\">".$_SESSION["korisnickoIme"]."</a> dodaje novu <a href='Skripte.php?br=MentorskeSkripte'>skriptu</a>");
					}
					$conn->close();
				}
				
				
			}
			
			
			
			
			}
			if(isset($_SESSION['idGrupeDokumenit'])){
				header("Location: http://crofiz.com/dokumenti.php?id=".$_SESSION['idGrupeDokumenit']);
				die();
			}
			else{
				header("Location: http://crofiz.com/Skripte.php?br=MentorskeSkripte");
				die();
			}
			
			function glava(){
				$conn=conn();
				
				$id=$_POST['odabrano'];
				$mojId=$_SESSION["userId"];
				$sql="select * from grupe where mentorid='$mojId' and id='$id'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					return False;
				}
				else{
					return True;
				}
				$conn->close();
			}

		?>