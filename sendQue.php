<?php

	//error_reporting(E_ERROR | E_WARNING | E_PARSE);


    $difficulty=$_POST["queDif"];
    $topic=$_POST["queTopic"];
    $question=$_POST["que"];
    $fname=$_POST["funcName"];
    $test=$_POST["test"];
    $testout=$_POST["testout"];


	//echo $test[0];

	/*
	$intent = "add_question";
	$difficulty = "medium";
	$topic = "for loop";
	$question = "from sendQue3";
	$fname = "power";
	$test = json_encode(array(1, 2));
	$testout = json_encode(array(3, 4));
	*/

    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "add_question", "queDif" => "$difficulty", "queTopic" => "$topic", "question" => "$question", "fName" => "$fname", "test" => "$test", "testcaseout" => "$testout");
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    //curl_exec($ch);
	$reply = curl_exec($ch);
	echo $reply;

    curl_close($ch);

?>