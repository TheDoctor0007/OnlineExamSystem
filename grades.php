

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
	<h1>Manage Grades</h1>
	<style>
		.manageuser{
			font-family: "Times New Roman", Times, serif;
			font-size: 20px;
		}
		
	</style>
		<div class = "manageuser">
                <form style="font-color:black;" action = "getGrade.php" method = "POST">
			<table class = "tblone" id = "gradesTable">
			<thead>
			<tr>
				<th width="100px">Name</th>
				<th width="50px">Grade</th>
				<th width="50px"></th>
			</tr>
			</thead>
	
			</table>
                <button id="publish" type="publish" class="btn">Publish Grades</button>
                <div id="lin"></div>
				
				
		<div/>
</div>
</section>
</div>

<script>
	$(document).ready(function(){
		$.ajax({ url: "getGrade.php",
		method: 'POST',
		datatypr: "json",
		cache: true,
            	data: { intent: "view_grades" },
        	context: document.body,
        	success: function(result){



           		var jsonAr = JSON.parse(result);

			var ucid = jsonAr.ucids;
			var grade  = jsonAr.grades;

			$("#gradeTable tbody tr").remove();
        		$("#lin2").html("");



            		for (var j=0; j < jsonAr.ucids.length; ++j){
				$("#gradesTable").append("<tr><td>"+ ucid[j] + "</td><td>" + grade[j] +"</td><td> <a href='modifyGrade.php?data=" + ucid[j] + "' class='button'>View More</a></td></tr>");
        		}

        	}});


		$("#publish").click(function(e) {
            e.preventDefault();

    	$.ajax({method: 'POST',
            url: 'publishGrade.php',
            cache: true,
            data: { intent: "publish_grade"},
            datatype: "json",
            beforeSend: function() {
              $("#lin").html("Loading....");
           },
        success: function(result){
              $("#lin").html("Grades Published!");

        }});
});









	});



</script>





</body>
</html>