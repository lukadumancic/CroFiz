<?php
				include "Funkcije.php";
				
				$conn=conn();
				$br=$_GET["limit"];
				$sql="select id,ime,idkorisnik,datum from forum order by id desc limit $br";
				$rez=$conn->query($sql);
				for($i=0;$i<$br-10;$i++){
					$row=$rez->fetch_assoc();
				}
				$ret="";
				while($row=$rez->fetch_assoc()){
					$ret.="<div>";
					$ret.="<strong class='tamnije'>".brojObjava($row["id"])."</strong>  ";
					$ret.="<a class='tema' href='http://34.121.205.40/Tema2.php?id=".$row['id']."' >".$row["ime"]."</a> ";
					$ret.="<div class='temaMaliInfo'>";
					$ret.="Objavio ".infoKorisnik($row["idkorisnik"])." ";
					$ret.=obradiDatum($row["datum"]);
					$ret.="</div>";
					$ret.="<p style='background-color: #696969;padding: 1px;'></p>";
				}
				$conn->close();
				echo $ret;
				
				
			
			function infoKorisnik($id){
				$conn=conn();
				
				$sql="select ime,prezime,nick from korisnici where id='$id'";
				$rezultat=$conn->query($sql);
				$row=$rezultat->fetch_assoc();
				$conn->close();
				return "<a class='nick3' style='font-size: 10px;margin-left:0px;' href='http://34.121.205.40/Profil.php?nick=".$row["nick"]."'>".$row["ime"]." ".$row["prezime"]."</a>";
				
			}
			function brojObjava($id){
				$conn=conn();
				
				$sql="select id from objavetemaforum where idforum='".$id."'";
				$rez=$conn->query($sql);
				$conn->close();
				return $rez->num_rows;
			}

			?>