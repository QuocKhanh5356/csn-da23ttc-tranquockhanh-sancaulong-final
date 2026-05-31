<?php
require_once __DIR__ . '/../DAL/connect_database.php';

$conn = getConnection();

$sql = "ALTER TABLE users ADD COLUMN background VARCHAR(255) DEFAULT NULL";

if ($conn->query($sql) === TRUE) {
    echo "Column background added successfully";
} else {
    echo "Error adding column: " . $conn->error;
}

$conn->close();
?>