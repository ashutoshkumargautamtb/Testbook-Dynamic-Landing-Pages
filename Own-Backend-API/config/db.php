<?php
// Database configuration
$host = 'localhost'; // Database host (usually 'localhost')
$dbname = 'all_india_iit_jee'; // Name of the database
$username = 'root'; // Username for the database
$password = ''; // Password for the database

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Set default fetch mode to associative array

    // Connection successful
} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}
?>
