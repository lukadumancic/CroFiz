<script>
				function startTime() {
					var today=new Date();
					var h=today.getHours();
					var m=today.getMinutes();
					var s=today.getSeconds();
					m = checkTime(m);
					s = checkTime(s);
					document.getElementById('txt').innerHTML = h+":"+m+":"+s;
					var t = setTimeout(function(){startTime()},500);
				}
				function checkTime(i) {
					if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
					return i;
				}
				
				var paragrafFooter=document.createElement("p");
				var sat=document.createElement("p");
				
				sat.id="txt";
				sat.classList.add("fut");
				
				paragrafFooter.innerHTML="Clock: ";
				paragrafFooter.classList.add("fut");
				
				document.getElementById("fut").appendChild(paragrafFooter);
				document.getElementById("fut").appendChild(sat);
			</script>
			<p class='ftr'>
				Made by: CroFiz WebTeam
			</p>
			<p class='ftr'>
				Email contact: crofiz.webteam@gmail.com
			</p>
			<p class='ftr'>
				<strong>© 2015. - Sva prava pridržana</strong>
			</p>