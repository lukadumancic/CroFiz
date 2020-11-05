
		
		<div id="navigacija" class="navigacija">
			<header>
				<div class='crofiz'><a href="http://crofiz.com">CROFIZ</a></div>
			</header>
			<nav>
				<div id="nav" >
				
					<div id="nav2">
						<span class="mob" onClick='prikazNav1()'></span>
					</div>
					
					<script>
					
					var dis="block";
						function prikazNav1(){
							document.getElementById("nav1").style.display=dis;
							if(dis=="block"){
								dis="none";
							}
							else{
								dis="block";
							}
						}
					</script>
					
					<div id="nav1">
						<?php if(prijavljen()!=="True"){echo '<a class="navbutton" href="http://34.121.205.40/Main.php">Početna</a>';} ?>
						<?php if(prijavljen()==="True"){echo '<a class="navbutton" href="http://34.121.205.40/Naslovna.php">Naslovna</a>';} ?>
						<?php if(prijavljen()==="True"){echo '<a class="navbutton" href="http://34.121.205.40/Profil.php">Profil</a>';} ?>
						<?php if(prijavljen()==="True"){echo '<a class="navbutton" href="http://34.121.205.40/Grupe.php">Grupe</a>';} ?>
						<a class="navbutton" href='http://34.121.205.40/Zadaci.php'>Zadaci</a>
						<a class="navbutton" href='http://34.121.205.40/Forum.php'>Forum</a>
						<a class="navbutton" href='http://34.121.205.40/Ucenje.php'>Učenje</a>
						<div class='trazi'>
							<?php if(prijavljen()==="True"){echo '<label for="tags"><img class="povecalo" src="Slicice/povecalo.png" onclick="prikaziTrazilicu()" ></label>';} ?>
							<script>
								function prikaziTrazilicu(){
									document.getElementById("trazilica").style.display="inline";
								}
							</script>
							<?php 
								if(prijavljen()==="True"){echo 
									'<div id="trazilica" style="display:none;">
										<form action="Rezultati.php" method="get" style="display:inline;">
											<div class="ui-widget" style="display:inline;">
												<label for="tags"></label>
												<input name="trazilica" id="tags" placeholder="Tražilica" required>
											</div>
											<input type="submit" style="visibility: hidden;width:0px;margin:0px;">
										</form>
									</div>';
								}
							?>
						</div>
					
				
				<p></p>
				</div>

			</nav>
			<div id="logReg" >
					
					<?php 
						//Ako nitko nije prijavljen ispisuje se prostor za prijavu, inače ime korisnika i logout button
						if(prijavljen()==="False"){echo '
							<button type="button" class="prijavaButton" onClick="prikaziPrijavu()">Prijava</button>	
							<button type="button" class="registracijaButton" onClick="prikaziRegistraciju()">Registracija</button>
						';}
						else{

							echo "<div class='dodaci'>";
							echo "<a onmouseover='prikaziPoruke()' href='Poruke.php' title='Poruke'>
							<div class='brojPoruka' id='brPoruka'></div>
							<img style='margin-right: -6px;height: 40px;width: 40px;' src='Slicice/poruka.jpg'>
							</a>";
							echo "<div id='poruke' style='display:none;' onmouseleave='sakrijPoruke()'>";
							echo "</div>";
							echo "</div>";
							
							echo "<div class='dodaci'>";
							echo "<a onmouseover='prikaziObavijesti()' class='nick2' title='Obavijesti'><div id='brObavijesti' class='brojObavijesti'></div><img alt style='height:40px;width:40px;' src='Slicice/notification.jpg'></a>";
							echo "<div id='obavijesti' style='display:none;' onmouseleave='sakrijObavijesti()'>";
							echo "</div>";
							echo "</div>";
							
							
							echo "<div class='dodaci'>";
							echo "<div style='display: inline;' onmouseover='prikaziDodatak()' class='nick2'>".mojaSlika()."</div>";
							echo "<div id='dodatak' style='display:none;' onmouseleave='sakrijDodatak()'>";
							echo "<a href='http://34.121.205.40/Profil.php?nick=".$_SESSION["korisnickoIme"]."'>".mojaSlika()."</a><br>";
							echo "<a href='http://34.121.205.40/Profil.php?nick=".$_SESSION["korisnickoIme"]."'>".getName($_SESSION["userId"])." ".getSurName($_SESSION["userId"])."</a>";
							echo "<br>".cp()." <img src='Slicice/cp.png' style='width:15px;height:15px;'>";
							echo '<a style="display: inherit;" href="Leveli.php"><div class="levelanje">
								<div class="prikazLevela">'.level1($_SESSION["userId"]).'</div><br>
									<div class="progress2">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:'.postotak($_SESSION["userId"]).'%">
										'.level2($_SESSION["userId"]).'
										</div>
									</div>
								</div></a>';
								
							//DODATNI LINKOVI
							
							echo "<a class='gold dodatak' href='Postignuca.php'>Postignuća</a>";
							echo "<a class='dodatak' href='Prijatelji.php'>Prijatelji</a>";
							echo "<a class='dodatak' href='Postavke.php'>Postavke</a>";
							echo "<a class='dodatak' href='PromjenaLozinke.php'>Promjena lozinke</a>";
							
							if(profesor2()){
								echo "<a class='dodatak' href='SlanjeZadataka.php'>Pošaljite nam zadatke</a>";
							}
							echo "<form class='dodatak' method='post' style='display:inline;'><input type='hidden' style='display:inline;bottom: 10px;position: absolute;'  name='logOut' value='1'><input class='odjavaGumb' type='submit' value='Odjava'></form>";
							echo "</div>";
							echo "</div>";
							
							echo'
							<script>
								document.getElementById("logReg").style.marginTop="0px";
							</script>';
						}
					?>
					<script>
						
						
						function prikaziDodatak(){
							sakrijObavijesti();
							sakrijPoruke();
							document.getElementById("dodatak").style.display='block';
						}
						function sakrijDodatak(){
							document.getElementById("dodatak").style.display='none';
						}
						
						function prikaziObavijesti(){
							obav();
							sakrijDodatak();
							sakrijPoruke();
							document.getElementById("obavijesti").style.display='block';
						}
						function sakrijObavijesti(){
							document.getElementById("obavijesti").style.display='none';
						}
						
						function prikaziPoruke(){
							por();
							sakrijDodatak();
							sakrijObavijesti();
							document.getElementById("poruke").style.display='block';
						}
						function sakrijPoruke(){
							document.getElementById("poruke").style.display='none';
						}
						
						function sakrij(){
							sakrijDodatak();
							sakrijObavijesti();
							sakrijPoruke();
						}
					</script>
				</div>
		</div>
		
		
		<script>
		//Posjecena stranica u navigaciji se oboji drugom bojom
		//css-> a.current
		$(function(){
		  $('a').each(function() {
			if ($(this).prop('href') == '<?php echo 'http://34.121.205.40'.substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],".php")+4) ?>') {
			  $(this).addClass('current');
			}
		  });
		});
		</script>
		
		
		
		<script>
			<?php 
				if(prijavljen()==="True"){
					echo '
					brojObavijesti();
					brojPoruka();
					window.setInterval(brojObavijesti, 10000);
					window.setInterval(brojPoruka, 10000);';
				}
			?>
		
			function obav()
				{
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
						if(xmlhttp.responseText.indexOf("a")==-1){
							console.log("0");
						}
						else{
							document.getElementById("obavijesti").innerHTML=xmlhttp.responseText;
						}
						}
					  }
					  //x=0 oznacava max 10 obavijesti
				xmlhttp.open("GET","obavijesti.php?x=0",true);
				xmlhttp.send();
				}
			function por()
				{
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
						if(xmlhttp.responseText.indexOf("a")==-1){
							console.log("0");
						}
						else{
							document.getElementById("poruke").innerHTML=xmlhttp.responseText;
						}
						}
					  }
				xmlhttp.open("GET","poruke2.php",true);
				xmlhttp.send();
				}
			function brojPoruka()
				{
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
						document.getElementById("brPoruka").innerHTML=xmlhttp.responseText;
						}
					  }
				xmlhttp.open("GET","brojPoruka.php",true);
				xmlhttp.send();
				}
			function brojObavijesti()
				{
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
						document.getElementById("brObavijesti").innerHTML=xmlhttp.responseText;
						}
					  }
				xmlhttp.open("GET","brojObavijesti.php",true);
				xmlhttp.send();
				}
		</script>
		
		
		<?php
			function imena(){
				if(prijavljen()=="True"){
					$conn=conn();
					$sql="select ime,prezime,nick from korisnici";
					$rezultat=$conn->query($sql);
					while($row=$rezultat->fetch_assoc()){
						echo "'".$row["ime"]." ".$row["prezime"]."'";
						echo ",";
						echo "'".$row["nick"]."'";
						echo ",";
					}
					$conn->close();
				}
			}
			function imena2(){
				if(prijavljen()=="True"){
					$conn=conn();
					$sql="select ime,prezime,nick from korisnici";
					$rezultat=$conn->query($sql);
					while($row=$rezultat->fetch_assoc()){
						echo "'".$row["nick"]."'";
						echo ",";
					}
					$conn->close();
				}
			}
			function mojaSlika(){
					return "<img alt style='height:40px;width:40px;' src='Slike/Korisnik".$_SESSION['userId'].".jpg'>";
			}
			
			
			
			function level1($id){
				$conn=conn();
				$sql="select xp from informacije where idkorisnik='".$id."'";
				
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=20;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=20*pow(2,$level);
					}
					return "Level <br><img style='width: 50px;' src='Slicice/level".($level+1).".jpg'>";
				}
			}
			function level2($id){
				$conn=conn();
				$sql="select xp from informacije where idkorisnik='".$id."'";
				
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=20;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=20*pow(2,$level);
					}
					return ($xp-$manja).'/'.($veca-$manja)." XP";
				}
			}
			function postotak($id){
				$conn=conn();
				$sql="select xp from informacije where idkorisnik='".$id."'";
				
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=20;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						$level++;
						$manja=$veca;
						$veca+=20*pow(2,$level);
					}
					return ($xp-$manja)/($veca-$manja)*100;
				}
				return 0;
			}
			
			
		?>
		