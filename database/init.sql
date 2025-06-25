
-- 2. Bảng Role
CREATE TABLE Role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL
);
-- 2. Thêm dữ liệu Role mẫu: admin và user
INSERT INTO Role (id, name) VALUES
(1, 'admin'),
(2, 'user');
-- 3. Bảng User
CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    address VARCHAR(200),
    password VARCHAR(100) NOT NULL,
    role_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted TINYINT DEFAULT 0,
    FOREIGN KEY (role_id) REFERENCES Role(id)
);
-- 4. Thêm tài khoản mẫu: admin và user
-- ⚠️ Mật khẩu được hash bằng password_hash trong PHP
INSERT INTO User (fullname, email, phone_number, address, password, role_id)
VALUES
('Admin 1', 'admin@gmail.com', '0123456789', '123 Admin St',
 '$2y$10$fkPEcG1dQXdpCBqMlcWBnO6Q3rozNyO50qQH6FZJD8CcEFSJMYdmm', 1), -- admin123
('User 1', 'user@gmail.com', '0987654321', '456 User Rd',
 '$2y$10$g5tcIMxhkUdOmnIaj8rcI.2jIfZ08SHb.TmXtXPjxY/x0UMOGm.Mq', 2); -- user123

-- 4. Bảng Tokens
CREATE TABLE Tokens (
    user_id INT,
    token VARCHAR(32),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, token),
    FOREIGN KEY (user_id) REFERENCES User(id)
);

-- 5. Bảng Category
CREATE TABLE Category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- 6. Bảng Product
CREATE TABLE Product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(250) NOT NULL,
    price INT NOT NULL,
    color VARCHAR(50) NOT NULL,
    thumbnail VARCHAR(500),
    description LONGTEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted TINYINT DEFAULT 0,
    FOREIGN KEY (category_id) REFERENCES Category(id)
);
-- 11. Bảng Size (danh sách các size giày)
CREATE TABLE Size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    size_value VARCHAR(10) NOT NULL
);

-- 12. Bảng Product_Size (liên kết sản phẩm và size, mỗi sản phẩm có thể có nhiều size)
CREATE TABLE Product_Size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    size_id INT,
    quantity INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES Product(id),
    FOREIGN KEY (size_id) REFERENCES Size(id)
);


-- 7. Bảng Galery
CREATE TABLE Galery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    thumbnail VARCHAR(500),
    FOREIGN KEY (product_id) REFERENCES Product(id)
);

-- 8. Bảng Feedback
CREATE TABLE FeedBack (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30),
    lastname VARCHAR(30),
    email VARCHAR(250),
    phone_number VARCHAR(20),
    subject_name VARCHAR(350),
    note VARCHAR(1000),
    status INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 9. Bảng Orders
CREATE TABLE Orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    fullname VARCHAR(50),
    email VARCHAR(150),
    phone_number VARCHAR(20),
    address VARCHAR(200),
    note VARCHAR(1000),
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status INT DEFAULT 0,
    total_money INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES User(id)
);

-- 10. Bảng Order_Details
CREATE TABLE Order_Details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    price INT NOT NULL,
    num INT NOT NULL,
    total_money INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(id),
    FOREIGN KEY (product_id) REFERENCES Product(id)
);