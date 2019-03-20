<?php
	echo "<script>";
	if(!$_SESSION["help"]){
		echo "document.getElementsByClassName('opis')[0].style.display='none';";
		echo "document.getElementsByClassName('naslov')[0].innerHTML+='<form onmouseover=\"prikaziPomoc()\" onmouseleave=\"sakrijPomoc()\" style=\"display:inline;\" method=\"post\"><input type=\"hidden\" name=\"pomoc\" value=\"0\"><a title=\"Prikaži pomoć\"><input type=\"image\" src=\"Slicice/help.png\" alt=\"Submit Form\"></a></form>';";
	}
	else{
		echo "document.getElementsByClassName('opis')[0].innerHTML+='<form style=\"display:inline;\" method=\"post\"><input type=\"hidden\" name=\"pomoc\" value=\"1\"><a title=\"Sakrij pomoć\"><input type=\"image\" src=\"Slicice/help.png\" alt=\"Submit Form\"></a></form>';";
	}
	echo "</script>";
?>
<script>
	function prikaziPomoc(){
		document.getElementsByClassName('opis')[0].style.display='block';
	}
	function sakrijPomoc(){
		document.getElementsByClassName('opis')[0].style.display='none';
	}
</script>