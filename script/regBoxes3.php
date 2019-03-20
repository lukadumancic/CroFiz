<div class="overlay" id="overlayy">
			<div class="regBox" id="regBoxx" onmouseleave='izlazY()' onmouseover='ulazY()'>
				<img src='Slicice/zatvori.png' style="height:30px;width:30px;right: 0px;display: block;position: absolute;" onclick='sakrijRegistraciju()'>
				<form method="post" action="Registracija.php">
					<h2 style="font-size:25px;">Registracija</h2>
					<div class="regBox2" style="margin-top:30px;" >
						<input type="text" placeholder="Nick" name="nick" required><br>
						<input type="password" id="pass" placeholder="Password" name="pass" required><br>
						<input type="password" id="pass2" placeholder="Password*" name="pass2" onchange="provjeriPass()" required><br>
						<input type="email" placeholder="Email" name="email" required><br>
					</div>
					<div  class="regBox2" style="margin-left:100px;margin-top:30px;">
						<input type="text" placeholder="Ime" name="ime" required><br>
						<input type="text" placeholder="Prezime" name="prezime" required><br>
						<select name="obrazovanje">
							<option value="1">1. razred SŠ</option>
							<option value="2">2. razred SŠ</option>
							<option value="3">3. razred SŠ</option>
							<option value="4">4. razred SŠ</option>
							<option value="Profesor">Profesor</option>
						</select><br>
					</div>
					<input style="width: 100px;display: block;margin-right: 500px;margin-left: 250px;margin-top: 20px;" type="submit" value="Registriraj se!">
					</form>
			</div>
		</div>
		<div class="overlay" id="overlayx">
			<div class="regBox" id="regBoxx" onmouseleave='izlazX()' onmouseover='ulazX()'>
				<img id='sakrijZab' src='Slicice/zatvori.png' style="height:30px;width:30px;right: 0px;display: block;position: absolute;" onclick='sakrijZaboravljenu()'>
				<form method="post" action="Zaboravljena.php">
					<p>Unesite username ili email</p>
					<input type="text" name="userOrPass">
					<input type="submit" value="Pošalji">
				</form>
			</div>
		</div>
		<div class="overlay" id="overlayz">
			<div class="regBox" id="regBoxx" onmouseleave='izlazZ()' onmouseover='ulazZ()'>
				<img id='sakrijZab' src='Slicice/zatvori.png' style="height:30px;width:30px;right: 0px;display: block;position: absolute;" onclick='sakrijPrijavu()'>
				<form method="post">
					<p>Prijava</p>
					<input type="text" style="width: 18%;" placeholder="Nick" name="nickPrijava" required>
					<input type="password" style="width: 18%;" placeholder="Pass" name="passPrijava" required>
					<input type="submit" class="prijaviButton" value="Prijava">
				</form>
				<button type="button" class="registracijaButton" onClick="prikaziZaboravljenu()">Zaboravljena lozinka</button>
			</div>
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
			
			function sakrijZaboravljenu(){
				document.getElementById("overlayx").style.display='none';
			}
			function sakrijRegistraciju(){
				document.getElementById("overlayy").style.display='none';
			}
			function sakrijPrijavu(){
				document.getElementById("overlayz").style.display='none';
			}
			
			function izlazX(){
				document.getElementById("overlayx").onclick=function(){
					sakrijZaboravljenu();
				}
			}
			function ulazX(){
				document.getElementById("overlayx").onclick=function(){
					return;
				}
			}
			
			function izlazY(){
				document.getElementById("overlayy").onclick=function(){
					sakrijRegistraciju();
				}
			}
			function ulazY(){
				document.getElementById("overlayy").onclick=function(){
					return;
				}
			}
			function izlazZ(){
				document.getElementById("overlayz").onclick=function(){
					sakrijPrijavu();
				}
			}
			function ulazZ(){
				document.getElementById("overlayz").onclick=function(){
					return;
				}
			}
		</script>