<?php

    $backurl = "https://web.njit.edu/~prm46/backend.php";
	//$backurl = "https://web.njit.edu/~qwc2/back.php";


    $input = file_get_contents('php://input');
    $json = json_decode($input, true);
    $user = $json['username'];
    $pass = $json['password'];
	//$user = 'qwc2';
	//$pass = 'password';
    $hashpass = md5($pass);
	



    $function = $json['ans'];
	$qst = $json['question'];
    $funcName = $json['fName'];
    $qType = $json['queTopic'];
	$diff = $json['queDif'];
    $test = $json['test'];
    $testOut = $json['testcaseout'];
	$grade = $json['autograde'];
	$qid = $json['questionID'];
	$points = $json['points'];
	

	$intent = $json['intent'];
	$uType = $json['is_prof'];
	$eid = "1";
	$scores = $json['scores'];
	$scoresArr = $json['scores'];

	$pointList = $json['pointList'];
	$comment = $json['comments'];
	$qidArr = $json['qidArr'];

/*
	//tests for add question
	$intent = 'add_question';
	$funcName = 'skrrt';
	$qst = 'This is from mid end';
	$qType = 'for';
	$diff = 'medium';
	$testCase1 = 'asd';
	$testOut = 'dsa';
*/

	//tests for view exam
	//$intent = 'view_exam';
	//$uType = 0;
/*
	$intent = 'store_grade';
	$user = 'qwc2';
	$eid = 1;
	$grade = 8;

*/

	

	//$intent = 'insert_question';
	
	//$qid = 5;

    $info = json_encode(array('username'=> $user, 'password'=> $hashpass, 'testout'=> $testOut, 'questionID'=> $qid, 'qIDList'=>$qid, 'scores'=>$scores, 'scoresArr'=>$scoresArr, 
	'ans'=> $function, 'fname'=> $funcName, 'topic'=> $qType, 'difficulty'=> $diff, 'question'=> $qst, 'points'=> $points, 'pointList'=>$pointList, 'qidArr'=>$qidArr, 
	'testInput'=> $test, 'testOutput'=> $testOut, 'intent'=> $intent, 'grade'=> $grade, 'is_prof'=> $uType, 'examID'=> $eid, 'comment'=> $comment));

	//echo $info;


    $ch = curl_init();

    curl_setopt ($ch, CURLOPT_URL, $backurl);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt ($ch, CURLOPT_REFERER, $backurl);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $info);

    $reply = curl_exec($ch);


    curl_close($ch);

	echo $reply;


	//DONT NEED ANYTHING HERE I JUST DONT WANNA DELETE INCASE I DO ACTUALLY NEED
/*
    $json = json_decode($reply);

    if($intent == "login"){
    		$jsonSend = array($json->check, $json->is_prof);
		echo json_encode($jsonSend);
	}
	elseif($intent == "take_exam"){
		$jsonSend = array($json->qs);
		echo json_encode($jsonSend);
	}
	elseif($intent == "view_questions"){
		$jsonSend = array($json->tops, $json->diffs, $json->qsts, $json->qids, $json->fnames);
		echo json_encode($jsonSend);
	}
	elseif($intent == "view_exam"){
		//$jsonSend = array($json->eids, $json->qidlist, $json->published, $json->ucid, $json->tops, $json->diffs, $json->qsts, $json->qids, $json->fnames);
		$jsonSend = $json;
		//$jsonSend = array($json->eids, $json->qidlist);
		echo json_encode($jsonSend);
	}
	elseif($intent == "view_grades"){
		$jsonSend = array($json->ucid, $json->exam, $json->grd, $json->pub);
		echo json_encode($jsonSend);
	}
*/
	
	//echo $json;
	//echo json_encode($jsonSend);

?>
