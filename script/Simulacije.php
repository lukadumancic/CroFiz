<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<html>
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
				if ($(this).prop('href') == 'http://localhost/Ucenje.php') {
				  $(this).addClass('current');
				}
			  });
			});
			</script>
		
		<article>
			
			<div class='opis2' style="background: url('Slicice/simulacije-banner2.jpg');background-size: cover;background-position: center; ">
				<strong class='naslovStranice'>Simulacije</strong>
			</div>
			
			<div class='opis2'>
				<strong>CroFiz</strong> simulacije su stvorene kako bi vam pomogle pri učenju gradiva koje možda nije toliko intuitivno i jasno na prvi pogled.<br>
				Kako biste mogli pokrenuti naše simulacije, potrebno je skinuti program <strong><a class='black' href="http://www.algodoo.com/download/">Algodoo</a></strong>, a nakon toga otići na njihovu stranicu i skinuti <a class='black' href="http://www.algodoo.com/algobox/profile.php?id=25310"><strong>CroFiz simulacije</strong></a>
			</div>
			
			<div style='text-align: -webkit-center;'>
				<div class='paralelna3' style="background: url('Slicice/gear.jpg');background-size: cover;">
					<p><strong>1. </strong><a href="http://www.algodoo.com/download/">Algodoo</a></p>
				</div>
						
				<div class='paralelna3' style="background: url('Slicice/simulacije-simulacije.jpg');background-size: cover;">
					<p><strong>2. </strong><a href="http://www.algodoo.com/algobox/profile.php?id=25310">Simulacije</a></p>
				</div>
					
				<div class='paralelna3' style="background: url('Slicice/enjoy.jpg');background-size: cover;">
					<p><strong>3. </strong>Uživajte!</p>
				</div>	
			</div>
				
		</article>
		
		<footer id="fut">
			<?php include 'footer.php';?>
			
		</footer>
		
	</body>
</html>