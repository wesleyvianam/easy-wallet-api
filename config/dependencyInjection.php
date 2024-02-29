<?php

declare(strict_types=1);

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $host = 'easy-db';
        $port = '3306';
        $dbName = 'easywallet';
        $user = 'root';
        $password = 'mariadb';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8";

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
]);

return $builder->build();