<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="False"){
		header("Location: http://34.121.205.40/Main.php");
		die();
	}
?>

<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<head>
			<?php include 'head.php';?>
			<style>
			</style>
		</head>
		<body>
			
			<?php include 'navigacija.php';?>
			
			
			
			<article id="art">
				
					
				<div class='opis2' style="background: url('Slicice/challenge2.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Postignuća</strong>
				</div>
				
				<div class='opis2'>
					<?php if(profesor2()){
						echo "Postignuća neka vam budu smjernice kako pomoći svojim učenicima! Za svako ispunjeno postignuće dobijete <strong>CroFiz Pointse</strong> i <strong>XP</strong>";
					}
					else{
						echo "Postignuća neka vam budu cilj i poticaj prilikom učenja! Za svako ispunjeno postignuće dobijete <strong>CroFiz Pointse</strong> i <strong>XP</strong>";
					}
					?>
				</div>
				
				<?php 
					if(profesor2()){
						include "postignucaProfesor.php";
					}
					else{
						include "postignucaUcenik.php";
					}
				?>
				
			
			</article>
			
			<footer>
				<?php include 'footer.php'; ?>
			</footer>
			
			
			
			
		</body>
</html>