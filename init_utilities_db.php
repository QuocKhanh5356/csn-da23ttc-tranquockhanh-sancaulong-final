<?php
require_once __DIR__ . '/DAL/connect_database.php';

$conn = getConnection();

// Tạo bảng utilities_inventory
$sql1 = "CREATE TABLE IF NOT EXISTS utilities_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    price DECIMAL(10,2) NOT NULL DEFAULT 0
)";

if ($conn->query($sql1) === TRUE) {
    echo "✓ Bảng utilities_inventory đã được tạo/tồn tại<br>";
} else {
    echo "✗ Lỗi tạo bảng utilities_inventory: " . $conn->error . "<br>";
}

// Tạo bảng utilities_orders
$sql2 = "CREATE TABLE IF NOT EXISTS utilities_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    drink_type VARCHAR(255),
    drink_quantity INT DEFAULT 0,
    racket_type VARCHAR(255),
    racket_quantity INT DEFAULT 0,
    stringing_service BOOLEAN DEFAULT FALSE,
    stringing_details TEXT,
    total DECIMAL(10,2) DEFAULT 0,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql2) === TRUE) {
    echo "✓ Bảng utilities_orders đã được tạo/tồn tại<br>";
} else {
    echo "✗ Lỗi tạo bảng utilities_orders: " . $conn->error . "<br>";
}

// Xóa dữ liệu cũ
$conn->query("DELETE FROM utilities_inventory");

// Chèn dữ liệu mẫu
$insert_sql = "INSERT INTO utilities_inventory (item_name, category, quantity, price) VALUES
('Nước khoáng', 'drink', 100, 10000),
('Nước ngọt', 'drink', 50, 15000),
('Nước ép', 'drink', 30, 20000),
('Vợt cơ bản', 'racket', 20, 500000),
('Vợt trung cấp', 'racket', 15, 800000),
('Vợt cao cấp', 'racket', 10, 1200000),
('Dịch vụ quấn vợt', 'service', 999, 50000)";

if ($conn->query($insert_sql) === TRUE) {
    echo "✓ Dữ liệu mẫu đã được chèn vào kho<br>";
} else {
    echo "✗ Lỗi chèn dữ liệu: " . $conn->error . "<br>";
}

$conn->close();
echo "<br><a href='check_tables.php'>Kiểm tra lại</a>";
?>
