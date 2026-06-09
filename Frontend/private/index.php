<?php
session_start();

// Impede o acesso direto ao script (apenas permite pedidos POST)
// Se for acedido diretamente (por URL), será redirecionado para o login.
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // Redireciona para o formulário de login (interface pública)
    header('Location: ../public/login.php');
    // Encerra a execução do script imediatamente após o redirecionamento
    return;
}

// Recolha dos dados enviados pelo formulário
// Verifica se os campos foram enviados via POST.
$username = isset($_POST['text_username']) ? $_POST['text_username'] : '';
$password = isset($_POST['text_password']) ? $_POST['text_password'] : '';
// Se sim, guarda-os nas variáveis $username e $password. Caso contrário, usa string vazia.

//Apresentação dos dados recebidos
echo "Utilizador: " . $username . "<br>";
echo "Password: " . $password;


// VALIDAÇÃO DOS DADOS (sanitização)

// Inicializa um array vazio para guardar mensagens de erro de validação
$validation_errors = [];
// Verifica se o nome de utilizador (username) é um endereço de email válido
// Se não for, adiciona uma mensagem de erro ao array
if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $validation_errors[] = 'O username tem que ser um email válido.';
}
// Verifica se o nome de utilizador tem um comprimento entre 5 e 50 caracteres
// Isto evita usernames demasiado curtos ou excessivamente longos
if (strlen($username) < 5 || strlen($username) > 50) {
    $validation_errors[] = 'O username deve ter entre 5 e 50 caracteres.';
}
// Verifica se a password tem um comprimento entre 6 e 12 caracteres
// Garante uma password minimamente segura, mas fácil de recordar
if (strlen($password) < 6 || strlen($password) > 12) {
    $validation_errors[] = 'A password deve ter entre 6 e 12 caracteres.';
}

// Se existirem erros de validação, guarda-os na sessão
// Depois, redireciona o utilizador de volta para o formulário de login
if (!empty($validation_errors)) {
    $_SESSION['validation_errors'] = $validation_errors;
    // Redireciona para a página de login 
    header('Location: ../public/login.php'); 
    return;
}
?>

<?php include 'includes/header.php'; ?>

<?php 
$pagina = 'index';
include 'includes/nav.php';
?>

        <div class="container-fluid">
            <div class="row">
                <?php include 'includes/sidebar.php'; ?>
                <!-- Conteúdo Principal -->
                <main class="col-8 col-md-9 col-lg-10 p-4">
                    <section class="main-section">
                        <h2>Bem-vindo a MEDInvenTEC</h2>
                        <p>Gere equipamentos médicos e muito mais, de forma simples e eficiente. </p>
                        <p>Utilize o menu lateral para aceder às funcionalidades do sistema.</p>
                    </section>
                </main>
            </div>
        </div>

<?php include 'includes/footer.php'; ?>