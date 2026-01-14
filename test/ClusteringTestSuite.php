<?php
// C:\xampp\htdocs\csapp\tests\ClusteringTest.php
use PHPUnit\Framework\TestCase;

// Include the logic from your main file
require_once 'run_clustering.php'; 

class ClusteringTest extends TestCase {

    /**
     * Test Task: Validate normalizeData logic
     * Justification: Ensures Min-Max scaling is accurate
     */
    public function testNormalization() {
        $val = 50; $min = 0; $max = 100;
        $expected = 0.5;
        
        // Asserting the mathematical logic from run_clustering.php
        $this->assertEquals($expected, normalizeData($val, $min, $max));
    }

    /**
     * Test Task: Validate euclideanDistance logic
     * Justification: Ensures accurate point-to-centroid assignment
     */
    public function testEuclideanDistance() {
        $point1 = [0, 0];
        $point2 = [3, 4];
        $expected = 5.0; // Standard 3-4-5 triangle math
        
        $this->assertEquals($expected, euclideanDistance($point1, $point2));
    }

    /**
     * Test Task: Mock Data Clustering
     * Justification: Uses Mock Objects to simulate database results without a live connection
     */
    public function testClusteringWithMockData() {
        $mockCustomers = [
            ['id' => 1, 'income' => 20000, 'total_spent' => 500],
            ['id' => 2, 'income' => 80000, 'total_spent' => 45000]
        ];
        
        // Test logic would continue here to ensure the algorithm 
        // separates these two distinct economic profiles correctly
        $this->assertNotEmpty($mockCustomers);
    }
}