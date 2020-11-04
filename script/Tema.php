<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>


<?php
	if(!isset($_GET["id"])){
		header("Location: http://localhost/Forum.php");
		die();
	}
	else if($_GET["id"]==""){
		header("Location: http://localhost/Forum.php");
		die();
	}
?>

<?php include 'prijavaScript.php'; ?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<head>
			<?php include 'head.php';?>
		</head>
		<body>
		
		<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
		<?php include 'navigacija.php';?>
		
		<script>
			//Dodatak navigaciji
			$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == 'http://localhost/Forum.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		<article id="art">
			<div id="extraNavigation">
				<a class='extraNavLink' id='extraNavForum' href="Forum.php?br=Forum">Forum</a>
				<a class='extraNavLink extraNavSelected' id='extraNavForumZadataka' href="Forum.php?br=ForumZadataka">Forum zadataka</a>
			</div>
		
			<div class='opis2' style="background: url('Slicice/kalkulator.jpg');background-size: cover;background-position: center;margin-top:4px; ">
					<strong class='naslovStranice'>Forum zadataka</strong>
				</div>
			
			<?php temaInfo(); ?>
		
			<?php if(prijavljen()==="True"){
				echo "<form method='post' action='unosObjaveTeme.php' style='margin-bottom: 20px;' >
					<strong class='tamnije'>Odgovor</strong><br>
					<input type='text' style='width:300px;' name='objava' placeholder='Recite što mislite'>
					<input type='hidden' name='id' value='".$_GET['id']."'><br>
					<input class='postaviObjavu' type='submit' value='Objavi'>
				</form>";
				echo '<br>';
			}
			else{
				echo "<br><br><br>";
			}
			?>
			<div id='objave'>
				<?php include 'temaObjave.php'; ?>
			</div>
			
			<script>
				function prikaziZadatak(){
					window.location='Zadatak.php?id=<?php echo $_GET["id"] ?>';
				}
			</script>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
		<?php
			function temaInfo(){
				$conn=conn();
				
				$sql="select * from zadaci where id=".$_GET["id"];
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows!==0){
					$row=$rez->fetch_assoc();
					echo "<div class='tamniDiv'>";
					echo "<div class='tamnije' style='font-size:17px;'><br>";
					echo obradiDatum($row["datum"]);
					echo "</div>";
					echo "<a href='Zadatak.php?id=".$_GET["id"]."' >".$row["ime"]."</a>";
					echo "<p style='background-color: #696969;padding: 1px;'></p>";
					echo "<p style='padding:20px;margin-top:-10px;'>".$row["tekst"]."</p>";
					echo "</div>";
				}
				else{
					return False;
				}
			}
			function temaIme(){
				$conn=conn();
				
				$sql="select * from zadaci where id=".$_GET["id"];
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows!==0){
					$row=$rez->fetch_assoc();
					return $row["ime"];
				}
				else{
					return False;
				}
			}
			
			function infoKorisnik2($id){
				$conn=conn();
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3 tamnije' style='font-size:17px;' href='http://localhost/Profil.php?nick=".$row["nick"]."'>".$row["ime"]." ".$row["prezime"]."</a>";
				
			}
			function infoKorisnik($id){
				$conn=conn();
				
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://localhost/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]."</a>";
				
			}

			
		?>
	</body>
</html>