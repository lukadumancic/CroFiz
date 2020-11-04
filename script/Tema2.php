<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>


<?php
	if(!isset($_GET["id"])){
		header("Location: http://34.121.205.40/Forum.php");
		die();
	}
	else if($_GET["id"]==""){
		header("Location: http://34.121.205.40/Forum.php");
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
			if ($(this).prop('href') == 'http://34.121.205.40/Forum.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		<article id="art">
		
			<div id="extraNavigation">
				<a class='extraNavLink extraNavSelected' id='extraNavForum' href="Forum.php?br=Forum">Forum</a>
				<a class='extraNavLink' id='extraNavForumZadataka' href="Forum.php?br=ForumZadataka">Forum zadataka</a>
			</div>
		
			<div class='opis2' style="background: url('Slicice/forum-banner.jpg');background-size: cover;background-position: center;margin-top:4px; ">
					<strong class='naslovStranice'>Forum</strong>
				</div>
			
			<?php temaInfo(); ?>
		
			<?php if(prijavljen()==="True"){
				echo "<form method='post' action='unosObjaveTeme2.php' style='margin-bottom: 20px;' >
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
				<?php include 'temaObjave2.php'; ?>
			</div>
			
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
		<?php

			function temaInfo(){
				$conn=conn();
				
				$sql="select * from forum where id=".$_GET["id"];
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows!==0){
					$row=$rez->fetch_assoc();
					echo "<div class='tamniDiv'>";
					echo "<div class='tamnije' style='font-size:17px;'>";
					echo infoKorisnik2($row['idkorisnik'])."<br>";
					echo obradiDatum($row["datum"]);
					echo "</div>";
					echo "<p style='font-size:17px;' >".$row["ime"]."</p>";
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
				
				$sql="select * from forum where id=".$_GET["id"];
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
				return "<a class='nick3 tamnije' href='http://34.121.205.40/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]." ".levelSlika($id)."</a>";
				
			}
			function infoKorisnik($id){
				$conn=conn();
				
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' href='http://34.121.205.40/Profil.php?nick=".$row["nick"]."'>".slika($id).$row["ime"]." ".$row["prezime"]." ".levelSlika($id)."</a>";
				
			}
			
			
		?>
	</body>
</html>