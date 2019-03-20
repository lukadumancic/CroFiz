<link rel="stylesheet" href="//codepen.io/assets/reset/normalize.css">

    
 <style>
      .progress {
		margin-bottom: 20px;
		overflow: hidden;
		background-color: #F5F5F5;
		border-radius: 4px;
		box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1) inset;
		color: #000;
		margin-left: 10%;
		margin-right: 10%;
		max-width: 100%;
		height: 200px;
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

<script>
	//Script, Jquery
	function makniPoruku3(){
		document.getElementById("dnevnaNagrada").style.display="none";
		document.getElementById("dnevnaNagradaX").innerHTML="";
	}
	function notok3(){
		document.getElementById("dnevnaNagrada").onclick=function(){return;}
	}
	function ok3(){
		document.getElementById("dnevnaNagrada").onclick=function(){makniPoruku3();}
	}
</script>

<div id='dnevnaNagrada' class='overlay' style='display:block;' onclick='makniPoruku3()'>
		<ol id='dnevnaNagradaX' class="progress" onmouseover='notok3()' onmouseleave='ok3()'>
			<p>Dnevna nagrada</p>
			<?php
				if(prijavljen()=="True"){
					$conn=conn();
					$sql="select zaredom from informacije where idkorisnik='".$_SESSION['userId']."'";
					$rez=$conn->query($sql);
					$row=$rez->fetch_assoc();
					
					$br=1;
					for($i=1;$i<$row["zaredom"];$i++){
						$br++;
						echo '<li class="is-complete" data-step="'.$i.'"></li>';
					}
					echo '<li class="is-active" data-step="'.$i.'"></li>';
					for($i=$br;$i<7;$i++){
						echo '<li class="not-active" data-step="'.$i.'"></li>';
					}
					echo '<li class="progress__last" data-step="7"></li>';
					$conn->close();
				}
			?>
		</ol>
</div>