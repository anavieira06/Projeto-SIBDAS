<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

// Buscar dados da BD para o dashboard
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    // Total de equipamentos
    $totalEquipamentos  = $ligacao->query("SELECT COUNT(*) FROM equipamentos")->fetchColumn();

    // Total de fornecedores ativos
    $totalFornecedores  = $ligacao->query("SELECT COUNT(*) FROM fornecedores WHERE ativo = 1")->fetchColumn();

    // Total de localizações ativas
    $totalLocalizacoes  = $ligacao->query("SELECT COUNT(*) FROM localizacoes WHERE ativo = 1")->fetchColumn();

    // Total de documentos
    $totalDocumentos    = $ligacao->query("SELECT COUNT(*) FROM documentos")->fetchColumn();
 
 
    // Equipamentos por estado
    $porEstado = $ligacao->query("
        SELECT est.estado, COUNT(*) as total
        FROM equipamentos e
        INNER JOIN estado est ON e.estado_id = est.id
        GROUP BY est.estado
    ")->fetchAll(PDO::FETCH_OBJ);
 
    // Equipamentos por categoria
    $porCategoria = $ligacao->query("
        SELECT cg.categoria_grupo, COUNT(*) as total
        FROM equipamentos e
        INNER JOIN categoria_grupo cg ON e.categoria_grupo_id = cg.id
        GROUP BY cg.categoria_grupo
    ")->fetchAll(PDO::FETCH_OBJ);
 
    // Equipamentos por serviço/departamento
    $porServico = $ligacao->query("
        SELECT l.servico_depart, COUNT(*) as total
        FROM equipamentos e
        INNER JOIN localizacoes l ON e.localizacao_id = l.id
        GROUP BY l.servico_depart
        ORDER BY total DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_OBJ);
 
    // Alertas
    $garantiaExpirando = $ligacao->query("
        SELECT COUNT(*) FROM garantias_contratos gc
        INNER JOIN equipamentos e ON e.garantia_contrato_id = gc.id
        WHERE gc.data_fim BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)
    ")->fetchColumn();
 
    $garantiaExpirada = $ligacao->query("
        SELECT COUNT(*) FROM garantias_contratos gc
        INNER JOIN equipamentos e ON e.garantia_contrato_id = gc.id
        WHERE gc.data_fim < NOW()
    ")->fetchColumn();
 
    $semDocumentacao = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        WHERE e.ativo = 1
        AND EXISTS (
            SELECT 1 FROM documentos d 
            WHERE d.equipamento_id = e.id 
            AND (d.ficheiro IS NULL OR d.ficheiro = '')
        )
    ")->fetchColumn();
 
    $criticidadeElevada = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        INNER JOIN criticidade c ON e.criticidade_id = c.id
        WHERE c.criticidade IN ('Alta', 'Suporte de Vida')
    ")->fetchColumn();
 
    $ligacao = null;
 
} catch (PDOException $e) {
    $totalEquipamentos = $equipamentosAtivos = $equipamentosInativos = $equipamentosManutencao = 0;
    $totalFornecedores = $totalLocalizacoes = $totalDocumentos = 0;
    $porEstado = $porCategoria = $porServico = [];
    $garantiaExpirando = $garantiaExpirada = $semDocumentacao = $criticidadeElevada = 0;
}
 
// Preparar dados para os gráficos
$estadoLabels  = json_encode(array_column((array)$porEstado,    'estado'));
$estadoData    = json_encode(array_column((array)$porEstado,    'total'));
$catLabels     = json_encode(array_column((array)$porCategoria, 'categoria_grupo'));
$catData       = json_encode(array_column((array)$porCategoria, 'total'));
$servicoLabels = json_encode(array_column((array)$porServico,   'servico_depart'));
$servicoData   = json_encode(array_column((array)$porServico,   'total'));


include __DIR__ . '/../../includes/header.php'; 

$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
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
                                <div class="stat-number" id="totalEquipamentos"><?= $totalEquipamentos ?></div>
                                <div class="stat-label">Total de Equipamentos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div>
                                <div class="stat-number"><?= $totalFornecedores ?></div>
                                <div class="stat-label">Fornecedores Ativos</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <div class="stat-number"><?= $totalLocalizacoes ?></div>
                                <div class="stat-label">Localizações ativas</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="stat-icon">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <div class="stat-number"><?= $totalDocumentos ?></div>
                                <div class="stat-label">Documentos</div>
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
                                    <strong><?= $garantiaExpirando ?> equipamentos</strong> com garantia a expirar nos próximos 30 dias
                                </div>

                                <div class="alert-item">
                                    <strong><?= $garantiaExpirada ?> equipamentos</strong> com garantia expirada
                                </div>

                                <div class="alert-item">
                                    <strong><?= $semDocumentacao ?> equipamentos</strong> com documento sem ficheiro associado
                                </div>

                                <div class="alert-item">
                                    <strong><?= $criticidadeElevada ?> equipamentos</strong> de criticidade elevada
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- Chart.js -->
<script src="/sibdas/1240811/projeto-sibdas/medinventec/assets/chart/chart.min.js"></script>

<script>
    // Gráfico por estado
    new Chart(document.getElementById('estadoChart'), {
        type: 'pie',
        data: {
            labels: <?= $estadoLabels ?>,
            datasets: [{
                data: <?= $estadoData ?>,
                backgroundColor: ['#680447','#9b0a68', '#d63384', '#d556a0', '#e489c3', '#f7c6e0']
            }]
        }
    });
 
    // Gráfico por serviço
    new Chart(document.getElementById('servicoChart'), {
        type: 'bar',
        data: {
            labels: <?= $servicoLabels ?>,
            datasets: [{
                label: 'Equipamentos',
                data: <?= $servicoData ?>,
                backgroundColor: '#bb226f'
            }]
        },
        options: {
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        x: {
            ticks: {
                display: false
            }
        }
    }
}
    });
 
    // Gráfico por categoria
    new Chart(document.getElementById('categoriaChart'), {
        type: 'pie',
        data: {
            labels: <?= $catLabels ?>,
            datasets: [{
                data: <?= $catData ?>,
                backgroundColor: ['#680447', '#9b0a68', '#c3186d', '#d24497', '#f083c3', '#f7c6e0', '#fff4fb']
            }]
        }
    });
</script>

<!-- Custom JS -->
<script src="/sibdas/1240811/projeto-sibdas/medinventec/assets/js/1240811.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>