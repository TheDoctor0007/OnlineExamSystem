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
	$qst = $json['que'];
    $funcName = $json['funcName'];
    $qType = $json['queTopic'];
	$diff = $json['queDif'];
    $testCase1 = $json['testcase'];
    $testOut = $json['testcaseSol'];
	$grade = $json['autograde'];
	

	$intent = $json['intent'];
	$uType = $json['is_prof'];

	/*tests for add question
	$intent = 'add_question';
	$funcName = 'Test';
	$qst = 'Test from mid';
	$qType = 'for';
	$diff = 'medium';
	$testCase1 = 'asd';
	$testOut = 'dsa';
/*

	//tests for view exam
	$intent = 'view_grades';
	$user = "qwc2";
	//$uType = 0;


	



    $info = json_encode(array('username'=> $user, 'password'=> $hashpass, 'testout'=> $testOut,
	'ans'=> $function, 'fname'=> $funcName, 'topic'=> $qType, 'difficulty'=> $diff, 'question'=> $qst, 
	'test'=> $testCase1, 'intent'=> $intent, 'grade'=> $grade, 'is_prof'=> $uType));



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


    $json = json_decode($reply);
/*
    if($intent == "login"){
    		$jsonSend = array($json->check, $json->is_prof);
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
	echo $reply;	
	//echo $json;
	//echo json_encode($jsonSend);

?>
