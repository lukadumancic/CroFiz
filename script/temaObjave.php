<?php
if(prijavljen()=="True" and isset($_POST["idObjave"]) and isset($_POST["submit"])){
	$conn=conn();
	
	$sql="select * from objavetema where id='".$_POST["idObjave"]."'";
	$rez=$conn->query($sql);
	if($rez->num_rows===1){
		$row=$rez->fetch_assoc();
		$korisnici=explode("|",$row["kor"]);
		if(!in_array($_SESSION["userId"],$korisnici)){
			
			$kor=$row["kor"].$_SESSION["userId"].'|';
			
			$id=$row["idkorisnik"];
			
			if($_POST["submit"]=="+1"){
				$sql="UPDATE `objavetema` SET `kor`='$kor', `bodovi`=`bodovi`+1 WHERE `id`='".$_POST["idObjave"]."'";
				//Dodati 5 XP-a onomu tko dobije pohvalu na odgovor 
				dodajXp2(5,$id);
			}
			else{
				$sql="UPDATE `objavetema` SET `kor`='$kor', `bodovi`=`bodovi`-1 WHERE `id`='".$_POST["idObjave"]."'";
			}
			
			$conn->query($sql);
			
			
		}
	}
	$conn->close();
	
}
	if(prijavljen()=="True"){
		$conn=conn();

		$ret="";
		$sql="select * from objavetema where idzadatak=".$_GET["id"]." order by bodovi desc";
		$rezultat=$conn->query($sql);
		if($rezultat->num_rows>0){
			while($row=$rezultat->fetch_assoc()){
				
				$korisnici=explode("|",$row["kor"]);
				
				$ret.="<div class='objava'>";
				if(!in_array($_SESSION["userId"],$korisnici) and $row["idkorisnik"]!=$_SESSION["userId"]){
					$ret.="<form method='post' style='display: inline-block;position: relative;top: 10px;float:left;margin-left:2%;'>";
					$ret.="<input class='plusMinus' type='hidden' name='idObjave' value='".$row['id']."'>";
					$ret.="<input class='plusMinus plus' type='submit' name='submit' value='+1'>";
					$ret.="<div class='plusMinus'>".$row["bodovi"]."</div>";
					$ret.="<input class='plusMinus minus' type='submit' name='submit' value='-1'>";
					$ret.="</form>";
				}
				else{
					$ret.="<div style='    display: inline-block;position: relative;top: 30px;float: left;margin-left: 2%;font-size: 30px;'>".$row["bodovi"]."</div>";
				}
				$ret.="<div style='display:inline;'>";
				$ret.="<div style='display: inline-block;'>".infoKorisnik($row["idkorisnik"]);
				$ret.="<p class='tamnije' style='font-size:10px;'>".obradiDatum($row["datum"])."</p></div><br>";
				if($row["bodovi"]<0){
					$ret.="<textarea class='ispis tamnijiIspis'  readonly>".$row["objava"]."</textarea>";
				}
				else{
					$ret.="<textarea class='ispis'  readonly>".$row["objava"]."</textarea>";
				}
				$ret.="</div>";
				$ret.="</div>";
				$ret.="<p style='background-color: #696969;padding: 1px;'></p>";
			}
		}
		else{
			$ret="<strong class='tamnije'>Nema objava na ovu temu!</strong>";
		}
		$conn->close();
		echo $ret;
	}
	else{
		$conn=conn();

		$ret="";
		$sql="select * from objavetema where idzadatak=".$_GET["id"]." order by bodovi desc";
		$rezultat=$conn->query($sql);
		if($rezultat->num_rows>0){
			while($row=$rezultat->fetch_assoc()){
				
				
				$ret.="<div class='objava'>";

				$ret.="<div style='display: inline-block;position: relative;top: 30px;float: left;margin-left: 2%;font-size: 30px;'>".$row["bodovi"]."</div>";
				$ret.="<div style='display:inline;'>";
				$ret.="<div style='display: inline-block;'>".infoKorisnik($row["idkorisnik"]);
				$ret.="<p class='tamnije' style='font-size:10px;'>".obradiDatum($row["datum"])."</p></div><br>";
				if($row["bodovi"]<0){
					$ret.="<textarea class='ispis tamnijiIspis'  readonly>".$row["objava"]."</textarea>";
				}
				else{
					$ret.="<textarea class='ispis'  readonly>".$row["objava"]."</textarea>";
				}
				$ret.="</div>";
				$ret.="</div>";
				$ret.="<p style='background-color: #696969;padding: 1px;'></p>";
			}
		}
		else{
			$ret="<strong class='tamnije'>Nema objava na ovu temu!</strong>";
		}
		$conn->close();
		echo $ret;
	}	
?>