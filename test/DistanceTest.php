<?php
// C:\xampp\htdocs\csapp\test\DistanceTest.php

/**
 * Mock of the euclideanDistance function from run_clustering.php
 * Formula: sqrt((x2-x1)^2 + (y2-y1)^2)
 */
function euclideanDistance($p1, $p2) {
    $sum = 0;
    for ($i = 0; $i < count($p1); $i++) {
        $sum += pow($p1[$i] - $p2[$i], 2);
    }
    return sqrt($sum);
}

echo "<h2>Testing euclideanDistance() Function</h2>";

$testCases = [
    [
        "name" => "Identical Points (Zero Distance)",
        "p1" => [0.5, 0.5],
        "p2" => [0.5, 0.5],
        "expected" => 0.0
    ],
    [
        "name" => "Standard 3-4-5 Triangle Distance",
        "p1" => [0, 0],
        "p2" => [3, 4],
        "expected" => 5.0
    ],
    [
        "name" => "Horizontal Distance Only",
        "p1" => [1.0, 5.0],
        "p2" => [4.0, 5.0],
        "expected" => 3.0
    ],
    [
        "name" => "Vertical Distance Only",
        "p1" => [2.0, 2.0],
        "p2" => [2.0, 10.0],
        "expected" => 8.0
    ],
    [
        "name" => "Normalized Range Test (Max distance in a 1x1 unit square)",
        "p1" => [0.0, 0.0],
        "p2" => [1.0, 1.0],
        "expected" => 1.4142 // sqrt(2)
    ]
];

foreach ($testCases as $test) {
    $result = euclideanDistance($test['p1'], $test['p2']);
    // Using round to handle floating point precision in comparisons
    $status = (round($result, 4) === round($test['expected'], 4)) ? "✅ PASS" : "❌ FAIL (Got: $result)";
    
    echo "<b>Test:</b> {$test['name']}<br>";
    echo "P1: [" . implode(",", $test['p1']) . "] | P2: [" . implode(",", $test['p2']) . "]<br>";
    echo "Result: $status<br><br>";
}
?>