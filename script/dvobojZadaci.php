<?php

	include 'Funkcije.php';
	include 'session.php';
	
	if(prijavljen()=="True" and isset($_SESSION['dvobojId'])){
		$conn=conn();
		$id=$_SESSION['dvobojId'];
		$sql="select * from dvoboj where id='".$id."'";
		$rez=$conn->query($sql);
		if($rez->num_rows>0){
			$row=$rez->fetch_assoc();
			$kor1=$row["idkorisnik1"];
			$kor2=$row["idkorisnik2"];
			$toc1=$row["tocno1"];
			$toc2=$row["tocno2"];
			$zadaci=$row["idzadaci"];
			$zadaci=explode("|",$zadaci);
			$ok=true;
			if($kor1==$_SESSION["userId"]){
				$toc1=explode("|", $toc1);
				if(count($toc1)-1>=count($zadaci)-1){
					echo "false";
					$ok=false;
				}
				else{
					$zadatakid=$zadaci[count($toc1)-1];
				}
			}
			else if($kor2==$_SESSION["userId"]){
				$toc2=explode("|", $toc2);
				if(count($toc2)-1>=count($zadaci)-1){
					echo "false";
					$ok=false;
				}
				else{
					$zadatakid=$zadaci[count($toc2)-1];
				}
			}
			if($ok==true){
				$_SESSION["dvobojZadatakId"]=$zadatakid;
				$sql="select * from maturazadaci where id='".$zadatakid."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				echo $row["tekst"];
				echo "|||||";
				echo $row["rjesenja"];
			}
		}
		else{
			echo "false";
		}
		$conn->close();
	}
	else{
		echo "false";
	}

?>