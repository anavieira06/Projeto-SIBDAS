<?php
require_once __DIR__ . '/../private/includes/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nome     = trim($_POST['nome']     ?? '');
$email    = trim($_POST['email']    ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// Validar
if (empty($nome) || empty($email) || empty($mensagem) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?erro=1');
    exit;
}
date_default_timezone_set('Europe/Lisbon'); 
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $ligacao->prepare("INSERT INTO mensagens_contacto (nome, email, mensagem) VALUES (:nome, :email, :mensagem)");
    $stmt->execute([':nome' => $nome, ':email' => $email, ':mensagem' => $mensagem]);

    $ligacao = null;

    header('Location: index.php?enviado=1');
    exit;

} catch (PDOException $e) {
    header('Location: index.php?erro=1');
    exit;
}