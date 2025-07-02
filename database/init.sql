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
    brand VARCHAR(50), -- thêm dòng này
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
INSERT INTO Product (category_id, title, price, color, thumbnail, description, brand)
VALUES
<<<<<<< HEAD
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
(2, 'Nike Air Max 270 React', 2700000, 'Trắng/Hồng', 'airmax270react.jpg', 'Nike Air Max 270 React là sự kết hợp giữa công nghệ đệm Air Max nổi tiếng và lớp đệm React siêu êm ái, mang lại cảm giác thoải mái tối đa cho mỗi bước chân. Với phối màu trắng/hồng nữ tính, đôi giày này không chỉ phù hợp với những cô nàng yêu thích phong cách thể thao năng động mà còn rất dễ phối với các outfit thường ngày như quần jogger, jeans, hoặc đầm casual. Thiết kế hiện đại, trẻ trung cùng hiệu năng tuyệt vời khiến Air Max 270 React trở thành lựa chọn hoàn hảo cho việc đi chơi, đi học hoặc vận động nhẹ nhàng.'),
(2, 'Adidas Forum Low White', 2300000, 'Trắng/Kem', 'forumlowwhite.jpg', 'Adidas Forum Low ''White'' mang phong cách bóng rổ cổ điển, nhưng lại trở thành một xu hướng thời trang được yêu thích. Với thiết kế chunky vừa phải, đôi giày này mang lại vẻ ngoài năng động, retro và dễ dàng kết hợp với nhiều loại trang phục, từ váy đầm nhẹ nhàng đến quần jeans ống rộng.'),
(2, 'Converse Chuck 70 Low Parchment', 1700000, 'Trắng ngà', 'chuck70lowparchment.jpg', 'Converse Chuck 70 Low ''Parchment'' là phiên bản nâng cấp của Chuck Taylor cổ điển, với màu sắc trung tính dễ phối đồ và chất lượng vật liệu vượt trội. Đôi giày này mang đến vẻ ngoài vintage, thanh lịch nhưng vẫn rất năng động, phù hợp cho mọi hoạt động hàng ngày.'),
(2, 'New Balance 530', 2500000, 'Xám', 'nb530.jpg', 'New Balance 530 là đôi giày ''dad shoe'' đang rất thịnh hành, nổi bật với vẻ ngoài chunky và retro. Không chỉ mang lại phong cách ấn tượng, 530 còn cực kỳ thoải mái và êm ái nhờ công nghệ đệm ABZORB, phù hợp cho cả việc đi bộ hàng ngày và tạo điểm nhấn cho outfit.'),
(2, 'Nike Dunk Low Light Bone', 2800000, 'Trắng ngà/Nâu nhạt', 'dunklowlb.jpg', 'Nike Dunk Low ''Light Bone'' mang đến một phối màu trung tính, nhẹ nhàng và thanh lịch, dễ dàng phối hợp với nhiều trang phục khác nhau. Vẫn giữ nguyên form dáng cổ điển của Dunk Low, phiên bản này là lựa chọn tuyệt vời cho những cô gái yêu thích sự đơn giản nhưng vẫn muốn tạo điểm nhấn tinh tế.'),
(2, 'PUMA Mayze Lth White', 2000000, 'Trắng', 'mayzelthwhite.jpg', 'PUMA Mayze Lth ''White'' là một đôi sneaker có đế platform cao, giúp ''ăn gian'' chiều cao hiệu quả và mang lại vẻ ngoài cá tính, hiện đại. Chất liệu da cao cấp và thiết kế đơn giản nhưng độc đáo làm cho Mayze trở thành lựa chọn yêu thích của các cô gái năng động.'),
(2, 'Adidas Gazelle Bold Pink Glow', 2600000, 'Hồng phấn/Trắng', 'gazelleboldpinkglow.jpg', 'Adidas Gazelle Bold ''Pink Glow'' là sự kết hợp hoàn hảo giữa phong cách retro và xu hướng hiện đại. Với màu hồng phấn ngọt ngào và đế platform ấn tượng, đôi giày này sẽ là điểm nhấn nổi bật cho mọi set đồ, thể hiện sự nữ tính và cá tính.'),
(2, 'Nike Blazer Mid 77 Vintage White/Black', 2400000, 'Trắng/Đen', 'blazermid77wb.jpg', 'Nike Blazer Mid ''77 Vintage ''White/Black'' mang đến vẻ ngoài retro cổ điển của những năm 70. Thiết kế đơn giản, vượt thời gian cùng phối màu trắng đen kinh điển giúp đôi giày này dễ dàng phù hợp với nhiều phong cách, từ sporty đến casual chic.'),
(2, 'ASICS Gel-Kayano 14', 3500000, 'Bạc/Trắng', 'gelkayano14.jpg', 'ASICS Gel-Kayano 14 là một đôi giày chạy bộ hiệu năng cao nhưng lại rất được ưa chuộng trong giới thời trang. Với công nghệ GEL mang lại sự êm ái vượt trội và thiết kế ''chunky'' độc đáo, Gel-Kayano 14 là lựa chọn hoàn hảo cho những cô gái yêu thích phong cách techwear hoặc muốn một đôi giày vừa thoải mái vừa trendy.'),
(2, 'Veja V-10 White/Black', 3200000, 'Trắng/Đen', 'vejav10wb.jpg', 'Veja V-10 ''White/Black'' là lựa chọn lý tưởng cho những ai quan tâm đến thời trang bền vững và phong cách tối giản. Đôi giày này không chỉ được làm từ vật liệu thân thiện với môi trường mà còn mang thiết kế sạch sẽ, tinh tế, dễ dàng phối hợp với mọi trang phục, từ công sở đến đi chơi.'),
(2, 'Adidas Falcon', 2400000, 'Hồng/Xám', 'falcon.jpg', 'Adidas Falcon nổi bật với form chunky đậm chất thập niên 90, phối màu hồng và xám thời thượng. Đây là mẫu giày mang phong cách street style rõ nét, thích hợp để phối với quần jean, crop top hoặc các outfit phá cách.'),
(2, 'Puma Cali Dream', 2100000, 'Trắng/Xanh', 'calidream.jpg', 'Puma Cali Dream là lựa chọn lý tưởng cho những cô nàng hiện đại. Với thiết kế đế cao nhẹ, kiểu dáng đơn giản nhưng thời trang, đôi giày này mang lại sự thoải mái và tự tin khi đi học, đi chơi hoặc dạo phố.'),
(2, 'New Balance 237', 2000000, 'Be/Hồng', 'nb237.jpg', 'New Balance 237 mang phong cách retro hiện đại với chất liệu vải thoáng khí, màu sắc nhẹ nhàng. Thiết kế đơn giản, nhẹ và êm chân giúp bạn di chuyển linh hoạt suốt ngày dài, phù hợp cho sinh viên hoặc người làm việc văn phòng.'),
(2, 'Converse Chuck Taylor Lift', 1900000, 'Trắng', 'ctaylorlift.jpg', 'Converse Chuck Taylor Lift là phiên bản platform nâng cấp từ mẫu cổ điển. Đế cao giúp tăng chiều cao một cách tinh tế, vẫn giữ lại nét đặc trưng của Converse, phù hợp với nhiều phong cách khác nhau từ vintage đến casual.'),
(2, 'Vans Old Skool Pastel', 1700000, 'Xanh pastel', 'oldskoolpastel.jpg', 'Vans Old Skool Pastel giữ nguyên thiết kế cổ điển với đường sọc trắng đặc trưng, kết hợp phối màu pastel xanh dịu nhẹ. Mẫu giày này mang lại cảm giác trẻ trung, nữ tính và dễ phối với mọi kiểu trang phục hàng ngày.'),
(2, 'Reebok Club C Double', 1800000, 'Trắng/Xanh lá', 'clubcdouble.jpg', 'Reebok Club C Double là mẫu sneaker có đế dày với thiết kế thể thao tối giản. Với phối màu trắng/xanh lá hài hòa, đây là lựa chọn linh hoạt cho cả phong cách thể thao, năng động lẫn thời trang thường ngày.'),
(2, 'Fila Electrove 2', 2200000, 'Trắng/Hồng', 'electrove2.jpg', 'Fila Electrove 2 gây ấn tượng với thiết kế chunky đặc trưng, màu trắng phối hồng nổi bật, giúp tạo điểm nhấn cá tính cho outfit. Đây là mẫu giày cực kỳ phù hợp để xuống phố, chụp ảnh hoặc đi dạo cuối tuần.'),
(2, 'Nike Waffle One', 2300000, 'Xám/Hồng', 'waffleone.jpg', 'Nike Waffle One kết hợp vẻ ngoài hiện đại với lưới thoáng khí và phần đế waffle bám tốt. Thiết kế nhẹ, êm và linh hoạt giúp bạn thoải mái vận động nhẹ nhàng như đi bộ, tập gym hoặc đi chơi thường ngày.'),
(2, 'Adidas Stan Smith Bold', 2500000, 'Trắng/Vàng', 'stansmithbold.jpg', 'Adidas Stan Smith Bold là phiên bản nâng đế của dòng giày huyền thoại Stan Smith. Với thiết kế tối giản, phối màu trắng/vàng sang trọng, đôi giày phù hợp để diện đi học, đi làm hoặc phối với trang phục công sở thanh lịch.');


