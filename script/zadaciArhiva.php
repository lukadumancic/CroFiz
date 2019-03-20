			<div id="arhiva" class="divZadaci">
				<p class="odabrano" style='background: url("Slicice/bannerB.png");'>Arhiva zadataka</p><br>
				
				<strong style='display:block;'>Ako želiš provjeriti naučeno, ovo je pravo mjesto!</strong>
				<img src="Slicice/arhiva.jpg" class='krugSlika' style='opacity:1.0;margin-top:10px;margin-bottom:-10px;'>
				
				<p style='color: #989898;'>Posljednji zadaci</p>
				<?php echo zadnjiZadaci(); ?>
				<p class="bijeliPar">Razredi</p>
				<div id="navRazredi"></div>
				<br>
				<?php
					for($i=1;$i<=4;$i++){
						echo "<div class='arhiva' id='arhiva$i' style='display:none;'>";
						echo "<div id='navigacijaArhiva$i' style='display: -webkit-inline-box;padding: 50px;padding-top: 0px;'><strong>Područje</strong><br></div>";
						echo "<div id='zadaciArhiva$i' style='display:inline-block;padding: 50px;padding-top: 0px;'></div>";
						echo "</div>";
						dohvatiPodrucja($i);
					}
				?>
				<script>
					for (i=1;i<=4;i++){
						document.getElementById("navRazredi").innerHTML+="<button style='width: 120px;' class='navZadaci' id='razred"+i+"' onClick='prikaziRazred("+i+")'>"+i+". razred</button>";
					}
					function prikaziRazred(x){
						for(i=1;i<=4;i++){
							document.getElementById("arhiva"+i).style.display="none";
							document.getElementById("razred"+i).style.color="";
						}
						document.getElementById("razred"+x).style.color="#989898";
						document.getElementById("arhiva"+x).style.display="block";
						
						prikaziArhivuZad('sve'+x);
					}
					
					
					var arh="0";
					function prikaziArhivuZad(p){
						p=p.toString();
						if(arh==0){
							arh=p;
						}
						else{
							document.getElementById(arh).style.display="none";
							arh=p;
						}
						document.getElementById(p).style.display="block";
					}
					
					
				</script>
				
			</div>