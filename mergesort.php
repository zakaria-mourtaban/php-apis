<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data["array"])) {
    echo json_encode(["error" => "Invalid JSON data or missing 'array' key"]);
    exit();
}

$array = json_decode($data["array"]);

function mergeSort(array &$arr)
{
    $len = count($arr);
    if ($len <= 1) {
        return $arr;
    }

    $mid = intdiv($len, 2);
    $leftarr = array_slice($arr, 0, $mid);
    $rightarr = array_slice($arr, $mid);

    mergeSort($leftarr);
    mergeSort($rightarr);
    merge($leftarr, $rightarr, $arr);
}

function merge(array $leftarr, array $rightarr, array &$arr)
{
    $llen = count($leftarr);
    $rlen = count($rightarr);
    $i = $l = $r = 0;

    while ($l < $llen && $r < $rlen) {
        if ($leftarr[$l] <= $rightarr[$r]) {
            $arr[$i++] = $leftarr[$l++];
        } else {
            $arr[$i++] = $rightarr[$r++];
        }
    }

    while ($l < $llen) {
        $arr[$i++] = $leftarr[$l++];
    }

    while ($r < $rlen) {
        $arr[$i++] = $rightarr[$r++];
    }
}

mergeSort($array);

echo json_encode(["sorted_array" => $array]);
