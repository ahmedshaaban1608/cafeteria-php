CREATE TABLE room (
    room_no INT PRIMARY KEY
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    hashed_password VARCHAR(100) NOT NULL,
    profile_img VARCHAR(255) NOT NULL,
    room_no INT NOT NULL,
    ext INT NOT NULL,
    CONSTRAINT room_reference FOREIGN KEY (room_no) REFERENCES room(room_no)
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    price INT UNSIGNED NOT NULL,
    img VARCHAR(255) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE
);

CREATE TABLE product_order (
    id INT PRIMARY KEY,
    user_id INT NOT NULL,
    status ENUM('done', 'processing', 'out of delivery') DEFAULT 'processing',
    order_date TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    room_no INT NOT NULL,
    CONSTRAINT user_order_reference FOREIGN KEY (user_id) REFERENCES user(id)  ON DELETE CASCADE,
    CONSTRAINT order_room_reference FOREIGN KEY (room_no) REFERENCES room(room_no)
);

CREATE TABLE order_items (
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    CONSTRAINT order_reference FOREIGN KEY (order_id) REFERENCES product_order(id) ON DELETE CASCADE,
    CONSTRAINT product_reference FOREIGN KEY (product_id) REFERENCES product(id)
);


DELIMITER //

CREATE TRIGGER create_user BEFORE INSERT ON user
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM user WHERE email = NEW.email) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Email already exists';
    END IF;
END;
//

DELIMITER ;


CREATE VIEW order_details_view AS
SELECT
    po.id AS order_id,
    po.user_id,
    u.fullname AS user_fullname,
    p.name AS product_name,
    p.price AS product_price,
    oi.quantity AS product_quantity,
    po.status AS order_status,
    po.order_date,
    po.notes,
    r.room_no AS room_number
FROM
    product_order po
JOIN
    user u ON po.user_id = u.id
JOIN
    order_items oi ON po.id = oi.order_id
JOIN
    product p ON oi.product_id = p.id
JOIN
    room r ON po.room_no = r.room_no;
