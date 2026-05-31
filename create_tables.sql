-- Tạo bảng utilities_inventory
CREATE TABLE IF NOT EXISTS utilities_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    price DECIMAL(10,2) NOT NULL DEFAULT 0
    ,image_url VARCHAR(255) DEFAULT ''
);

-- Tạo bảng utilities_orders
CREATE TABLE IF NOT EXISTS utilities_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
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
INSERT INTO utilities_inventory (item_name, category, quantity, price, image_url) VALUES
('Nước khoáng', 'drink', 100, 10000, 'https://via.placeholder.com/400x250?text=Nước+khoáng'),
('Nước ngọt', 'drink', 50, 15000, 'https://via.placeholder.com/400x250?text=Nước+ngọt'),
('Nước ép', 'drink', 30, 20000, 'https://via.placeholder.com/400x250?text=Nước+ép'),
('Vợt cơ bản', 'racket', 20, 500000, 'https://via.placeholder.com/400x250?text=Vợt+cơ+bản'),
('Vợt trung cấp', 'racket', 15, 800000, 'https://via.placeholder.com/400x250?text=Vợt+trung+cấp'),
('Vợt cao cấp', 'racket', 10, 1200000, 'https://via.placeholder.com/400x250?text=Vợt+cao+cấp'),
('Dịch vụ quấn vợt', 'service', 999, 50000, 'https://via.placeholder.com/400x250?text=Quấn+vợt');
