			<div id="osnovno">
			
				<div class='opis2' style="background: url('Slicice/ucenje-banner4.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Zadaci</strong>
				</div>
				
				<div class='opis2'>
					<strong>CroFiz</strong> vam pruža mogućnost da birate između više vrsta rješavanja zadataka. Možete rješavati zadatke na klasičan način ili pak izazvati prijatelje na dvoboj. Odabir ovisi isključivo o vama.
				</div>
			
				<div style='text-align: -webkit-center;'>
					<div class='paralelna3' style="background: url('Slicice/sat.jpg');background-size: cover;">
						<p><a href="?br=Dnevni">Dnevni</a></p>
					</div>
						
					<div class='paralelna3' style="background: url('Slicice/tjedan.jpg');background-size: cover;">
						<p><a href="?br=Tjedni">Tjedni</a></p>
					</div>
					
					<div class='paralelna3' style="background: url('Slicice/blackboard.jpg');background-size: cover;">
						<p><a href="?br=Mentorski">Mentorski</a></p>
					</div>
					<div class='paralelna2' style="background: url('Slicice/challenge.jpg');background-size: cover;">
						<p><a href="?br=Dvoboj">Dvoboj</a></p>
					</div>
					
					<div class='paralelna2' style="background: url('Slicice/arhiva.jpg');background-size: cover;">
						<p><a href="?br=Arhiva">Arhiva</a></p>
					</div>
					
				</div>
				
				<div class='opis2'>
					Rješavajući <a class='black underline' href="?br=Dnevni">Dnevne</a> i <a class='black underline' href="?br=Tjedni">Tjedne</a> zadatke, dobivate bodove kojima napredujete na rank listi!
				</div>
				
				<div class='paralelna1' style="background: url('Slicice/progress.jpg');background-size: cover;">
					<p><a href="RankLista.php">Ranklista</a></p>
				</div>
				<?php if(prijavljen()=="True"){
					echo "<div class='opis2'>
						Ovdje možete provjeriti svoju točnost/netočnost svojih zadataka
					</div>
					
					<div class='paralelna1' style='background: url(\"Slicice/tocno.jpg\");background-size: cover;'>
						<p><a href='RijeseniZadaci.php'>Riješeni zadaci</a></p>
				</div>";
				}
				?>
			</div>