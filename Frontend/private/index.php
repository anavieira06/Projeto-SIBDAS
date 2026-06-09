<?php
// Impede o acesso direto ao script (apenas permite pedidos POST)
// Se for acedido diretamente (por URL), será redirecionado para o login.
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // Redireciona para o formulário de login (interface pública)
    header('Location: ../public/login.php');
    // Encerra a execução do script imediatamente após o redirecionamento
    return;
}
// Mostrar os dados recebidos pelo formulário através do método POST
echo "Utilizador: " . $_POST['text_username'] . "<br>"; // Mostra o username inserido
echo "Password: " . $_POST['text_password']; // Mostra a password inserida
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