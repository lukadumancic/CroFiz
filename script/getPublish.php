<?php
	$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				// Stvaranje veze
				$conn = new mysqli($servername, $username, $password, $dbname2);
				// Provjera veze
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql="select userid,UNIX_TIMESTAMP(date) from x where text='".$_GET["text"]."' order by date desc limit 50";
				$rez=$conn->query($sql);
				if($rez->num_rows===0){
					echo "No results";
				}
				else{
					$i=0;
					while($row=$rez->fetch_assoc()){
						$i++;
						if($i==1){
						echo "Last search:<br>";
						echo "<div id='pub$i' class='publish1'>";
						echo getInfo($row["userid"]);
						echo "<br>";
						echo time_elapsed_string(intval($row['UNIX_TIMESTAMP(date)']));
						echo "</div>";
						echo "Other searches:<br>";
						}
						else{
						echo "<div id='pub$i' class='publish'>";
						echo getInfo($row["userid"]);
						echo "<br>";
						echo time_elapsed_string(intval($row['UNIX_TIMESTAMP(date)']));
						echo "</div>";
						}
						
					}
				}
				$conn->close();
				
				function getInfo($id){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname2);
				$sql="select nick from users where id='$id'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				return $row["nick"];
			}
				
		function timeNow(){
			return date('Y/m/d H:i:s');
		}
		function makeTime($time){
			$time=str_replace('-','/',$time);
			return substr($time,0,19);
		}
		function time_elapsed_string($ptime)
			{
				$etime = time() - $ptime;

				if ($etime < 1)
				{
					return '0 seconds';
				}

				$a = array( 365 * 24 * 60 * 60  =>  'year',
							 30 * 24 * 60 * 60  =>  'month',
								  24 * 60 * 60  =>  'day',
									   60 * 60  =>  'hour',
											60  =>  'minute',
											 1  =>  'second'
							);
				$a_plural = array( 'year'   => 'years',
								   'month'  => 'months',
								   'day'    => 'days',
								   'hour'   => 'hours',
								   'minute' => 'minutes',
								   'second' => 'seconds'
							);

				foreach ($a as $secs => $str)
				{
					$d = $etime / $secs;
					if ($d >= 1)
					{
						$r = round($d);
						return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
					}
				}
			}
?>









