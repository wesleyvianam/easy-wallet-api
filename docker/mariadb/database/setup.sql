USE easywallet;

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
    INDEX idx_user_id (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
