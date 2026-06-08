<?php include 'includes/header.php'; ?>

<?php
$pagina = 'normal';
include '../../includes/nav.php';
?>

        <!-- Sidebar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <a href="../equipamentos/lista.html" class="sidebar-link">
                    <i class="fas fa-laptop"></i> Equipamentos
                </a>
                <a href="../fornecedores/lista_forn.html" class="sidebar-link">
                    <i class="fas fa-building"></i> Fornecedores
                </a>
                <a href="../localizações/lista_loc.html" class="sidebar-link">
                    <i class="fas fa-location-dot"></i> Localizações
                </a>
                <a href="../documentação/lista_doc.html" class="sidebar-link">
                    <i class="fas fa-folder-open"></i> Documentação
                </a>
                <a href="../garantias e contratos/garantias.html" class="sidebar-link">
                    <i class="fas fa-file-signature"></i> Garantias e Contratos
                </a>
                <a href="../dashboard/dashboard.html" class="sidebar-link">
                    <i class="fas fa-chart-column"></i> Dashboard
                </a>
                <a href="../gestão de conteúdos/gestao_cont.html" class="sidebar-link">
                    <i class="fas fa-globe"></i> Gestão de conteúdos públicos
                </a>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <strong>Dashboard</strong>
                </h2>
            </div>
            <p class="text-muted">Visão geral dos equipamentos registados</p>

            <!-- Indicadores -->
            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-laptop-medical"></i>
                            </div>
                            <div>
                                <div class="stat-number" id="totalEquipamentos">1247</div>
                                <div class="stat-label">Total de Equipamentos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <div class="stat-number" id="equipamentosAtivos">1103</div>
                                <div class="stat-label">Equipamentos Ativos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </div>
                            <div>
                                <div class="stat-number" id="equipamentosManutencao">89</div>
                                <div class="stat-label">Equipamentos em Manutenção</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div>
                                <div class="stat-number" id="equipamentosInativos">55</div>
                                <div class="stat-label">Equipamentos Inativos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row g-4 mb-4">

                    <div class="col-md-6">
                        <div class="card chart-card">
                            <div class="card-body">
                                <h5 class="chart-title">
                                    Equipamentos por Estado
                                </h5>
                                <canvas id="estadoChart" class="dashboard-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card chart-card">
                            <div class="card-body">
                                <h5 class="chart-title">
                                    Distribuição por Categoria
                                </h5>
                                <canvas id="categoriaChart" class="dashboard-chart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Categorias e Alertas -->
                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="card chart-card">
                            <div class="card-body">
                                <h5 class="chart-title">
                                    Equipamentos por Serviço
                                </h5>
                                <canvas id="servicoChart" class="dashboard-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card chart-card">
                            <div class="card-body">

                                <h5 class="chart-title">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    Alertas
                                </h5>

                                <div class="alert-item">
                                    <strong>12 equipamentos</strong> com garantia a expirar nos próximos 30 dias
                                </div>

                                <div class="alert-item">
                                    <strong>9 equipamentos</strong> com garantia expirada
                                </div>

                                <div class="alert-item">
                                    <strong>5 equipamentos</strong> sem documentação associada
                                </div>

                                <div class="alert-item">
                                    <strong>18 equipamentos</strong> de criticidade elevada
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom JS -->
<script src="../../../assets/js/1240811.js"></script>

<?php include 'includes/footer.php'; ?>