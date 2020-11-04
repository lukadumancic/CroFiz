<?php
	include 'Funkcije.php';
	include 'session.php';
	
	if(prijavljen()=="False"){
		header("Location: http://34.121.205.40/Main.php");
		die();
	}
	if(isset($_POST["id"])){
		$conn=conn();
		$sql="select * from dvoboj where id='".$_POST["id"]."'";
		$rez=$conn->query($sql);
		if($rez->num_rows==0){
			header("Location: http://34.121.205.40/Zadaci.php?br=Dvoboj");
			die();
		}
		else{
			$row=$rez->fetch_assoc();
			
			$l1=explode('|',$row["tocno1"]);
			$l2=explode('|',$row["tocno2"]);
			$zad=explode('|',$row["idzadaci"]);
			
			if($_SESSION["userId"]==$row["idkorisnik1"]){
				if(count($zad)!=count($l1)){
					$_SESSION['dvobojId']=$_POST["id"];
				}
				else{
					header("Location: http://34.121.205.40/Zadaci.php?br=Dvoboj");
					die();
				}
			}
			else{
				if(count($zad)!=count($l2)){
					$_SESSION['dvobojId']=$_POST["id"];
				}
				else{
					header("Location: http://34.121.205.40/Zadaci.php?br=Dvoboj");
					die();
				}
			}
		}
	}
	else if(zivoti()==0){
		header("Location: http://34.121.205.40/Zadaci.php?br=Dvoboj");
		die();
	}
	
?>


