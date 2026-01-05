<?php
    require_once 'connect_database.php';

    function getBankData() {
        $conn = getConnection();
        $result = $conn->query("SELECT * FROM bank_information");
        $arr = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
        $conn->close();
        return $arr;
    }