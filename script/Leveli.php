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
		
		
			<div class='opis2' style="background: url('Slicice/leveli-banner.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Leveli</strong>
			</div>
			
			<div class='opis2'>
				Ovdje možete vidjeti tko je najbolji po XP-u na <strong>CroFiz</strong>-u
			</div>
			
			<div class='paralelna1' style="background: url('Slicice/progress.jpg');background-size: cover;background-position: center; " >
				<?php include "XPrank.php"; ?>
			</div>
			
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
		</footer>
		
		<?php
			
		?>
	</body>
</html>