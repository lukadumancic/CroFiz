<?php
				include "Funkcije.php";
				
				$conn=conn();
				
				$br=$_GET["limit"];
				$sql="select id,ime,datum from zadaci order by datum desc limit $br";
				$rez=$conn->query($sql);
				for($i=0;$i<$br-10;$i++){
					$row=$rez->fetch_assoc();
				}
				$ret="";
				while($row=$rez->fetch_assoc()){
					$ret.="<div>";
					$ret.="<strong class='tamnije'>".brojObjava($row["id"])."</strong>  ";
					$ret.="<a class='tema' href='http://localhost/Tema.php?id=".$row['id']."' >".$row["ime"]."</a> ";
					$ret.="<div class='temaMaliInfo'>";
					$ret.=obradiDatum($row["datum"]);
					$ret.="</div>";
					$ret.="<p style='background-color: #696969;padding: 1px;'></p>";
				}
				$conn->close();
				echo $ret;
				
				
			function brojObjava($id){
				$conn=conn();
				
				$sql="select id from objavetema where idzadatak='".$id."'";
				$rez=$conn->query($sql);
				$conn->close();
				return $rez->num_rows;
			}

			?>