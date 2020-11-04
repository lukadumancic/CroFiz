<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

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
			if ($(this).prop('href') == 'http://34.121.205.40/Ucenje.php') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		<article id="art">
			<div class='opis2' style="background: url('Slicice/videozapisi-banner2.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Videozapisi</strong>
			</div>
			<div class='opis2'>
				U suradnji s YouTube kanalom <strong><a class='black' href="https://www.youtube.com/channel/UC8Kl6Q2_CGcSqvmR6FMUnaQ/videos">Profesor Fizi Lab</a></strong> omogućujemo vam brojne videozapise koji će vam olakšati shvaćanje pojedinih gradiva vezanih za fiziku
			</div>
			
			<div>
				<iframe width="640" height="360" src="https://www.youtube.com/embed/4I-4Wsdj3eg" frameborder="0" allowfullscreen></iframe>
				<iframe width="640" height="360" src="https://www.youtube.com/embed/2hdLRuSfcus" frameborder="0" allowfullscreen></iframe>
				<iframe width="640" height="360" src="https://www.youtube.com/embed/IVBXuS5PoLQ" frameborder="0" allowfullscreen></iframe>
				<iframe width="640" height="360" src="https://www.youtube.com/embed/lDBIlkbKL00" frameborder="0" allowfullscreen></iframe>
			</div>
			
			<div class='opis2'>
				Ostatak videozapisa možete pogledati na YouTube kanalu <strong><a class='black' href="https://www.youtube.com/channel/UC8Kl6Q2_CGcSqvmR6FMUnaQ/videos">Profesor Fizi Lab</a></strong>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
		<?php
			
		?>
	</body>
</html>