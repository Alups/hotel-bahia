<?php
include '../includes/db.php'; // Include your database connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    foreach ($data as $room) {
        $roomId = $room["id"];
        $roomName = $room["name"];

        $sql = "UPDATE bookings SET assigned_room = '$roomName' WHERE id = $roomId";

        if ($conn->query($sql) === TRUE) {
            $response = array("status" => "success");
        } else {
            $response = array("status" => "error", "message" => $conn->error);
            break;
        }
    }

    echo json_encode($response);
}

$conn->close();

?>
