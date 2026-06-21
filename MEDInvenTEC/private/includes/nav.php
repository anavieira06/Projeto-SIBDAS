<?php
$pagina = $pagina ?? 'normal'; /* Se $pagina já tiver valor continua, se for null é 'normal' */

// Verifica se a sessão ainda não foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão
}
// Verifica se o utilizador está autenticado
if (!isset($_SESSION['utilizador'])) {
    // Se não estiver autenticado, redireciona para o formulário de login
    header('Location: ../public/login.php');
    exit; // Encerra o script
}
// A partir daqui, o utilizador está autenticado
// Podemos usar livremente os dados da sessão
$nome = $_SESSION['utilizador'];
?>

<!-- Navbar -->
<header class="container-fluid custom-navbar">
    <div class="row align-items-center h-100">
        <div class="col d-flex align-items-center">

            <?php if ($pagina == 'index') : ?>
                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/home.php">
                    <img src="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/assets/img/Imagem 3.jpeg" alt="Logo da empresa" class="logo">
                </a>

            <?php else : ?>
                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/home.php">
                    <img src="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/assets/img/Imagem 3.jpeg" alt="Logo da empresa" class="logo">
                </a>
            <?php endif; ?>

        </div>

        <?php if ($pagina == 'index') : ?>
            <div class="col text-end">
                <div class="dropdown">
                    <button class="dropdown-toggle custom-btn" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-user me-2"></i> <?= htmlspecialchars($nome) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/public/logout.php">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        <?php else : ?>
            <div class="col-auto">
                <button class="custom-button" type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu">
                    <i class="fa-solid fa-bars me-2"></i> Menu
                </button>
            </div>
        <?php endif; ?>

    </div>
</header>