<?php
			//Unos objave
			include "Funkcije.php";
			session_start();
			if(prijavljen()==="True"){
				if(isset($_POST["objavaTekst"]) and isset($_SESSION["idGrupa"])){
					$_POST['id']=$_SESSION["idGrupa"];
					
					$conn=conn();
					
					$Nick=$_SESSION["korisnickoIme"];
					$Pass=$_SESSION["zaporka"];
					
					//Querry, dohvaćanje id-a
					$sql="select id from korisnici where nick='".$Nick."' and pass='".$Pass."'";
					$rezultat=$conn->query($sql);
					$row = $rezultat->fetch_assoc();
					$idkorisnik=$row["id"];
					
					//Querry, slanje objave
					//Funkcija promjeni znakove je opisana u dodatnim funkcijama
					if(!$_FILES['userfile']['size'] > 0){
						$sql="INSERT INTO `objavegrupa` (`objava`,`idgrupa`, `idkorisnik`, `br`) VALUES ('".promjeniZnakove($_POST["objavaTekst"])."','".$_POST['id']."',  '". $idkorisnik ."', '1')";
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
						
						$sql="INSERT INTO `objavegrupa` (`objava`,`idgrupa`, `idkorisnik`,`type` ,`data` , `br`) VALUES ('".promjeniZnakove($_POST["objavaTekst"])."','".$_POST['id']."', '$idkorisnik','$fileType' ,'$data', '0')";
					}
					
					$conn->query($sql);
					
			
					$sql="select idkor from grupe where id='".$_POST['id']."'";
					$rez=$conn->query($sql);
					$s=$rez->fetch_assoc();
					$l=explode("|",$s["idkor"]);
					
					for($i=0;$i<sizeof($l);$i++){
						if($l[$i]==$_SESSION["userId"]){
							continue;
						}
						obavijesti($l[$i],$_SESSION["korisnickoIme"]." objavljuje u grupi <a href=\"Grupa.php?id=".$_POST['id']."\">".imeGrupe()."</a>");
					}
					
					$conn->close();
					
				}
				header("Location: http://34.121.205.40/Grupa.php?id=".$_SESSION["idGrupa"]);
				die();
			}
			
			
	//Dodatne funkcije

			
			
			function imeGrupe(){
				$conn=conn();
				$id=$_POST['id'];
				$sql="select ime from grupe where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["ime"];
			}
			function promjeniZnakove($str){
				$znakovi = array('"');
				$str=str_replace($znakovi,'\\\\"', $str);
				$znakovi = array("'");
				return str_replace($znakovi,"\\\\'", $str);
			}
			
	?>
			