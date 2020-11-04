<?php
	include "Funkcije.php";
	include "session.php";
?>

		<?php
			if (prijavljen()==="True"){
			$conn=conn();
			if(isset($_GET["limit"])){
				$limit=$_GET["limit"];
			}
			else{
				$limit=10;
			}
			$sql="select id,objava,idkorisnik,datum,type from objave where id between ".($limit-9)." and ".($limit)." order by id desc";
			$rezultat=$conn->query($sql);
			while($row=$rezultat->fetch_assoc()){
				echo "<div class='objava'>";
				echo "<div style='display: inline-block;'>".infoKorisnik($row["idkorisnik"]);
				echo "<p class='tamnije' style='font-size:10px;'>".obradiDatum($row["datum"])."</p></div><br>";
				echo "<textarea class='ispis'  readonly>".$row["objava"]."</textarea>";
				if($row["type"]){
					echo "<br><img class='slika' src='http://34.121.205.40/Slike/objava".$row["id"].".jpg'>";
				}
				echo "</div>";
				echo "<p style='background-color: #696969;padding: 1px;'></p>";
			}
			$conn->close();
			}
		?>

		<?php
			

			function infoKorisnik($id){
				$conn=conn();
				
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://34.121.205.40/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]." ".levelSlika($id)."</a>";
				
			}

		?>
