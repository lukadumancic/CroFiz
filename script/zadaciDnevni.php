			<div id="dnevni" style='margin-top:5px'>
			
				<div class='opis2' style="background: url('Slicice/ucenje-banner4.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Dnevni zadaci</strong>
				</div>
				
				<div class='opis2' style='font-size:25px;'>Svakoga dana točno u podne stižu novi, svježi zadaci!</div>
				
				
					
				<div class="ispisZadataka">
					
					<?php
						if(!profesor2()){
							echo ispisiDnevni();
							echo "<div class='opis2'>Dnevni zadaci u zadnjih 7 dana</div>";
						}
						
						echo ispisiSveDnevne();
					?>
				</div>
				
				<div class='opis2'>
					Pratite svoj napredak na <a href="RankLista.php" class="black">Ranklisti!</a><br>
				</div>
			
			</div>