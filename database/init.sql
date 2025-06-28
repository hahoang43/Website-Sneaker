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
-- 5. Thêm dữ liệu Category mẫu
INSERT INTO Category (id, name) VALUES
(1, 'Giày Nam'),
(2, 'Giày Nữ'),
(3, 'Giày Trẻ Em'),
(4, 'Phụ kiện giày');

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
-- Thêm size mẫu
INSERT INTO Size (size_value) VALUES 
('36'), ('37'), ('38'), ('39'), ('40'), ('41'), ('42'), ('43');

-- Thêm 20 sản phẩm giày sneaker mẫu vào bảng Product
INSERT INTO Product (category_id, title, price, color, thumbnail, description)
VALUES
(1, 'Nike Air Force 1', 2500000, 'Trắng', 'Air Force 1.jpg', 'Nike Air Force 1 cổ điển, phù hợp mọi phong cách.'),
(1, 'Adidas Superstar', 2200000, 'Trắng/Đen', 'superstar.jpg', 'Adidas Superstar với thiết kế vỏ sò đặc trưng.'),
(1, 'Converse Chuck Taylor', 1800000, 'Đen', 'chucktaylor.jpg', 'Converse Chuck Taylor cổ cao, trẻ trung năng động.'),
(1, 'Vans Old Skool', 1700000, 'Đen/Trắng', 'oldskool.jpg', 'Vans Old Skool với sọc trắng đặc trưng.'),
(1, 'Puma Suede Classic', 1600000, 'Xanh Navy', 'pumasuede.jpg', 'Puma Suede Classic mềm mại, thời trang.'),
(1, 'Nike Air Max 97', 3500000, 'Bạc', 'airmax97.jpg', 'Nike Air Max 97 với đế khí êm ái.'),
(1, 'Adidas Stan Smith', 2100000, 'Trắng/Xanh', 'stansmith.jpg', 'Adidas Stan Smith đơn giản, thanh lịch.'),
(1, 'New Balance 574', 2000000, 'Xám', 'nb574.jpg', 'New Balance 574 êm ái, phù hợp đi bộ.'),
(1, 'Reebok Classic Leather', 1900000, 'Trắng', 'reebokclassic.jpg', 'Reebok Classic Leather bền bỉ, cá tính.'),
(1, 'Nike Dunk Low', 3200000, 'Đa sắc', 'dunklow.jpg', 'Nike Dunk Low phối màu trẻ trung.'),
(1, 'Adidas NMD R1', 3300000, 'Đen', 'nmdr1.jpg', 'Adidas NMD R1 công nghệ Boost hiện đại.'),
(1, 'Vans Slip-On', 1500000, 'Trắng', 'vansslipon.jpg', 'Vans Slip-On tiện lợi, dễ mang.'),
(1, 'Nike Blazer Mid', 2700000, 'Trắng/Đỏ', 'blazermid.jpg', 'Nike Blazer Mid cổ cao, cá tính.'),
(1, 'Fila Disruptor II', 1800000, 'Trắng', 'filadisruptor.jpg', 'Fila Disruptor II đế chunky nổi bật.'),
(1, 'Puma RS-X', 2500000, 'Xanh/Đỏ', 'pumarsx.jpg', 'Puma RS-X phối màu hiện đại.'),
(1, 'Adidas Yeezy Boost 350', 6000000, 'Xám', 'yeezy350.jpg', 'Adidas Yeezy Boost 350 thiết kế độc đáo.'),
(1, 'Nike Air Jordan 1', 5500000, 'Đỏ/Đen', 'airjordan1.jpg', 'Nike Air Jordan 1 huyền thoại bóng rổ.'),
(1, 'Converse One Star', 1700000, 'Đen/Trắng', 'onestar.jpg', 'Converse One Star trẻ trung, năng động.'),
(1, 'New Balance 997', 3200000, 'Xám/Xanh', 'nb997.jpg', 'New Balance 997 chất liệu cao cấp.'),
(1, 'Reebok Club C 85', 1600000, 'Trắng/Xanh', 'clubc85.jpg', 'Reebok Club C 85 phong cách retro.');

