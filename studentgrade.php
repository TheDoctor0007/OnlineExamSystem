
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
        <form style="font-color:black;" action = "getGradeStu.php" method = "POST">
		<h2>Grade</h2>
        <div class="input-group">
        </div>
                <div style="color:blue; font-size:75%" id="lin"></div>
		<div id="gradeTotal"></div>

        </form>
	</div>
</div>
</section>

<div style="padding-left:30px;" id="loadedgrade"></div>
</div>

<script>
$(document).ready(function(){
        $.ajax({method: 'POST',
            url: 'getGradeStu.php',
            cache: true,
            data: { intent: "view_grades"},
            datatype: "json",
            beforeSend: function() {
              $("#lin").html("Loading grade....");
           },
            success: function(result){



		var jsonAr = JSON.parse(result);

		$("#lin").html("");
		
		if(jsonAr.pubs == 1){

			var grade  = jsonAr.grades;
			var answers = jsonAr.answers;
			
			var scrArr = jsonAr.scores;
			var qidArr = jsonAr.qidArr;
			
			var scores = jsonAr.scores.toString().split(",");
			var ans = answers.toString().split(",");
			var com = jsonAr.comms.toString().split(".");
			var comments = jsonAr.comms.toString().split(".");


			$("#gradeTable tbody tr").remove();
        		$("#lin2").html("");

			var newLine = new RegExp("\n", 'g');
			var retur = new RegExp("\r", 'g');
			var tab = new RegExp("\t", 'g');
			var all = new RegExp("\r\n\t", 'g');

			$("#gradeTotal").html("Exam Score: " + jsonAr.grades + "%");

			var tEarn = 0;
			var tPos = 0;


			for(var i = 0; i<jsonAr.qids.length; i++){
				var comms = comments[i+1].slice(comments[i+1].indexOf(" ")+1, comments[i+1].indexOf("("));
				var scoreWhole = comments[i+1].slice(comments[i+1].indexOf("(")+1, comments[i+1].indexOf(")"));
				var earned = scoreWhole.slice(0, scoreWhole.indexOf("/"));
				var possible = scoreWhole.slice(scoreWhole.indexOf("/")+1);


				$("#loadedgrade").append("<h3>Question " + (i+1) + ":</h3>");
				$("#loadedgrade").append("<br>" + jsonAr.quest[i] + "<hr>");
				$("#loadedgrade").append("<br>Your Answer:<br><br><p style='margin-left: 40px'>" + answers[i].replace(tab, '&emsp;').replace(newLine, '<br>') + "</p><br>");
				$("#loadedgrade").append("Instructor Comments:<p style='margin-left: 40px'>" + comms.replace(newLine, '<br>') + "</p>")
				$("#loadedgrade").append("Score: " + earned +"/" + possible + "<br><br>");


				tEarn += parseInt(earned, 10);
				tPos += parseInt(possible, 10);
			}

			$("#gradeTotal").append("<br>Points Earned: " + tEarn + "/" + tPos);


		}
		else{
			$("#loadedgrade").html("Exam Score not Published");
		}


        }});
});
</script>
</body>
</html>