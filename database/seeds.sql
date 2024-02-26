INSERT INTO users
(name, email, password, type, active, document)
VALUES
    ('Wesley Viana Martins', 'wesley@gmail.com', '123123', 'F', 1, '111.222.333-45'),
    ('Gabrielle Lino Santana Martins', 'gabs@gmail.com', '123123', 'F', 1, '111.222.333-12'),
    ('Calçados LTDA', 'calcados@gmail.com', '123123', 'J', 1, '111.222.33/0001-45'),
    ('Distribuidora e Comércio LTDA', 'distribuidora@gmail.com', '123123', 'J', 1, '111.222.33/0001-42');

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