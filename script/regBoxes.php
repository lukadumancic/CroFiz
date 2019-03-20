<div id="registracijaForm" class='box'>
	<form method="post" action="Registracija.php">
		<br><strong >Registriraj se besplatno!</strong>
		<svg class='izlaz' onclick='zatvoriRegBoxes()'>
			<line x1="0" y1="0" x2="25" y2="25" style="stroke: #CECECE;stroke-width:2" />
			<line x1="0" y1="25" x2="25" y2="0" style="stroke: #CECECE;stroke-width:2" />
		</svg>
		<div class="regBox2" style="margin-top:30px;" >
			<strong style="font-size:20px;color: #45739C;">Podaci za prijavu</strong><br>
			<input type="text" placeholder="Nick" name="nick" value="<?php if(isset($_SESSION["nickReg"])){echo $_SESSION["nickReg"];} ?>" required><br>
			<input type="password" id="pass" placeholder="Password" name="pass" required><br>
			<input type="password" id="pass2" placeholder="Password*" name="pass2" onchange="provjeriPass()" required><br>
			<input type="email" placeholder="Email" name="email" value="<?php if(isset($_SESSION["emailReg"])){echo $_SESSION["emailReg"];} ?>" required><br>
			
			<strong style="font-size:20px;color: #45739C;">Osobni podaci</strong><br>
			<input type="text" placeholder="Ime" name="ime" value="<?php if(isset($_SESSION["imeReg"])){echo $_SESSION["imeReg"];} ?>" required><br>
			<input type="text" placeholder="Prezime" name="prezime" value="<?php if(isset($_SESSION["prezimeReg"])){echo $_SESSION["prezimeReg"];} ?>" required><br>
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
		<br><strong>Unesite email</strong>
		<svg class='izlaz' onclick='zatvoriRegBoxes()'>
			<line x1="0" y1="0" x2="25" y2="25" style="stroke: #CECECE;stroke-width:2" />
			<line x1="0" y1="25" x2="25" y2="0" style="stroke: #CECECE;stroke-width:2" />
		</svg>
		<br>
		<br>
		<input type="email" placeholder="email" name="userOrPass">
		<input type="submit" style="margin-bottom: 40px;" value="Pošalji">
		<br>
	</form>
</div>

<div id="prijavaForm" class='box'>
	<form method="post">
		<br><strong>Prijava</strong>
		<svg class='izlaz' onclick='zatvoriRegBoxes()'>
			<line x1="0" y1="0" x2="25" y2="25" style="stroke: #CECECE;stroke-width:2" />
			<line x1="0" y1="25" x2="25" y2="0" style="stroke: #CECECE;stroke-width:2" />
		</svg>
		<br><br>
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
			function zatvoriRegBoxes(){
				sakrijZaboravljenu();
				sakrijRegistraciju();
				sakrijPrijavu();
			}
		
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
				$('html').animate({scrollTop:0}, 'slow');
				$('body').animate({scrollTop:0}, 'slow');
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
				$('html').animate({scrollTop:0}, 'slow');
				$('body').animate({scrollTop:0}, 'slow');
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