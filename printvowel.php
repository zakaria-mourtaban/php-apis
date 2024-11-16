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