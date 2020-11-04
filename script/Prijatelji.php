<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://crofiz.com/Main.php");
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
		
		
			<div class='opis2' style="background: url('Slicice/prijatelji-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Prijatelji</strong>
			</div>
			
			<div class='opis2'>
				Ovdje možete vidjeti tko je od vaših prijatelja trenutno aktivan
			</div>
			<div class='paralelna1' style="background: url('Slicice/prijatelji2.jpg');background-size: cover;background-position: center; ">
				<?php 
					$l=prijatelji();
					echo "<p>Aktivni</p>";
					$br=0;
					for($i=0;$i<count($l);$i++){
						if(!aktivan($l[$i]))continue;
						$br=1;
						echo "<p>".infoKorisnik($l[$i])."</p>";
					}
					if($br==0){
						echo "<p>Trenutno nitko nije aktivan</p>";
					}
					echo "<br><br><p>Neaktivni</p>";
					for($i=0;$i<count($l);$i++){
						if(aktivan($l[$i]))continue;
						echo "<p>".infoKorisnik($l[$i])."</p>";
					}
				
				?>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
		<?php
			function brojObjava(){
				$conn=conn();
				$sql="SELECT COUNT(*) from objave";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return $row["COUNT(*)"];
			}
			function infoKorisnik($id){
				$conn=conn();
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://crofiz.com/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]." ".levelSlika($id)."</a>";
				
			}
		?>
	</body>
</html>