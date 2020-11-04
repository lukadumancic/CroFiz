
		<?php
			function prijavljen(){
				if($_SESSION["korisnickoIme"]=="*%test%*" and $_SESSION["zaporka"]=="*%test%*"){
					return "False";
				}
				else{
					$conn=conn();
					$sql="SELECT * FROM korisnici where nick='".$_SESSION["korisnickoIme"]."' and pass='".$_SESSION["zaporka"]."'";
					$rez=$conn->query($sql);
					$conn->close();
					if($rez->num_rows===0){
						return "False";
					}
					else{
						return "True";
					}
				}
			}
			function obradiDatum($str){
				return protekloVrijeme($str);
				//Nekad bilo
				$array=explode(' ',$str);
				$dateArray=explode('-',$array[0]);
				$timeArray=explode('.',$array[1]);
				$timeArray2=explode(':',$timeArray[0]);
				return $dateArray[2].".".$dateArray[1].".".$dateArray[0]." ".$timeArray2[0].":".$timeArray2[1];
			}
			function conn(){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname = "crofiz";
				$conn = new mysqli($servername, $username, $password, $dbname);
				$conn->set_charset("utf8");
				return $conn;
			}
			function getId($nick){
				$conn = conn();
				$sql="select id from korisnici where nick='".$nick."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["id"];
			}
			function getNick($id){
				$conn = conn();

				$sql="select nick from korisnici where id='".$id."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["nick"];
			}	
			function imePrezime($id){
				return getName($id)." ".getSurName($id);
			}
			function getName($id){

					$conn = conn();

					$sql="select ime from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$conn->close();
					return $row["ime"];
				}
			function getSurName($id){

					$conn = conn();

					$sql="select prezime from korisnici where id='".$id."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					$conn->close();
					return $row["prezime"];
			}
			function vecaSlika($id){
					return "<img alt class='vecaSlika' src='Slike/Korisnik".$id.".jpg'>";
			}
			function slika($id){
					return "<img alt class='profilnaSlika' src='Slike/Korisnik".$id.".jpg'>";
			}
			function slika2($id){
					return 'Slike/Korisnik'.$id.'.jpg';
			}
			function slikaGrupa($id){
				return "<a href='http://localhost/Grupa.php?id=".$id."'><img src='Slike/Grupa$id.jpg' class='krugSlika' style='width: 100px;height: 100px;margin-top: 0px;align-self: center;padding: 30%;padding-top:10px;padding-bottom: 0px;'></a>";
			}
			function rijesenostZadatka($id){
				$conn=conn();
				$sql="select * from pokusaji where idzadatak='".$id."' and tocnost='1'";
				$rez1=$conn->query($sql);
				$sql="select * from pokusaji where idzadatak='".$id."' ";
				$rez2=$conn->query($sql);
				$br1=$rez1->num_rows;
				$br2=$rez2->num_rows;
				$conn->close();
				return $br1."/".$br2;
			}
			function obavijesti($id,$tekst){
				$conn=conn();

				if($id=="|" or $id=="" or $id==" "){
					$conn->close();
					return;
				}
				
				$sql="INSERT INTO obavijesti (`obavijest`, `idkorisnik`, `pogledano`) VALUES ('$tekst', '$id', '0');";
				$conn->query($sql);
				$conn->close();
			}
			function prijatelj($id){
				$conn=conn();
				$sql="SELECT prijatelji FROM informacije where idkorisnik='".$_SESSION["userId"]."'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0)return false;
				$row=$rez->fetch_assoc();
				$l=explode("|",$row["prijatelji"]);
				for($i=0;$i<count($l);$i++){
					if($l[$i]==$id){
						return true;
					}
				}
				return false;
			}
			
			
			function protekloVrijeme($datetime, $full = false) {
				$now = new DateTime;
				$ago = new DateTime($datetime);
				$diff = $now->diff($ago);

				$diff->w = floor($diff->d / 7);
				$diff->d -= $diff->w * 7;

				$string = array(
					'y' => 'godine',
					'm' => 'mjeseca',
					'w' => 'tjedna',
					'd' => 'dana',
					'h' => 'sati',
					'i' => 'minuta',
					's' => 'sekundi',
				);
				foreach ($string as $k => &$v) {
					if ($diff->$k) {
						$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
					} else {
						unset($string[$k]);
					}
				}

				if (!$full) $string = array_slice($string, 0, 1);
				return "Prije ".implode(', ', $string);
			}
			
			
			function zivoti(){
			$conn=conn();
			$sql="select zivoti from informacije where idkorisnik='".$_SESSION["userId"]."'";
			$rez=$conn->query($sql);
			if($rez->num_rows==0){
				$conn->close();
				return false;
			}
			$row=$rez->fetch_assoc();
			$t=time();
			$l=$row["zivoti"];
			$l=explode("|",$l);
			$zivot=3;
			$br=0;
			for($i=0;$i<count($l);$i++){
				if($l[$i]=="")continue;
				$br++;
				if(($l[$i]+24*60*60)>$t){
					$zivot--;
				}
				if($br==3)break;
			}
			$conn->close();
			return $zivot;
		}
		function ubaciPocetno(){
			if(prijavljen()=="True"){
				$conn=conn();
				$sql="select idkorisnik from informacije where idkorisnik='".$_SESSION['userId']."'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					$sql="INSERT INTO `informacije` (`idkorisnik`,`xp`,`prijatelji`,`maturazadaci`,`zivoti`,`datum`,`zaredom`) VALUES ('".getId($_SESSION["korisnickoIme"])."','0','|','|','|','0','1')";
					$conn->query($sql);
				}
				$conn->close();
			}
		}	
		
		function prijavaDatum(){
			if(prijavljen()=="True"){
				$conn=conn();
				$sql="UPDATE `crofiz`.`informacije` SET `datum`='".time()."' WHERE `idkorisnik`='".$_SESSION['userId']."'";
				$conn->query($sql);
				$conn->close();
			}
		}
		
		function dnevnaPrijava(){
			if(prijavljen()=="True"){
				$conn=conn();
				$sql="select * from informacije where idkorisnik='".$_SESSION["userId"]."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$datum=$row["datum"];
				if($datum<strtotime("today")){
					if($datum<strtotime("yesterday")){
						$sql="UPDATE `crofiz`.`informacije` SET `zaredom`='1' WHERE `idkorisnik`='".$_SESSION['userId']."'";
						$conn->query($sql);
						ispisPrijavaZaRedom(1);
					}
					else{
						$sql="UPDATE `crofiz`.`informacije` SET `zaredom`=`zaredom`+1 WHERE `idkorisnik`='".$_SESSION['userId']."'";
						$conn->query($sql);
						ispisPrijavaZaRedom($row["zaredom"]);
					}
					
				}
				prijavaDatum();
				$conn->close();
			}
		}
		function ispisPrijavaZaRedom($x){
			if(prijavljen()=="True"){
				$_SESSION["poruka"]="<p class='prijavaZaRedom'>Prijava ".$x." dana za redom<br>Nagrada<br>".$x." XP</p><p>Prijavite se 7 ili više dana za redom kako biste dobili CP</p>";
				dodajXp($x);
				if($x>=7){
					dodajCp(1);
				}
				//include 'prijavaZaRedom.php';
			}
		}
		
		
		function dodajXp($xp){
				$conn=conn();
				$sql="UPDATE `informacije` SET `xp`=`xp`+$xp where idkorisnik='".$_SESSION['userId']."'";
				
				$conn->query($sql);
				prelazakLevela($xp);
				$conn->close();
			}
		function prelazakLevela($xpPlus){
				$conn=conn();
				$sql="select xp from informacije where idkorisnik='".$_SESSION['userId']."'";
				$rez=$conn->query($sql);
				
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=20;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						return;
						$level++;
						$manja=$veca;
						$veca+=20*pow(2,$level);
					}
					$level++;
					
					if($xp-$xpPlus<$manja){
						obavijesti($_SESSION["userId"],'<a href="Leveli.php">Prešli ste na novu razinu! Sada ste razina '.$level.'</a>');
					}
				}
			}
		
			function prelazakLevela2($xpPlus,$id){
				$conn=conn();
				$sql="select xp from informacije where idkorisnik='$id'";
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=20;
					$manja=0;
					$level=0;
					while($xp>=$veca){
						return;
						$level++;
						$manja=$veca;
						$veca+=20*pow(2,$level);
					}
					$level++;
					if($xp-$xpPlus<$manja){
						obavijesti($id,'<a href="Leveli.php">Prešli ste na novu razinu! Sada ste razina '.$level.'</a>');
					}
				}
			}
			function dodajXp2($xp,$id){
				$conn=conn();
				$sql="UPDATE `informacije` SET `xp`=`xp`+$xp where idkorisnik='$id'";

				$conn->query($sql);
				prelazakLevela2($xp, $id);
				$conn->close();
			}
			function prijatelji(){
				$p=array();
				$conn=conn();
				$sql="select prijatelji from informacije where idkorisnik='".$_SESSION["userId"]."'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$l=explode("|",$row["prijatelji"]);
				for($i=0;$i<count($l);$i++){
					if($l[$i]=="")continue;
					array_push($p,$l[$i]);
				}
				$conn->close();
				return $p;
			}
			function datumPrijave($id){
				$sql="select datum from informacije where idkorisnik='".$id."'";
				$conn=conn();
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				$conn->close();
				return $row["datum"];
			}
			function aktivan($id){
				$datum=datumPrijave($id);
				if(time()-$datum<300){
					return 1;
				}
				return 0;
			}
			
			function profesor2(){
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
			function levelSlika($id){
				$conn=conn();
				$sql="select xp from informacije where idkorisnik='".$id."'";
				
				$rez=$conn->query($sql);
				$conn->close();
				if($rez->num_rows===1){
					$row=$rez->fetch_assoc();
					$xp=$row["xp"];
					$veca=10;
					$manja=0;
					$level=1;
					while($xp>=$veca){
						return;
						$level++;
						$manja=$veca;
						$veca+=10*pow(2,$level);
					}
					return "<img style='width: 20px;' src='Slicice/level".$level.".jpg'>";
				}
			}
			function postignuca(){
				$conn=conn();
				$sql="select * from postignuca where id='".$_SESSION["userId"]."'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					$sql="INSERT INTO postignuca (`id`, `dvoboj`, `zadatak`, `pobjede`, `slanje`, `izazov`, `ucenici`, `tema`, `odgovor`, `ocjena`, `objava`, `mentor`) VALUES ('".$_SESSION["userId"]."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
					$conn->query($sql);
					$x=0;
				}
				else{
					$x=1;
				}
				if(isset($_SESSION["postignuce"])){
					if($_SESSION["postignuce"]==1){
						$vrsta=$_SESSION["vrsta"];
						if($x==1){
							$row=$rez->fetch_assoc();
							$x=$row[$vrsta];
						}
						if($x==0 or $x==4 or $x==99 or $x==99){
							obavijesti($_SESSION["userId"],'<br>Riješili ste novo <a class="gold" href="Postignuca.php">Postignuće</a> i dobili 5 CP-a i 20 XP-a');
							dodajXp(20);
							dodajCp(5);
						}
						
						$sql="UPDATE `postignuca` SET `".$vrsta."` = `".$vrsta."`+'1' WHERE `id`='".$_SESSION["userId"]."'";
						$conn->query($sql);
						$_SESSION["postignuce"]=0;
					}
				}
				$sql="select * from korisnici where mentorid='".$_SESSION["userId"]."'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					$br=0;
				}
				else{
					$br=$rez->num_rows;
				}
				$sql="UPDATE `crofiz`.`postignuca` SET `ucenici`='".$br."' WHERE `id`='".$_SESSION["userId"]."'";
				$conn->close();
			}
			function cp(){
				$conn=conn();
				$sql="select * from cp where id='".$_SESSION["userId"]."'";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					$sql="INSERT INTO `crofiz`.`cp` (`id`, `cp`) VALUES ('".$_SESSION["userId"]."', '0')";
					$conn->query($sql);
					$conn->close();
					return 0;
				}
				
				else{
					$row=$rez->fetch_assoc();
					$conn->close();
					return $row["cp"];
				}
				
				
			} 
			function dodajCp($x){
				$sql="UPDATE `crofiz`.`cp` SET `cp`=`cp`+'".$x."' WHERE `id`='".$_SESSION["userId"]."'";
				$conn=conn();
				$conn->query($sql);
				$conn->close();
			}
			function dodatnaPostignuca($x,$id){
				$sql="select ".$x." from postignuca where id='".$id."'";
				$conn=conn();
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				if($row[$x]=='0'){
					obavijesti($_SESSION["userId"],'<br>Riješili ste novo <a class="gold" href="Postignuca.php">Postignuće</a> i dobili 5 CP-a i 20 XP-a');
					dodajXp(20);
					dodajCp(5);
				}
				$sql="UPDATE `postignuca` SET `".$x."`='1' WHERE `id`='".$id."'";
				$conn->query($sql);
				$conn->close();
			}
		?>