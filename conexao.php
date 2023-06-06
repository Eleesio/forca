<?php
// Configurações do banco de dados MySQL
$host = 'localhost';
$user = 'seu_usuario';
$password = 'sua_senha';
$database = 'seu_banco_de_dados';

// Nível de dificuldade recebido do App Inventor (fácil, médio ou difícil)
$nivel = $_POST['nivel'];

// Conexão com o banco de dados
$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
    die('Erro na conexão com o banco de dados: ' . $mysqli->connect_error);
}

// Consulta ao banco de dados para obter uma palavra aleatória do nível de dificuldade escolhido
$query = "SELECT palavra FROM palavras WHERE nivel = '$nivel' ORDER BY RAND() LIMIT 1";
$result = $mysqli->query($query);
if (!$result) {
    die('Erro na consulta ao banco de dados: ' . $mysqli->error);
}

// Verificar se há palavras disponíveis para o nível de dificuldade escolhido
if ($result->num_rows == 0) {
    die('Não há palavras disponíveis para o nível de dificuldade escolhido.');
}

// Obter a palavra do resultado da consulta
$row = $result->fetch_assoc();
$palavra = $row['palavra'];

// Fechar a conexão com o banco de dados
$mysqli->close();

// Enviar a palavra para o App Inventor
header('Content-Type: application/json');
echo json_encode(['palavra' => $palavra]);
?>