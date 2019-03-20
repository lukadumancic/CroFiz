			<div id="mentorski" style='margin-top:5px;'>
				<div class='opis2' style="background: url('Slicice/mentorski-izazov-banner.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Mentorski Izazov</strong>
				</div>
				<div class='opis2' style='font-size:30px;'>
					<strong>Mentorski Izazov</strong> je skup zadataka koje profesor radi za svoje učenike.
				</div>
				<?php
					if(prijavljen()=="True"){
						if(profesor()){
							include 'noviIzazov.php';
						}
						echo "<div class='opis2' style='background: url(\"Slicice/grupa-banner.jpg\");background-size: cover;background-position: center; '>
							<strong class='naslovStranice'>Grupe</strong>
						</div>";
						echo ispisMentorskih();
					}
					else{
						include 'prijaviteSe.php';
					}
				?>
				
			</div>