<?php
		include "Funkcije.php";
		include "session.php";
		if(isset($_POST["unesenoRjesenje"])){
			$_POST["idZadatak"]=$_SESSION['idZadatak'];
			if(prijavljen()=="True"){
				$_POST["zadatakDana"]=$_SESSION['zadatakDana'];
			}
			$conn=conn();
			
			$id=getId($_SESSION["korisnickoIme"]);
			
			$sql="select rjesenje from zadaci where id=".$_POST["idZadatak"];
			$rezultat=$conn->query($sql);
			$row=$rezultat->fetch_assoc();
			if($row["rjesenje"]==$_POST["unesenoRjesenje"]){
				$br=1;
				$_SESSION['poruka']="Točno";
			}
			else{
				$br=0;
				$_SESSION['poruka']="Netočno";
			}
		}
		if(prijavljen()=="True"){
			if($br==1){
				$sql="select * from pokusaji WHERE idkorisnik=$id and idzadatak=".$_POST["idZadatak"];
				$rez=$conn->query($sql);
				$z=0;
				if($rez->num_rows===0){
					$z=1;
				}
				else{
					$row=$rez->fetch_assoc();
					if(intval($row["tocnost"])===0 or intval($row["tocnost"])===-1){
						$z=1;
					}
				}
				if($z===1){
					if(!profesor2()){
						$_SESSION["postignuce"]=1;
						$_SESSION["vrsta"]="zadatak";
					}
				
					$sql="DELETE FROM `pokusaji` WHERE idkorisnik=$id and idzadatak=".$_POST["idZadatak"];
					$conn->query($sql);
					$sql="INSERT INTO `pokusaji` (`tocnost`,`idkorisnik`,`idzadatak`) VALUES ('1','$id','".$_POST["idZadatak"]."')";
					$conn->query($sql);
					if($_POST["zadatakDana"]=="1"){
						$sql="select * from ranklista WHERE idkorisnik=$id";
						$rezultat=$conn->query($sql);
						if($rezultat->num_rows === 0){
							$sql="INSERT INTO ranklista (`idkorisnik`, `bodovi`, `razred`) VALUES ('$id', '".bodovi()."', '".razred()."')";
							$conn->query($sql);
						}
						else{
							$sql="UPDATE `ranklista` SET `bodovi`=`bodovi`+'".bodovi()."' WHERE `idkorisnik`='$id'";
							$conn->query($sql);
						}
						//2 puta više xp-a za zadatak dana
						dodajXp(20);
					}
					if($_POST["zadatakDana"]=="2"){
						$sql="select * from ranklista WHERE idkorisnik=$id";
						$rezultat=$conn->query($sql);
						if($rezultat->num_rows === 0){
							$sql="INSERT INTO ranklista (`idkorisnik`, `bodovi`, `razred`) VALUES ('$id', '".bodovi2()."', '".razred()."')";
							$conn->query($sql);
						}
						else{
							$sql="UPDATE `ranklista` SET `bodovi`=`bodovi`+'".bodovi2()."' WHERE `idkorisnik`='$id'";
							$conn->query($sql);
						}
						//5 puta više xp-a za zadatak tjedna
						dodajXp(50);
					}
					else{
						//10 xp-a za obićan zadatak
						dodajXp(10);
					}
				}
			}
			
			else{
				$sql="select tocnost from pokusaji WHERE idkorisnik=$id and idzadatak=".$_POST["idZadatak"];
				$rez=$conn->query($sql);
				$z=0;
				if($rez->num_rows===0){
					$z=2;
				}
				else{
					$row=$rez->fetch_assoc();
					if(intval($row["tocnost"])==0 or intval($row["tocnost"])==-1){
						$z=1;
					}
				}
				if($z===1){
					$sql="UPDATE pokusaji SET tocnost='1' WHERE idkorisnik=$id and idzadatak=".$_POST["idZadatak"];
					$conn->query($sql);
					$sql="UPDATE pokusaji SET tocnost='0' WHERE idkorisnik=$id and idzadatak=".$_POST["idZadatak"];
					$conn->query($sql);
				}
				else if($z===2){
					$sql="INSERT INTO `pokusaji` (`tocnost`,`idkorisnik`,`idzadatak`) VALUES ('0','$id','".$_POST["idZadatak"]."')";
					$conn->query($sql);
				}
			}
		}
		$conn->close();
		
		header("Location: http://34.121.205.40/Zadatak.php?id=".$_POST["idZadatak"]);
		die();
		
	function bodovi(){
				$conn=conn();
				$sql="select UNIX_TIMESTAMP(datum) from zadaci where id=".$_POST["idZadatak"];
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				
				$sec1=$row["UNIX_TIMESTAMP(datum)"];
				$sec2=time();
				$conn->close();
				//Formula po kojoj se računaju bodovi
				return (1440-round(($sec2-$sec1)/60,1));
	}
	function bodovi2(){
		$conn=conn();
				$sql="select UNIX_TIMESTAMP(datum) from zadaci where id=".$_POST["idZadatak"];
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				
				$sec1=$row["UNIX_TIMESTAMP(datum)"];
				$sec2=time();
				$conn->close();
				//Formula po kojoj se računaju bodovi
				return (10080-round(($sec2-$sec1)/60,1));
	}
	function razred(){
		$conn=conn();
				$sql="select obrazovanje from korisnici where id=".getId($_SESSION["korisnickoIme"]);
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				
				$conn->close();
				return $row["obrazovanje"];
	}
	
?>