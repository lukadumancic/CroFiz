<?php
	if(isset($_POST["uredivanje"])){
		$conn=conn();
		$sql="UPDATE `objave` SET `objava`='".$_POST["uredivanje"]."' WHERE `id`='".$_SESSION['idObjava']."'";
		$conn->query($sql);
	}
	if(isset($_POST["vrsta"]) and isset($_POST["id"])){
		$_SESSION["idObjava"]=$_POST["id"];
		echo "<script>";
		echo "document.getElementById('porukaTekst').innerHTML=\"Uređivanje objave<form method='post'><input style='width:300px;' type='text' name='uredivanje' value='".dohvatiObjavu()."'><br><input type='submit' value='Uredi'></form>\";";
		echo 'document.getElementById("poruka").style.display="block";';
		echo "</script>";
	}
	
	
	function dohvatiObjavu(){

		$conn=conn();
		$sql="select objava from objave where id='".$_POST["id"]."' and idkorisnik='".getId($_SESSION['korisnickoIme'])."'";
		$rez=$conn->query($sql);
		$conn->close();
		if($rez->num_rows===1){
			$row=$rez->fetch_assoc();
			return $row["objava"];
		}
		return;

	}
	

?>