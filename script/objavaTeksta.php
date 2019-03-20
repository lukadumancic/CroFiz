<?php
			//Unos objave
			include "Funkcije.php";
			include "session.php";
			session_start();
			if(prijavljen()=="True"){
			if(isset($_POST["objavaTekst"])){
				$conn=conn();
				
				$idkorisnik=$_SESSION["userId"];
				
				//Querry, slanje objave
				//Funkcija promjeni znakove je opisana u dodatnim funkcijama
				if(!$_FILES['userfile']['size'] > 0){
					echo $sql="INSERT INTO `objave` (`objava`, `idkorisnik`, `br`) VALUES ('".promjeniZnakove($_POST["objavaTekst"])."', '". $idkorisnik ."', '1')";
                }
				else{
					$fileName = $_FILES['userfile']['name'];
					$tmpName  = $_FILES['userfile']['tmp_name'];
					$fileSize = $_FILES['userfile']['size'];
					$fileType = $_FILES['userfile']['type'];
					
					$data= addslashes($_FILES['userfile']['tmp_name']);
					$name= addslashes($_FILES['userfile']['name']);
					$data= file_get_contents($data);
					$data= base64_encode($data);
					
					$sql="INSERT INTO `objave` (`objava`, `idkorisnik`,`type` ,`data` , `br`) VALUES ('".promjeniZnakove($_POST["objavaTekst"])."', '$idkorisnik','$fileType' ,'$data', '0')";
				}
				
				$conn->query($sql);
				
				dodatnaPostignuca("objava",$_SESSION["userId"]);
				
				$conn->close();
			}
			}
			header("Location: http://82.132.7.168/Naslovna.php");
			die();
			
			
	//Dodatne funkcije
			function promjeniZnakove($str){
				$znakovi = array('"');
				$str=str_replace($znakovi,'\\\\"', $str);
				$znakovi = array("'");
				return str_replace($znakovi,"\\\\'", $str);
			}
			
	?>
			
