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
<h1>Create a question</h1>
	<div class = "adminpanel">
		<form style="font-color:black;" action = "sendQue.php" method = "POST">
                <label>Question Difficulty:</label>
                <select name="queDif" id="queDif">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                </select><br/>
                <label>Question Topic:</label>
                <select name="queTopic" id="queTopic">
                        <option value="none">N/A</option>
                        <option value="for loop">For Loop</option>
                        <option value="while loop">While Loop</option>
                        <option value="recursion">Recursion</option>
                </select><br/><br/>
                <label>Question:</label><br/>
                <textarea name="que" id="que" placeholder="Enter question...." style="height:80px; width:600px"></textarea><br/><br/>
                <label>Function name:</label><br/>
                <textarea name="funcName" id="funcName" placeholder="Enter function name...." style="width:600px"></textarea><br/><br/>
                
		<table class = "tbTC" id="testCaseTable">
		<tr>
			<th width="50%">Test Case</th>
			<th width="50%">Test Case Out</th>
		</tr>
		<tr>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tc1" cols="30" rows="2" placeholder="Enter testcase1...."></textarea>
		</td>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tco1" cols="30" rows="2" placeholder="Enter testcase1 output...."></textarea>
		</td>

		</tr>
		<tr>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tc2" cols="30" rows="2" placeholder="Enter testcase2...."></textarea>
		</td>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tco2" cols="30" rows="2" placeholder="Enter testcase2 output...."></textarea>
		</td>

		</tr>
		<tr>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tc3" cols="30" rows="2" placeholder="Enter testcase3...."></textarea>
		</td>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tco3" cols="30" rows="2" placeholder="Enter testcase3 output...."></textarea>
		</td>

		</tr>
		<tr>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tc4" cols="30" rows="2" placeholder="Enter testcase4...."></textarea>
		</td>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tco4" cols="30" rows="2" placeholder="Enter testcase4 output...."></textarea>
		</td>

		</tr>
		<tr>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tc5" cols="30" rows="2" placeholder="Enter testcase5...."></textarea>
		</td>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tco5" cols="30" rows="2" placeholder="Enter testcase5 output...."></textarea>
		</td>

		</tr>
		<tr>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tc6" cols="30" rows="2" placeholder="Enter testcase6...."></textarea>
		</td>
		<td>
    			<textarea style="overflow:auto;resize:none" name="" id="tco6" cols="30" rows="2" placeholder="Enter testcase6 output...."></textarea>
		</td>

		</tr>

    		</table>

                <button id="add" type="add" class="btn">Create</button>
                <div style="color:blue;" id="lin"></div>

		</form>
	</div>
</div>

<div class="split right";>
<h1>Existing Questions</h1>
        <div class = "manageuser">
        <form style="font-color:black;" action = "getQue.php" method = "POST">
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
                        <option value="none">N/A</option>
                        <option value="for loop">For Loop</option>
                        <option value="while loop">While Loop</option>
                        <option value="recursion">Recursion</option>
                </select>
                <button id="load" type="load" class="btn">Load</button>

                <div style="color:blue;" id="lin2"></div>
                <table class = "tblone" id="queBank">
			<thead>
				<tr>
					<th width="20%">Topic</th>
					<th width="15%">Difficulty</th>
					<th width="65%">Question</th>
				</tr>
			</thead>
                 </table>
        </form>
        </div>
</div>
</div>
</section>
</div>



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

			//$("#queBank tr").remove();
				$("#lin2").html("");

			var myTable = document.getElementById("queBank");
			var rowCount = myTable.rows.length;

			for (var j=rowCount-1; j > 0; j--){
				myTable.deleteRow(j);
			}

				for (var j=0; j < jsonAr.tops.length; ++j){
			$("#queBank").append("<tr><td>"+ tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
			}
			}});
		} 
		else{

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

			//$("#queBank tr").remove();
				$("#lin2").html("");

			var myTable = document.getElementById("queBank");
			var rowCount = myTable.rows.length;

			for (var j=rowCount-1; j > 0; j--){
				myTable.deleteRow(j);
			}
			for (var j=0; j < jsonAr.tops.length; ++j){
				$("#queBank").append("<tr><td>"+ tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
			}
			}});
		}
    });
});

</script>


<script>
$(document).ready(function(){
    $("#add").click(function(e){
            e.preventDefault();



		var tcase = [$('#tc1').val(), $('#tc2').val(), $('#tc3').val(), $('#tc4').val(), $('#tc5').val(), $('#tc6').val()];
		var tcaseout = [$('#tco1').val(), $('#tco2').val(), $('#tco3').val(), $('#tco4').val(), $('#tco5').val(), $('#tco6').val()];
		var testcase = '';
		var testcaseout = '';


		for(var j=0; j<5; j++){
			if(tcase[j] != '' && tcaseout[j] != ''){
				testcase += tcase[j] + ",";
				testcaseout += tcaseout[j] + ",";
			}
		}

		testcase = testcase.slice(0, -1);
		testcaseout = testcaseout.slice(0, -1);

		
		$.ajax({method: 'POST',
		url: 'sendQue.php',
		cache: true,
		data: { intent: "filter", queDif: $('#queDif').val(), queTopic: $('#queTopic').val(), que: $('#que').val(), funcName: $('#funcName').val(), test: testcase, testout: testcaseout},
		datatype: "json",
		beforeSend: function() {
		$("#lin2").html("Loading....");
		},
		success: function(result){



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

			//$("#queBank tr").remove();
				$("#lin2").html("");

			var myTable = document.getElementById("queBank");
			var rowCount = myTable.rows.length;

			for (var j=rowCount-1; j > 0; j--){
				myTable.deleteRow(j);
			}
			for (var j=0; j < jsonAr.tops.length; ++j){
				$("#queBank").append("<tr><td>"+ tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
			}
	}});
});











		$("#lin2").html("");
		}});

	});
});

</script>

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


			$("#lin2").html("");


			for (var j=0; j < ques.length; j++){
				$("#queBank").append("<tr><td>" + tops[j] + "</td><td>" + difs[j] + "</td><td>" + ques[j] +"</td></tr>");
			}

        }});
});


</script>

</body>
</html>