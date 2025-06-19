-- 1. Tạo cơ sở dữ liệu web-
CREATE DATABASE IF NOT EXISTS sneakers  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sneakers;

-- 2. Bảng người dùng
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Bảng sản phẩm
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Bảng giỏ hàng
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 5. Bảng đơn hàng
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2),
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 6. Chi tiết đơn hàng
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 7. Giao hàng
CREATE TABLE shipping (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    address TEXT NOT NULL,
    phone VARCHAR(20),
    shipping_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- 8. Thêm tài khoản mẫu
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@gmail.com', '$2y$10$S3FtoPJGk3UkB2yQCLSnEerZTwYeFzW2wqZ2x5Kkzw/JGCVPG5En2', 'admin'); -- admin123

-- 9. Thêm sản phẩm mẫu
INSERT INTO products (name, description, price, category, image, stock) 
VALUES
('Nike Air Force 1', 'Giày sneaker cổ thấp kinh điển, chất liệu da cao cấp', 2300000, 'Sneaker', 'images/nike-air-force-1.jpg', 20),
('Adidas Ultraboost 22', 'Giày chạy bộ êm ái, công nghệ đệm Boost', 2900000, 'Running', 'images/adidas-ultraboost-22.jpg', 15),
('Converse Chuck Taylor', 'Giày vải cổ cao thời trang, phong cách cổ điển', 1500000, 'Casual', 'images/converse-chuck-taylor.jpg', 25);
