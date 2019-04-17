<?php

$servername = "sql1.njit.edu";
$username = "prm46";
$password = "EUBow3aL0";
$database = "prm46";

//Get information from Middle
//$user = $_post['login'];
//$pwd = $_post['pass'];

// Get information from Middle
$input = file_get_contents('php://input');
$json = json_decode($input);

//login
$user = $json->{"username"};
$pwd = $json->{"password"};
//$user = "prm46";
//$pwd = "fjdsakslfjl";
//$pwd = MD5($pwd);

//add question
$qst = $json->{"question"};
$topic = $json->{"topic"};
$diff = $json->{"difficulty"};
$fname = $json->{"fname"};
$testcaseList = $json->{"testcaseList"};
$points = $json->{"points"};
$testInput = $json->{"testInput"};
$testOutput = $json->{"testOutput"};


echo $testInput;
echo $testOutput;




//$qst = "write a recursive method to print every value of the array";
//$topic = "recursion";
//$diff = "medium";
//$fname = "array_contents";
//$test = "y";
//$testout = "n";

//insert into exam
$insert = $json->{"insert"};
$qid = $json->{"questionID"};
$qIDList = $json->{"qIDList"};
$eid = $json->{"examID"};
$publish = $json->{"pubExam"};
//$insert = "yes";
//$qid = 10;
//$eid = 1;
//$publish = 1;

//take exam
$take = $json->{"take"};
//$take = "yes";

//store_grade
$grade = $json->{"grade"};
$comment = $json->{"comment"};
//$grade = 90;

//publish_grade
$pubgrade = $json->{"pubGrade"};

/*
intents:
---------------------------
login				x
store_grade			x
add_question		x
insert_question		x
take_exam			x
view_questions		x
view_exam			x
publish_grade		x
publish_exam		x
unpublish_exam		x
view_grades			x
filter				x
*/
$intent = $json->{"intent"};
//$intent = "unpublish_exam";
//$diff = "medium";
//$topic = "for loop";
//$qIDList = "5";

//Get information from database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//check credentials
if ($intent == "login") {
	$check = "SELECT * FROM Credentials WHERE Username = '$user' && Password = '$pwd'";
	$num_matches = $conn->query($check);

	if ($num_matches->num_rows > 0) {
		$obj->check = "yes";
		if ($row = $num_matches->fetch_assoc()) {
			$obj->is_prof = $row["Is_Professor"];
			
			//echo $row["Is_Professor"];
		}
		$json = json_encode($obj);
	} else {
		$obj->check = "no";
		$json = json_encode($obj);
	}
	echo $json;
}

//add question to question bank and testcases to their appropriate table - each test case refers to a specific question
elseif ($intent == "add_question") {
	$insert = "INSERT INTO `Question_Bank`(`Topic`, `Difficulty`, `Question`, `Function_Name`, `Points`) VALUES ('$topic','$diff','$qst','$fname', '$points')";
	$result = $conn->query($insert);
	$select = "SELECT Question_ID FROM Question_Bank WHERE Topic = '$topic' && Difficulty = '$diff' && Question = '$qst'";
	$result2 = $conn->query($select);
	if ($row = $result->fetch_assoc()) {
		$currqid = $row["Question_ID"];
	}
	for ($i = 0; $i < sizeof($testInput); $i++) {
		$in = "INSERT INTO `Test_Cases` (`Input`, `Output`, `Question_ID`) VALUES ('$testInput[$i]', '$testOutput[$i]', '$currqid')";
	}
	//echo $result2;
}

