			<div id="forumZadataka" style='margin-top: 5px;'>
				<div class='opis2' style="background: url('Slicice/kalkulator.jpg');background-size: cover;background-position: center; ">
					<strong class='naslovStranice'>Forum Zadataka</strong>
				</div>
			
				<div style='background-color: #383535;color:white;padding-top: 20px;' id="teme2">
					<strong style='margin-top:20px;' class='tamnije'>Zadaci</strong><br>
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
						document.getElementById("teme2").innerHTML+=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","dohvatiTeme.php?limit="+x,true);
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