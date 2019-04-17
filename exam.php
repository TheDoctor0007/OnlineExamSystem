<html>
<head>
	<link rel="stylesheet" href="admin.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
<div class="phpcoding">
	<section class="headeroption"></section>
		<section class="maincontent">
		<div class="menu">
		<ul>
			<li><a href="student.html">Home</a></li>
			<li><a href="exam.php">Take Exam</a></li>
			<li><a href="studentgrade.php">Grades</a></li>
			<li><a href="index.html">Logout</a></li>
		</ul>
	 </div>
<style>
	.main{
		
		
	}
	.main h1{
		font-family: "Times New Roman", Georgia, Serif;
		font-size: 30px;
		color:#5e0c17;
	}
	.adminpanel{
		width:500px;
		color:#897073;
		margin:30px auto 0;
		padding:50px;
		border:2px solid #ddd;
		font-family: "Times New Roman", Georgia, Serif;
		font-size: 20px;
		}
</style>
<div class="main">
	<div class = "adminpanel">
        <form style="font-color:black;" onSubmit="return false;" method = "POST">
		<h2>Exam</h2>
		<button id="start" type="start" class="btn">Start</button>
		<div style="color:blue; font-size:75%" id="lin"></div>
        </form>
	</div>

	<form style="font-color:black;" onSubmit="return false;">
			<div id="linT"></div> 
			<button id="send" type="send" class="btn" style="visibility:hidden;">Submit</button>
			<!--
	<div class="input-group">
			<label>Question 1:</label>
			<div id="lin1"></div> 
	<textarea name="que1" id="que1" style="height:80px; width:600px"></textarea><br/><br/>
	</div>
	<div class="input-group">
			<label>Question 2:</label>
			<div id="lin2"></div> 
	<textarea name="que2" id="que2" style="height:80px; width:600px"></textarea><br/><br/>
	</div>
	-->
	</form>


	
</div>
</section>
</div>

<script>
var decodedResult, queTotal;
$(document).ready(function(){
    $("#start").click(function(){
        $.ajax({method: 'POST',
            url: 'takeexam.php',
            cache: true,
            data: { intent: "take_exam"},
            datatype: "json",
            beforeSend: function() {
              $("#lin").html("Loading....");
           },
            success: function(result){				
				var toDisplay = "";
				decodedResult = JSON.parse(result);
				queTotal = decodedResult.points.length;
				
				//toDisplay += "<h1>" + result + "</h1>";
				for (i = 0; i < decodedResult.points.length; i++) {
					toDisplay += "<label>" + (i+1) + ". " + decodedResult.qsts[i] + "</label><br>";
					toDisplay += "<label>Points: " + decodedResult.points[i] + "</label><br>";
					toDisplay += '<textarea name="' + decodedResult.qids[i] + '" id="que' + i + '" id="que' + i +'" style="height:80px; width:600px"></textarea><br/><br/>';
				}
				//toDisplay += '<button id="send" type="send" class="btn" style="display: none;">Submit</button>';
				
				$("#start").css("visibility", "hidden");
				$("#send").css("visibility", "visible");
				$("#lin").html(""); // No more "Loading..."
				$("#linT").html(toDisplay);
				
			}});
    });
});

$(document).ready(function(){
				$("#send").click(function(){
				  var x = $("textarea").serializeArray();
				  var examqids = [];
          var examqpts = [];
          var examqans = [];
		  var username = "prm46";
		  var examfname = [];
		  var examqqtype = [];
		  var examtestins = [];
		  var examtestouts = [];
          $.each(x, function(i, field){
        	  examqids.push(field.name);
            examqans.push(field.value);
          });
          for (i = 0; i < decodedResult.points.length; i++){
            examqpts.push(decodedResult.points[i]);
			examfname.push(decodedResult.fnames[i]);
			examqqtype.push(decodedResult.tops[i]);
			examtestins.push(decodedResult.ins[i]);
			examtestouts.push(decodedResult.outs[i]);
          }
          
          $.ajax({method: 'POST',
            url: 'grade.php',
            cache: true,
            data: JSON.stringify({eqids: examqids, eqans: examqans, eqpts: examqpts, eqfname: examfname, eqtype: examqqtype, eqins: examtestins, eqouts: examtestouts}),
            //dataType: "json",
            beforeSend: function() {
              $("#lin").html("Submitting....");
           },
            success: function(result){	

		alert(result);
	

              $("#lin").html("Submitted!"); // No more "Loading..."
				      $("#linT").html("");

			      },
            error: function(jqXHR, exception, thrown) {
              $("#lin").html(exception + thrown);
            }
          });
    });
});
</script>

</body>
</html>

