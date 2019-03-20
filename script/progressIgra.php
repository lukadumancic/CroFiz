
<?php
	include 'Funkcije.php';
	include 'session.php';
?>
<html>
<head>
    
    
    <link rel="stylesheet" href="//codepen.io/assets/reset/normalize.css">

    
        <style>
      .progress {
  list-style: none;
  margin: 0;
  padding: 0;
  display: table;
  table-layout: fixed;
  width: 100%;
  color: #849397;
}
.progress > li {
  position: relative;
  display: table-cell;
  text-align: center;
  font-size: 0.8em;
}
.progress > li:before {
  content: attr(data-step);
  display: block;
  margin: 0 auto;
  background: #DFE3E4;
  width: 3em;
  height: 3em;
  text-align: center;
  margin-bottom: 0.25em;
  line-height: 3em;
  border-radius: 100%;
  position: relative;
  z-index: 1000;
}
.progress > li:after {
  content: '';
  position: absolute;
  display: block;
  background: #DFE3E4;
  width: 100%;
  height: 0.5em;
  top: 1.25em;
  left: 50%;
  margin-left: 1.5em\9;
  z-index: -1;
}
.progress > li:last-child:after {
  display: none;
}
.progress > li.is-complete {
  color: #2ECC71;
}
.progress > li.is-complete:before, .progress > li.is-complete:after {
  color: #FFF;
  background: #2ECC71;
}
.progress > li.is-active {
  color: #3498DB;
}
.progress > li.is-active:before {
  color: #FFF;
  background: #3498DB;
}

.progress > li.not-active {
  color: #3498DB;
}
.progress > li.not-active:before {
  color: #84939;
  background: #DFE3E4;
}

/**
 * Needed for IE8
 */
.progress__last:after {
  display: none !important;
}

/**
 * Size Extensions
 */
.progress--medium {
  font-size: 1.5em;
}

.progress--large {
  font-size: 2em;
}

/**
 * Some Generic Stylings
 */
*, *:after, *:before {
  box-sizing: border-box;
}

.progress {
  margin-bottom: 3em;
}

</style>

<script>
	window.console = window.console || function(t) {};
</script>

    
    
  </head>

  <body>
<ol class="progress">
	<?php
		if(isset($_SESSION['dvobojId']) and isset($_SESSION["dvobojZadatakId"])){
			$conn=conn();
			$sql="select * from dvoboj where id='".$_SESSION['dvobojId']."'";
			$rez=$conn->query($sql);
			$row=$rez->fetch_assoc();
			$zad=$row["idzadaci"];
			$zad=explode("|",$zad);
			$br=0;
			for($i=1;$i<count($zad);$i++){
				if($zad[$i]=="")continue;
				if($i==count($zad)-2){
					echo '<li class="progress__last" data-step="'.$i.'">
					</li>';
				}
				else if($br==1){
					echo '<li class="not-active" data-step="'.$i.'">
					</li>';
				}
				else if($zad[$i]==$_SESSION["dvobojZadatakId"]){
					echo '<li class="is-active" data-step="'.$i.'">
					</li>';
					$br=1;
				}
				else{
					echo '<li class="is-complete" data-step="'.$i.'">
					</li>';
				}
				
			}
			
		}
	?>
</ol>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    
    
    <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>

    
  

 
</body>
</html>
