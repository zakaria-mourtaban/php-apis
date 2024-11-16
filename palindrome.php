<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: GET POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
	echo json_encode(["error" => "Invalid JSON data"]);
	exit();
}

if (isset($data["word"])) {
	$word = $data["word"];
} else {
	echo json_encode(["error" => "Missing JSON data"]);
	exit();
}

$wordlen = mb_strlen($word);//this is for multibyte strings so that it can read utf8 characters

$i = 0;
$l = $wordlen - 1;
while ($i < $wordlen / 2) {
	if ($word[$i] != $word[$l]) {
		echo json_encode(["palindrome" => false]);
		exit();
	}
	$i++;
	$l--;
}
echo json_encode(["palindrome" => true]);