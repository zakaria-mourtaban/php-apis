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

$array = $data["array"];

class Node
{
	public $data;
	public $next;
	public function __construct($data)
	{
		$this->data = $data;
		$this->next = null;
	}
}

class LinkedList
{
	public $head;
	public function __construct()
	{
		$this->head = null;
	}
	public function append($data)
	{
		$newNode = new Node($data);
		if ($this->head === null) {
			$this->head = $newNode;
			return;
		}
		$last = $this->head;
		while ($last->next !== null) {
			$last = $last->next;
		}
		$last->next = $newNode;
	}

	public function printvowel()
	{
		$tmp = $this->head;
		while ($tmp != null) {
			$sum = 0;
			$vowarr = array_fill(0, 5, 0);
			$len = strlen($tmp->data);
			for ($i = 0; $i < $len; $i++) {
				if ($tmp->data[$i] == "a" || $tmp->data[$i] == "A") {
					$vowarr[0] += 1;
				} else if ($tmp->data[$i] == "e" || $tmp->data[$i] == "E") {
					$vowarr[1] += 1;
				} else if ($tmp->data[$i] == "i" || $tmp->data[$i] == "I") {
					$vowarr[2] += 1;
				} else if ($tmp->data[$i] == "o" || $tmp->data[$i] == "O") {
					$vowarr[3] += 1;
				} else if ($tmp->data[$i] == "u" || $tmp->data[$i] == "U") {
					$vowarr[4] += 1;
				}
			}
			for ($i = 0; $i < 5; $i++) {
				$sum += $vowarr[$i];
			}
			if ($sum == 2) {
				echo json_encode($tmp->data);
			}
			$tmp = $tmp->next;
		}
	}
}

$linkedList = new LinkedList();

foreach ($array as $item) {
	$linkedList->append($item);
}

$linkedList->printvowel();
