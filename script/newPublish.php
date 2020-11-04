<?php
session_start();
if(loged()){
	$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname2);
				
				echo $sql="INSERT INTO `x` (`userid`, `text`) VALUES ('".getId($_SESSION['nick'])."', '".$_GET['text']."')";
				$conn->query($sql);
				$conn->close();
}
				
	function loged(){
				if($_SESSION["nick"]=="*%test%*" and $_SESSION["pass"]=="*%test%*"){
					return False;
				}
				else{
					return True;
				}
			}
			function getId($nick){
				$servername = "35.238.67.22";
				$username = "root";
				$password = "124578";
				$dbname2 = "crofiz";

				$conn = new mysqli($servername, $username, $password, $dbname2);
				$sql="select id from users where nick='$nick'";
				$rez=$conn->query($sql);
				$row=$rez->fetch_assoc();
				return $row["id"];
			}

?>