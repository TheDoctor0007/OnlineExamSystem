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
			<li><a href="instructor.html">Home</a></li>
			<li><a href="quesadd.php">Create Questions</a></li>
			<li><a href="queslist.php">Manage Exam</a></li>
			<li><a href="grades.php">Manage Grades</a></li>
			<li><a href="index.html">Logout</a></li>
		</ul>
	 </div>
<style>
	.main h1{
		
		font-family: "Times New Roman", Georgia, Serif;
		font-size: 30px;
		color:#5e0c17;
	}
</style>
<div class="main">
	<h1>Modify Grades</h1>
	<style>
		.manageuser{
			font-family: "Times New Roman", Times, serif;
			font-size: 20px;
		}
		
	</style>
		<div class = "manageuser">
                <form style="font-color:black;" id="questions" method = "POST">




                <div id="lin"></div>
				
				
		<div/>

</div>

</section>
		<button id='submit' type='submit'>Submit Changes</button><br><br>

</div>


<script>

	var user;
	var qids;
	var comments;
	var scores;
	var newTotal = 0;
	var com;
	var totalScore = [];



	$(document).ready(function(){

		var student = "<?php
		if(isset($_GET["data"])){$data = $_GET["data"];}
		echo $data;
		?>";


	

		$.ajax({ url: "manageGrade.php",
		method: 'POST',
		datatypr: "json",
		cache: true,
            	data: { intent: "manage_grade", ucid: student},
        	context: document.body,
        	success: function(result){



           		var jsonAr = JSON.parse(result);

			user = jsonAr.ucids;
			var grade  = jsonAr.grades;
			var answers = jsonAr.answers;
			
			var scrArr = jsonAr.scores;
			var qidArr = jsonAr.qidArr;
			
			scores = jsonAr.scores.toString().split(",");
			var ans = answers.toString().split(",");
			com = jsonAr.comms.toString().split(".");
			comments = jsonAr.comms.toString().split(")");
			qids = jsonAr.qids;


			$("#gradeTable tbody tr").remove();
        		$("#lin2").html("");

			var newLine = new RegExp("\n", 'g');
			var retur = new RegExp("\r", 'g');
			var tab = new RegExp("\t", 'g');
			var all = new RegExp("\r\n\t", 'g');


			for(var i = 0; i<jsonAr.qids.length; i++){
				
				var comms = comments[i].slice(comments[i+1].indexOf(" ")+1, comments[i].indexOf("("));
				var scoreWhole = comments[i].slice(comments[i].indexOf("(")+1);
				var earned = scoreWhole.slice(0, scoreWhole.indexOf("/"));
				var possible = scoreWhole.slice(scoreWhole.indexOf("/")+1);

				com[i] = comms;

				$("#questions").append("<h3>Question " + (i+1) + ":</h3>");
				$("#questions").append("<br>" + jsonAr.quest[i] + "<hr>");
				$("#questions").append("<br>Student Answer:<br><br><p style='margin-left: 40px'>" + answers[i].replace(tab, '&emsp;').replace(newLine, '<br>') + "</p><br>");
				$("#questions").append("Comments:<p style='margin-left: 40px'><textarea style='overflow:auto;resize:none' id='addComm" + i + "' cols='60' rows='8' placeholder='No Comments'>" + comms + "</textarea></p>")
				$("#questions").append("Score: <input type='text' class='newScore' style='width:2em' value='" + earned +"'>/" + possible);


				totalScore[i] = possible;

			}



        	}});



	});



	$("#submit").click(function(e) {
            e.preventDefault();

			var newComments = document.getElementsByClassName("addComm");
			var newScore = document.getElementsByClassName("newScore");
			var scoreOut = [];

			var sendScores = 0;
			var sendComments = "";

			var tt = $('#addComm').val();

			for (var j = 0; j<qids.length; j++){
				var tt = $("#addComm" + j).val();
				sendComments += (j+1) + ". " + tt + "\n(" + newScore[j].value + "/" + totalScore[j] + ")\n";
				sendScores += parseInt(newScore[j].value, 10);
				scoreOut[j] = newScore[j].value;
				newTotal += parseInt(totalScore[j], 10);
			}

			sendComments += "Total: (" + sendScores + "/" + newTotal + ")";

			var percent = (sendScores/newTotal)*100;


			var tempScoreOut = "";
			var tempQIDS = "";
			for (var j = 0; j<qids.length; j++){
				tempScoreOut += scoreOut[j] + ",";
				tempQIDS += qids[j] + ",";
			}

			tempScoreOut = tempScoreOut.slice(0, tempScoreOut.length - 1);
			tempQIDS = tempQIDS.slice(0, tempQIDS.length - 1);

			var toSend = { intent: "modify", user: user, score: tempScoreOut, comments: sendComments, qid: tempQIDS, grade: percent};


    	$.ajax({method: 'POST',
            url: 'modify.php',
            cache: true,
            data: { intent: "modify", user: user, score: tempScoreOut, comments: sendComments, qid: tempQIDS, grade: percent},
            datatype: "json",
            beforeSend: function() {
              $("#lin2").html("Loading....");
           },
        success: function(result){
		window.location = "https://web.njit.edu/~qwc2/grades.php";

        }});
});


</script>


<script>


</script>



</body>
</html>