//filter by topic and / or difficulty
elseif ($intent == "filter") {
	if ($topic && $diff) {
		$filter = "SELECT * FROM Question_Bank WHERE Topic = '$topic' && Difficulty = '$diff'";
		$result = $conn->query($filter);
		$tarr = array();
		$darr = array();
		$qarr = array();
		$qidarr = array();
		$fnarray = array();
		$pointarr = array();
		$tlarr = array();
		$inarr = array();
		$i = 1;
		while ($row = $result->fetch_assoc()) {
			$tarr = array_pad($tarr, $i, $row["Topic"]);
			$darr = array_pad($darr, $i, $row["Difficulty"]);
			$qarr = array_pad($qarr, $i, $row["Question"]);
			$qidarr = array_pad($qidarr, $i, $row["Question_ID"]);
			$fnarr = array_pad($fnarr, $i, $row["Function_Name"]);
			$pointarr = array_pad($pointarr, $i, $row["Points"]);
			$tlarr = array_pad($tlarr, $i, $row["Testcase_List"]);
			$inarr = array_pad($inarr, $i, $row["In_Exam"]);
			$i++;
		}
		$obj->tops = $tarr;
		$obj->diffs = $darr;
		$obj->qsts = $qarr;
		$obj->qids = $qidarr;
		$obj->fnames = $fnarr;
		$obj->points = $pointarr;
		$obj->tlist = $tlarr;
		$obj->inExam = $inarr;
		$json = json_encode($obj);
	}
	elseif ($topic) {
		$filter = "SELECT * FROM Question_Bank WHERE Topic = '$topic'";
		$result = $conn->query($filter);
		$tarr = array();
		$darr = array();
		$qarr = array();
		$qidarr = array();
		$fnarray = array();
		$pointarr = array();
		$tlarr = array();
		$inarr = array();
		$i = 1;
		while ($row = $result->fetch_assoc()) {
			$tarr = array_pad($tarr, $i, $row["Topic"]);
			$darr = array_pad($darr, $i, $row["Difficulty"]);
			$qarr = array_pad($qarr, $i, $row["Question"]);
			$qidarr = array_pad($qidarr, $i, $row["Question_ID"]);
			$fnarr = array_pad($fnarr, $i, $row["Function_Name"]);
			$pointarr = array_pad($pointarr, $i, $row["Points"]);
			$tlarr = array_pad($tlarr, $i, $row["Testcase_List"]);
			$inarr = array_pad($inarr, $i, $row["In_Exam"]);
			$i++;
		}
		$obj->tops = $tarr;
		$obj->diffs = $darr;
		$obj->qsts = $qarr;
		$obj->qids = $qidarr;
		$obj->fnames = $fnarr;
		$obj->points = $pointarr;
		$obj->tlist = $tlarr;
		$obj->inExam = $inarr;
		$json = json_encode($obj);
	}
	elseif ($diff) {
		$filter = "SELECT * FROM Question_Bank WHERE Difficulty = '$diff'";
		$result = $conn->query($filter);
		$tarr = array();
		$darr = array();
		$qarr = array();
		$qidarr = array();
		$fnarray = array();
		$pointarr = array();
		$tlarr = array();
		$inarr = array();
		$i = 1;
		while ($row = $result->fetch_assoc()) {
			$tarr = array_pad($tarr, $i, $row["Topic"]);
			$darr = array_pad($darr, $i, $row["Difficulty"]);
			$qarr = array_pad($qarr, $i, $row["Question"]);
			$qidarr = array_pad($qidarr, $i, $row["Question_ID"]);
			$fnarr = array_pad($fnarr, $i, $row["Function_Name"]);
			$pointarr = array_pad($pointarr, $i, $row["Points"]);
			$tlarr = array_pad($tlarr, $i, $row["Testcase_List"]);
			$inarr = array_pad($inarr, $i, $row["In_Exam"]);
			$i++;
		}
		$obj->tops = $tarr;
		$obj->diffs = $darr;
		$obj->qsts = $qarr;
		$obj->qids = $qidarr;
		$obj->fnames = $fnarr;
		$obj->points = $pointarr;
		$obj->tlist = $tlarr;
		$obj->inExam = $inarr;
		$json = json_encode($obj);
	}
	echo $json;
}

