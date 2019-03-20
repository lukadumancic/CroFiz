<?php
		include "Funkcije.php";
		session_start();
		$n=$_POST["n"];
		$mojId=getId($_SESSION["korisnickoIme"]);
		$idizazov=$_POST["id"];
		
		$conn=conn();
		
		$sql="select idzadaci from izazovi where id=".$_POST["id"];
		$rez=$conn->query($sql);
		if($rez->num_rows!=0){
			$row=$rez->fetch_assoc();
			$x=$row["idzadaci"];
			$l=explode("|",$x);
			$br=0;
			$tocnost="|";
			$rjes="|";
			for($i=0;$i<sizeof($l);$i++){
				$idZad=$l[$i];
				if($idZad==""){
					continue;
				}
				$sql="select rjesenje from izazovizadaci where id=$idZad";
				$rez2=$conn->query($sql);
				$row2=$rez2->fetch_assoc();
				if($row2["rjesenje"]===$_POST["rjesenje$i"]){
					$tocnost.="1|";
				}
				else{
					$tocnost.="0|";
				}
				$rjes.=$_POST["rjesenje$i"]."|";
			}
			$sql="select * from izazovtocnost where idkorisnik='$mojId' and idizazov='$idizazov'";
			$rez=$conn->query($sql);
			if($rez->num_rows===0){
				$sql="INSERT INTO `izazovtocnost` (`idizazov`, `idkorisnik`, `tocnost`,`rjesenje`) VALUES ('$idizazov', '$mojId', '$tocnost', '$rjes')";
				$conn->query($sql);
			}
			else{
				$sql="UPDATE `izazovtocnost` SET `tocnost`='$tocnost',`rjesenje`='$rjes' WHERE idkorisnik='$mojId' and idizazov='$idizazov'";
				$conn->query($sql);
			}
		}
		$conn->close();
		header("Location: http://82.132.7.168/Izazov.php?id=".$_POST['id']);
		die();
	?>