=======
(1, 'Nike Air Force 1', 2500000, 'Trắng', 'Air Force 1.jpg', 'Nike Air Force 1 cổ điển, phù hợp mọi phong cách.', 'Nike'),
(1, 'Adidas Superstar', 2200000, 'Trắng/Đen', 'superstar.jpg', 'Adidas Superstar với thiết kế vỏ sò đặc trưng.', 'Adidas'),
(1, 'Converse Chuck Taylor', 1800000, 'Đen', 'chucktaylor.jpg', 'Converse Chuck Taylor cổ cao, trẻ trung năng động.', 'Converse'),
(1, 'Vans Old Skool', 1700000, 'Đen/Trắng', 'oldskool.jpg', 'Vans Old Skool với sọc trắng đặc trưng.', 'Vans'),
(1, 'Puma Suede Classic', 1600000, 'Xanh Navy', 'pumasuede.jpg', 'Puma Suede Classic mềm mại, thời trang.', 'Puma'),
(1, 'Nike Air Max 97', 3500000, 'Bạc', 'airmax97.jpg', 'Nike Air Max 97 với đế khí êm ái.', 'Nike'),
(1, 'Adidas Stan Smith', 2100000, 'Trắng/Xanh', 'stansmith.jpg', 'Adidas Stan Smith đơn giản, thanh lịch.', 'Adidas'),
(1, 'New Balance 574', 2000000, 'Xám', 'nb574.jpg', 'New Balance 574 êm ái, phù hợp đi bộ.', 'New Balance'),
(1, 'Reebok Classic Leather', 1900000, 'Trắng', 'reebokclassic.jpg', 'Reebok Classic Leather bền bỉ, cá tính.', 'Reebok'),
(1, 'Nike Dunk Low', 3200000, 'Đa sắc', 'dunklow.jpg', 'Nike Dunk Low phối màu trẻ trung.', 'Nike'),
(1, 'Adidas NMD R1', 3300000, 'Đen', 'nmdr1.jpg', 'Adidas NMD R1 công nghệ Boost hiện đại.', 'Adidas'),
(1, 'Vans Slip-On', 1500000, 'Trắng', 'vansslipon.jpg', 'Vans Slip-On tiện lợi, dễ mang.', 'Vans'),
(1, 'Nike Blazer Mid', 2700000, 'Trắng/Đỏ', 'blazermid.jpg', 'Nike Blazer Mid cổ cao, cá tính.', 'Nike'),
(1, 'Fila Disruptor II', 1800000, 'Trắng', 'filadisruptor.jpg', 'Fila Disruptor II đế chunky nổi bật.', 'Fila'),
(1, 'Puma RS-X', 2500000, 'Xanh/Đỏ', 'pumarsx.jpg', 'Puma RS-X phối màu hiện đại.', 'Puma'),
(1, 'Adidas Yeezy Boost 350', 6000000, 'Xám', 'yeezy350.jpg', 'Adidas Yeezy Boost 350 thiết kế độc đáo.', 'Adidas'),
(1, 'Nike Air Jordan 1', 5500000, 'Đỏ/Đen', 'airjordan1.jpg', 'Nike Air Jordan 1 huyền thoại bóng rổ.', 'Nike'),
(1, 'Converse One Star', 1700000, 'Đen/Trắng', 'onestar.jpg', 'Converse One Star trẻ trung, năng động.', 'Converse'),
(1, 'New Balance 997', 3200000, 'Xám/Xanh', 'nb997.jpg', 'New Balance 997 chất liệu cao cấp.', 'New Balance'),
(1, 'Reebok Club C 85', 1600000, 'Trắng/Xanh', 'clubc85.jpg', 'Reebok Club C 85 phong cách retro.', 'Reebok');
>>>>>>> 561fc3c511bdda1ea84e18641f40824a8cfdcb09

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