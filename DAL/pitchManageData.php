<?php
require_once 'connect_database.php';
require_once __DIR__ . '/../MODEL/badminton_pitches_model.php';

function getDataPitch(){
    $conn = getConnection();
    $sql = "SELECT * FROM badminton_pitches";
    $result = $conn->query($sql);
    
    if ($result === false) {
        die("Error in query: " . $conn->error);
    }
    
    $conn->close();
    return $result;
}

function AddPitchToData($name, $time_start, $time_end, $description, $price_per_hour, $price_per_peak_hour, $is_maintenance, $pitch_type_id, $created_at, $updated_at) {
    $conn = getConnection();
    try {
        // Prepare the SQL query with placeholders
        $query = "INSERT INTO badminton_pitches(name, time_start, time_end, description, price_per_hour, price_per_peak_hour, is_maintenance, pitch_type_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind parameters with types
        // 'sssiississ' corresponds to 10 parameters: 4 strings, 2 ints, 1 int, 1 int, 2 strings
        $stmt->bind_param('sssiississ', $name, $time_start, $time_end, $description, $price_per_hour, $price_per_peak_hour, $is_maintenance, $pitch_type_id, $created_at, $updated_at);

        // Execute the statement
        $result = $stmt->execute();

        // Close the statement
        $stmt->close();
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Handle any exceptions
        $errorMessage = "Lỗi: " . $e->getMessage();
        return false;
    }
    
    // Close the connection
    $conn->close();
}

function UpdatePitch($id, $name, $time_start, $time_end, $description, $price_per_hour, $price_per_peak_hour, $is_maintenance, $pitch_type_id, $updated_at){
    $conn = getConnection();
    $query = "UPDATE badminton_pitches SET name = ?, time_start = ?, time_end = ?, description = ?, price_per_hour = ?, price_per_peak_hour = ?, is_maintenance = ?, pitch_type_id = ?, updated_at = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssiissisi', $name, $time_start, $time_end, $description, $price_per_hour, $price_per_peak_hour, $is_maintenance, $pitch_type_id, $updated_at, $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

function DelId($id){
    $conn = getConnection();
    $query = "DELETE FROM badminton_pitches WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}
function Getpic($id) {
    $conn = getConnection();
    $query = "SELECT * FROM badminton_pitch_details WHERE badminton_pitch_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = []; 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['image']; 
        }
    }
    $stmt->close();
    $conn->close();
    return $images;
}
function getNamefromData(){
    $conn = getConnection();
    $query = 'SELECT * from badminton_pitches';
    $ans = [];
    $result = $conn->query($query);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ans['name'] = $row['name'];
        }
    }
    return $ans;
}

function getPitchNameFromDatabase($id){
    $conn = getConnection();
    $sql = "SELECT name FROM badminton_pitches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result === false || $result->num_rows == 0) {
        $stmt->close();
        $conn->close();
        return null; 
    }
    
    $data = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $data;
}


function getPitchIdByName($name){
    $conn = getConnection();
    $sql = "SELECT id from badminton_pitches WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeName = "%$name%";
    $stmt->bind_param('s', $likeName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result === false) {
        $stmt->close();
        $conn->close();
        die("Error in query: " . $conn->error);
    }
    
    $stmt->close();
    $conn->close();
    return $result;
}
function ThemAnhDaTa($hinhAnh, $id){
    $conn = getConnection();
    $sql = "INSERT INTO badminton_pitch_details (image, badminton_pitch_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $hinhAnh, $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    if ($result === false) {
        die("Error in query: " . $conn->error);
    }
    return true;
}