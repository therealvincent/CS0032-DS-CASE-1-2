<?php
// C:\xampp\htdocs\csapp\test_api.php

// Correct path for your local csapp folder
$apiUrl = "http://localhost/csapp/api.php?type=segment_metadata";

echo "<h2>Testing Metadata Visualization API</h2>";
echo "Connecting to: <code>$apiUrl</code><br><br>";

$response = @file_get_contents($apiUrl);

if ($response === FALSE) {
    echo "❌ <b>Error:</b> Could not connect to the API. Make sure 'api.php' exists in 'csapp' folder.";
    exit;
}

$data = json_decode($response, true);

if (isset($data['clusters']) && count($data['clusters']) > 0) {
    echo "✅ <b>Success:</b> API returned " . count($data['clusters']) . " clusters.<br>";
    
    $sample = $data['clusters'][0];
    if (isset($sample['avg_income']) && isset($sample['customer_count'])) {
        echo "✅ <b>Success:</b> Metadata contains average income and counts.<br>";
        echo "<pre>Sample Metadata: " . print_r($sample, true) . "</pre>";
    } else {
        echo "⚠️ <b>Warning:</b> API returned clusters but missing visualization metadata keys.";
    }
} else {
    echo "❌ <b>Failed:</b> API returned empty data or invalid JSON.";
}
?>