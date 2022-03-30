CREATE TABLE product (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(9, 2) NOT NULL,
    type ENUM ('dvd_disc','book','furniture'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE dvd_disc (
    id INT PRIMARY KEY,
    size DECIMAL(9, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES product(id) ON DELETE CASCADE  
);


CREATE TABLE book (
    id INT PRIMARY KEY,
    weight DECIMAL(6, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES product(id) ON DELETE CASCADE  
);


CREATE TABLE furniture (
    id INT PRIMARY KEY,
    height DECIMAL(6, 2) NOT NULL,
    width DECIMAL(6, 2) NOT NULL,
    length DECIMAL(6, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES product(id) ON DELETE CASCADE  
);