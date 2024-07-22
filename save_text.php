<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "speechRecognition";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'] ?? '';

    if (!empty($text)) {
        $stmt = $conn->prepare("INSERT INTO speechRecognition (text) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $text);

            if ($stmt->execute()) {
                echo "Text saved successfully.";
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "No text provided.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