-- Thêm size cho từng sản phẩm (giả sử mỗi sản phẩm có đủ size 38, 39, 40, 41, 42, 43)
INSERT INTO Product_Size (product_id, size_id, quantity) VALUES
-- Nike Air Force 1 (id=1)
(1, 3, 10), (1, 4, 10), (1, 5, 10), (1, 6, 10), (1, 7, 10), (1, 8, 10),
-- Adidas Superstar (id=2)
(2, 3, 8), (2, 4, 8), (2, 5, 8), (2, 6, 8), (2, 7, 8), (2, 8, 8),
-- Converse Chuck Taylor (id=3)
(3, 3, 12), (3, 4, 12), (3, 5, 12), (3, 6, 12), (3, 7, 12), (3, 8, 12),
-- Vans Old Skool (id=4)
(4, 3, 7), (4, 4, 7), (4, 5, 7), (4, 6, 7), (4, 7, 7), (4, 8, 7),
-- Puma Suede Classic (id=5)
(5, 3, 9), (5, 4, 9), (5, 5, 9), (5, 6, 9), (5, 7, 9), (5, 8, 9),
-- Nike Air Max 97 (id=6)
(6, 3, 6), (6, 4, 6), (6, 5, 6), (6, 6, 6), (6, 7, 6), (6, 8, 6),
-- Adidas Stan Smith (id=7)
(7, 3, 11), (7, 4, 11), (7, 5, 11), (7, 6, 11), (7, 7, 11), (7, 8, 11),
-- New Balance 574 (id=8)
(8, 3, 10), (8, 4, 10), (8, 5, 10), (8, 6, 10), (8, 7, 10), (8, 8, 10),
-- Reebok Classic Leather (id=9)
(9, 3, 8), (9, 4, 8), (9, 5, 8), (9, 6, 8), (9, 7, 8), (9, 8, 8),
-- Nike Dunk Low (id=10)
(10, 3, 7), (10, 4, 7), (10, 5, 7), (10, 6, 7), (10, 7, 7), (10, 8, 7),
-- Adidas NMD R1 (id=11)
(11, 3, 9), (11, 4, 9), (11, 5, 9), (11, 6, 9), (11, 7, 9), (11, 8, 9),
-- Vans Slip-On (id=12)
(12, 3, 10), (12, 4, 10), (12, 5, 10), (12, 6, 10), (12, 7, 10), (12, 8, 10),
-- Nike Blazer Mid (id=13)
(13, 3, 8), (13, 4, 8), (13, 5, 8), (13, 6, 8), (13, 7, 8), (13, 8, 8),
-- Fila Disruptor II (id=14)
(14, 3, 7), (14, 4, 7), (14, 5, 7), (14, 6, 7), (14, 7, 7), (14, 8, 7),
-- Puma RS-X (id=15)
(15, 3, 9), (15, 4, 9), (15, 5, 9), (15, 6, 9), (15, 7, 9), (15, 8, 9),
-- Adidas Yeezy Boost 350 (id=16)
(16, 3, 5), (16, 4, 5), (16, 5, 5), (16, 6, 5), (16, 7, 5), (16, 8, 5),
-- Nike Air Jordan 1 (id=17)
(17, 3, 6), (17, 4, 6), (17, 5, 6), (17, 6, 6), (17, 7, 6), (17, 8, 6),
-- Converse One Star (id=18)
(18, 3, 8), (18, 4, 8), (18, 5, 8), (18, 6, 8), (18, 7, 8), (18, 8, 8),
-- New Balance 997 (id=19)
(19, 3, 10), (19, 4, 10), (19, 5, 10), (19, 6, 10), (19, 7, 10), (19, 8, 10),
-- Reebok Club C 85 (id=20)
(20, 3, 7), (20, 4, 7), (20, 5, 7), (20, 6, 7), (20, 7, 7), (20, 8, 7);
