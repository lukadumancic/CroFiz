<?php
	include 'Funkcije.php';
	include 'session.php';
	
	if(prijavljen()=="True" and zivoti()>0 and isset($_GET["protivnik"]) and isset($_GET["vrsta"]) and isset($_GET["broj"])){
		$conn=conn();
		$protivnik=$_GET["protivnik"];
		if($protivnik=="Random"){
			$protivnik=1;
		}
		else{
			$protivnik=2;
		}
		$vrsta=$_GET["vrsta"];
		if($vrsta=="Matura"){
			$vrsta=1;
		}
		else{
			//TODO
			$vrsta=2;
		}
		$broj=$_GET["broj"];
		
		echo $protivnik;
		echo $vrsta;
		
		if($protivnik==2){
			$l=randomzadaci();
			$zadaci="|";
			for($i=0;$i<$broj;$i++){
				if($l[$i]==""){
					$broj++;
					continue;
				}
				$zadaci.=$l[$i]."|";
			}
			$sql="INSERT INTO `dvoboj` (`idkorisnik1`,`idkorisnik2`,`tocno1`, `idzadaci`, `vrijeme1`) VALUES ('".$_SESSION['userId']."','".$_GET["prijatelj"]."','|', '".$zadaci."', ".time().")";
			$conn->query($sql);
			$sql="select id from dvoboj where `idkorisnik1`='".$_SESSION['userId']."' and `idzadaci`='".$zadaci."'";
			$rez=$conn->query($sql);
			$row=$rez->fetch_assoc();
			echo "true";
			smanjiZivote();
			
			$_SESSION["dvobojId"]=$row["id"];
			obavijesti($_GET["prijatelj"], '<a href="Profil.php?nick='.$_SESSION["korisnickoIme"].'">'.getName($_SESSION["userId"]).' '.getSurName($_SESSION["userId"]).'</a> vas je izazvao na <a href="prihvatiDvoboj.php?id='.$_SESSION["dvobojId"].'">Dvoboj</a>');
			if(!profesor2()){
				$_SESSION["postignuce"]=1;
				$_SESSION["vrsta"]="dvoboj";
			}
		}
		else{
			$sql="select * from querydvoboj where broj='".$broj."' and vrsta='".$vrsta."' and not idkorisnik='".$_SESSION["userId"]."'";
			$rez=$conn->query($sql);
			if($rez->num_rows==0){
				$l=randomzadaci();
				$zadaci="|";
				for($i=0;$i<$broj;$i++){
					if($l[$i]==""){
						$broj++;
						continue;
					}
					$zadaci.=$l[$i]."|";
				}
				ubaciMaturaInfo($zadaci);
				$sql="INSERT INTO `querydvoboj` (`idkorisnik`, `broj`, `idzadaci`, `vrsta`) VALUES ('".$_SESSION["userId"]."', '".$broj."', '".$zadaci."', '".$vrsta."')";
				$conn->query($sql);
				$sql="INSERT INTO `dvoboj` (`idkorisnik1`,`tocno1`, `idzadaci`, `vrijeme1`) VALUES ('".$_SESSION['userId']."','|', '".$zadaci."', ".time().")";
				$conn->query($sql);
				$sql="select id from dvoboj where `idkorisnik1`='".$_SESSION['userId']."' and `idzadaci`='".$zadaci."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				echo "true";
				$_SESSION["dvobojId"]=$row["id"];
				smanjiZivote();
				if(!profesor2()){
					$_SESSION["postignuce"]=1;
					$_SESSION["vrsta"]="dvoboj";
				}
			}
			else{
				$row=$rez->fetch_assoc();
				$idkorisnik=$row["idkorisnik"];
				$idzadaci=$row["idzadaci"];
				ubaciMaturaInfo($idzadaci);
				$sql="DELETE FROM `querydvoboj` WHERE `id`='".$row['id']."'";
				$conn->query($sql);
				$sql="UPDATE `dvoboj` SET `idkorisnik2`='".$_SESSION['userId']."', `tocno2`='|', `vrijeme2`='".time()."'  WHERE idkorisnik1='".$idkorisnik."' and idzadaci='".$idzadaci."'";
				$conn->query($sql);
				$sql="select id from dvoboj where `idkorisnik2`='".$_SESSION['userId']."' and idzadaci='".$idzadaci."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				echo "true";
				$_SESSION["dvobojId"]=$row["id"];
				smanjiZivote();
				if(!profesor2()){
					$_SESSION["postignuce"]=1;
					$_SESSION["vrsta"]="dvoboj";
				}
			}
		}
		$conn->close();
	}
	else{
		echo "Greška";
	}
	
	
	
		
		
		function randomzadaci(){
			$conn=conn();
			$sql="select maturazadaci from informacije where idkorisnik='".$_SESSION["userId"]."'";
			$rez=$conn->query($sql);
			if($rez->num_rows==0){
				$conn->close();
				return false;
			}
			$row=$rez->fetch_assoc();
			$l=$row["maturazadaci"];
			$l=explode("|",$l);
			$sql="select id from maturazadaci";
			$rez=$conn->query($sql);
			if($rez->num_rows==0){
				$conn->close();
				return false;
			}
			$l2=array();
			while($row=$rez->fetch_assoc()){
				$x=$row["id"];
				if(!in_array($x,$l)){
					array_push($l2, $x);
				}
			}
			shuffle($l2);
			for($i=0;$i<count($l);$i++){
				if($l[$i]=="")continue;
				array_push($l2, $l[$i]);
			}
			return $l2;
			
		}
		
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
		
		function ubaciMaturaInfo($s){
			$conn=conn();
			$sql="UPDATE `newdatabase`.`informacije` SET `maturazadaci`=concat(`maturazadaci`,'".$s."') WHERE `idkorisnik`='".$_SESSION['userId']."'";
			$conn->query($sql);
			$conn->close();
		}
?>