<?php include 'includes/header.php'; ?>

<?php 
$pagina = 'index';
include 'includes/nav.php';
?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <aside class="col-4 col-md-3 col-lg-2 p-3 min-vh-100 custom-sidebar">
                    <h4 class="sidebar-title" style="color:#945880; font-weight:bold">Menu</h4>
                    <nav class="sidebar-menu">
                        <a href="/Projeto SIBDAS/Frontend/private/views/equipamentos/lista.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-laptop"></i> &ensp; Equipamentos</a>
                        <hr>
                        <a href="/Projeto SIBDAS/Frontend/private/views/fornecedores/lista_forn.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-building"></i> &ensp; Fornecedores</a>
                        <hr>
                        <a href="/Projeto SIBDAS/Frontend/private/views/localizações/lista_loc.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-location-dot"></i> &ensp; Localizações</a>
                        <hr>
                        <a href="/Projeto SIBDAS/Frontend/private/views/documentação/lista_doc.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-folder-open"></i> &ensp; Documentação</a>
                        <hr>
                        <a href="/Projeto SIBDAS/Frontend/private/views/garantias e contratos/garantias.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-file-signature"></i> &ensp; Garantias e Contratos</a>
                        <hr>
                        <a href="/Projeto SIBDAS/Frontend/private/views/dashboard/dashboard.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-chart-column"></i> &ensp; Dashboard</a>
                        <hr>
                        <a href="/Projeto SIBDAS/Frontend/private/views/gestão de conteúdos/gestao_cont.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-globe"></i> &ensp; Gestão de conteúdos públicos</a>
                    </nav>
                        
                </aside>
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