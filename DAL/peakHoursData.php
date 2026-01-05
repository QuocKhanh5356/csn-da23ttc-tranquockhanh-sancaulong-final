<?php
    require_once 'connect_database.php';
    
    function getPeakHours() {
        $conn = getConnection();
        $result = $conn->query("SELECT start_at, end_at FROM peak_hours");
        $arr = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
        $conn->close();
        return $arr;
    }