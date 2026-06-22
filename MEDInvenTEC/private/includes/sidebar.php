<?php
$pagina = $pagina ?? 'normal';
$perfil = $_SESSION['perfil'] ?? '';
?>

<?php if ($pagina == 'index') : ?>
    <!-- Sidebar -->
    <aside class="col-4 col-md-3 col-lg-2 p-3 min-vh-100 custom-sidebar">
        <h4 class="sidebar-title" style="color:#945880; font-weight:bold">Menu</h4>
        <nav class="sidebar-menu">

            <!-- Todos os perfis -->
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/dashboard/dashboard.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-chart-column"></i> &ensp; Dashboard</a>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/equipamentos/lista.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-laptop"></i> &ensp; Equipamentos</a>

            <!-- Técnico e Administrador -->
            <?php if ($perfil == 'tecnico' || $perfil == 'administrador'): ?>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-location-dot"></i> &ensp; Localizações</a>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/fornecedores/lista_forn.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-building"></i> &ensp; Fornecedores</a>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/documentação/lista_doc.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-folder-open"></i> &ensp; Documentação</a>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/garantias e contratos/garantias.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-file-signature"></i> &ensp; Garantias e Contratos</a>
            <?php endif; ?>

            <!-- Apenas Administrador -->
            <?php if ($perfil == 'administrador'): ?>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/gestão de conteúdos/gestao_cont.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-globe"></i> &ensp; Gestão de conteúdos públicos</a>
            <hr>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/gestão de conteúdos/mensagens.php" class="px-0 mb-2 d-block sidebar-link"><i class="fas fa-envelope"></i> &ensp; Mensagens de contacto</a>
            <?php endif; ?>

        </nav>
    </aside>

<?php else : ?>
    <!-- Sidebar offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">

            <!-- Todos os perfis -->
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/dashboard/dashboard.php" class="sidebar-link">
                <i class="fas fa-chart-column"></i> Dashboard
            </a>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/equipamentos/lista.php" class="sidebar-link">
                <i class="fas fa-laptop"></i> Equipamentos
            </a>

            <!-- Técnico e Administrador -->
            <?php if ($perfil == 'tecnico' || $perfil == 'administrador'): ?>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php" class="sidebar-link">
                <i class="fas fa-location-dot"></i> Localizações
            </a>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/fornecedores/lista_forn.php" class="sidebar-link">
                <i class="fas fa-building"></i> Fornecedores
            </a>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/documentação/lista_doc.php" class="sidebar-link">
                <i class="fas fa-folder-open"></i> Documentação
            </a>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/garantias e contratos/garantias.php" class="sidebar-link">
                <i class="fas fa-file-signature"></i> Garantias e Contratos
            </a>
            <?php endif; ?>

            <!-- Apenas Administrador -->
            <?php if ($perfil == 'administrador'): ?>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/gestão de conteúdos/gestao_cont.php" class="sidebar-link">
                <i class="fas fa-globe"></i> Gestão de conteúdos públicos
            </a>
            <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/gestão de conteúdos/mensagens.php" class="sidebar-link">
                <i class="fas fa-envelope"></i>
                Mensagens de contacto
            </a>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>