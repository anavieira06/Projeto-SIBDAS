<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado


include __DIR__ . '../../includes/header.php'; 

$pagina = 'normal';
include __DIR__ . '../../includes/nav.php';
include __DIR__ . '../../includes/sidebar.php';
?>


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

<script>
    // Gráfico por estado
    new Chart(document.getElementById('estadoChart'), {
        type: 'pie',
        data: {
            labels: ['Ativos', 'Manutenção', 'Inativos'],
            datasets: [{
                data: [1103, 89, 55],
                backgroundColor: ['#680447', '#d63384', '#f4a6d7']
            }]
        }
    });

    // Gráfico por serviço
    new Chart(document.getElementById('servicoChart'), {
        type: 'bar',
        data: {
            labels: ['UCI', 'Urgência', 'Bloco Operatório', 'Imagiologia', 'Laboratório'],
            datasets: [{
                label: 'Equipamentos',
                data: [120, 95, 72, 48, 60],
                backgroundColor: '#bb226f'
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Gráfico por categoria
    new Chart(document.getElementById('categoriaChart'), {
        type: 'pie',
        data: {
            labels: ['Monitorização', 'Diagnóstico', 'Suporte de Vida', 'Laboratório', 'Terapia', 'Esterilização', 'Reabilitação'],
            datasets: [{
                data: [25, 23, 17, 12, 10, 10, 8],
                backgroundColor: ['#680447', '#9b0a68', '#c3186d', '#d24497', '#f083c3', '#f7c6e0', '#fff4fb']
            }]
        }
    });
</script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom JS -->
<script src="/ProjetoSIBDAS/Frontend/assets/js/1240811.js"></script>

<?php include __DIR__ . '../../includes/footer.php'; ?>