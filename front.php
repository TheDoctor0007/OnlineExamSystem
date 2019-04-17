<?php

    	/*$intent = 'add_question';
	$funcName = 'Test';
	$qst = 'Test from mid';
	$qType = 'for';
	$diff = 'medium';
	$testCase1 = 'asd';
	$testOut = 'dsa';
*/
	$intent = 'view_questions';

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    //$data = array("intent" => $intent, "difficulty" => $difficulty, "topic" => $topic, "question" => $question, "fname" => "$fname", "test" => $test, "testout" => $testout);
    
	$data = array("intent" => $intent);
	$data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

	$result = curl_exec($ch);
	$read = json_decode($result);

	//echo $result;
	echo $read->tops[1];

    curl_close($ch);

?>