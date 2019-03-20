			<div id="forum" style='margin-top: 5px;'>
				<div class='opis2' style="background: url('Slicice/forum-banner.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Forum</strong>
				</div>
				<?php
					if(prijavljen()=="True"){
					echo '<form style="padding-top: 10px;padding-bottom: 10px;" method="post" action="otvaranjeTeme.php">
						<strong>Otvaranje nove teme</strong><br>
						<input type="text" name="ime" placeholder="Naslov" required>
						<textarea class="tekstNovaTema" style="height:auto;" name="tekst" cols="40" rows="5" placeholder="Tekst" required></textarea>
						<input class="otvoriNovuTemu" type="submit" value="Otvori novu temu">
					</form>';
					}?>
					
					<br>
					<div style='margin-top: -28px;background-color: #383535;color:white;padding-top: 20px;' id="teme1">
						<strong style='margin-top:20px;' class='tamnije'>Teme</strong><br>
						<p style='background-color: #696969;padding: 1px;'></p>
					</div>
					<script>
							var x=0;
							function dodajTeme()
							{
								x+=10;
							var xmlhttp;    
							if (window.XMLHttpRequest)
							  {// code for IE7+, Firefox, Chrome, Opera, Safari
							  xmlhttp=new XMLHttpRequest();
							  }
							else
							  {// code for IE6, IE5
							  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							  }
							xmlhttp.onreadystatechange=function()
							  {
							  if (xmlhttp.readyState==4 && xmlhttp.status==200)
								{
								document.getElementById("teme1").innerHTML+=xmlhttp.responseText;
								}
							  }
							xmlhttp.open("GET","dohvatiTeme2.php?limit="+x,true);
							xmlhttp.send();
							}
							
							//Dodavanje objava prilikom otvaranja stranice
							dodajTeme();
							
							window.onscroll = function(ev) {
								if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
									dodajTeme();
								}
							}
						</script>
				</div>