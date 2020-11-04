<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>

<?php
	if(prijavljen()=="True"){
		header("Location: http://localhost/Naslovna.php");
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
			
			<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
			<?php include 'navigacija.php';?>
			
			<article id="art" >
				
				<script language="JavaScript"> 
					var i = 1; 
					var j = 1;

					function swapImage() 
					{ 
					document.getElementById("slider"+j.toString()).style.display='none';
					j=i;
					document.getElementById("slider"+i.toString()).style.display='block';
					if(i < 11){
						i++; 
						setTimeout("swapImage()",2500); 
					}
					else {
						i = 1; 
						setTimeout("swapImage()",6000); 
					}
					
					} 
					window.onload=swapImage; 
					
				</script> 
				
				<div id="slideshow" style="height:70%">
					<div class="slider" id="slider1" style="background-image:url('Slicice/nature.jpeg')">
						<p class="sliderText">"Physics is hidden in the nature..."</p>
					</div>
					<div class="slider" id="slider2" style="background-image:url('Slicice/community.jpg'); display:none;">
						<p class="sliderText">"...Physics are the people..."</p>
					</div>
					<div class="slider" id="slider3" style="background-image:url('Slicice/water.jpg'); display:none;">
						<p class="sliderText">"...Physics can be found in the seas..."</p>
					</div>
					<div class="slider" id="slider4" style="background-image:url('Slicice/sky.jpg'); display:none;">
						<p class="sliderText">"...Skies..."</p>
					</div>
					<div class="slider" id="slider5" style="background-image:url('Slicice/winter.jpg'); display:none;">
						<p class="sliderText">"...And frozen lakes..."</p>
					</div>
					<div class="slider" id="slider6" style="background-image:url('Slicice/light.jpg'); display:none;">
						<p class="sliderText">"...Physics is all around us..."</p>
					</div>
					<div class="slider" id="slider7" style="background-image:url('Slicice/smallthings.jpg'); display:none;">
						<p class="sliderText">"...You just have to look closer..."</p>
					</div>
					<div class="slider" id="slider8" style="background-image:url('Slicice/stars.jpg'); display:none;">
						<p class="sliderText">"...Or think greater..."</p>
					</div>
					<div class="slider" id="slider9" style="background-image:url('Slicice/path.jpg'); display:none;">
						<p class="sliderText">"...Find your path..."</p>
					</div>
					<div class="slider" id="slider10" style="background-image:url('Slicice/sky2.jpeg'); display:none;">
						<p class="sliderText">"...And help others see the sky..."</p>
					</div>
					<div class="slider" id="slider11" style="background-image:url('Slicice/changes.jpeg'); display:none;">
						<p class="sliderText">"...Join CroFiz and make changes!"</p>
					</div>
				</div>
				
				
				<div class='opis2'>
					<?php include 'logo.svg'; ?>
					<br>
					<br>
					<strong>CroFiz</strong> je web stranica namjenjena učenicima, profesorima i svim fizičarima u njihovoj potrazi za znanjem!
				</div>
				
				<div style='text-align: -webkit-center;'>
					<div class='paralelna3' style="background: url('Slicice/learning.jpeg');background-size: cover;">
						<p><a href="Ucenje.php">Učenje</a></p>
					</div>
						
					<div class='paralelna3' style="background: url('Slicice/kalkulator.jpg');background-size: cover;">
						<p><a href="Zadaci.php">Zadaci</a></p>
					</div>
					
					<div class='paralelna3' style="background: url('Slicice/forumNaslovna.jpg');background-size: cover;">
						<p><a href="Forum.php">Forum</a></p>
					</div>
				</div>
				
				<div class='opis2'>
					<strong>CroFiz</strong> je savršeno mjesto za one koji vole fiziku!
				</div>
				
				<div style='text-align: -webkit-center;'>
					<div class="paralelna2" style="background: url('Slicice/student.jpg');background-size: cover;">
						<p>Spojite se sa svojim profesorom, učenicima, prijateljima ili kolegama   </p>
					</div>
					
					<div class="paralelna2" style="background: url('Slicice/astronaut.jpg');background-size: cover;">
						<p>Postanite dio zajednice <strong>CroFiz</strong> i izgradite bolji svijet</p>
					</div>
				</div>
				
				
				<div class='opis2'>
					<strong>Registriraj se već sada i to besplatno!</strong>
				</div>
				
				<button type="button" class="registracijaButton2" onClick="prikaziRegistraciju()">Registracija</button>
			
			</article>
			
			<footer>
				<?php include 'footer.php'; ?>
			</footer>
			
			
			
			
		</body>
</html>