//insert question into exam
elseif ($intent == "insert_question") {
	$questNums = explode(",", $qIDList);
	$i = 1;
	foreach ($questNums as $qnum) {
		$update = "UPDATE `Question_Bank` SET `In_Exam`='1' WHERE `Question_ID`='$qnum'";
		$result = $conn->query($update);
	}
/*	
	$select = "SELECT * FROM Exams WHERE Exam_ID = '$eid'";
	$num_matches = $conn->query($select);
	if ($num_matches->num_rows == 0) {
		$questNums = explode(",", $qIDList);
		$insert = "INSERT INTO `Exams`(`Exam_ID`, `Question_IDs`, `Is_Published`) VALUES ('$eid','$qidlist','0')";
		$result = $conn->query($insert);
	}
	else {
		if ($row = $num_matches->fetch_assoc()) {
			$qids = $row["Question_IDs"];
		}
		$qidstr = strval($qid);
		$qlist = $qids.",".$qidstr;
		$insert = "UPDATE `Exams` SET `Question_IDs`='$qlist', `Is_Published`='0' WHERE `Exam_ID`='$eid'";
		$result = $conn->query($insert);
	}
*/
}

//send exam for student to take
elseif ($intent == "take_exam") {
	//echo "start take exam";
	$exam = "SELECT * FROM `Exams` WHERE Is_Published = '1'";
	$num_matches = $conn->query($exam);
	$questions = "SELECT * FROM Question_Bank WHERE In_Exam = '1'";
	$result = $conn->query($questions);
	$tarr = array();
	$darr = array();
	$qarr = array();
	$qidarr = array();
	$fnarray = array();
	$tlarr = array();
	$inarr = array();
	$i = 1;
		while ($row = $result->fetch_assoc()) {
			$tarr = array_pad($tarr, $i, $row["Topic"]);
			$darr = array_pad($darr, $i, $row["Difficulty"]);
			$qarr = array_pad($qarr, $i, $row["Question"]);
			$qidarr = array_pad($qidarr, $i, $row["Question_ID"]);
			$fnarr = array_pad($fnarr, $i, $row["Function_Name"]);
			$tlarr = array_pad($tlarr, $i, $row["Testcase_List"]);
			$inarr = array_pad($inarr, $i, $row["In_Exam"]);
			$i++;
		}
	$obj->tops = $tarr;
	$obj->diffs = $darr;
	$obj->qsts = $qarr;
	$obj->qids = $qidarr;
	$obj->fnames = $fnarr;
	$obj->tlist = $tlarr;
	$obj->inExam = $inarr;
	if($num_matches > 0){
		$obj->Is_Published = 1;
	}
	else{
		$obj->Is_Published = 0;		
	}
	$json = json_encode($obj);
		/*
		//echo "there is stuff";	
		if ($row = $num_matches->fetch_assoc()) {
			//echo "fetched EID";
			$examID = $row["Exam_ID"];
			$obj->eid = $examID;
			$select = "SELECT Question_IDs FROM Exams WHERE Exam_ID = '$examID'";
			$result = $conn->query($select);
			if ($result->num_rows > 0) {
				//echo "there is a list of QIDs";
				if ($col = $result->fetch_assoc()) {
					//echo "fetched QIDs";
					$qlist = $col["Question_IDs"];
					$obj->qids = $qlist;
					$qarr = explode(",", $qlist);
					$i = 1;
					$questarr = array();
					foreach ($qarr as $qid) {
						$select = "SELECT Question FROM Question_Bank WHERE Question_ID = '$qid'";
						$result2 = $conn->query($select);
						if ($result2->num_rows > 0) {
							while ($column = $result2->fetch_assoc()) {
								$questarr = array_pad($questarr, $i, $column["Question"]);
								$i++;
							}
						}
					}
					$obj->qs = $questarr;
					//echo "before encode";
					$json = json_encode($obj);
				}
			}
		}
		*/
	echo $json;
}

//store grade to transcript
elseif ($intent == "store_grade") {
	$insert = "INSERT INTO `Student_Transcripts`(`UCID`, `Exam`, `Grade`, `Published`, `Comments`) VALUES ('$user','$eid','{$grade}','0', $comment)";
	$result = $conn->query($insert);
}

