<?php
require_once __DIR__ . '/includes/funcoes.php';
session_start();

// Impede o acesso direto ao script (apenas permite pedidos POST)
// Se for acedido diretamente (por URL), será redirecionado para o login.
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // Redireciona para o formulário de login (interface pública)
    header('Location: /sibdas/1240811/projeto-sibdas/medinventec/public/login.php');
    // Encerra a execução do script imediatamente após o redirecionamento
    return;
}


// Verifica se os campos foram enviados via POST.
// Recolha dos dados enviados pelo formulário
$email = isset($_POST['text_username']) ? $_POST['text_username'] : '';
$password = isset($_POST['text_password']) ? $_POST['text_password'] : '';
// Se sim, guarda-os nas variáveis $username e $password. Caso contrário, usa string vazia.

// VALIDAÇÃO DOS DADOS (sanitização)

// Inicializa um array vazio para guardar mensagens de erro de validação
$validation_errors = [];
// Verifica se o nome de utilizador (username) é um endereço de email válido
// Se não for, adiciona uma mensagem de erro ao array
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $validation_errors[] = 'O username tem que ser um email válido.';
}
// Verifica se o nome de utilizador tem um comprimento entre 5 e 50 caracteres
// Isto evita usernames demasiado curtos ou excessivamente longos
if (strlen($email) < 5 || strlen($email) > 50) {
    $validation_errors[] = 'O username deve ter entre 5 e 50 caracteres.';
}
// Verifica se a password tem um comprimento entre 6 e 12 caracteres
// Garante uma password minimamente segura, mas fácil de recordar
if (strlen($password) < 6 || strlen($password) > 20) {
    $validation_errors[] = 'A password deve ter entre 6 e 20 caracteres.';
}

// Se existirem erros de validação, guarda-os na sessão
// Depois, redireciona o utilizador de volta para o formulário de login
if (!empty($validation_errors)) {
    $_SESSION['validation_errors'] = $validation_errors;
    // Redireciona para a página de login 
    header('Location: /sibdas/1240811/projeto-sibdas/medinventec/public/login.php'); 
    return;
}

// LIGAÇÃO À BASE DE DADOS E VERIFICAÇÃO DO LOGIN
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
 
    // Buscar utilizador pelo email
    $stmt = $ligacao->prepare("
        SELECT u.*, p.perfil
        FROM utilizador u
        INNER JOIN perfil p ON u.perfil_id = p.id
        WHERE u.email = :email
        AND u.ativo = 1
        LIMIT 1
    ");
    $stmt->execute([':email' => $email]);
    $utilizador = $stmt->fetch(PDO::FETCH_OBJ);

    // Verificar se o utilizador existe e se a password está correta
    if (!$utilizador || !password_verify($password, $utilizador->password)) {
        registar_evento('TENTATIVA DE AUTENTICAÇÃO FALHADA', $email);
        $_SESSION['server_error'] = 'Login inválido';
        header('Location: /sibdas/1240811/projeto-sibdas/medinventec/public/login.php');
        return;
    }
    // Atualizar last_login
    $stmtUpdate = $ligacao->prepare("UPDATE utilizador SET last_login = NOW() WHERE id = :id");
    $stmtUpdate->execute([':id' => $utilizador->id]);
 
    $ligacao = null;
 
    // Guardar dados na sessão
    $_SESSION['utilizador'] = $utilizador->nome;
    $_SESSION['email']      = $utilizador->email;
    $_SESSION['perfil']     = $utilizador->perfil;
    $_SESSION['perfil_id']  = $utilizador->perfil_id;

    registar_evento('AUTENTICAÇÃO BEM SUCEDIDA', $utilizador->email);
 
    // Redirecionar para a página principal privada
    header('Location: home.php');
    exit;
 
} catch (PDOException $e) {
    $_SESSION['server_error'] = 'Erro ao ligar à base de dados.';
    header('Location: /sibdas/1240811/projeto-sibdas/medinventec/public/login.php');
    return;
}