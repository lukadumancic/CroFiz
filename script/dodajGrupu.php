
	
	<?php
	include 'Funkcije.php';
	session_start();
				if(prijavljen()==="True"){
				$conn=conn();
				$id=$_SESSION["userId"];
				if($_POST["opcija"]=="svi"){
					$idkor=sviId();
				}
				else{
					$idkor=$_POST["odabrano"];
					$idkor="|".$idkor."|";
				}
				$sql="INSERT INTO grupe (`ime`, `mentorid`, `idkor`) VALUES ('".$_POST['imeGrupe']."', '$id', '$idkor')";
				$conn->query($sql);
				$conn->close();
				
				saljiObavijesti($idkor);
				
				
	}
	header("Location: http://crofiz.com/Grupe.php");
	die();

	
			function mojUcenik($x){
				$conn=conn();
				$sql="select mentorid from korisnici where id='$x'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				if($row["mentorid"]==$_SESSION["userId"]){
					return True;
				}
				else{
					return False;
				}
			}
			function sviId(){
				$conn=conn();
				$sql="select id from korisnici where mentorId='".$_SESSION['userId']."'";
				$rez=$conn->query($sql);
				$conn->close();
				$ret="|";
				if($rez->num_rows>0){
					while($row=$rez->fetch_assoc()){
						$ret.=$row["id"]."|";
					}
				}
				return $ret;
			}
			function grupaId(){
				$conn=conn();
				$sql="SELECT id FROM newdatabase.grupe where mentorid='".$_SESSION['userId']."' order by id desc limit 1";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["id"];
			}
			function saljiObavijesti($idkor){
				$l=explode("|",$idkor);
				for($i=0;$i<sizeof($l);$i++){
					obavijesti($l[$i],"<a href=\"Profil.php?nick=".$_SESSION["korisnickoIme"]."\">".$_SESSION["korisnickoIme"]."</a> stvara novu grupu <a href=\"Grupa.php?id=".grupaId()."\">".$_POST['imeGrupe']."</a>");
				}
			}
			?>