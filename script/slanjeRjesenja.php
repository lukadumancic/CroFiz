<?php

	include "Funkcije.php";
	include "session.php";
	if(prijavljen()=="True" and isset($_SESSION["dvobojZadatakId"]) and isset($_GET["rjesenje"]) and isset($_SESSION["dvobojId"])){
		$conn=conn();
		$sql="select tocno from maturazadaci where id='".$_SESSION["dvobojZadatakId"]."'";
		$rez=$conn->query($sql);
		$row=$rez->fetch_assoc();
		$br=-1;
		if($row["tocno"]==$_GET["rjesenje"]){
			$br=time();
		}
		
		$sql="select * from dvoboj where id='".$_SESSION['dvobojId']."'";
		$rez=$conn->query($sql);
		$row=$rez->fetch_assoc();
		
		if($row["idkorisnik1"]==$_SESSION["userId"]){
			if($br!=-1){
				$br-=$row["vrijeme1"];
			}
			$sql="UPDATE `dvoboj` SET `tocno1`=concat(`tocno1`,'".$br."|') WHERE `id`='".$_SESSION["dvobojId"]."'";
			$conn->query($sql);
		}
		else if($row["idkorisnik2"]==$_SESSION["userId"]){
			if($br!=-1){
				$br-=$row["vrijeme2"];
			}
			$sql="UPDATE `dvoboj` SET `tocno2`=concat(`tocno2`,'".$br."|') WHERE `id`='".$_SESSION["dvobojId"]."'";
			$conn->query($sql);
		}
		
		iduciZadatak();
		
	}

	function iduciZadatak(){
		$conn=conn();
		$sql="select idzadaci from dvoboj where id='".$_SESSION["dvobojId"]."'";
		$rez=$conn->query($sql);
		$row=$rez->fetch_assoc();
		$l=$row["idzadaci"];
		$l=explode("|",$l);
		print_r($l);
		$br=0;
		for($i=0;$i<count($l)-1;$i++){
			if($br==1){
				$_SESSION["dvobojZadatakId"]=$l[$i];
				$br=-1;
				break;
			}
			if($l[$i]==$_SESSION["dvobojZadatakId"]){
				$br=1;
			}
		}
		if($br==1){
			echo "false";
			unset($_SESSION['dvobojId']);
		}
		else{
			echo $br;
		}
		$conn->close();
	}
?>