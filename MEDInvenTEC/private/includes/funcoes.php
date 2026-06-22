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
function redirect_if_not_logged($redirect_to = '/sibdas/1240811/projeto-sibdas/medinventec/public/login.php')
{
    start_session();
    if (!check_session()) {
        header("Location: " . $redirect_to);
        exit;
    }
}

function logout_and_redirect($redirect_to = '/sibdas/1240811/projeto-sibdas/medinventec/public/login.php')
{
    start_session();
    session_unset();
    session_destroy();
    header("Location: " . $redirect_to);
    exit;
}


// ============================================================
// Encriptação e desencriptação de valores com OpenSSL
// ============================================================
function aes_encrypt($value) {
    return bin2hex(openssl_encrypt(
        $value,
        OPENSSL_METHOD,
        OPENSSL_KEY,
        OPENSSL_RAW_DATA,
        OPENSSL_IV
    ));
}

function aes_decrypt($value) {
    if (!is_string($value) || strlen($value) % 2 !== 0) return false;
    return openssl_decrypt(
        hex2bin($value),
        OPENSSL_METHOD,
        OPENSSL_KEY,
        OPENSSL_RAW_DATA,
        OPENSSL_IV
    );
}

// ============================================================
// Registo de eventos no ficheiro de log
// ============================================================
function registar_evento($tipo, $email = null) {
    $pasta = __DIR__ . '/../../logs';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }
    $ficheiro = $pasta . '/eventos.log';
    $data     = date('Y-m-d H:i:s');
    $emailStr = $email ? " | utilizador: $email" : '';
    $linha    = "[$data] $tipo$emailStr" . PHP_EOL;
    file_put_contents($ficheiro, $linha, FILE_APPEND | LOCK_EX);
}