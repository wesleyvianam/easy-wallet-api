<?php

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $host = 'easy-wallet-db-1';
        $port = '3306';
        $dbName = 'easywallet';
        $user = 'root';
        $password = 'mariadb';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8";

        // Conexão com o MySQL
        try {
            $pdo = new PDO($dsn, $user, $password);
            // Configurações adicionais, se necessário
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
]);

return $builder->build();