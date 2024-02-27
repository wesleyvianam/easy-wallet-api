USE easywallet;

DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    document VARCHAR(25) NOT NULL UNIQUE,
    type ENUM('F', 'J') NOT NULL,
    active TINYINT NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE transactions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    type INTEGER NOT NULL,
    sub_type ENUM('I', 'E') NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    value INTEGER NOT NULL,
    status TINYINT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users
(name, email, password, type, active, document, phone)
VALUES
    ('Wesley Viana Martins', 'wesley@gmail.com', '123123', 'F', 1, '111.222.333-45', '(38) 9 91198109'),
    ('Gabrielle Lino Santana Martins', 'gabs@gmail.com', '123123', 'F', 1, '111.222.333-12', '(38) 9 91198100'),
    ('Calçados LTDA', 'calcados@gmail.com', '123123', 'J', 1, '111.222.33/0001-45', '(38) 9 91198107'),
    ('Distribuidora e Comércio LTDA', 'distribuidora@gmail.com', '123123', 'J', 1, '111.222.33/0001-42', '(38) 9 91198101');

INSERT INTO transactions
(type, sub_type, user_id, value, status)
VALUES
    (1, 'I', 1, '100000', 1),
    (1, 'I', 2, '100000', 1),
    (1, 'I', 3, '100000', 1),
    (1, 'I', 4, '100000', 1),
    (2, 'E', 1, '20000', 1),
    (2, 'E', 2, '15000', 1),
    (2, 'E', 3, '12520', 1),
    (2, 'E', 4, '50000', 1),
    (3, 'E', 1, '12500', 1),
    (3, 'I', 2, '12500', 1),
    (3, 'E', 1, '15500', 1),
    (3, 'I', 4, '15500', 1),
    (3, 'E', 1, '20000', 0),
    (3, 'I', 2, '20000', 0);
