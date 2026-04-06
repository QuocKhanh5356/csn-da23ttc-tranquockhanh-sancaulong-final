-- Tạo bảng utilities_inventory
CREATE TABLE IF NOT EXISTS utilities_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    price DECIMAL(10,2) NOT NULL DEFAULT 0
);

-- Tạo bảng utilities_orders
CREATE TABLE IF NOT EXISTS utilities_orders (
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
);

-- Xóa dữ liệu cũ nếu có
DELETE FROM utilities_inventory;

-- Chèn dữ liệu mẫu vào inventory
INSERT INTO utilities_inventory (item_name, category, quantity, price) VALUES
('Nước khoáng', 'drink', 100, 10000),
('Nước ngọt', 'drink', 50, 15000),
('Nước ép', 'drink', 30, 20000),
('Vợt cơ bản', 'racket', 20, 500000),
('Vợt trung cấp', 'racket', 15, 800000),
('Vợt cao cấp', 'racket', 10, 1200000),
('Dịch vụ quấn vợt', 'service', 999, 50000);
