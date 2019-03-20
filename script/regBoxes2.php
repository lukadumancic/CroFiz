<div id="registracijaForm" class='box'>
	<form method="post" action="Registracija.php">
		<br><strong>Registriraj se besplatno!</strong><br>
		<div class="regBox2" style="margin-top:30px;" >
		
			<strong style="font-size:20px;color: #45739C;">Podaci za prijavu</strong><br>
			<input type="text" placeholder="Nick" name="nick" required><br>
			<input type="password" id="pass" placeholder="Password" name="pass" required><br>
			<input type="password" id="pass2" placeholder="Password*" name="pass2" onchange="provjeriPass()" required><br>
			<input type="email" placeholder="Email" name="email" required><br>
			
			<strong style="font-size:20px;color: #45739C;">Osobni podaci</strong><br>
			<input type="text" placeholder="Ime" name="ime" required><br>
			<input type="text" placeholder="Prezime" name="prezime" required><br>
			<select name="obrazovanje">
				<option value="1">1. razred SŠ</option>
				<option value="2">2. razred SŠ</option>
				<option value="3">3. razred SŠ</option>
				<option value="4">4. razred SŠ</option>
				<option value="Profesor">Profesor</option>
			</select><br>
			<input class="registrirajSe" type="submit" value="Registriraj se!">
		</div>
	</form>
</div>

<div id="zaboravljenoForm" class='box'>
	<form method="post" action="Zaboravljena.php">
		<br><strong>Unesite username ili email</strong><br><br>
		<input type="text" name="userOrPass">
		<input type="submit" style="margin-bottom: 40px;" value="Pošalji">
		<br>
	</form>
</div>

<div id="prijavaForm" class='box'>
	<form method="post">
		<br><strong>Prijava</strong><br><br>
		<input type="text" placeholder="Nick" name="nickPrijava" required>
		<input type="password" placeholder="Pass" name="passPrijava" required>
		<br>
		<input type="submit" class="prijaviButton" value="Prijava">
	</form>
	<?php
	if(isset($_SESSION["zabLoz"])){
		if($_SESSION["zabLoz"]==1){
			echo '<button type="button" class="zaboravljenaButton" onClick="prikaziZaboravljenu()">Zaboravljena lozinka</button>';
		}
	}
	?>
</div>
			
			
		<script type='text/javascript'>
			function provjeriPass(){
				if(document.getElementById("pass2").value==document.getElementById("pass").value){
					document.getElementById("pass2").style.border="2px solid #06DE26";
					document.getElementById("pass").style.border="2px solid #06DE26";
				}
			    else{
					document.getElementById("pass2").style.border="2px solid #DE0606";
					document.getElementById("pass").style.border="2px solid #DE0606";
				}
			}
			
			function prikaziRegistraciju(){
				sakrijZaboravljenu();
				sakrijPrijavu();
				document.getElementById("registracijaForm").style.display='block';
			}
			function prikaziZaboravljenu(){
				sakrijRegistraciju();
				sakrijPrijavu();
				document.getElementById("zaboravljenoForm").style.display='block';
			}
			function prikaziPrijavu(){
				sakrijZaboravljenu();
				sakrijRegistraciju();
				document.getElementById("prijavaForm").style.display='block';
			}
			
			function sakrijZaboravljenu(){
				document.getElementById("zaboravljenoForm").style.display='none';
			}
			function sakrijRegistraciju(){
				document.getElementById("registracijaForm").style.display='none';
			}
			function sakrijPrijavu(){
				document.getElementById("prijavaForm").style.display='none';
			}
			
		</script>