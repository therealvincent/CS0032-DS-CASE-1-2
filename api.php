<?php
// C:\xampp\htdocs\csapp\api.php
header('Content-Type: application/json');
require_once 'db.php'; // This provides $pdo

$type = $_GET['type'] ?? '';

if ($type === 'segments/cluster') {
    try {
        // Updated to use PDO syntax
        $query = "SELECT 
                    sr.cluster_id, 
                    COUNT(c.customer_id) as total_customers,
                    AVG(c.income) as avg_income,
                    AVG(c.total_spent_lifetime) as avg_spend
                  FROM segmentation_results sr
                  JOIN customers c ON sr.customer_id = c.customer_id
                  GROUP BY sr.cluster_id";

        $stmt = $pdo->query($query);
        $response = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $avg_income = (float)$row['avg_income'];
            $avg_spend = (float)$row['avg_spend'];

            // Logic to assign descriptive labels
            $label = "Standard Customer";
            if ($avg_spend > 30000) $label = "High-Spenders";
            elseif ($avg_income > 70000 && $avg_spend < 10000) $label = "Frugal High-Earners";
            elseif ($avg_spend < 5000) $label = "Budget-Conscious";

            $response[] = [
                "cluster_id" => (int)$row['cluster_id'],
                "label" => $label,
                "total_customer_count" => (int)$row['total_customers'],
                "metrics" => [
                    "avg_income" => round($avg_income, 2),
                    "avg_purchase_amount" => round($avg_spend, 2)
                ]
            ];
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid endpoint"]);
?>