//professor can view question bank
elseif ($intent == "view_questions") {
	$select = "SELECT * FROM `Question_Bank`";
	$result = $conn->query($select);
	$tarr = array();
	$darr = array();
	$qarr = array();
	$qidarr = array();
	$fnarray = array();
	$pointarr = array();
	$tlarr = array();
	$inarr = array();
	$i = 1;
	while ($row = $result->fetch_assoc()) {
		$tarr = array_pad($tarr, $i, $row["Topic"]);
		$darr = array_pad($darr, $i, $row["Difficulty"]);
		$qarr = array_pad($qarr, $i, $row["Question"]);
		$qidarr = array_pad($qidarr, $i, $row["Question_ID"]);
		$fnarr = array_pad($fnarr, $i, $row["Function_Name"]);
		$pointarr = array_pad($pointarr, $i, $row["Points"]);
		$tlarr = array_pad($tlarr, $i, $row["Testcase_List"]);
		$inarr = array_pad($inarr, $i, $row["In_Exam"]);
		$i++;
	}
	$obj->tops = $tarr;
	$obj->diffs = $darr;
	$obj->qsts = $qarr;
	$obj->qids = $qidarr;
	$obj->fnames = $fnarr;
	$obj->points = $pointarr;
	$obj->tlist = $tlarr;
	$obj->inExam = $inarr;
	$json = json_encode($obj);
	echo $json;
}

//professor can edit exam by viewing exam and question bank
elseif ($intent == "view_exam") {
	$select = "SELECT * FROM `Question_Bank`";
	$result = $conn->query($select);
	$tarr = array();
	$darr = array();
	$qarr = array();
	$qidarr = array();
	$fnarray = array();
	$pointarr = array();
	$tlarr = array();
	$inarr = array();
	$i = 1;
	while ($row = $result->fetch_assoc()) {
		$tarr = array_pad($tarr, $i, $row["Topic"]);
		$darr = array_pad($darr, $i, $row["Difficulty"]);
		$qarr = array_pad($qarr, $i, $row["Question"]);
		$qidarr = array_pad($qidarr, $i, $row["Question_ID"]);
		$fnarr = array_pad($fnarr, $i, $row["Function_Name"]);
		$pointarr = array_pad($pointarr, $i, $row["Points"]);
		$tlarr = array_pad($tlarr, $i, $row["Testcase_List"]);
		$inarr = array_pad($inarr, $i, $row["In_Exam"]);
		$i++;
	}
	$obj->tops = $tarr;
	$obj->diffs = $darr;
	$obj->qsts = $qarr;
	$obj->qids = $qidarr;
	$obj->fnames = $fnarr;
	$obj->points = $pointarr;
	$obj->tlist = $tlarr;
	$obj->inExam = $inarr;
	
	$select = "SELECT * FROM `Exams`";
	$result = $conn->query($select);
	$eidarr = array();
	$qlistarr = array();
	$pubarr = array();
	$j = 1;
	while ($row = $result->fetch_assoc()) {
		$eidarr = array_pad($eidarr, $j, $row["Exam_ID"]);
		$qlistarr = array_pad($qlistarr, $j, $row["Question_IDs"]);
		$pubarr = array_pad($pubarr, $j, $row["Is_Published"]);
		$j++;
	}
	$obj->eids = $eidarr;
	$obj->qidlist = $qlistarr;
	$obj->published = $pubarr;
	
	$json = json_encode($obj);
	echo $json;
}

//professor can publish grade
elseif ($intent == "publish_grade") {
	$update = "UPDATE `Student_Transcripts` SET `Published`='1' WHERE UCID = '$user'";
	$result = $conn->query($update);
}

//professor can publish exam for student to take
elseif ($intent == "publish_exam") {
	$update = "UPDATE `Exams` SET `Is_Published`='1' WHERE Exam_ID = '1'";
	$result = $conn->query($update);
}

//professor can take exam down
elseif ($intent == "unpublish_exam") {
	$update = "UPDATE `Exams` SET `Is_Published`='0'";
	$result = $conn->query($update);
}

//student can view any published grades
elseif ($intent == "view_grades") {
	$select = "SELECT * FROM Student_Transcripts WHERE UCID = '$user' && Published = '1'";
	$result = $conn->query($select);
	while ($row = $filter->fetch_assoc()) {
		$ucid = $row["UCID"];
		$exam = $row["Exam"];
		$grd = $row["Grade"];
		$pub = $row["Published"];
	}
	$obj->ucid = $ucid;
	$obj->exam = $exam;
	$obj->grd = $grd;
	$obj->pub = $pub;
	$json = json_encode($obj);
	echo $json;
}

?>