<?php
header('Content-Type: application/json');
require_once 'db.php';

// Security: Simple Token Check
$api_key = "my_secret_key_123";
$headers = getallheaders();

if (!isset($headers['Authorization']) || $headers['Authorization'] !== "Bearer " . $api_key) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized: Invalid API Key"]);
    exit;
}

// Endpoint Logic
$type = $_GET['type'] ?? 'summary';

switch ($type) {
    case 'summary':
        echo json_encode(["available_types" => ["gender", "region", "clv_tiers", "cluster"]]);
        break;

    case 'clv_tiers':
        $sql = "SELECT 
                    CASE 
                        WHEN (total_spent_lifetime * (DATEDIFF(last_purchase_date, registration_date) / 30 + 1)) >= 50000 THEN 'Platinum'
                        WHEN (total_spent_lifetime * (DATEDIFF(last_purchase_date, registration_date) / 30 + 1)) >= 20000 THEN 'Gold'
                        WHEN (total_spent_lifetime * (DATEDIFF(last_purchase_date, registration_date) / 30 + 1)) >= 5000 THEN 'Silver'
                        ELSE 'Bronze'
                    END AS tier,
                    COUNT(*) AS count 
                FROM customers GROUP BY tier";
        $stmt = $pdo->query($sql);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Segment type not found"]);
}
?>