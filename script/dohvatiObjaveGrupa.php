<?php
	include "Funkcije.php";
	session_start();
?>

		<?php
		if(prijavljen()==="True" and mojaGrupa()){
			$conn=conn();
			
			if(isset($_GET["limit"])){
				$limit=$_GET["limit"];
			}
			else{
				$limit=10;
			}
			$sql="select id,objava,idkorisnik,datum,type from objavegrupa where idgrupa=".$_GET['id']." and id between ".($limit-9)." and ".($limit)." order by id desc";
			$rezultat=$conn->query($sql);
			if($rezultat->num_rows>0){
				while($row=$rezultat->fetch_assoc()){
					echo "<div class='objava'>";
					echo "<div style='display: inline-block;'>".infoKorisnik($row["idkorisnik"]);
					echo "<p class='tamnije' style='font-size:10px;'>".obradiDatum($row["datum"])."</p></div><br>";
					echo "<textarea class='ispis'  readonly>".$row["objava"]."</textarea>";
					if($row["type"]){
						echo "<br><img class='slika' src='http://crofiz.com/Slike/objavagrupa".$row["id"].".jpg'>";
					}
					echo "</div>";
					echo "<p style='background-color: #696969;padding: 1px;'></p>";
					}
			}
			$conn->close();
		}

		
			function infoKorisnik($id){
				$conn=conn();
				
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://crofiz.com/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]."</a>";
				
			}
			function mojaGrupa(){
				$conn=conn();
				
				$id=$_GET["id"];
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select mentorid from korisnici where id=$mojId";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$mentorId=$row["mentorid"];
				$sql="select * from grupe where mentorid='$mentorId' and idkor='-1' or id='$id' and (idkor like '|$mojId|' or idkor like '%|$mojId|' or idkor like '|$mojId|%' or idkor like '%|$mojId|%' or mentorid='$mojId')";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===0){
					return False;
				}
				else{
					return True;
				}
			}
		?>
