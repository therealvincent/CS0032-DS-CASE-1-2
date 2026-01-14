<?php
// C:\xampp\htdocs\csapp\tests\ClusteringTest.php
use PHPUnit\Framework\TestCase;

class ClusteringTest extends TestCase {
    
    // Test if the Euclidean Distance math is correct
    public function testDistanceCalculation() {
        $point1 = [100, 100];
        $point2 = [130, 140];
        
        // Use the function from your app logic
        $result = euclideanDistance($point1, $point2); 
        
        $this->assertEquals(50, $result); // 30-40-50 triangle
    }

    // Test if the API returns the correct JSON structure
    public function testApiStructure() {
        $json = file_get_contents("http://localhost/csapp/api.php?type=segment_metadata");
        $data = json_decode($json, true);
        
        $this->assertArrayHasKey('clusters', $data);
    }
}