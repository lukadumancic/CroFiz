			<div id="tjedni" style="margin-top: 4px;">
			
				<div class='opis2' style="background: url('Slicice/month.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Tjedni zadaci</strong>
				</div>
				
				<div class='opis2' style='font-size:25px;'>
					Svaki tjedan, teži zadatak jedan!
				</div>
				
				<div class="ispisZadataka">
					<?php
						if(!profesor2()){
							echo ispisiTjedni();
							echo "<div class='opis2'>Tjedni zadaci za sve razrede</div>";
						}
						echo ispisiSveTjedne();
					?>
				</div>
				
				<div class='opis2'>
					Pratite svoj napredak na <a href="RankLista.php" class="black">Ranklisti!</a><br>
				</div>
				
			</div>