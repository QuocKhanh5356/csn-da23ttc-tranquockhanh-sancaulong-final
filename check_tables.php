<?php
$conn = new mysqli('localhost', 'root', '', 'quan_ly_san_cau_long');
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}

// Kiểm tra bảng utilities_inventory
$sql_check_inv = "SHOW TABLES LIKE 'utilities_inventory'";
$result_inv = $conn->query($sql_check_inv);

// Kiểm tra bảng utilities_orders
$sql_check_orders = "SHOW TABLES LIKE 'utilities_orders'";
$result_orders = $conn->query($sql_check_orders);

if ($result_inv->num_rows > 0) {
    echo "✓ Bảng utilities_inventory đã tồn tại<br>";
} else {
    echo "✗ Bảng utilities_inventory chưa được tạo<br>";
}

if ($result_orders->num_rows > 0) {
    echo "✓ Bảng utilities_orders đã tồn tại<br>";
} else {
    echo "✗ Bảng utilities_orders chưa được tạo<br>";
}

$conn->close();
?>
