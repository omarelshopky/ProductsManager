CREATE TABLE product (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(9, 2) NOT NULL
)


CREATE TABLE dvd_disc (
    id INT PRIMARY KEY,
    size DECIMAL(9, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES product(id)
)


CREATE TABLE book (
    id INT PRIMARY KEY,
    weight DECIMAL(6, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES product(id)
)


CREATE TABLE furniture (
    id INT PRIMARY KEY,
    height DECIMAL(6, 2) NOT NULL,
    width DECIMAL(6, 2) NOT NULL,
    length DECIMAL(6, 2) NOT NULL,
    FOREIGN KEY (id) REFERENCES product(id)
)