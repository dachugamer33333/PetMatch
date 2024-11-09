<?php

    require __DIR__ . '/../vendor/autoload.php';


    // Cargar las variables desde el archivo .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

    $dotenv->load();
    $dbHost = $_ENV['DB_HOST'];
    $dbUser = $_ENV['DB_USER'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbName = $_ENV['DB'];

    $conn= new mysqli($dbHost,$dbUser,$dbPassword,$dbName);
    if($conn->connect_error)
    {
        echo "Error" . $conn->connect_error;
    }


?>