<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<?php include 'head.php';?>
	</head>
	<body>
		
		<div id="navigacija" class="navigacija">
			<header>
				<div class="crofiz">CROFIZ</div>
			</header>
			<nav>
				<div id="nav">
				</div>
			</nav>
			 <iframe style='margin-top: 30px;margin-bottom: -15px;' class='progressIgra' id='ifrm' scrolling="no" src="http://34.121.205.40/progressIgra.php"></iframe> 
			 <script>
				IFrame=document.getElementById("ifrm");
				IFrame.src = 'http://34.121.205.40/progressIgra.php';
				IFrame.style.backgroundColor = "transparent";
				IFrame.frameBorder = "0";
				IFrame.allowTransparency="true";
			 </script>
		</div>
		
		
		<div class='lijevo' id="lijevo">
			<div id='odabir'>
				<div id='form'>
					<p>Protivnik</p>
					<button class='odabir' id='random' type='button' onclick='activeRandom()'>Nasumično</button>
					<button class='odabir' id='prijatelji' type='button' onclick='activePrijatelji()'>Prijatelji</button>
					<select name='idPrijatelj' id="prijateljiList" onchange='prijateljId()' style='display:none'>
						<option value='0'>Odaberite</option>
						<?php
							$conn=conn();
							$sql="select prijatelji from informacije where idkorisnik='".$_SESSION["userId"]."'";
							$rez=$conn->query($sql);
							if($rez->num_rows==0){
								
							}
							else{
								$row=$rez->fetch_assoc();
								$x=$row["prijatelji"];
								$x=explode("|",$x);
								for($i=0;$i<count($x);$i++){
									if($x[$i]=="")continue;
									echo "<option value='".$x[$i]."'>".getName($x[$i])." ".getSurName($x[$i])."</option>";
								}
							}
						?>
					</select>
					
					<p>Vrsta zadataka</p>
					<button class='odabir' id='matura' type='button' onclick='activeMatura()'>Matura</button>
					<button class='odabir' id='tezi' type='button' onclick='activeTezi()' disabled>Teži zadaci</button>
					
					<p>Broj zadataka</p>
					<button class='odabir' id='tri' type='button' onclick='active3()'>3</button>
					<button class='odabir' id='jedan' type='button' onclick='active1()'>1</button>
					
					<br>
					<button class='kreni' type='button' onclick='kreni()'>Kreni!</button>
				</div>
			</div>
			<div id="dvobojTeskt" class='dvobojTeskt'>
				
			</div>
			<script>
			
					zivotiRefresh();
				
					var protivnik="";
					var vrsta="";
					var broj=0;
					var prijatelj=0;
					
					function activeRandom(){
						protivnik="Random";
						document.getElementById("random").className='odabir odabirActive';
						document.getElementById("prijatelji").className='odabir';
						document.getElementById("prijateljiList").style.display="none";
					}
					function activePrijatelji(){
						protivnik="Prijatelji";
						document.getElementById("random").className='odabir';
						document.getElementById("prijatelji").className='odabir odabirActive';
						document.getElementById("prijateljiList").style.display="inline-block";
					}
					function prijateljId(){
						prijatelj=document.getElementById("prijateljiList").value;
						console.log(prijatelj);
					}
					
					function activeMatura(){
						vrsta="Matura";
						document.getElementById("matura").className='odabir odabirActive';
						document.getElementById("tezi").className='odabir';
					}
					function activeTezi(){
						vrsta="Teži";
						document.getElementById("matura").className='odabir';
						document.getElementById("tezi").className='odabir odabirActive';
					}
					
					function active1(){
						broj=1;
						document.getElementById("jedan").className='odabir odabirActive';
						document.getElementById("tri").className='odabir';
					}
					function active3(){
						broj=3;
						document.getElementById("jedan").className='odabir';
						document.getElementById("tri").className='odabir odabirActive';
					}
				
				
					function kreni(){
						if(protivnik!="" && vrsta!="" && broj!=0){
							console.log(1);
							var xmlhttp;    
							if (window.XMLHttpRequest){
								xmlhttp=new XMLHttpRequest();
							}
							else{
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							}
							xmlhttp.onreadystatechange=function()
							  {
							  if (xmlhttp.readyState==4 && xmlhttp.status==200)
								{
									console.log(xmlhttp.responseText);
									if(xmlhttp.responseText.indexOf("true")==-1){
										document.getElementById("lijevo").innerHTML="Greška";
									}
									else{
										zivotiRefresh();
										start();
									}
								}
							  }
							console.log("unosIgre.php?protivnik="+protivnik+"&vrsta="+vrsta+"&broj="+broj+"&prijatelj="+prijatelj);
							xmlhttp.open("GET","unosIgre.php?protivnik="+protivnik+"&vrsta="+vrsta+"&broj="+broj+"&prijatelj="+prijatelj,true);
							xmlhttp.send();
						}
						else{
							console.log(0);
						}
					}
					function zivotiRefresh(){
						var xmlhttp;    
						if (window.XMLHttpRequest){
							xmlhttp=new XMLHttpRequest();
						}
						else{
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
								document.getElementById("nav").innerHTML="<a style='margin:50px;' href='Zadaci.php?br=Dvoboj'>Zadaci-Dvoboj</a>"+xmlhttp.responseText;
							}
						}
						xmlhttp.open("GET","zivoti.php",true);
						xmlhttp.send();
					}
					function start(){
						var xmlhttp;    
						if (window.XMLHttpRequest){
							xmlhttp=new XMLHttpRequest();
						}
						else{
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
								console.log(xmlhttp.responseText);
								if(xmlhttp.responseText.search("false")==-1){
									var l=xmlhttp.responseText.split("|||||");
									ispisTeksta(l[0]);
									ispisRjesenja(l[1]);
									document.getElementById('ifrm').contentWindow.location.reload(true);
								}
							}
						}
						xmlhttp.open("GET","dvobojZadaci.php",true);
						xmlhttp.send();
					}
					start();
					
					
					function ispisTeksta(string){
						document.getElementById("odabir").innerHTML="";
						document.getElementById("dvobojTeskt").innerHTML=string;
					}
					
					function ispisRjesenja(string){
						var l=string.split("|");
						var div="<div class='ispisZadataka' id='ispisZadataka'>";
						for(var i=1;i<5;i++){
							div+="<br><button type='button' id='rjesenje"+i+"' class='dvobojRjesenje' onClick='odaberi("+i+")'>"+l[i]+"</button>";
						}
						div+="<br><br><button type='button' class='posaljiRjesenje' onclick='posaljiRjesenje()'>Pošalji</button>";
						div+="</div>";
						document.getElementById("desno").innerHTML=div;
					}
					
					var rj="";
					
					function odaberi(br){
						rj=document.getElementById("rjesenje"+br).innerHTML;
						for(var i=1;i<5;i++){
							document.getElementById("rjesenje"+i).className="dvobojRjesenje";
						}
						document.getElementById("rjesenje"+br).className="dvobojRjesenje dvobojRjesenjeActive";
					}
					
					function posaljiRjesenje(){
						var xmlhttp;    
						if (window.XMLHttpRequest){
							xmlhttp=new XMLHttpRequest();
						}
						else{
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
								console.log(xmlhttp.responseText);
								if(xmlhttp.responseText.search("-1")!=-1){
									start();
								}
								else{
									ispisRezultata();
								}
							}
						}
						xmlhttp.open("GET","slanjeRjesenja.php?rjesenje="+rj,true);
						xmlhttp.send();
					}
					function ispisRezultata(){
						location.reload();
					}
				</script>
		</div>
		<div class='desno' id="desno">
		</div>
		
		
	</body>
	<?php

		
		
		
	?>
</html>