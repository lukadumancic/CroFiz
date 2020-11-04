<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<head>
			<?php include 'head.php';?>
			<style>
			</style>
		</head>
		<body>
			
			<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
			<?php include 'navigacija.php';?>
			<script>
			//Dodatak navigaciji
				$(function(){
			  $('a').each(function() {
				if ($(this).prop('href') == 'http://localhost/Ucenje.php') {
				  $(this).addClass('current');
				}
			  });
			});
			</script>
			
			
			
			<article id="art">
				
				<div id="extraNavigation" style="margin-bottom: 5px;">
					<a class='extraNavLink' href="Skripte.php">Skripte</a>
					<a class='extraNavLink' href="Simulacije.php">Simulacije</a>
					<a class='extraNavLink' href="Videozapisi.php">Videozapisi</a>
				</div>
					
				<div class='opis2' style="background: url('Slicice/ucenje-banner4.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Učenje</strong>
				</div>
				
				<div class='opis2'>
					<strong>CroFiz</strong> vam nudi bogatu ponudu skripti, simulacija i videozapisa iz kojih možete svakodnevno učiti
				</div>
				
				<div style='text-align: -webkit-center;'>
					<div class='paralelna3' style="background: url('Slicice/ucenje-skripte.jpeg');background-size: cover;">
						<p><a href="Skripte.php">Skripte</a></p>
					</div>
						
					<div class='paralelna3' style="background: url('Slicice/ucenje-simulacije.jpg');background-size: cover;">
						<p><a href="Simulacije.php">Simulacije</a></p>
					</div>
					
					<div class='paralelna3' style="background: url('Slicice/forumNaslovna.jpg');background-size: cover;">
						<p><a href="Videozapisi.php">Videozapisi</a></p>
					</div>
					
				</div>
				
			
			</article>
			
			<footer>
				<?php include 'footer.php'; ?>
			</footer>
			
			
			
			
		</body>
</html>