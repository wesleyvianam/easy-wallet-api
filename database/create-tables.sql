CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    document VARCHAR(25) NOT NULL UNIQUE,
    type ENUM('F', 'J') NOT NULL,
    active TINYINT NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE wallets (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    balance INTEGER NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE transactions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    type ENUM('0', '1', '2', '3') NOT NULL,
    sub_type ENUM('I', 'E') NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    wallet_id BIGINT UNSIGNED NOT NULL,
    reversed_from BIGINT DEFAULT NULL,
    value DECIMAL(10, 2) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (wallet_id) REFERENCES wallets(id)
);


INSERT INTO users
    (name, email, password, type, active, document)
VALUES
    ('Wesley', 'wesley@gmail.com', '123123', 'F', 1, '111.222.333-45'),
    ('Gabrielle', 'gabi@gmail.com', '123123', 'F', 1, '111.222.333-12'),
    ('Cleia', 'cleia@gmail.com', '123123', 'F', 1, '111.222.333-32'),
    ('Kezy', 'kezy@gmail.com', '123123', 'J', 1, '111.222.33/0001-45'),
    ('Keke', 'keke@gmail.com', '123123', 'J', 1, '111.222.33/0001-42');

INSERT INTO wallets
    (balance, user_id)
VALUES
    (100, 1),
    (100, 2),
    (100, 3),
    (100, 4),
    (100, 5);
