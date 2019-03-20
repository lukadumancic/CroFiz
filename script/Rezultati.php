<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://82.132.7.168/Main.php");
		die();
	}
?>
<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php include 'head.php';?>
	</head>
	<body>
		<?php include 'navigacija.php';?>
		
		<article id="art">
			<div class='opis2' style="background: url('Slicice/trazilica.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Tražilica</strong>
			</div>
		
			
				<?php	
				if(isset($_GET["trazilica"])){
					
					
					
					$conn=conn();
					
					$x=$_GET["trazilica"];
					
					echo "<div class='opis2' style='font-size:30px;'>Tražena riječ:<br>";
					echo $x."</div>";
					
					
					
					
					echo "<div>";
					//Korisnici
					
					
					echo "<div class='paralelna3' style='background: url(\"Slicice/korisnici.jpg\");background-size: cover;'>";
					echo "<p>Korisnici</p><br>";
					
					$sql="select * from korisnici where id='$x' or nick='$x' or ime='$x' or prezime='$x'";
					$rezultat=$conn->query($sql);
					$br=0;
					if($rezultat->num_rows>0){
						while($row=$rezultat->fetch_assoc()){
							$br=1;
							echo "<p>".infoKorisnik($row["id"])."</p>";
						}
					}
					if(strpos($x," ")!=false){
						$l=explode(" ",$x);
						$sql="select * from korisnici where ime='$l[0]' and prezime='$l[1]'";
						$rezultat=$conn->query($sql);
						if($rezultat->num_rows>0){
							while($row=$rezultat->fetch_assoc()){
							$br=1;
							echo "<p>".infoKorisnik($row["id"])."</p>";
						}
					}
					
					}
					
					if($br==0){
						echo "<p>Nema rezultata pretrage</p>";
					}
					
					
					
					//Zadaci
					
					
					
					echo "</div>";
					
					echo "<div class='paralelna3' style='background: url(\"Slicice/kalkulator.jpg\");background-size: cover;'>";
					echo "<p><a href='Zadaci.php'>Zadaci</a></p><br>";
					
					$sql="select * from zadaci where id='$x' or ime like '$x' or ime like '%$x' or ime like '%$x%' or ime like '$x%' or podrucje='$x' ";
					$rezultat=$conn->query($sql);
					$br=0;
					if($rezultat->num_rows>0){
						while($row=$rezultat->fetch_assoc()){
							$br=1;
							echo "<p><a class='zadatak' href='http://82.132.7.168/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
						}
					}
					if($br==0){
						echo "<p>Nema rezultata pretrage</p>";
					}
					
					echo "</div>";
					
					//Forum
					
					
					
					echo "<div class='paralelna3' style='background: url(\"Slicice/forum.jpg\");background-size: cover;'>";
					echo "<p><a href='Forum.php'>Forum</a></p><br>";
					
					$sql="select * from zadaci where id='$x' or ime like '$x' or ime like '%$x' or ime like '%$x%' or ime like '$x%' or tekst like '$x' or tekst like '%$x' or tekst like '%$x%' or tekst like '$x%' ";
					$rezultat=$conn->query($sql);
					$br=0;
					if($rezultat->num_rows>0){
						while($row=$rezultat->fetch_assoc()){
							$br=1;
							echo "<p><a class='zadatak' href='http://82.132.7.168/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
						}
					}
					if($br==0){
						echo "<p>Nema rezultata pretrage</p>";
					}
					
					$conn->close();
					echo "</div>";
				}
				else{
					echo "<p class='tamnije'>Ključna riječ:</p>";
					echo "<p style='color:white;font-weight:bold;'>'Nije zadano'</p>";
					
				}
				?>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php'; ?>
		</footer>
		
		<!-- Dodatne php funkcije -->
		<?php
			function infoKorisnik($id){
				$conn=conn();
				
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://82.132.7.168/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]." ".levelSlika($id)."</a>";
				
			}
		?>
	</body>
</html>