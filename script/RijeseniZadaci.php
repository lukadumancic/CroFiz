<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php 
	if(prijavljen()=="False"){
		header("Location: http://localhost/Main.php");
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
		
		<script>
			//Dodatak navigaciji
			$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == 'http://localhost/Zadaci.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		
		<article id="art">	
			<div class='opis2' style="background: url('Slicice/banner-naslovna.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Riješeni zadaci</strong>
			</div>
			<div class='opis2'>
				Ovdje možete vidjeti točnost/netočnost svojih zadataka
			</div>
			<div class='opis2'>
				Točno riješeni zadaci
			</div>
			<div class='paralelna1' style="background: url('Slicice/tocno.jpg');background-size: cover;background-position: center; ">
			<?php 
				$conn=conn();
				$sql="select * from pokusaji where idkorisnik='".$_SESSION['userId']."' and tocnost='1'";
				$rez=$conn->query($sql);
				echo "<p>Točno riješeni zadaci</p>";
				if($rez->num_rows==0){
					echo "<p>Nemate točno riješenih zadataka</p>";
				}
				else{
					while($row=$rez->fetch_assoc()){
						echo "<p><a href='Zadatak.php?id=".$row['idzadatak']."'>".imeZadatka($row['idzadatak'])."</a></p>";
					}
				}
			?>
			</div>
			<div class='opis2'>
				Netočno riješeni zadaci
			</div>
			<div class='paralelna1' style="background: url('Slicice/netocno.jpg');background-size: cover;background-position: center; ">
			<?php 
				$conn=conn();
				$sql="select * from pokusaji where idkorisnik='".$_SESSION['userId']."' and tocnost='2'";
				$rez=$conn->query($sql);
				
				if($rez->num_rows==0){
					echo "<p>Nemate netočno riješenih zadataka</p>";
				}
				else{
					while($row=$rez->fetch_assoc()){
						echo "<p><a href='Zadatak.php?id=".$row['idzadatak']."'>".imeZadatka($row['idzadatak'])."</a></p>";
					}
				}
			?>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		<?php 
			function imeZadatka($id){
				$conn=conn();
				$sql="select ime from zadaci where id=$id";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				return $row["ime"];
			}
		
		?>
	</body>
</html>