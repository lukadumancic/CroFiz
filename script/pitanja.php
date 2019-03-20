<?php

$conn=conn();
$sql="select * from pitanja";
$rez=$conn->query($sql);
while($row=$rez->fetch_assoc()){
	echo("|||");
	echo($row["tezina"]);
	echo("|");
	echo($row["vrsta"]);
	echo("|");
	echo($row["pitanje"]);
	echo("|");
	echo($row["odgovor"]);
}

function conn(){
	$servername = "82.132.7.168";
	$username = "crofiz";
	$password = "peta@crofiz";
	$dbname = "newdatabase";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset("utf8");
	return $conn;
}

?>