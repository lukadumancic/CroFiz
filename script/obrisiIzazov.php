
	<?php
	include "Funkcije.php";
	session_start();
	if(prijavljen()==="True" and  mojIzazov() and profesor()){
		$conn=conn();
		$id=$_POST["id"];
		$sql="UPDATE `izazovi` SET `trajanje`='-1' WHERE `id`='$id';";
		$conn->query($sql);
		$conn->close();
	}
	header("Location: http://localhost/Zadaci.php?br=Mentorski");
	die();
	
		
			function profesor(){
				$conn=conn();
				
				$nick=$_SESSION["korisnickoIme"];
				$sql="select obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function mojIzazov(){
				$conn=conn();
				if(isset($_POST["id"])){
					$id=$_POST["id"];
					$sql="select idgrupe from izazovi where id='$id'";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						$conn->close();
						return False;
					}
					else{
						$row=$rez->fetch_assoc();
						$idgrupa=$row["idgrupe"];
						$mojId=getId($_SESSION["korisnickoIme"]);
						if(!profesor()){
							$sql="select idkor from grupe where id='$idgrupa' and (idkor like '%|$mojId|%' or idkor like '%|$mojId|' or idkor like '|$mojId|' or idkor like '|$mojId|%' or idkor like '-1' and mentorid='".mentorid()."')";
							$rezultat=$conn->query($sql);
							$conn->close();
							if($rezultat->num_rows===0){
								return False;
							}
							else{
								return True;
							}
						}
						else{
							$sql="select idkor from grupe where id='$idgrupa' and  mentorid='$mojId'";
							$rezultat=$conn->query($sql);
							$conn->close();
							if($rezultat->num_rows===0){
								return False;
							}
							else{
								return True;
							}
						}
					}
				}
				else{
					$conn->close();
					return False;
				}
			}
			function mentorid(){
				$conn=conn();
				$nick=$_SESSION["korisnickoIme"];
				$sql="select mentorid from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["mentorid"];
			}
	?>
	