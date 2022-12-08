<?php

$file = file_get_contents(__DIR__ . "/input.txt");
$results = [];
$result = 0;
foreach (explode("\n", $file) as $line) {
    if ($line == "") {
        echo $line . PHP_EOL;
        echo "BLANK LINE";
        $results[] = $result;
        $result = 0;
    } else {
        $result = $result + $line;
        echo $result . PHP_EOL;
    }
}
sort($results);
var_dump($results);
$length = count($results);
$total = 0;
for ($i = 1; $i <= 3; $i++) {
    echo $results[$length - $i] . PHP_EOL;
    $total += $results[$length  - $i];
}
var_dump($total);