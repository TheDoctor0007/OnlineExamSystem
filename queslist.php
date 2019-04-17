<html>
<head>
	<link rel="stylesheet" href="admin.css">
	<link rel="stylesheet" href="split.css">
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
	.adminpanel{color:black;margin:20px auto 0;padding:10px;border:1px solid #ddd;}
</style>
<style>
	.main h1{
		
		font-family: "Times New Roman", Georgia, Serif;
		font-size: 30px;
		color:#5e0c17;
	}
</style>
<div class="split left";>
<h1>Current exam</h1>
	<div class = "adminpanel">
		<form style="font-color:black;" action = "createexam.php" method = "POST">
                <table class = "tbltwo" id="examBank">
			<thead>
			<tr>
				<th width="5%">No.</th>
				<th width="95%">Question</th>
				<th width="5%">Points</th>
			</tr>
			</thead>
                 </table>
                <button id="pubexam" type="pubexam" class="btn">Publish Exam</button>
                <div style="color:blue;" id="lin4"></div>
		</form>
	</div>
</div>

<div class="split right";>
<h1>Existing Questions</h1>
        <div class = "manageuser">
                <form style="font-color:black;" action = "getExam.php" method = "POST">
                <label>Question Difficulty:</label>
                <select name="queDifFilter" id="queDifFilter">
                        <option value="All">All</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                </select>
                <label>Question Topic:</label>
                <select name="queTopicFilter" id="queTopicFilter">
                        <option value="All">All</option>
                        <option value="for loop">For Loop</option>
                        <option value="while loop">While Loop</option>
                        <option value="recursion">Recursion</option>
                </select>
                <button id="load" type="load" class="btn">Load</button>
             <div style="color:blue;" id="lin2"></div>
                <table class = "tblone" id="queBank2">
			<thead>
			<tr>
				<th width="5%">No.</th>
				<th width="20%">Topic</th>
				<th width="15%">Difficulty</th>
				<th width="60%">Question</th>
			</tr>
			</thead>
                 </table>
		</form>
                <form style="font-color:black;" action = "addToExam.php" method = "POST">
                <div class="input-group">
    		<label>Question No.:</label> 
    		<input name="quesNo" id="quesNo">
		</div>
		<button id="addE" type="addE" class="btn">Add to Exam</button>
                <div style="color:blue;" id="lin5"></div>
		</form>
        </div>
</div>

<script>

$( document ).ready(function() {
    $.ajax({method: 'POST',
            url: 'getQue.php',
            cache: true,
            data: { intent: "view_question"},
            datatype: "json",
            beforeSend: function() {
              $("#lin2").html("Loading....");
           },
        success: function(result){

			var jsonAr = JSON.parse(result);

			var tops = jsonAr.tops;
			var difs = jsonAr.diffs;
			var ques = jsonAr.qsts;
			var qids = jsonAr.qids;
			var qidlist = jsonAr.qidlist;
			var inExam = jsonAr.inExam;
			var points = jsonAr.points;


			$("#lin2").html("");
		
			 var pointTotal = 0;

			for (var j=0; j < ques.length; j++){
				if(inExam[j] == 1){
					$("#examBank").append("<tr><td>"+ qids[j] + "</td><td>" + ques[j] + "</td><td><input type='text' style='width:30px' name='pointText' id='pointText" + j + "' value=" + points[j] + " /></td></tr>");
					pointTotal += parseInt(points[j]);
				}else{
					$("#queBank2").append("<tr><td>"+ qids[j] + "</td><td>" + tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
				}

			}
			$("#examBank").append("<tr><td>"+ "</td><td>" + "</td><td id='pointTotal'>" + pointTotal + "</td></tr>");

        }});
});

</script>

<script>

$(document).ready(function(){
    $("#examBank").change(function(){


	var table = $("#examBank tr").length - 1;
	var sum =0;
	var myT = document.getElementById('examBank');

	for (var j=1; j < table; j++){
		sum = sum + parseInt(myT.rows[j].cells[2].getElementsByTagName('input')[0].value);
	}


	document.getElementById("pointTotal").innerHTML = sum;


		
});
});

</script>

<script>
$(document).ready(function(){
    $("#load").click(function(e){
            e.preventDefault();

	if($('#queDifFilter').val() == "All" && $('#queTopicFilter').val() == "All"){


        $.ajax({method: 'POST',
            url: 'getQue.php',
            cache: true,
            data: { intent: "view_questions"},
            datatype: "json",
            beforeSend: function() {
              $("#lin2").html("Loading....");
           },
            success: function(result){

		var jsonAr = JSON.parse(result);

		var tops = jsonAr.tops;
		var difs = jsonAr.diffs;
		var ques = jsonAr.qsts;
		var qids = jsonAr.qids;
		var qidlist = jsonAr.qidlist;
		var inExam = jsonAr.inExam;


		var myTable = document.getElementById("queBank2");
		var rowCount = myTable.rows.length;

		for (var j=rowCount-1; j > 0; j--){
			myTable.deleteRow(j);
		}

		$("#lin2").html("");

		for (var j=0; j < jsonAr.tops.length; ++j){
			if(inExam[j] == 0){
			$("#queBank2").append("<tr><td>"+ qids[j] + "</td><td>" + tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
        		}
		}


        	}});
	}else{

		$qdf = $('#queDifFilter').val();
		$qtf = $('#queTopicFilter').val();
		if($('#queDifFilter').val() == "All"){
			$qdf = null;
		}
		if($('#queTopicFilter').val() == "All"){
			$qtf = null;
		}

			$.ajax({method: 'POST',
			url: 'getFilter.php',
			cache: true,
			data: { intent: "filter", queDif: $qdf, queTopic: $qtf},
			datatype: "json",
			beforeSend: function() {
			  $("#lin2").html("Loading....");
			 },
			success: function(result){

			var jsonAr = JSON.parse(result);

			var tops = jsonAr.tops;
			var difs = jsonAr.diffs;
			var ques = jsonAr.qsts;
			var qids = jsonAr.qids;
			var qidlist = jsonAr.qidlist;
			var inExam = jsonAr.inExam;

			//$("#queBank tr").remove();
				$("#lin2").html("");

			var myTable = document.getElementById("queBank2");
			var rowCount = myTable.rows.length;

			for (var j=rowCount-1; j > 0; j--){
				myTable.deleteRow(j);
			}
			for (var j=0; j < jsonAr.tops.length; ++j){
				if(inExam[j] == 0){
					$("#queBank2").append("<tr><td>"+ qids[j] + "</td><td>" + tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
				}
			}
			}});



	}


    });
});
</script>

<script>
$(document).ready(function(){
    $("#addE").click(function(e){
	e.preventDefault();
        $.ajax({method: 'POST',
            url: 'addToExam.php',
            cache: true,
            data: { intent: "insert_question", questID: $("#quesNo").val()},
            datatype: "json",
            beforeSend: function() {
              $("#lin5").html("Adding....");
           },
            success: function(){
            $("#lin5").html("Added!");











        }});
	});
});
</script>

<script>
$(document).ready(function(){
    $("#pubexam").click(function(e){
	e.preventDefault();

	var table = $("#examBank tr").length - 1;
	pointString = '';
	noString = '';
	var myT = document.getElementById('examBank');

	for (var j=1; j < table; j++){
		pointString += myT.rows[j].cells[2].getElementsByTagName('input')[0].value + ",";
		noString += myT.rows[j].cells[0].innerHTML + ",";
	}
	
	pointString = pointString.slice(0, -1);
	noString = noString.slice(0, -1);

	
	   
        $.ajax({method: 'POST',
            url: 'createexam.php',
            cache: true,
            data: { intent: "publish_exam", points: pointString, quesID: noString},
            datatype: "json",
            beforeSend: function() {
              $("#lin4").html("Publishing....");
           },
            success: function(result){
            $("#lin4").html("Published!");	


        }});
    });
});
</script>

</section>
</div>

</body>
</html>