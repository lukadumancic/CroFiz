<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://34.121.205.40/Main.php");
		die();
	}
	if(!profesor2()){
		header("Location: http://34.121.205.40/Main.php");
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
			<div class='opis2' style="background: url('Slicice/slanje-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Slanje zadataka</strong>
			</div>
				
			<div class='opis2'>
				Vašim učenicima ćete pružiti nove zadatke i tako osigurati kvalitetno učenje.
			</div>
			
			<div class='paralelna1' style="background: url('Slicice/dokumenti.jpg');background-size: cover;background-position: center; ">
				<p>Slanje zadatka</p>
				<form method="post" action="posaljiZadatak.php">
					<input name="naslov" type="text" placeholder="Naslov zadatka" required><br>
					<textarea style="height:auto;" name="tekst" cols="40" rows="5" placeholder="Tekst zadatka" required></textarea><br>
					<input name="rjesenje" type="text" placeholder="Rješenje zadatka" required><br>
					<input name="mjerna" type="text" placeholder="Mjerna jedinica" required><br>
					<input type="submit" value="Pošalji">
				</form>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
	</body>
</html>