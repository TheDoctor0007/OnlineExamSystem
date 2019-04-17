<?php


	//echo "test";

    $ucid=$_POST["user"];
	$comment=$_POST["comments"];
	$score=$_POST["score"];
	$qid=$_POST["qid"];
	$grade=$_POST["grade"];

//FOR TESTING

/*
  $ucid="prm46";
	$comment="1. -8 for not compiling or passing any cases \n-1 for not meeting constraint \nChanged comments \n(2/15) \n2. (30/50) \nTotal: (32/65) \n";
	$score="2,30";
	$qid="77,125";
	$grade="53.8";
*/




    $ch = curl_init('https://web.njit.edu/~qwc2/middle.php');

    $data = array("intent" => "modify", "username"=> $ucid[0], "scores"=> $score, "comments"=> $comment, "questionID"=>$qid, "autograde"=>$grade);
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    $result = curl_exec($ch);

    curl_close($ch);


    echo $result;

?>