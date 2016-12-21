<?php
	session_start();

	$yWin = isset($_SESSION["blueWin"]) ? $_SESSION["blueWin"] : 0;
	$eWin = isset($_SESSION["redWin"]) ? $_SESSION["redWin"] : 0;
?>
<!DOCTYPE html>
	<html>
	<head>
      	<!--Import Google Icon Font-->
      	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      	<!--Import materialize.css-->
      	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      	<!--Let browser know website is optimized for mobile-->
      	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
    	<nav class="light-blue lighten-1" role="navigation">
    		<div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">CS:GO Map Compare</a>
	      		<ul class="right hide-on-med-and-down">
	        		<li><a href="#">Created by Joseph Chua</a></li>
	      		</ul>
	      		<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    		</div>
  		</nav>
  		<div class="section no-pad-bot" id="index-banner">
			<div class="container">
	  			<div class="row center">
	    			<div class="row">
						<form name='compareForm' id='compareForm' class="col s12">
					      	<div class="row" id="timeInputs">
					        	<div class="input-field col s6">
					          		<textarea id='p1_times' name='p1_times' class="materialize-textarea"></textarea>
					          		<label for="p1_times"><span id="p1_name"></span> Time:</label>
					        	</div>
					        	<div class="input-field col s6">
					          		<textarea id='p2_times' name='p2_times' class="materialize-textarea"></textarea>
					          		<label for="p2_times"><span id="p2_name"></span> Time:</label>
					        	</div>
					      	</div>
					      	<div class="row">
					      		<div class="center-align">

								</div>
					      	</div>
					      	<div class="row" id="cardResult">
					      		<div class="input-field col s12">
					          		<div class="row">
        								<div class="col s6">
          									<div <?php if ($yWin > $eWin) { echo "class='card blue darken-1 z-depth-5'"; } else { echo "class='card red darken-1'"; } ?>>
            									<div class="card-content white-text">
              										<span class="card-title" id="p2_name_target"></span>
              										<p id="yourWinCount">Total Win: </p>
            									</div>
          									</div>
        								</div>
        								<div class="col s6">
          									<div <?php if ($yWin > $eWin) { echo "class='card red darken-1'"; } else { echo "class='card blue darken-1 z-depth-5'"; } ?>>
            									<div class="card-content white-text">
              										<span class="card-title" id="p2_name_target"></span>
              										<p id="enemyWinCount">Total Win: </p>
            									</div>
          									</div>
        								</div>
      								</div>
					        	</div>
					        	<div class="input-field col s12">
					          		<div class="row">
        								<div class="col s12">
        									<textarea id="logResultTimes" class="materialize-textarea"></textarea>
        								</div>
      								</div>
					        	</div>
					      	</div>
					      	<div class="row">
					      		<div class="input-field col s12 center-align">
					      			<a id='compareFormSubmit' class="waves-effect waves-light btn blue"><i class="material-icons left">swap_horiz</i> Compare</a>
					      			<a id='redoCompare' onclick="window.location.reload();" class="waves-effect waves-light btn blue"><i class="material-icons left">replay</i> Again</a>
					      		</div>
					      	</div>
					    </form>
					    <form id="entryForm" class="col s12">
					    	<div class="row">
					      		<div class="center-align input-field col s6">
						          	<input id="name1" placeholder="Name #1: " type="text" class="validate">
						        </div>
						        <div class="center-align input-field col s6">
						          	<input id="name2" placeholder="Name #2: " type="text" class="validate">
						        </div>
					      	</div>
						    <div class="row">
					      		<div class="input-field col s12 center-align">
					      			<a id='goNext' class="waves-effect waves-light btn blue"><i class="material-icons left">trending_flat</i> Next</a>
					      		</div>
					      	</div>
					    </form>
					</div>
	  			</div>
			</div>
		</div>
      	<!--Import jQuery before materialize.js-->
      	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      	<script type="text/javascript" src="js/materialize.min.js"></script>
      	<script>
      		$(document).on("ready", function(){
      			$("#compareForm").hide();
      			$("#cardResult").hide();
      			$("#redoCompare").hide();
      			$.post("process.php?clear");
      		});

      		$("#goNext").on("click", function(){
      			if ($("#name1").val().length <= 0 || $("#name2").val().length <= 0) {
      				var $toastContent = $('<span>Please enter two names!</span>');
					Materialize.toast($toastContent, 1000);
      			} else {
      				$.post("process.php?entry", {name1: $("#name1").val(), name2: $("#name2").val()});
      				$("#entryForm").hide();
      				$("#compareForm").show();
      				$("#p1_name").text($("#name1").val() + "'s");
      				$("#p2_name").text($("#name2").val() + "'s");
      				$(".card-title").eq(0).text($("#name1").val() + "'s Summary");
      				$(".card-title").eq(1).text($("#name2").val() + "'s Summary");
      			}
      		});

      		$("#compareFormSubmit").on("click", function(){
      			if ($("#p1_times").val().length < 50 || $("#p2_times").val().length < 50) {
		   			var $toastContent = $('<span>You must fill in both datas!</span>');
					Materialize.toast($toastContent, 1000);
				} else {
					$.post("process.php?data", {p1Times: $("#p1_times").val(), p2Times: $("#p2_times").val()}, function(data) {
						var datas = JSON.parse(data);
						console.log(datas[1]);
						$("#yourWinCount").text("Total Win: " + datas[1].yWin);
						$("#enemyWinCount").text("Total Win: " + datas[1].eWin);
						$("#cardResult").show();
						$("#timeInputs").hide();
						$("#compareFormSubmit").hide();
						$("#redoCompare").show();
						for (var i = 0, l = datas[0].length; i < l; i++ ) {
						    $("#logResultTimes").append(datas[0][i]);
						}
						$("#logResultTimes").css("height", "1320px");
					});
				}
			});
      	</script>
    </body>
</html>