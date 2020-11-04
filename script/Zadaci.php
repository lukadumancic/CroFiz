<!doctype html>
<?php include 'Funkcije.php'; ?>
<?php include 'session.php';?>

<?php include 'prijavaScript.php'; ?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<head>
			<?php include 'head.php';?>
			<?php if(isset($_GET["br"])){
					if($_GET["br"]=="Dvoboj"){
						include 'povijestIgreHead.php';
					}
				}
			?>
			
			
		</head>
		<body>
			
			<?php if(prijavljen()=="False"){include 'regBoxes.php';}?>
			<?php include 'navigacija.php';?>
			
			<article id="art">
			
			<div id="extraNavigation">
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavDnevni' href="?br=Dnevni">Dnevni</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavTjedni' href="?br=Tjedni">Tjedni</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavMentorski' href="?br=Mentorski">Mentorski</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavDvoboj' href="?br=Dvoboj">Dvoboj</a>
				<a class='extraNavLink extraNavLinkZadaci' id='extraNavArhiva' href="?br=Arhiva">Arhiva</a>
			</div>
			
		
			<?php
				if(isset($_GET["br"])){
					$br=$_GET["br"];
					if($br=="Dnevni"){
						include "zadaciDnevni.php";
					}
					else if($br=="Tjedni"){
						include "zadaciTjedni.php";
					}
					else if($br=="Mentorski"){
						include "zadaciMentorski.php";
					}
					else if($br=="Dvoboj"){
						if(prijavljen()=="False"){
							include "zadaciDvoboj2.php";
						}
						else{
							include "zadaciDvoboj.php";
						}
					}
					else{
						include "zadaciArhiva2.php";
					}
				}
				else{
					include "zadaciOsnovno.php";
				}
			?>
			
			
			<script>
				a="<?php if(isset($_GET["br"])){echo $_GET["br"];}?>";
				if(a!=""){
					document.getElementById("extraNav"+a).className+=" extraNavSelected";
				}
			</script>

			
		</article>
			
			<footer>
				<?php include 'footer.php'; ?>
			</footer>
			
			
		<?php
			
			function ispisiTjedni(){
				if(prijavljen()=="True" and !profesor2()){
					$id=getId($_SESSION["korisnickoIme"]);
					$conn=conn();
					
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
						$sql="select * from zadaci where razred='".$row["obrazovanje"]."' and br='2' order by datum desc limit 1";
						$rez=$conn->query($sql);
						$row=$rez->fetch_assoc();
						$conn->close();
						return 
							"<div class='opis2' style='background: url(\"Slicice/to-do.jpg\");background-size: cover;background-position: center; '>
								<p style='color:white;font-size:20px;'>Ovotjedni zadatak</p>
								<p><a style='font-size:40px;' class='zadatak' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>
								<p class='rijesenostZadatka tamnije' style='width:35%'>".rijesenostZadatka($row["id"])."<br>
								".objavljenZadatak($row["id"])."
								</p>
							</div>";
					}
					else{
						$conn->close();
						return False;
					}
				}
				else{
					return False;
				}
			}
			function ispisiDnevni(){
				if(prijavljen()=="True" and !profesor2()){
					$id=getId($_SESSION["korisnickoIme"]);
					$conn=conn();
					
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$i=$row["obrazovanje"];
					if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
						$sql="select * from zadaci where razred='".$row["obrazovanje"]."' and br='1' order by datum desc limit 1";
						$rez=$conn->query($sql);
						$row=$rez->fetch_assoc();
						$conn->close();
						return 
							"<div class='opis2' style='background: url(\"Slicice/now.jpg\");background-size: cover;background-position: center; '>
								<p style='color:white;font-size:20px;'>Današnji zadatak</p>
								<p><a style='font-size:40px;' class='zadatak' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>
								<p class='rijesenostZadatka tamnije' style='width:35%'>".rijesenostZadatka($row["id"])."<br>
								".objavljenZadatak($row["id"])."
								</p>
							</div>";
						
					}
					else{
						$conn->close();
						return False;
					}
				}
				else{
					return False;
				}
			}
			function ispisiSveDnevne(){
					$conn=conn();
					
					$ret="";
					for($i=1;$i<5;$i++){
						$sql="select * from zadaci where razred='$i' and br='1' order by datum desc limit 1";
						$rez=$conn->query($sql);
						while($row=$rez->fetch_assoc()){
							$ret.="<div class='paralelna4' style='background: url(\"Slicice/razred$i.jpg\");background-size: cover;'>
							<p style='background-color: #696969;padding: 1px;'></p>
							<p>$i. razred</p>
							<p>
							<a class='zadatak' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a>
							</p>
							<p class='rijesenostZadatka tamnije'>
							".rijesenostZadatka($row["id"])."<br>
							".objavljenZadatak($row["id"])."
							</p>
							
							<br><p style='background-color: #696969;padding: 2px;'></p><br>
							
							<p class='tamnije'>Tjedan</p>
							".ispisiSveDnevneTjedan($i)."
							</div>";
						}
					}
					$conn->close();
					return $ret;
			
			}
			function ispisiSveTjedne(){
					$id=getId($_SESSION["korisnickoIme"]);
					$conn=conn();
					
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					
					$ret="";
					for($i=1;$i<5;$i++){
						$sql="select * from zadaci where razred='$i' and br='2' order by datum desc limit 1";
						$rez=$conn->query($sql);
						while($row=$rez->fetch_assoc()){
							$ret.="<div class='paralelna4' style='background: url(\"Slicice/razred$i.jpg\");background-size: cover;'>
							<p style='background-color: #696969;padding: 1px;'></p>
							<p>$i. razred</p>
							<p>
							<a class='zadatak' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a>
							</p>
							<p class='rijesenostZadatka tamnije'>
							".rijesenostZadatka($row["id"])."<br>
							".objavljenZadatak($row["id"])."
							</p>
							<p style='background-color: #696969;padding: 1px;'></p>
							</div>";
						}
					}
					$conn->close();
					return $ret;
			
				}
			function ispisiTjedan(){
				if(prijavljen()=="True"){
					$id=getId($_SESSION["korisnickoIme"]);
					$conn=conn();
					
					$sql="select `obrazovanje` from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					if($row["obrazovanje"]!="Profesor" and $row["obrazovanje"]!="Drugo"){
						$sql="select * from zadaci where br='1' and razred='".$row["obrazovanje"]."' order by datum desc limit 7";
						$rez=$conn->query($sql);
						$ret="";
						while($row=$rez->fetch_assoc()){
							$ret.="<p class='dan'>".$row["dan"]."  <a class='zadatak' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
						}
						$conn->close();
						
						return $ret;
					}
					else{
						$conn->close();
						return False;
					}
				}
				else{
					return False;
				}
			}
			function ispisiSveDnevneTjedan($i){
					$conn=conn();
					$ret="";
					$sql="select * from zadaci where br='1' and razred='".$i."' order by datum desc limit 7";
					$rez=$conn->query($sql);
					
					$rez->fetch_assoc();
					while($row=$rez->fetch_assoc()){
						$ret.="<p class='dan'>".$row["dan"]."  <a class='zadatak underline' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
					}
						
					$conn->close();
					return $ret;
			}
			function profesor(){
				$conn=conn();
				$nick=$_SESSION["korisnickoIme"];
				$sql="select obrazovanje from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				if($row["obrazovanje"]=="Profesor"){
					return True;
				}
				else{
					return False;
				}
			}
			function dohvatiGrupe(){
				$conn=conn();
				$mojId=getId($_SESSION["korisnickoIme"]);
				$sql="select id,ime from grupe where mentorid=$mojId";
				$rez=$conn->query($sql);
				
				if($rez->num_rows===0){
					$conn->close();
					return "Nemate grupa za odabir";
				}
				else{
					$ret="<select name='odabrano'>";
					$ret.='<option value="0">Odaberite grupu<br>';
					while($row=$rez->fetch_assoc()){
						$ret.='<option value="'.$row['id'].'">'.$row['ime'].'<br>';
					}
					$ret.="</select>";
					$conn->close();
					return $ret;
				}
			}
			function ispisMentorskih(){
				if(prijavljen()=="True"){
					$conn=conn();
					$mojId=getId($_SESSION["korisnickoIme"]);
					$sql="select mentorid from korisnici where id=$mojId and (mentorid is not null or obrazovanje='Profesor')";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						$conn->close();
						return "<p>Nemate mentora</p>";
					}
					else{
						$ret="";
						$row=$rez->fetch_assoc();
						$mentorId=$row["mentorid"];
						if($mentorId==""){
							$mentorId=$mojId;
						}
						if(profesor()){
							$sql="select * from grupe where mentorid=$mentorId";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								$ret.="<p style='padding:100px;'>Nemate grupe<br>Napravite jednu kako biste mogli praviti izazove svojim učenicima!<br></p>";
							}
							else{
								while($row=$rez->fetch_assoc()){
									$ret.="<div class='grupaDiv'>"
									.$row['ime']
									.slikaGrupa($row["id"])."<br>";
									$sql="select ime,id from izazovi where trajanje='1' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									
									if($rez2->num_rows===0){
										$ret.="<strong style='color: #A9A4A4;'>Nema aktivnih izazova</strong><br>";
									}
									else{
										$ret.="<strong style='color: #A9A4A4;'>Aktivni izazovi</strong><br>";
										$ret.="<table>";
										while($row2=$rez2->fetch_assoc()){
											$ret.="<tr>";
											$ret.="<td><a class='izazov' href='http://crofiz.com/Izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a></td>";
											$ret.="<td>".prebrojIzazovTocnostSvihUcenika($row2['id'])."</td>";
											$ret.="<td><form style='display:inline;' method='post' action='zaustaviIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input class='izazovExtraButtonZaustavi' type='submit' value='Zaustavi'></form></td>";
											$ret.="<td><form style='display:inline;' method='post' action='obrisiIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input class='izazovExtraButton' type='submit' value='Obriši'></form></td>";
											$ret.="<tr>";
										}
										$ret.="</table>";
									}
									$ret.="<br>";
									$sql="select ime,id from izazovi where trajanje='0' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows!=0){
										$ret.="<strong style='color: #A9A4A4;'>Zaustavljeni izazovi</strong><br>";
										$ret.="<table>";
										while($row2=$rez2->fetch_assoc()){
											$ret.="<tr>";
											$ret.="<td><a class='izazov' href='http://crofiz.com/Izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a></td>";
											$ret.="<td>".prebrojIzazovTocnostSvihUcenika($row2['id'])."</td>";
											$ret.="<td><form style='display:inline;' method='post' action='zaustaviIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input class='izazovExtraButtonPokreni' type='submit' value='Pokreni'></form></td>";
											$ret.="<td><form style='display:inline;' method='post' action='obrisiIzazov.php' ><input type='hidden' name='id' value=".$row2["id"]."><input class='izazovExtraButton' type='submit' value='Obriši'></form></td>";
											$ret.="</tr>";
										}
										$ret.="</table>";
									}
									$ret.="</div>";
								}
							}
						}
						if(!profesor()){
							$sql="select * from grupe where idkor like '|$mojId|' or idkor like '|$mojId|%' or idkor like '%|$mojId|' or idkor like '%|$mojId|%' or (mentorid=$mentorId and idkor='-1')";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								$ret.="<p style='padding:100px;'>Nemaš grupu<br>Pošalji poruku svome profesoru da napravi jednu!<br></p>";
							}
							else{
								while($row=$rez->fetch_assoc()){
									$ret.="<div class='grupaDiv'>"
									.$row['ime']
									.slikaGrupa($row["id"])."<br>";
									$sql="select ime,id from izazovi where trajanje='1' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									
									
									
									if($rez2->num_rows===0){
										$ret.="<strong style='color: #A9A4A4;'>Nema aktivnih izazova</strong><br>";
									}
									else{
										$ret.="<strong style='color: #A9A4A4;'>Aktivni izazovi</strong><br>";
										$ret.="<table>";
										while($row2=$rez2->fetch_assoc()){
											$ret.="<tr>";
											$ret.="<td><a class='izazov' href='http://crofiz.com/izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a></td>";
											$ret.="<td>".prebrojIzazovTocnost($row2['id'])."</td>";
											$ret.="</tr>";
										}
										$ret.="</table>";
									}
									$sql="select ime,id from izazovi where trajanje='0' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows!=0){
										$ret.="<strong style='color: #A9A4A4;'>Zaustavljeni izazovi</strong><br>";
										$ret.="<table>";
										while($row2=$rez2->fetch_assoc()){
											$ret.="<tr>";
											$ret.="<td><a class='izazov' href='http://crofiz.com/Izazov.php?id=".$row2["id"]."'>".$row2['ime']."</a></td>";
											$ret.="<td>".prebrojIzazovTocnost($row2['id'])."</td>";
											$ret.="</tr>";
										}
										$ret.="</table>";
									}
									$ret.="</div>";
								}
							}
						}
						$conn->close();
						return $ret;
						
					}
				}
			}
			function dohvatiSveZadatke($razred,$podrucje){
				$id=getId($_SESSION["korisnickoIme"]);
					
					$conn = $conn();

						$sql="select id,ime from zadaci where razred='$razred' and podrucje='$podrucje' order by datum desc";
						$rez=$conn->query($sql);
						$ret="";
						while($row=$rez->fetch_assoc()){
							$ret.="<a class='zadatak' href='http://crofiz.com/Zadatak.php?id=".$row["id"]."'>".$row["ime"]."</a></p>";
						}
						$conn->close();
						
						return $ret;
			}
			function prebrojIzazovTocnost($id){
				$conn=conn();
				$sql="select tocnost from izazovtocnost where idizazov='".$id."' and idkorisnik='".$_SESSION['userId']."'";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===0){
					return False;
				}
				else{
					$row=$rez->fetch_assoc();
					$br=substr_count($row["tocnost"],"|")-1;
					$x=substr_count($row["tocnost"],"1");
					return floor(($x/$br)*100)."%";
				}
			}
			function prebrojIzazovTocnostSvihUcenika($id){
				$conn=conn();
				$sql="select tocnost from izazovtocnost where idizazov='".$id."'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					return False;
				}
				else{
					$brojUcenika=$rez->num_rows;
					$row=$rez->fetch_assoc();
					$br=substr_count($row["tocnost"],"|")-1;
					$x=substr_count($row["tocnost"],"1");
					while($row=$rez->fetch_assoc()){
						$x+=substr_count($row["tocnost"],"1");
					}
					if($br==0){
						return "0%";
					}
					return floor((($x/$br)/$brojUcenika)*100)."%";
				}
			}
			function dohvatiPodrucja($razred){
				$conn=conn();
					$sql="select podrucje from zadaci where razred=$razred";
					$rez=$conn->query($sql);
					if($rez->num_rows>0){
						$l=[];
						while($row=$rez->fetch_assoc()){
							if(!in_array($row["podrucje"],$l)){
								array_push($l,$row["podrucje"]);
							}
						}
						echo "<script>";
						echo "document.getElementById('zadaciArhiva$razred').innerHTML+='<div class=\"zadaciArhiva\" style=\"display:none;\" id=\"sve$razred\"><strong>Zadaci</strong><br></div>';";
						echo "document.getElementById('navigacijaArhiva$razred').innerHTML+='<button class=\"podrucje\" type=\"button\" onClick=\"prikaziArhivuZad(\'sve$razred\')\">Svi zadaci</button><br>';";
							
						for($i=0;$i<count($l);$i++){
							echo "document.getElementById('navigacijaArhiva$razred').innerHTML+='<button class=\"podrucje\" class=\"podrucje\" type=\"button\" onClick=\"prikaziArhivuZad(\'".$l[$i]."\')\">".$l[$i]."</button><br>';";
							unesiArhivu($razred,$l[$i]);
						}
						echo "</script>";
					}
				$conn->close();
			}
			function unesiArhivu($razred,$podrucje){
				$conn=conn();
					
					$sql="select * from zadaci where podrucje='$podrucje'";
					$rez=$conn->query($sql);
					echo "document.getElementById('zadaciArhiva$razred').innerHTML+='<div style=\"display:none;\" id=\"$podrucje\"><strong>$podrucje</strong><br></div>';";
					while($row=$rez->fetch_assoc()){
						echo "document.getElementById('$podrucje').innerHTML+='<a style=\"display: inline;\" class=\"zadatak\" href=\"http://crofiz.com/Zadatak.php?id=".$row["id"]."\">".$row["ime"]."</a><br>';";
						echo "document.getElementById('sve$razred').innerHTML+='<a style=\"display: inline;\" class=\"zadatak\" href=\"http://crofiz.com/Zadatak.php?id=".$row["id"]."\">".$row["ime"]."</a><br>';";
					}
					$conn->close();
			}
			function zadnjiZadaci(){
				$conn=conn();
				$sql="select * from zadaci limit 5";
				$rez=$conn->query($sql);
				echo "<div style='color: #383838;'>";
				echo "<table style='color:white;'>";
				echo "<tr>";
				echo "<td style='color: #989898;'>Zadatak</td>
					  <td class='rjz' style='color: #989898;'>Riješenost</td>
					  <td class='pdr' style='color: #989898;'>Područje</td>";
				echo "</tr>";
				while($row=$rez->fetch_assoc()){
					echo "<tr>";
					echo "<td><a class=\"zadatak\" href=\"http://crofiz.com/Zadatak.php?id=".$row["id"]."\">".$row["ime"]."</a></td>';";
					echo "<td class='rjz'>".rijesenostZadatka($row['id'])."</td>";
					echo "<td class='pdr'>".$row["podrucje"]."</td>";
					echo "</tr>";
				}
				echo "</table></div>";
				$conn->close();
			}
			
			function najlosijiIzazov(){
				$conn=conn();
					$mojId=getId($_SESSION["korisnickoIme"]);
					$sql="select mentorid from korisnici where id=$mojId and (mentorid is not null or obrazovanje='Profesor')";
					$rez=$conn->query($sql);
					if($rez->num_rows===0){
						$conn->close();
						return False;
					}
					else{
						$ret="<div class='pokusajPonovno'><p style='color: #8C8C8C;'>Pokušaj riješiti ovaj izazov ponovno!</p>";
						$row=$rez->fetch_assoc();
						$mentorId=$row["mentorid"];
						if(!profesor()){
							$sql="select * from grupe where idkor like '|$mojId|' or idkor like '|$mojId|%' or idkor like '%|$mojId|' or idkor like '%|$mojId|%' or (mentorid=$mentorId and idkor='-1')";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								return False;
							}
							
							$minimum="100%";
							$br=0;
							
								while($row=$rez->fetch_assoc()){
									$sql="select id from izazovi where trajanje='1' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									
									
									
									if($rez2->num_rows>0){
										while($row2=$rez2->fetch_assoc()){
											$x=prebrojIzazovTocnost($row2['id']);
											if(intval($x)<=intval($minimum)){
												$minimum=$x;
												$idmin=$row2['id'];
											}
										}
									}
									$sql="select ime,id from izazovi where trajanje='0' and idgrupe=".$row["id"];
									$rez2=$conn->query($sql);
									if($rez2->num_rows!=0){
										while($row2=$rez2->fetch_assoc()){
											
										}
									}
								}
								$sql="select ime,id from izazovi where id=".$idmin;
								$rez=$conn->query($sql);
								$row=$rez->fetch_assoc();
								
								$postotak=prebrojIzazovTocnost($row['id']);
								if($postotak==False){
									$postotak="0%";
								}
								
								$ret.="<a class='izazov' href='http://crofiz.com/izazov.php?id=".$row["id"]."'>".$row['ime']."</a>";
								$ret.="<p style='color: #8C8C8C;'>Postotak riješenosti<br>".$postotak."</p>";
							}
						$conn->close();
						$ret.="</div>";
						return $ret;
						
					}
				}
				
			function objavljenZadatak($id){
				$conn=conn();
				$sql="select datum from zadaci where id='".$id."'";
				$rez=$conn->query($sql);
				$conn->close();
				$row=$rez->fetch_assoc();
				return obradiDatum($row["datum"]);
			}
		?>
			
		</body>
</html>