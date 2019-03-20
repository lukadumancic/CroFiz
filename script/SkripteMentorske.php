			<?php echo ispisSkripte(); ?>
			<?php obrisiSkriptu(); ?>
			
			<div class='opis2' style="background: url('Slicice/student2.jpg');background-size: cover;background-position: center;margin-top:5px; ">
				<strong class='naslovStranice'>Mentosrke Skripte</strong>
			</div>
			
			<div class='opis2'>
				<strong>Mentorske skripte</strong> su ovdje kako bi pomogle učenicima!
			</div>
				
				<?php
					if(prijavljen()=="True"){
						if(profesor()){
							echo '<div class="paralelna1" style=\'background: url("Slicice/izrada.jpg");background-size: cover;background-position: center;\'>';
							echo "<p><strong>Dodavanje skripte</strong></p>";
							echo '<form method="post" enctype="multipart/form-data" action="uploadSkripta.php"><br>
							<input style="margin:5px;" type="text" name="ime" placeholder="Naziv" required>
							<input type="hidden" name="MAX_FILE_SIZE" value="20000000"><br>
							<div style="margin:5px;" class="fileUpload btn btn-primary">
								<img id="ikonaOdabir" src="Slicice/dodajSkriptu.jpg" style="height:50px;width:50px;">
								<input onchange="prikaziSliku()" class="upload" name="userfile" type="file" id="userfile" required>
							</div>
							<br>Grupa<br>'.
							dohvatiGrupe().
							'<br><br><input class="novaSkripta" name="upload" type="submit" id="upload" value="Upload"><br>
							</form>';
							echo "</div>";
							echo "<div class='opis2'>Skripte možete brisati i dodati koliko god puta hoćete!</div>";
						}
						else{
							
						}
						echo "<div class='opis2' style='background: url(\"Slicice/grupa-banner.jpg\");background-size: cover;background-position: center;'>
								<strong class='naslovStranice tamnije'>Grupe</strong>
							</div>";
					}
					else{
						echo "<div class='tamnije'>";
						include "prijaviteSe.php";
						echo "</div>";
					}
				?>
				
			
			<div id="mnt" >
			
				<?php
					if(prijavljen()=="True"){
						echo ispisiMentorskeSkripte();
					}
					
				?>
				
				<script>
					function prikaziSliku(){
						document.getElementById("ikonaOdabir").src="Slicice/dodajSkriptuOdabrano.jpg";
					}
				</script>
				
			</div>