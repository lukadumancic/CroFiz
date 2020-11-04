<?php 
	include "Funkcije.php";
	include "session.php";
	if(prijavljen()=="True" and isset($_GET["id"])){
		$conn=conn();
		$sql="select * from dvoboj where id='".$_GET["id"]."' and idkorisnik2='".$_SESSION["userId"]."' and vrijeme2=''";
		$rez=$conn->query($sql);
		if($rez->num_rows==0){
			header("Location: http://crofiz.com/Main.php");
			die();
		}
		else{
			$sql="UPDATE `dvoboj` SET `vrijeme2`='".time()."', `tocno2`='|' WHERE `id`='".$_GET["id"]."'";
			$conn->query($sql);
			$_SESSION["dvobojId"]=$_GET["id"];
			smanjiZivote();
			$_SESSION["postignuce"]=1;
			$_SESSION["vrsta"]="dvoboj";
			header("Location: http://crofiz.com/igra.php");
			die();
		}
	}
	header("Location: http://crofiz.com/Main.php");
	die();

	function smanjiZivote(){
		$conn=conn();
		$sql="select zivoti from informacije where idkorisnik='".$_SESSION['userId']."'";
		$rez=$conn->query($sql);
		$row=$rez->fetch_assoc();
		$l=$row["zivoti"];
		$s="|".time().$l;
		$sql="UPDATE `informacije` SET `zivoti`='".$s."' WHERE `idkorisnik`='".$_SESSION['userId']."'";
		$conn->query($sql);
		$conn->close();
			
	}
		
?>