<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
include __DIR__ . '/../../includes/header.php'; 
?>

<?php
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';

 
// Paginação
$registosPorPagina = 5;
 
$paginaAtual = isset($_GET['pagina'])
    ? (int) $_GET['pagina']
    : 1;
 
if ($paginaAtual < 1) {
    $paginaAtual = 1;
}

$offset = ($paginaAtual - 1) * $registosPorPagina;
 
// Pesquisa e filtros
$pesquisa              = isset($_GET['pesquisa'])        ? trim($_GET['pesquisa'])          : '';
$filtroContrato        = isset($_GET['contrato'])        ? trim($_GET['contrato'])           : '';
$filtroTipoContrato    = isset($_GET['tipo_contrato'])   ? (int) $_GET['tipo_contrato']     : 0;
$filtroPeriodicidade   = isset($_GET['periodicidade'])   ? (int) $_GET['periodicidade']     : 0;
$filtroEntidade        = isset($_GET['entidade'])        ? trim($_GET['entidade'])           : '';

try {
 
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
 
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    // Construção dinâmica das condições WHERE
    $condicoes = [];
    $parametros = [];
 
    if ($pesquisa !== '') {
        $condicoes[] = "(gc.entidade_responsavel LIKE :pesquisa
            OR gc.data_inicio LIKE :pesquisa
            OR gc.data_fim LIKE :pesquisa
            OR tc.tipo_contrato LIKE :pesquisa
            OR p.periodicidade LIKE :pesquisa
            OR e.codigo_inventario LIKE :pesquisa
            OR e.designacao_equipamento LIKE :pesquisa)";
        $parametros[':pesquisa'] = '%' . $pesquisa . '%';
    }
 
    if ($filtroContrato !== '') {
        $condicoes[] = "gc.contrato_manutencao = :contrato";
        $parametros[':contrato'] = ($filtroContrato === 'sim') ? 1 : 0;
    }
 
    if ($filtroTipoContrato > 0) {
        $condicoes[] = "gc.tipo_contrato_id = :tipo_contrato";
        $parametros[':tipo_contrato'] = $filtroTipoContrato;
    }
 
    if ($filtroPeriodicidade > 0) {
        $condicoes[] = "gc.periodicidade_id = :periodicidade";
        $parametros[':periodicidade'] = $filtroPeriodicidade;
    }
 
    if ($filtroEntidade !== '') {
        $condicoes[] = "gc.entidade_responsavel = :entidade";
        $parametros[':entidade'] = $filtroEntidade;
    }
 
    $whereSql = '';
    if (!empty($condicoes)) {
        $whereSql = ' WHERE ' . implode(' AND ', $condicoes);
    }
 
    $sql = "
        SELECT gc.*,
               tc.tipo_contrato,
               p.periodicidade,
               e.codigo_inventario, e.designacao_equipamento
        FROM garantias_contratos gc
        LEFT JOIN tipo_contrato tc ON gc.tipo_contrato_id = tc.id
        LEFT JOIN periodicidade p ON gc.periodicidade_id = p.id
        LEFT JOIN equipamentos e ON e.garantia_contrato_id = gc.id
        " . $whereSql . "
        ORDER BY gc.data_fim ASC
        LIMIT :limite OFFSET :offset
    ";
 
    $stmt = $ligacao->prepare($sql);
 
    foreach ($parametros as $chave => $valor) {
        if ($chave === ':pesquisa' || $chave === ':entidade') {
            $stmt->bindValue($chave, $valor, PDO::PARAM_STR);
        } elseif ($chave === ':contrato') {
            $stmt->bindValue($chave, $valor, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($chave, $valor, PDO::PARAM_INT);
        }
    }
 
    $stmt->bindValue(':limite', $registosPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
 
    $stmt->execute();
 
    $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
 
    // Contar total de registos
    $sqlTotal = "
        SELECT COUNT(DISTINCT gc.id) AS total
        FROM garantias_contratos gc
        LEFT JOIN tipo_contrato tc ON gc.tipo_contrato_id = tc.id
        LEFT JOIN periodicidade p ON gc.periodicidade_id = p.id
        LEFT JOIN equipamentos e ON e.garantia_contrato_id = gc.id
        " . $whereSql . "
    ";
 
    $stmtTotal = $ligacao->prepare($sqlTotal);
 
    foreach ($parametros as $chave => $valor) {
        if ($chave === ':pesquisa' || $chave === ':entidade') {
            $stmtTotal->bindValue($chave, $valor, PDO::PARAM_STR);
        } else {
            $stmtTotal->bindValue($chave, $valor, PDO::PARAM_INT);
        }
    }
 
    $stmtTotal->execute();
 
    $totalRegistos = $stmtTotal->fetch(PDO::FETCH_OBJ)->total;
 
    $totalPaginas = ceil($totalRegistos / $registosPorPagina);
 
    // Listas para os selects de filtros
    $listaTiposContrato  = $ligacao->query("SELECT id, tipo_contrato FROM tipo_contrato ORDER BY tipo_contrato")->fetchAll(PDO::FETCH_OBJ);
    $listaPeriodicidades = $ligacao->query("SELECT id, periodicidade FROM periodicidade ORDER BY periodicidade")->fetchAll(PDO::FETCH_OBJ);
    $listaEntidades      = $ligacao->query("SELECT DISTINCT entidade_responsavel FROM garantias_contratos ORDER BY entidade_responsavel")->fetchAll(PDO::FETCH_OBJ);
 
    $erro = '';
 
} catch (PDOException $err) {
    $erro = "Erro: " . $err->getMessage();
    $resultados = [];
    $totalPaginas = 0;
    $totalRegistos = 0;
    $listaTiposContrato = [];
    $listaPeriodicidades = [];
    $listaEntidades = [];
}
 
// Fecha a ligação
$ligacao = null;

?>


        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Garantias e Contratos</strong>
                </h2>
            </div>

            <hr>
            <!-- Área de sucesso -->
            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    Fornecedor inserido com sucesso!
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['atualizado'])): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    Fornecedor atualizado com sucesso!
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow mb-4 rounded-4">

                <div class="card-body" style="background-color: #fff4fb;">
                    <!-- Pesquisa -->
                    <form method="GET" action="" id="formFiltros">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white">
                                        <i class="fa-solid fa-magnifying-glass" style="color: #680447;"></i>
                                    </span>
                                    <input type="text"
                                        name="pesquisa"
                                        id="campoPesquisa"
                                        class="form-control"
                                        value="<?= htmlspecialchars($pesquisa) ?>"
                                        placeholder="Datas, entidade responsável, equipamento ...">
                                </div>
                            </div>
                        </div>

                    <!-- Filtros -->
                    <div class="p-3 rounded-4 bg-white shadow-sm">
                        <h6 class="fw-bold mb-3" style="color:#680447;">
                            <i class="fa-solid fa-sliders me-2"></i>Filtros avançados
                        </h6>
                        <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Contrato de manutenção</label>
                                    <select class="form-select" name="contrato">
                                        <option value="">Todos</option>
                                        <option value="sim" <?= ($filtroContrato === 'sim') ? 'selected' : '' ?>>Sim</option>
                                        <option value="nao" <?= ($filtroContrato === 'nao') ? 'selected' : '' ?>>Não</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tipo de contrato</label>
                                    <select class="form-select" name="tipo_contrato">
                                        <option value="0">Todos</option>
                                        <?php foreach ($listaTiposContrato as $opcao): ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroTipoContrato == $opcao->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->tipo_contrato) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Periodicidade</label>
                                    <select class="form-select" name="periodicidade">
                                        <option value="0">Todos</option>
                                        <?php foreach ($listaPeriodicidades as $opcao): ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroPeriodicidade == $opcao->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->periodicidade) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Entidade responsável</label>
                                    <select class="form-select" name="entidade">
                                        <option value="">Todos</option>
                                        <?php foreach ($listaEntidades as $opcao): ?>
                                            <option value="<?= htmlspecialchars($opcao->entidade_responsavel) ?>" <?= ($filtroEntidade === $opcao->entidade_responsavel) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->entidade_responsavel) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="?" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-rotate-left me-1"></i> Limpar
                                </a>

                                <button type="submit" class="btn text-white" style="background-color:#680447;">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Aplicar filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (!empty($erro)): ?>
                <p class="text-center text-danger"><?= $erro ?></p>
            <?php elseif (count($resultados) == 0): ?>
                <p class="text-muted">Não existem garantias|contratos registados.</p>
            <?php else: ?>
                <p class="text-muted">Consulte a tabela abaixo com os garantias|contratos registados.</p>
            <div class="card shadow rounded-4 border-0 p-3">
                <div class="alert border-0 shadow-sm py-2 px-3 mb-3"
                    style="background-color:#f8e8f3; color:#680447; width:fit-content;">
                    <i class="fa-solid fa-file me-2"></i>
                    <strong><?= $totalRegistos ?></strong>
                    garantias|contratos registados
                </div>
                <div class="table-responsive">
                    <table id="tabelaGarantias" class="table table-bordered table-hover align-middle text-center w-100">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Equipamento associado
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Garantia até
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Contrato de manutenção
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Entidade responsável
                                    </a>
                                </th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $garantia): ?>
                            <tr>
                                <td><?= htmlspecialchars($garantia->codigo_inventario) ?> — <?= htmlspecialchars($garantia->designacao_equipamento) ?></td>
                                <td><?= htmlspecialchars($garantia->data_fim) ?></td>
                                <td>
                                    <?php if ($garantia->contrato_manutencao): ?>
                                        <span style="font-size:13px; color:#680447; font-weight:500;">✓ Sim</span>
                                    <?php else: ?>
                                        <span style="font-size:13px; color:#888;">✗ Não</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($garantia->entidade_responsavel) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/ProjetoSIBDAS/Frontend/private/views/garantias e contratos/detalhes_garant.php?id=<?= aes_encrypt($garantia->id) ?>" class="btn-sm btn-acao"><i class="fa-solid fa-eye me-2"></i></a>
                                        <span class="mx-2 text-muted">|</span>
                                        <a href="/ProjetoSIBDAS/Frontend/private/views/garantias e contratos/editar_garant.php?id=<?= aes_encrypt($garantia->id) ?>" class="btn-sm btn-acao"><i class="fa-regular fa-pen-to-square me-2"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            $inicio = max(1, $paginaAtual - 2);
            $fim = min($totalPaginas, $paginaAtual + 2);
            ?>
 
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
 
                    <?php if ($paginaAtual > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=1#tabelaGarantias">
                                Primeira
                            </a>
                        </li>
 
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?>#tabelaGarantias">
                                Anterior
                            </a>
                        </li>
                    <?php endif; ?>
 
                    <?php for ($i = $inicio; $i <= $fim; $i++) : ?>
                        <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>#tabelaGarantias">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
 
                    <?php if ($paginaAtual < $totalPaginas) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?>#tabelaGarantias">
                                Seguinte
                            </a>
                        </li>
 
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $totalPaginas ?>#tabelaGarantias">
                                Última
                            </a>
                        </li>
                    <?php endif; ?>
 
                </ul>
            </nav>
        <?php endif; ?>
        </div>  
        
<!-- Custom JS -->
<script src="/ProjetoSIBDAS/Frontend/assets/js/1240811.js"></script>

<!-- Datatables -->
<script>
    // tradução para português
    $(document).ready(function() {
        $('#tabelaGarantias').DataTable({
            ordering: true,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false
        });
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>