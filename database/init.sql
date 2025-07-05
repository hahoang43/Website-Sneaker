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
(4, 'Phụ Kiện Giày');

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


INSERT INTO Product (category_id, title, price, color, thumbnail, description, brand)
VALUES
(1, 'Nike Air Force 1', 2500000, 'Trắng', 'Air Force 1.jpg', 'Chất liệu da tổng hợp, cổ thấp, đế cao su chống trượt, lỗ thoáng khí mũi giày, lót giày êm ái.', 'Nike'),
(1, 'Adidas Superstar', 2200000, 'Trắng/Đen', 'superstar.jpg', 'Da trơn cao cấp, mũi vỏ sò đặc trưng, đế cao su nguyên khối, cổ thấp, đệm EVA nhẹ.', 'Adidas'),
(1, 'Converse Chuck Taylor', 1800000, 'Đen', 'chucktaylor.jpg', 'Canvas cao cấp, cổ cao, đế cao su chống trượt, mũi bọc cao su, lót mềm.', 'Converse'),
(1, 'Vans Old Skool', 1700000, 'Đen/Trắng', 'oldskool.jpg', 'Canvas và da lộn, đế waffle bám đường, cổ thấp, đường sọc trắng đặc trưng, lót đệm nhẹ.', 'Vans'),
(1, 'Puma Suede Classic', 1600000, 'Xanh Navy', 'pumasuede.jpg', 'Da lộn mềm mại, cổ thấp, đế cao su bền bỉ, lỗ xỏ kim loại, logo Puma nổi.', 'Puma'),
(1, 'Nike Air Max 97', 3500000, 'Bạc', 'airmax97.jpg', 'Thân vải lưới & da, đệm khí toàn bàn chân, cổ thấp, đế cao su rãnh sâu, dây giày ẩn.', 'Nike'),
(1, 'Adidas Stan Smith', 2100000, 'Trắng/Xanh', 'stansmith.jpg', 'Da tổng hợp, lỗ ba sọc thoáng khí, cổ thấp, đế cao su, form cổ điển.', 'Adidas'),
(1, 'New Balance 574', 2000000, 'Xám', 'nb574.jpg', 'Da lộn & lưới, đệm ENCAP, cổ thấp, đế cao su, form retro.', 'New Balance'),
(1, 'Reebok Classic Leather', 1900000, 'Trắng', 'reebokclassic.jpg', 'Da mềm, cổ thấp, đế cao su chống trượt, đệm EVA, lót thoải mái.', 'Reebok'),
(1, 'Nike Dunk Low', 3200000, 'Đa sắc', 'dunklow.jpg', 'Da thật, cổ thấp, đế cao su phẳng, lưỡi gà có đệm, kiểu dáng cổ điển.', 'Nike'),
(1, 'Adidas NMD R1', 3300000, 'Đen', 'nmdr1.jpg', 'Primeknit co giãn, đế Boost, cổ tất ôm chân, đệm EVA hông, đế cao su dẻo.', 'Adidas'),
(1, 'Vans Slip-On', 1500000, 'Trắng', 'vansslipon.jpg', 'Canvas bền, không dây, đế waffle, cổ thấp, lót giày êm nhẹ.', 'Vans'),
(1, 'Nike Blazer Mid', 2700000, 'Trắng/Đỏ', 'blazermid.jpg', 'Da tổng hợp, cổ mid cao, đế cao su, dây giày truyền thống, logo Swoosh lớn.', 'Nike'),
(1, 'Fila Disruptor II', 1800000, 'Trắng', 'filadisruptor.jpg', 'Da tổng hợp, đế chunky răng cưa, cổ thấp, lưỡi gà dày, logo Fila nổi.', 'Fila'),
(1, 'Puma RS-X', 2500000, 'Xanh/Đỏ', 'pumarsx.jpg', 'Da lộn + lưới, đệm RS êm, đế cao su dày, cổ thấp, thiết kế trẻ trung.', 'Puma'),
(1, 'Adidas Yeezy Boost 350', 6000000, 'Xám', 'yeezy350.jpg', 'Thân Primeknit co giãn, đế Boost đàn hồi, cổ tất ôm sát, dây tròn, đế vân nổi.', 'Adidas'),
(1, 'Nike Air Jordan 1', 5500000, 'Đỏ/Đen', 'airjordan1.jpg', 'Da thật cao cấp, cổ cao, đệm Air gót chân, đế cao su, logo Jordan đặc trưng.', 'Nike'),
(1, 'Converse One Star', 1700000, 'Đen/Trắng', 'onestar.jpg', 'Da lộn, cổ thấp, đế cao su cổ điển, logo ngôi sao bên hông, đệm nhẹ.', 'Converse'),
(1, 'New Balance 997', 3200000, 'Xám/Xanh', 'nb997.jpg', 'Da lộn & mesh, đế ENCAP, cổ thấp, đế ngoài cao su, lót mềm mại.', 'New Balance'),
(1, 'Reebok Club C 85', 1600000, 'Trắng/Xanh', 'clubc85.jpg', 'Da mềm, cổ thấp, đế cao su, lỗ thoáng khí mũi giày, phong cách retro.', 'Reebok'),
(2, 'Nike Air Max 270 React', 2700000, 'Trắng/Hồng', 'airmax270react.jpg', 'Nike Air Max 270 React là sự kết hợp giữa công nghệ đệm Air Max nổi tiếng và lớp đệm React siêu êm ái, mang lại cảm giác thoải mái tối đa cho mỗi bước chân. Với phối màu trắng/hồng nữ tính, đôi giày này không chỉ phù hợp với những cô nàng yêu thích phong cách thể thao năng động mà còn rất dễ phối với các outfit thường ngày như quần jogger, jeans, hoặc đầm casual. Thiết kế hiện đại, trẻ trung cùng hiệu năng tuyệt vời khiến Air Max 270 React trở thành lựa chọn hoàn hảo cho việc đi chơi, đi học hoặc vận động nhẹ nhàng.', 'Nike'),
(2, 'Adidas Forum Low White', 2300000, 'Trắng/Kem', 'forumlowwhite.jpg', 'Adidas Forum Low ''White'' mang phong cách bóng rổ cổ điển, nhưng lại trở thành một xu hướng thời trang được yêu thích. Với thiết kế chunky vừa phải, đôi giày này mang lại vẻ ngoài năng động, retro và dễ dàng kết hợp với nhiều loại trang phục, từ váy đầm nhẹ nhàng đến quần jeans ống rộng.', 'Adidas'),
(2, 'Converse Chuck 70 Low Parchment', 1700000, 'Trắng ngà', 'chuck70lowparchment.jpg', 'Converse Chuck 70 Low ''Parchment'' là phiên bản nâng cấp của Chuck Taylor cổ điển, với màu sắc trung tính dễ phối đồ và chất lượng vật liệu vượt trội. Đôi giày này mang đến vẻ ngoài vintage, thanh lịch nhưng vẫn rất năng động, phù hợp cho mọi hoạt động hàng ngày.', 'Converse'),
(2, 'New Balance 530', 2500000, 'Xám', 'nb530.jpg', 'New Balance 530 là đôi giày ''dad shoe'' đang rất thịnh hành, nổi bật với vẻ ngoài chunky và retro. Không chỉ mang lại phong cách ấn tượng, 530 còn cực kỳ thoải mái và êm ái nhờ công nghệ đệm ABZORB, phù hợp cho cả việc đi bộ hàng ngày và tạo điểm nhấn cho outfit.', 'New Balance'),
(2, 'Nike Dunk Low Light Bone', 2800000, 'Trắng ngà/Nâu nhạt', 'dunklowlb.jpg', 'Nike Dunk Low ''Light Bone'' mang đến một phối màu trung tính, nhẹ nhàng và thanh lịch, dễ dàng phối hợp với nhiều trang phục khác nhau. Vẫn giữ nguyên form dáng cổ điển của Dunk Low, phiên bản này là lựa chọn tuyệt vời cho những cô gái yêu thích sự đơn giản nhưng vẫn muốn tạo điểm nhấn tinh tế.', 'Nike'),
(2, 'PUMA Mayze Lth White', 2000000, 'Trắng', 'mayzelthwhite.jpg', 'PUMA Mayze Lth ''White'' là một đôi sneaker có đế platform cao, giúp ''ăn gian'' chiều cao hiệu quả và mang lại vẻ ngoài cá tính, hiện đại. Chất liệu da cao cấp và thiết kế đơn giản nhưng độc đáo làm cho Mayze trở thành lựa chọn yêu thích của các cô gái năng động.', 'Puma'),
(2, 'Adidas Gazelle Bold Pink Glow', 2600000, 'Hồng phấn/Trắng', 'gazelleboldpinkglow.jpg', 'Adidas Gazelle Bold ''Pink Glow'' là sự kết hợp hoàn hảo giữa phong cách retro và xu hướng hiện đại. Với màu hồng phấn ngọt ngào và đế platform ấn tượng, đôi giày này sẽ là điểm nhấn nổi bật cho mọi set đồ, thể hiện sự nữ tính và cá tính.', 'Adidas'),
(2, 'Nike Blazer Mid 77 Vintage White/Black', 2400000, 'Trắng/Đen', 'blazermid77wb.jpg', 'Nike Blazer Mid ''77 Vintage ''White/Black'' mang đến vẻ ngoài retro cổ điển của những năm 70. Thiết kế đơn giản, vượt thời gian cùng phối màu trắng đen kinh điển giúp đôi giày này dễ dàng phù hợp với nhiều phong cách, từ sporty đến casual chic.', 'Nike'),
(2, 'ASICS Gel-Kayano 14', 3500000, 'Bạc/Trắng', 'gelkayano14.jpg', 'ASICS Gel-Kayano 14 là một đôi giày chạy bộ hiệu năng cao nhưng lại rất được ưa chuộng trong giới thời trang. Với công nghệ GEL mang lại sự êm ái vượt trội và thiết kế ''chunky'' độc đáo, Gel-Kayano 14 là lựa chọn hoàn hảo cho những cô gái yêu thích phong cách techwear hoặc muốn một đôi giày vừa thoải mái vừa trendy.', 'ASICS'),
(2, 'Veja V-10 White/Black', 3200000, 'Trắng/Đen', 'vejav10wb.jpg', 'Veja V-10 ''White/Black'' là lựa chọn lý tưởng cho những ai quan tâm đến thời trang bền vững và phong cách tối giản. Đôi giày này không chỉ được làm từ vật liệu thân thiện với môi trường mà còn mang thiết kế sạch sẽ, tinh tế, dễ dàng phối hợp với mọi trang phục, từ công sở đến đi chơi.', 'Veja'),
(2, 'Adidas Falcon', 2400000, 'Hồng/Xám', 'falcon.jpg', 'Adidas Falcon nổi bật với form chunky đậm chất thập niên 90, phối màu hồng và xám thời thượng. Đây là mẫu giày mang phong cách street style rõ nét, thích hợp để phối với quần jean, crop top hoặc các outfit phá cách.', 'Adidas'),
(2, 'Puma Cali Dream', 2100000, 'Trắng/Xanh', 'calidream.jpg', 'Puma Cali Dream là lựa chọn lý tưởng cho những cô nàng hiện đại. Với thiết kế đế cao nhẹ, kiểu dáng đơn giản nhưng thời trang, đôi giày này mang lại sự thoải mái và tự tin khi đi học, đi chơi hoặc dạo phố.', 'Puma'),
(2, 'New Balance 237', 2000000, 'Be/Hồng', 'nb237.jpg', 'New Balance 237 mang phong cách retro hiện đại với chất liệu vải thoáng khí, màu sắc nhẹ nhàng. Thiết kế đơn giản, nhẹ và êm chân giúp bạn di chuyển linh hoạt suốt ngày dài, phù hợp cho sinh viên hoặc người làm việc văn phòng.', 'New Balance'),
(2, 'Converse Chuck Taylor Lift', 1900000, 'Trắng', 'ctaylorlift.jpg', 'Converse Chuck Taylor Lift là phiên bản platform nâng cấp từ mẫu cổ điển. Đế cao giúp tăng chiều cao một cách tinh tế, vẫn giữ lại nét đặc trưng của Converse, phù hợp với nhiều phong cách khác nhau từ vintage đến casual.', 'Converse'),
(2, 'Vans Old Skool Pastel', 1700000, 'Xanh pastel', 'oldskoolpastel.jpg', 'Vans Old Skool Pastel giữ nguyên thiết kế cổ điển với đường sọc trắng đặc trưng, kết hợp phối màu pastel xanh dịu nhẹ. Mẫu giày này mang lại cảm giác trẻ trung, nữ tính và dễ phối với mọi kiểu trang phục hàng ngày.', 'Vans'),
(2, 'Reebok Club C Double', 1800000, 'Trắng/Xanh lá', 'clubcdouble.jpg', 'Reebok Club C Double là mẫu sneaker có đế dày với thiết kế thể thao tối giản. Với phối màu trắng/xanh lá hài hòa, đây là lựa chọn linh hoạt cho cả phong cách thể thao, năng động lẫn thời trang thường ngày.', 'Reebok'),
(2, 'Fila Electrove 2', 2200000, 'Trắng/Hồng', 'electrove2.jpg', 'Fila Electrove 2 gây ấn tượng với thiết kế chunky đặc trưng, màu trắng phối hồng nổi bật, giúp tạo điểm nhấn cá tính cho outfit. Đây là mẫu giày cực kỳ phù hợp để xuống phố, chụp ảnh hoặc đi dạo cuối tuần.', 'Fila'),
(2, 'Nike Waffle One', 2300000, 'Xám/Hồng', 'waffleone.jpg', 'Nike Waffle One kết hợp vẻ ngoài hiện đại với lưới thoáng khí và phần đế waffle bám tốt. Thiết kế nhẹ, êm và linh hoạt giúp bạn thoải mái vận động nhẹ nhàng như đi bộ, tập gym hoặc đi chơi thường ngày.', 'Nike'),
(2, 'Adidas Stan Smith Bold', 2500000, 'Trắng/Vàng', 'stansmithbold.jpg', 'Adidas Stan Smith Bold là phiên bản nâng đế của dòng giày huyền thoại Stan Smith. Với thiết kế tối giản, phối màu trắng/vàng sang trọng, đôi giày phù hợp để diện đi học, đi làm hoặc phối với trang phục công sở thanh lịch.', 'Adidas');

