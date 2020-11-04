<?php
	//Pokretanje sessiona
	include "Funkcije.php";
	session_start();
?>

		<?php
		
		if(prijavljen()==="True"){
			$conn=conn();
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			if(isset($_GET["limit"])){
				$limit=$_GET["limit"];
			}
			else{
				$limit=10;
			}
			$sql="select id,objava,idkorisnik,datum,type from objave where idkorisnik='".$_GET["id"]."' order by datum desc limit $limit";
			$rezultat=$conn->query($sql);
			for($i=0;$i<$limit-10;$i++){
				$rezultat->fetch_assoc();
			}
			while($row=$rezultat->fetch_assoc()){
				echo "<div class='objava'>";
				echo "<div style='display: inline-block;'>".infoKorisnik($row["idkorisnik"]);
				echo "<p class='tamnije' style='font-size:10px;'>".obradiDatum($row["datum"])."</p></div><br>";
				if(mojProfil()){echo "<form method='post' style='display:inline;float: right;margin-right: 5px;margin-top: 5px;'><input type='hidden' name='vrsta' value='objava'><input type='hidden' name='id' value='".$row['id']."'><a title='Uređivanje objave'><input type='image' src='Slicice/tools.jpg' alt='Submit Form'></a></form>";}
				echo "<textarea class='ispis'  readonly>".$row["objava"]."</textarea>";
				if($row["type"]){
					echo "<br><img class='slika' src='http://crofiz.com/Slike/objava".$row["id"].".jpg'>";
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
				return "<a class='nick3' href='http://crofiz.com/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]."</a>";
				
			}
			function mojProfil(){
				if(getNick($_GET["id"])===$_SESSION["korisnickoIme"]){
					return True;
				}
				else{
					return False;
				}
			}
		?>
