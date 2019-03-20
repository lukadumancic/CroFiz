<?php
	//Pokretanje sessiona
	session_start();
	//Ako nisu postavljene session varijable tada ih treba postaviti
	if(!isset($_SESSION["nick"])){$_SESSION["nick"]="*%test%*";}
	if(!isset($_SESSION["pass"])){$_SESSION["pass"]="*%test%*";}
?>
<script>
function humanized_time_span(date, ref_date, date_formats, time_units) {
  //Date Formats must be be ordered smallest -> largest and must end in a format with ceiling of null
  date_formats = date_formats || {
    past: [
      { ceiling: 60, text: "$seconds seconds ago" },
      { ceiling: 3600, text: "$minutes minutes ago" },
      { ceiling: 86400, text: "$hours hours ago" },
      { ceiling: 2629744, text: "$days days ago" },
      { ceiling: 31556926, text: "$months months ago" },
      { ceiling: null, text: "$years years ago" }      
    ],
    future: [
      { ceiling: 60, text: "in $seconds seconds" },
      { ceiling: 3600, text: "in $minutes minutes" },
      { ceiling: 86400, text: "in $hours hours" },
      { ceiling: 2629744, text: "in $days days" },
      { ceiling: 31556926, text: "in $months months" },
      { ceiling: null, text: "in $years years" }
    ]
  };
  //Time units must be be ordered largest -> smallest
  time_units = time_units || [
    [31556926, 'years'],
    [2629744, 'months'],
    [86400, 'days'],
    [3600, 'hours'],
    [60, 'minutes'],
    [1, 'seconds']
  ];
  
  date = new Date(date);
  ref_date = ref_date ? new Date(ref_date) : new Date();
  var seconds_difference = (ref_date - date) / 1000;
  
  var tense = 'past';
  if (seconds_difference < 0) {
    tense = 'future';
    seconds_difference = 0-seconds_difference;
  }
  
  function get_format() {
    for (var i=0; i<date_formats[tense].length; i++) {
      if (date_formats[tense][i].ceiling == null || seconds_difference <= date_formats[tense][i].ceiling) {
        return date_formats[tense][i];
      }
    }
    return null;
  }
  
  function get_time_breakdown() {
    var seconds = seconds_difference;
    var breakdown = {};
    for(var i=0; i<time_units.length; i++) {
      var occurences_of_unit = Math.floor(seconds / time_units[i][0]);
      seconds = seconds - (time_units[i][0] * occurences_of_unit);
      breakdown[time_units[i][1]] = occurences_of_unit;
    }
    return breakdown;
  }

  function render_date(date_format) {
    var breakdown = get_time_breakdown();
    var time_ago_text = date_format.text.replace(/\$(\w+)/g, function() {
      return breakdown[arguments[1]];
    });
    return depluralize_time_ago_text(time_ago_text, breakdown);
  }
  
  function depluralize_time_ago_text(time_ago_text, breakdown) {
    for(var i in breakdown) {
      if (breakdown[i] == 1) {
        var regexp = new RegExp("\\b"+i+"\\b");
        time_ago_text = time_ago_text.replace(regexp, function() {
          return arguments[0].replace(/s\b/g, '');
        });
      }
    }
    return time_ago_text;
  }
          
  return render_date(get_format());
}	
var custom_date_formats = {
  past: [
    { ceiling: 60, text: "less than a minute ago" },
    { ceiling: 86400, text: "$hours hours, $minutes minutes and $seconds seconds ago" },
    { ceiling: null, text: "$years years ago" }
  ],
  future: [
    { ceiling: 60, text: "in less than a minute" },
    { ceiling: 86400, text: "in $hours hours, $minutes minutes and $seconds seconds time" },
    { ceiling: null, text: "in $years years" }
  ]
}
</script>
<html>
		<head>
			<link rel="stylesheet" type="text/css" href="Style.css">
			<title>Connectihno</title>
		</head>
		<body>
			<div class="fixed">
				<header>
					<h1 style="display:inline;color:white;">Connectihno</h1>
					<br>
				</header>
				<nav>
					<div id="nav">
						<a class='main' href='http://82.132.7.168/Connectihno.php'>Chat</a>
						<?php if(!loged())echo"<p style='font-size:25px;display:inline;'>/</p>
						<a class='reg' href='http://82.132.7.168/Registration.php'>Register</a>
						<p style='font-size:25px;display:inline;'>/</p>
						<a class='log' href='http://82.132.7.168/LogIn.php'>LogIn</a>";
						else{
							echo "
							<p style='font-size:25px;display:inline;'>/</p>
							<a class='main' href='http://82.132.7.168/Profile.php'>Profile</a>
							<p style='font-size:25px;display:inline;'>/</p>
							<a class='main' style='color:red;' href='http://82.132.7.168/LogOut.php'>LogOut</a>";
						}?>

					</div>
				</nav>
			</div>
			<article>
				<h2 style='color:black;font-size:35px;margin-top: -35px;'>Connectihno chat</h2><br>
				
				<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.0.0/annyang.min.js"></script>
				<script>
					if (annyang) {
					  var commands = {
						'go to *term':function(term){
							if(term=='chat'){term='Connectihno';}
							window.location='http://82.132.7.168/'+term+'.php'
						}
					  };
					  annyang.addCommands(commands);
					  // Start listening. You can call this here, or attach this call to an event, button, etc.
					  annyang.start();
					}
				</script>
				
			</article>
			<footer>
				<strong>Connectihno © 2015. - All rights reserved</strong>
			</footer>
		</body>
		<?php
			function loged(){
				if($_SESSION["nick"]=="*%test%*" and $_SESSION["pass"]=="*%test%*"){
					return False;
				}
				else{
					return True;
				}
			}
		?>
</html>
