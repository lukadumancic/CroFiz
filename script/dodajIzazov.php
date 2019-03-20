<?php
include "Funkcije.php";
	session_start();
	if(prijavljen()==="True"){
	if(isset($_POST['imeIzazova']) and isset($_POST['odabrano'])){
		$conn=conn();
				$brZad=$_POST["brojZadataka"];
				$idzadaci="|";
				$slike="|";
				$lista=explode( '|', $brZad );
				foreach($lista as $j => $i){
					if($i=="|" or $i==""){
						continue;
					}
					$ime=$_POST["ime$i"];
					$tekst=$_POST["tekst$i"];
					$mjerna=$_POST["mjernaJedinica$i"];
					$rjesenje=$_POST["rj$i"];
					
					$sql="INSERT INTO `izazovizadaci` (`ime`, `tekst`, `mjernaJedinica`, `idgrupe`,`rjesenje`) VALUES ('$ime', '$tekst', '$mjerna',".$_POST['odabrano'].",'$rjesenje')";
					$conn->query($sql);
					$sql="SELECT id from `izazovizadaci` where ime='$ime' order by datum desc limit 1";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$idzadaci.=$row["id"]."|";
					//Slike
					if($_FILES['slika'.$i]['size'] > 0){
						$slike.="1|";
						
						$fileType = $_FILES['slika'.$i]['type'];
					
						$data= addslashes($_FILES['slika'.$i]['tmp_name']);
						$name= addslashes($_FILES['slika'.$i]['name']);
						$data= file_get_contents($data);
						$data= base64_encode($data);
						$sql="INSERT INTO `slike` (`type` ,`data` ,`idzadatak`) VALUES ('$fileType' ,'$data', '".$row["id"]."')";
						$conn->query($sql);
					}
					else{
						$slike.="0|";
					}
					
				}
				$sql="INSERT INTO `izazovi` (`ime`,`idzadaci`, `idgrupe`, `trajanje`,`slike`) VALUES ('".$_POST['imeIzazova']."','$idzadaci','".$_POST['odabrano']."','1','$slike')";
				$conn->query($sql);
				
				$sql="select id from izazovi where ime='".$_POST['imeIzazova']."' and idgrupe='".$_POST['odabrano']."' and idzadaci='$idzadaci'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$izazovId=$row["id"];
				
				$sql="select idkor from grupe where id='".$_POST['odabrano']."'";
				$rez=$conn->query($sql);
				$s=$rez->fetch_assoc();
				$l=explode("|",$s["idkor"]);
				
				
				
				for($i=0;$i<sizeof($l);$i++){
					obavijesti($l[$i],"<a href=\"Profil.php?nick=".$_SESSION["korisnickoIme"]."\">".$_SESSION["korisnickoIme"]."</a> dodaje novi izazov <a href=\"izazov.php?id=".$izazovId."\">".$_POST['imeIzazova']."</a>");
				}
				
				$conn->close();
				
				$_SESSION["postignuce"]=1;
				$_SESSION["vrsta"]="izazov";
		}				
	}
	header("Location: http://82.132.7.168/Zadaci.php?br=Mentorski");
	die();
	?>