-- Thêm size cho từng sản phẩm (giả sử mỗi sản phẩm có đủ size 38, 39, 40, 41, 42, 43)
INSERT INTO Product_Size (product_id, size_id, quantity) VALUES
(1, 3, 12), (1, 4, 7), (1, 6, 14), (1, 8, 9),
(2, 3, 10), (2, 5, 8), (2, 6, 13), (2, 7, 6), (2, 8, 11),
(3, 4, 9), (3, 5, 13), (3, 6, 7), (3, 7, 12),
(4, 3, 8), (4, 4, 11), (4, 5, 6), (4, 7, 10), (4, 8, 13),
(5, 3, 14), (5, 5, 7), (5, 6, 12), (5, 8, 9),
(6, 4, 10), (6, 5, 8), (6, 6, 11), (6, 7, 7), (6, 8, 13),
(7, 3, 9), (7, 4, 12), (7, 5, 6), (7, 6, 15),
(8, 3, 11), (8, 5, 8), (8, 6, 13), (8, 7, 10), (8, 8, 7),
(9, 4, 14), (9, 5, 9), (9, 6, 12), (9, 8, 8),
(10, 3, 13), (10, 4, 7), (10, 5, 10), (10, 6, 11), (10, 7, 6),
(11, 3, 8), (11, 5, 12), (11, 6, 9), (11, 7, 14),
(12, 4, 10), (12, 5, 7), (12, 6, 13), (12, 8, 11),
(13, 3, 9), (13, 4, 12), (13, 7, 8), (13, 8, 14),
(14, 3, 11), (14, 5, 6), (14, 6, 10), (14, 7, 13), (14, 8, 7),
(15, 4, 8), (15, 5, 14), (15, 6, 9), (15, 7, 12),
(16, 3, 10), (16, 4, 7), (16, 5, 13), (16, 8, 11),
(17, 3, 8), (17, 5, 12), (17, 6, 9), (17, 7, 14), (17, 8, 6),
(18, 4, 11), (18, 5, 7), (18, 6, 13), (18, 8, 10),
(19, 3, 9), (19, 4, 12), (19, 5, 8), (19, 7, 15),
(20, 3, 14), (20, 4, 10), (20, 6, 7), (20, 7, 13), (20, 8, 8),
(21, 3, 11), (21, 5, 9), (21, 6, 12), (21, 8, 7),
(22, 4, 13), (22, 5, 8), (22, 6, 10), (22, 7, 14),
(23, 3, 7), (23, 4, 12), (23, 5, 11), (23, 6, 9), (23, 8, 13),
(24, 3, 10), (24, 5, 8), (24, 6, 15), (24, 7, 6),
(25, 4, 14), (25, 5, 9), (25, 6, 12), (25, 8, 11),
(26, 3, 8), (26, 4, 13), (26, 5, 7), (26, 6, 10), (26, 7, 12),
(27, 3, 11), (27, 5, 6), (27, 6, 14), (27, 8, 9),
(28, 4, 10), (28, 5, 13), (28, 6, 8), (28, 7, 12),
(29, 3, 7), (29, 4, 11), (29, 5, 9), (29, 6, 14), (29, 8, 10),
(30, 3, 12), (30, 5, 8), (30, 6, 13), (30, 7, 6),
(31, 4, 9), (31, 5, 14), (31, 6, 11), (31, 8, 7),
(32, 3, 10), (32, 4, 12), (32, 6, 8), (32, 7, 13), (32, 8, 9),
(33, 3, 11), (33, 5, 7), (33, 6, 14), (33, 8, 10),
(34, 4, 13), (34, 5, 9), (34, 6, 12), (34, 7, 8),
(35, 3, 8), (35, 4, 11), (35, 5, 6), (35, 7, 14), (35, 8, 12),
(36, 3, 10), (36, 5, 13), (36, 6, 9), (36, 8, 7),
(37, 4, 12), (37, 5, 8), (37, 6, 11), (37, 7, 15),
(38, 3, 14), (38, 4, 10), (38, 6, 7), (38, 8, 13),
(39, 3, 9), (39, 5, 12), (39, 6, 8), (39, 7, 11);