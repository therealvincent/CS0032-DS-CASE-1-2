<?php
// C:\xampp\htdocs\csapp\test\NormalizationTest.php

/**
 * Corrected normalizeData function
 * Formula: (value - min) / (max - min)
 */
function normalizeData($value, $min, $max) {
    // Fix for Fail 1: Prevent division by zero if all data points are the same
    if ($max == $min) {
        return 0.0;
    }
    
    // Core Min-Max scaling formula
    $normalized = ($value - $min) / ($max - $min);
    
    // Safety check to keep result within 0 and 1 range
    return (float)max(0, min(1, $normalized));
}

echo "<h2>Testing normalizeData() Function</h2>";
echo "<p>Validating mathematical integrity for K-Means preprocessing.</p>";

$testCases = [
    [
        "name" => "Standard Mid-range Value",
        "input" => ["val" => 50, "min" => 0, "max" => 100],
        "expected" => 0.5
    ],
    [
        "name" => "Minimum Boundary Value",
        "input" => ["val" => 1000, "min" => 1000, "max" => 5000],
        "expected" => 0.0
    ],
    [
        "name" => "Maximum Boundary Value",
        "input" => ["val" => 5000, "min" => 1000, "max" => 5000],
        "expected" => 1.0
    ],
    [
        "name" => "Division by Zero Protection (Min equals Max)",
        "input" => ["val" => 100, "min" => 100, "max" => 100],
        "expected" => 0.0
    ],
    [
        "name" => "Negative Range Handling",
        "input" => ["val" => 0, "min" => -100, "max" => 100],
        "expected" => 0.5
    ]
];



foreach ($testCases as $test) {
    $result = normalizeData($test['input']['val'], $test['input']['min'], $test['input']['max']);
    
    // Fix for Fail 2: Use round() to prevent floating-point precision errors
    $isPass = (round($result, 4) === round($test['expected'], 4));
    
    $status = $isPass ? "<span style='color:green;'>✅ PASS</span>" : "<span style='color:red;'>❌ FAIL</span>";
    $details = !$isPass ? " (Expected: {$test['expected']}, Got: $result)" : "";
    
    echo "<b>Test:</b> {$test['name']}<br>";
    echo "Input: Value: {$test['input']['val']}, Min: {$test['input']['min']}, Max: {$test['input']['max']}<br>";
    echo "Result: $status $details<br><br>";
}
?>