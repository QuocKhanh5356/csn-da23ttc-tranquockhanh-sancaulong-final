<?php
function getConnection() {
    $servername = "localhost"; // Thay bằng thông tin của bạn
    $username = "root"; // Thay bằng thông tin của bạn
    $password = ""; // Thay bằng thông tin của bạn
    $dbname = "quan_ly_san_cau_long"; // Thay bằng tên database của bạn

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    return $conn;
}