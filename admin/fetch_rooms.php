<?php
$db_name = 'mysql:host=localhost;dbname=bahia';
$user_name = 'root';
$user_password = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new PDO($db_name, $user_name, $user_password);
// Get the category from the client-side using AJAX
$category = $_GET['category'];

// Prepare and execute the SQL query to fetch rooms with the specified category
$select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE category = :category  AND status = 'Available'");
$select_rooms->bindParam(':category', $category);
$select_rooms->execute();

// Fetch the room data and return it as JSON response
$rooms = $select_rooms->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($rooms);

?>