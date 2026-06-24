<?php
require_once __DIR__ . '/../private/includes/funcoes.php';

// Inicia a sessão para aceder e manipular os dados da $_SESSION
session_start();

// Registar evento de logout
$email = $_SESSION['email'] ?? null;
registar_evento('SESSÃO TERMINADA', $email);

// Termina a sessão removendo todas as variáveis/dados armazenados
session_unset();

// Isto elimina o identificador da sessão e os dados associados
session_destroy();

// Após terminar a sessão, redireciona o utilizador para a página de login
header('Location: login.php');

return;