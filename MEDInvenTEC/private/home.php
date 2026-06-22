<?php
require_once __DIR__ . '/includes/funcoes.php';
redirect_if_not_logged();
start_session();

$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
?>

<?php 
include __DIR__ . '/includes/header.php';
$pagina = 'index';
include __DIR__ . '/includes/nav.php';
?>

<?php if (!empty($success_message)) : ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <?= htmlspecialchars($success_message) ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">

        <?php include __DIR__ . '/includes/sidebar.php'; ?>
        <!-- Conteúdo Principal -->
        <main class="col-8 col-md-9 col-lg-10 p-4">
            <section class="main-section">
                <?php if (isset($_GET['password_alterada'])): ?>
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4" id="alertPassword" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        Password alterada com sucesso!
                    </div>
                    <script>
                        history.replaceState(null, '', window.location.pathname);
                        setTimeout(() => {
                            document.getElementById('alertPassword').style.display = 'none';
                        }, 4000);
                    </script>
                <?php endif; ?>
                <h2>Bem-vindo a MEDInvenTEC</h2>
                <p>Gere equipamentos médicos e muito mais, de forma simples e eficiente. </p>
                <p>Utilize o menu lateral para aceder às funcionalidades do sistema.</p>
            </section>
        </main>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>