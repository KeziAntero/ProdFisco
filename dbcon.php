<?php
$con = mysqli_connect("localhost", "root", "", "prod");

// Verificação da conexão
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Usar o objeto de conexão em vez de funções mysqli para a compatibilidade com PDO
$pdo = new PDO("mysql:host=localhost;dbname=prod", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


