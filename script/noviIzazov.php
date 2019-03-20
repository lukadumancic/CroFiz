<head>
	<!--Sort -->
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <style>
  #dodavanjeZadatka { list-style-type: none; margin: 10; padding: 0;display:inline;  }
  #dodavanjeZadatka li { display:inline; }
  #dodavanjeZadatka li span { position: absolute; margin-left: -1.3em; }
  </style>
  <script>
  $(function() {
    $( "#dodavanjeZadatka" ).sortable();
    $( "#dodavanjeZadatka" ).disableSelection();
  });
  </script>
  <!-- Drag -->
  <style>
  #draggable { width: 100px; height: 100px; padding: 0.5em; margin: 10px 10px 10px 0; }
  #droppable { width: 50px; height: 50px; display:inline;font-size:45px;border: none; background: none; }
  </style>
  <script>
  

  
  function remove(id){
	  $("#"+id).remove();
  }
  
  $(function() {
    $( "#draggable" ).draggable();
    $( "#droppable" ).droppable({
      drop: function( event, ui ) {
		  var id = ui.draggable.attr("id");
		  remove(id);
		  
		  var index = l.indexOf(parseInt(id));
		  if (index >= 0) {
			l.splice( index, 1 );
		  }
		  document.getElementById("brZad").value='|'+l.join('|')+'|';
		  
		  id=id.replace("button", "");
		  
		  remove('noviZadatak'+id);
		  console.log('noviZadatak'+id);
        $( this )
          .addClass( "ui-state-highlight" )
          .find( "p" )
            .html( "Dropped!" );
      }
    });
  });
  </script>
</head>
<body>

<div class='paralelna1' style="background: url('Slicice/izrada.jpg');background-size: cover;background-position: center; ">
<p>Dodavanje izazova</p>
<form method="post" action="dodajIzazov.php" enctype= "multipart/form-data">
	<input type="text" name="imeIzazova" placeholder="Ime Izazova" required>
	<?php echo dohvatiGrupe(); ?>
	
	<div class='izazoviZadaci' style='display:block'>
		<ul id='dodavanjeZadatka'>
		</ul>
		<div id="droppable" class="ui-widget-header">
			<img style='height:40px;width:40px;' src='Slicice/bin.jpg'>
		</div>
		<button class='dodajZadatak' type='button' onclick='noviZadatak()'>+</button>
		<input type='hidden' name='brojZadataka' value='' id='brZad'>
		<div id='zadaci'></div>
	</div>
	<input class='dodajIzazov' type='submit' value='Novi izazov' style=''>
	 
</form>
</div>
<script>
	var n=0;
	var z=-1;
	var l=[];
	
	function prikazi(x){
		if(z==-1){
			z=x;
			document.getElementById("noviZadatak"+x).style.display="block";
			document.getElementById("button"+x).style.color="white";
		}
		else{
			try{
				document.getElementById("button"+z).style.color="";
				document.getElementById("noviZadatak"+z).style.display="none";
			}
			catch(err){
				x=x;
			}
			document.getElementById("button"+x).style.color="white";
			document.getElementById("noviZadatak"+x).style.display="block";
			z=x;
		}
	}
	function imeGumba(id){
		if(document.getElementById("ime"+id).value==""){
			document.getElementById("button"+id).innerHTML="Zadatak "+id;
		}
		else{
			document.getElementById("button"+id).innerHTML=document.getElementById("ime"+id).value;
		}
	}
	
	function noviZadatak(){
		/*try{
			document.getElementById("noviZadatak"+z).style.display="none";
		}
		catch(err){
			z=z;
		}*/
		n+=1;
		l.push(n);
		document.getElementById("brZad").setAttribute("value", n);
							
		par=document.getElementById("dodavanjeZadatka");
							
		child=document.createElement("li");
		child.style.border="none";
		child.style.background="#3271BF";
		child.setAttribute("style","background: black;color: #696969;border: none;");
		child.setAttribute("class","ui-state-default marginLR");
		child.setAttribute("id",'button'+n);
		child.setAttribute("onClick",'prikazi('+n+')');
		child.style.textAlign="center";
		child.innerHTML="Zadatak "+n;
		
		par.appendChild(child);
		
		par2=document.getElementById("zadaci");
		
						
						zad=document.createElement("div");
						zad.setAttribute("id","noviZadatak"+n);
						zad.setAttribute("class","noviZadatak");
						zad.style.textAlign="center";
						zad.style.display="none";
						
						ime=document.createElement("INPUT");
						ime.setAttribute("type", "text");
						ime.setAttribute("id", "ime"+n);
						ime.setAttribute("name", "ime"+n);
						ime.setAttribute("placeholder", "Ime zadatka");
						ime.setAttribute("onChange","imeGumba("+n+")");
						ime.style.display="block";
						ime.style.width="40%";
						ime.required=true;
						ime.className="izazovUnos";
						
						tekst=document.createElement("TEXTAREA");
						tekst.style.display="block";
						tekst.setAttribute("name", "tekst"+n);
						tekst.setAttribute("cols","10");
						tekst.setAttribute("rows","10");
						tekst.setAttribute("placeholder", "Tekst zadatka");
						tekst.style.width="90%";
						tekst.required=true;
						tekst.className="izazovUnos";
						
						rj=document.createElement("INPUT");
						rj.setAttribute("type", "text");
						rj.style.display="block";
						rj.setAttribute("name", "rj"+n);
						rj.setAttribute("placeholder", "Rješenje zadatka");
						rj.style.width="20%";
						rj.required=true;
						rj.className="izazovUnos";
						
						mjernaJedinica=document.createElement("INPUT");
						mjernaJedinica.setAttribute("type", "text");
						mjernaJedinica.style.display="block";
						mjernaJedinica.setAttribute("name", "mjernaJedinica"+n);
						mjernaJedinica.setAttribute("placeholder", "Mjerna jedinica");
						mjernaJedinica.style.width="20%";
						mjernaJedinica.required=true;
						mjernaJedinica.className="izazovUnos";
						
						slika=document.createElement("INPUT");
						slika.setAttribute("type", "file");
						slika.style.display="block";
						slika.setAttribute("name", "slika"+n);
						slika.className="izazovUnos";
						slika.style.border="none";
						slika.style.width="40%";
						
	
						zad.appendChild(ime);
						zad.appendChild(tekst);
						zad.appendChild(rj);
						zad.appendChild(mjernaJedinica);
						zad.appendChild(slika);
						
						par2.appendChild(zad);
						
		document.getElementById("brZad").value='|'+l.join('|')+'|';
		prikazi(n);
								
		
	}
</script>
 
</body>
</html>