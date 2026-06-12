<?php
require_once __DIR__ . '/../../config/config.php';
// Inicia a sessão se ainda não estiver iniciada
function start_session()
{
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
}
// Verifica se a sessão do utilizador está ativa
function check_session()
{
    return isset($_SESSION['utilizador']);
}

// Redireciona automaticamente se não houver sessão iniciada
function redirect_if_not_logged($redirect_to = '/Frontend/public/login.php')
{
    start_session();
    if (!check_session()) {
        header("Location: " . BASE_URL . $redirect_to);
        exit;
    }
}

function logout_and_redirect($redirect_to = '/Frontend/public/login.php')
{
    start_session();
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . $redirect_to);
    exit;
}