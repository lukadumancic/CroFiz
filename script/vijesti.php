<?php
				
				//Postavljanje varijabli za spajanje na bazu
				$servername = "82.132.7.168";
				$username = "admin";
				$password = "124578";
				$dbname = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				$x=$_GET["limit"];
				$sql="select data,datum from vijesti order by datum desc limit ".$x;
				$rezultat=$conn->query($sql);
				for($i=0;$i<$x-10;$i++){
					$rezultat->fetch_assoc();
				}
				while($row=$rezultat->fetch_assoc()){
					echo "<div class='vijesti'>".$row["data"]."<br>".obradiDatum($row["datum"])."</div>";
				}
				$conn->close();
				
				function obradiDatum($str){
				$array=explode(' ',$str);
				$dateArray=explode('-',$array[0]);
				$timeArray=explode('.',$array[1]);
				return $dateArray[2]."-".$dateArray[1]."-".$dateArray[0]." ".$timeArray[0];
			}
			?>