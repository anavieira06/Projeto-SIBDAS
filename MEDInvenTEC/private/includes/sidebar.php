<?php
$pagina = $pagina ?? 'normal'; /* Se $pagina já tiver valor continua, se for null é 'normal' */
?>

<?php if ($pagina == 'index') : ?>
    <!-- Sidebar -->
    <aside class="col-4 col-md-3 col-lg-2 p-3 min-vh-100 custom-sidebar">
        <h4 class="sidebar-title" style="color:#945880; font-weight:bold">Menu</h4>
        <nav class="sidebar-menu">
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/equipamentos/lista.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-laptop"></i> &ensp; Equipamentos</a>
            <hr>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/fornecedores/lista_forn.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-building"></i> &ensp; Fornecedores</a>
            <hr>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/localizações/lista_loc.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-location-dot"></i> &ensp; Localizações</a>
            <hr>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/documentação/lista_doc.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-folder-open"></i> &ensp; Documentação</a>
            <hr>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/garantias e contratos/garantias.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-file-signature"></i> &ensp; Garantias e Contratos</a>
            <hr>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/dashboard/dashboard.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-chart-column"></i> &ensp; Dashboard</a>
            <hr>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/gestão de conteúdos/gestao_cont.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-globe"></i> &ensp; Gestão de conteúdos públicos</a>
        </nav>
    </aside>

<?php else : ?>
    <!-- Sidebar -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/equipamentos/lista.php" class="sidebar-link">
                <i class="fas fa-laptop"></i> Equipamentos
            </a>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/fornecedores/lista_forn.php" class="sidebar-link">
                <i class="fas fa-building"></i> Fornecedores
            </a>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/localizações/lista_loc.php" class="sidebar-link">
                <i class="fas fa-location-dot"></i> Localizações
            </a>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/documentação/lista_doc.php" class="sidebar-link">
                <i class="fas fa-folder-open"></i> Documentação
            </a>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/garantias e contratos/garantias.php" class="sidebar-link">
                <i class="fas fa-file-signature"></i> Garantias e Contratos
            </a>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/dashboard/dashboard.php" class="sidebar-link">
                <i class="fas fa-chart-column"></i> Dashboard
            </a>
            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/gestão de conteúdos/gestao_cont.php" class="sidebar-link">
                <i class="fas fa-globe"></i> Gestão de conteúdos públicos
            </a>
        </div>
    </div>

<?php endif; ?>