<?php
    require_once 'connect_database.php';

    function getDiscountData() {
        $conn = getConnection();
        $result = $conn->query("SELECT * FROM discounts");
        $arr = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
        return $arr;
    }