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
$pesquisa        = isset($_GET['pesquisa'])   ? trim($_GET['pesquisa'])  : '';
$filtroTipoDoc   = isset($_GET['tipo_doc'])   ? (int) $_GET['tipo_doc'] : 0;
$filtroEquip     = isset($_GET['equipamento']) ? (int) $_GET['equipamento'] : 0;
$filtroForn      = isset($_GET['fornecedor']) ? (int) $_GET['fornecedor'] : 0;

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
        $condicoes[] = "(d.nome_doc LIKE :pesquisa
            OR d.data_doc LIKE :pesquisa
            OR td.tipo_doc LIKE :pesquisa
            OR e.codigo_inventario LIKE :pesquisa
            OR e.designacao_equipamento LIKE :pesquisa
            OR f.nome_empresa LIKE :pesquisa)";
        $parametros[':pesquisa'] = '%' . $pesquisa . '%';
    }
 
    if ($filtroTipoDoc > 0) {
        $condicoes[] = "d.tipo_doc_id = :tipo_doc";
        $parametros[':tipo_doc'] = $filtroTipoDoc;
    }
 
    if ($filtroEquip > 0) {
        $condicoes[] = "d.equipamento_id = :equipamento";
        $parametros[':equipamento'] = $filtroEquip;
    }
 
    if ($filtroForn > 0) {
        $condicoes[] = "d.fornecedor_id = :fornecedor";
        $parametros[':fornecedor'] = $filtroForn;
    }
 
    $whereSql = '';
    if (!empty($condicoes)) {
        $whereSql = ' WHERE ' . implode(' AND ', $condicoes);
    }
 
    $sql = "
        SELECT d.*, td.tipo_doc,
               e.codigo_inventario, e.designacao_equipamento, e.ativo,
               f.nome_empresa
        FROM documentos d
        LEFT JOIN tipo_doc td ON d.tipo_doc_id = td.id
        LEFT JOIN equipamentos e ON d.equipamento_id = e.id
        LEFT JOIN fornecedores f ON d.fornecedor_id = f.id
        " . $whereSql . "
        ORDER BY d.data_doc DESC, d.nome_doc
        LIMIT :limite OFFSET :offset
    ";
 
    $stmt = $ligacao->prepare($sql);
 
    foreach ($parametros as $chave => $valor) {
        if ($chave === ':pesquisa') {
            $stmt->bindValue($chave, $valor, PDO::PARAM_STR);
        } else {
            $stmt->bindValue($chave, $valor, PDO::PARAM_INT);
        }
    }
 
    $stmt->bindValue(':limite', $registosPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
 
    $stmt->execute();
 
    $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
 
    // Contar total de documentos
    $sqlTotal = "
        SELECT COUNT(DISTINCT d.id) AS total
        FROM documentos d
        LEFT JOIN tipo_doc td ON d.tipo_doc_id = td.id
        LEFT JOIN equipamentos e ON d.equipamento_id = e.id
        LEFT JOIN fornecedores f ON d.fornecedor_id = f.id
        " . $whereSql . "
    ";
 
    $stmtTotal = $ligacao->prepare($sqlTotal);
 
    foreach ($parametros as $chave => $valor) {
        if ($chave === ':pesquisa') {
            $stmtTotal->bindValue($chave, $valor, PDO::PARAM_STR);
        } else {
            $stmtTotal->bindValue($chave, $valor, PDO::PARAM_INT);
        }
    }
 
    $stmtTotal->execute();
 
    $totalRegistos = $stmtTotal->fetch(PDO::FETCH_OBJ)->total;
 
    $totalPaginas = ceil($totalRegistos / $registosPorPagina);
 
    // Listas para os selects de filtros
    $listaTiposDoc   = $ligacao->query("SELECT id, tipo_doc FROM tipo_doc ORDER BY tipo_doc")->fetchAll(PDO::FETCH_OBJ);
    $listaEquipamentos = $ligacao->query("SELECT id, codigo_inventario, designacao_equipamento FROM equipamentos ORDER BY codigo_inventario")->fetchAll(PDO::FETCH_OBJ);
    $listaFornecedores = $ligacao->query("SELECT id, nome_empresa FROM fornecedores ORDER BY nome_empresa")->fetchAll(PDO::FETCH_OBJ);
 
    $erro = '';
 
} catch (PDOException $err) {
    $erro = "Erro: " . $err->getMessage();
    $resultados = [];
    $totalPaginas = 0;
    $totalRegistos = 0;
    $listaTiposDoc = [];
    $listaEquipamentos = [];
    $listaFornecedores = [];
}
 
// Fecha a ligação
$ligacao = null;
?>


        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0 titulo-listagem" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Documentos</strong>
                </h2>
                <div class="ms-auto d-flex gap-2">
                    <a href="/sibdas/1240811/medinventec/backend/private/includes/exportar.php?tabela=documentos&formato=csv" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-file-csv me-1"></i> CSV</a>
                    <a href="/sibdas/1240811/medinventec/backend/private/includes/exportar.php?tabela=documentos&formato=json" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-file-code me-1"></i> JSON</a>
                    <a href="/sibdas/1240811/medinventec/backend/private/includes/exportar.php?tabela=documentos&formato=pdf" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="fa-solid fa-file-pdf me-1"></i> PDF</a>
                </div>
            </div>

            <hr>
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
                                        value="<?= htmlspecialchars($pesquisa) ?>">
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
                                        <label class="form-label fw-semibold">Tipo de documento</label>
                                        <select class="form-select" name="tipo_doc">
                                            <option value="0">Todos</option>
                                            <?php foreach ($listaTiposDoc as $opcao): ?>
                                                <option value="<?= $opcao->id ?>" <?= ($filtroTipoDoc == $opcao->id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($opcao->tipo_doc) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Equipamento associado</label>
                                        <select class="form-select" name="equipamento">
                                            <option value="0">Todos</option>
                                            <?php foreach ($listaEquipamentos as $opcao): ?>
                                                <option value="<?= $opcao->id ?>" <?= ($filtroEquip == $opcao->id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($opcao->codigo_inventario) ?> — <?= htmlspecialchars($opcao->designacao_equipamento) ?>
                                                </option>
                                            <?php endforeach; ?>
                                    </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Fornecedor associado</label>
                                        <select class="form-select" name="fornecedor">
                                            <option value="0">Todos</option>
                                            <?php foreach ($listaFornecedores as $opcao): ?>
                                                <option value="<?= $opcao->id ?>" <?= ($filtroForn == $opcao->id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($opcao->nome_empresa) ?>
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
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (!empty($erro)): ?>
                <p class="text-center text-danger"><?= $erro ?></p>
            <?php elseif (count($resultados) == 0): ?>
                <p class="text-muted">Não existem documentos registados.</p>
            <?php else: ?>
                <p class="text-muted">Consulte a tabela abaixo com os documentos registados.</p>

            <div class="card shadow rounded-4 border-0 p-3">
                <div class="alert border-0 shadow-sm py-2 px-3 mb-3"
                    style="background-color:#f8e8f3; color:#680447; width:fit-content;">
                    <i class="fa-solid fa-file me-2"></i>
                    <strong><?= $totalRegistos ?></strong>
                    documentos registados
                </div>

                <div class="table-responsive">
                    <table id="tabelaDocumentos" class="table table-bordered table-hover align-middle text-center w-100">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Tipo de documento
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Nome
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Data
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Equipamento associado
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Ativo | Inativo
                                    </a>
                                </th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $documentos): ?>
                                <tr>
                                    <td><?= htmlspecialchars($documentos->tipo_doc) ?></td>
                                    <td><?= htmlspecialchars($documentos->nome_doc) ?></td>
                                    <td><?= htmlspecialchars($documentos->data_doc) ?></td>
                                    <td><?= htmlspecialchars($documentos->codigo_inventario) ?> — <?= htmlspecialchars($documentos->designacao_equipamento) ?></td>
                                    <td>
                                        <?php if ($documentos->ativo == 1): ?>
                                            <span class="ativo-badge ativo-ativo">Ativo</span>
                                        <?php else: ?>
                                            <span class="ativo-badge ativo-inativo">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center gap-3">
                                            <a href="/sibdas/1240811/medinventec/backend/private/views/documentação/detalhes_doc.php?id=<?= aes_encrypt($documentos->id) ?>" class="btn-acao"><i class="fa-solid fa-eye me-2"></i></a>
                                            <span class="mx-2 text-muted">|</span>
                                            <a href="/sibdas/1240811/medinventec/backend/private/views/equipamentos/editar.php?id=<?= aes_encrypt($documentos->equipamento_id) ?>" class=" btn-acao"><i class="fa-regular fa-pen-to-square me-2"></i></a>
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
                            <a class="page-link" href="?pagina=1#tabelaDocumentos">
                                Primeira
                            </a>
                        </li>
 
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?>#tabelaDocumentos">
                                Anterior
                            </a>
                        </li>
                    <?php endif; ?>
 
                    <?php for ($i = $inicio; $i <= $fim; $i++) : ?>
                        <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>#tabelaDocumentos">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
 
                    <?php if ($paginaAtual < $totalPaginas) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?>#tabelaDocumentos">
                                Seguinte
                            </a>
                        </li>
 
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $totalPaginas ?>#tabelaDocumentos">
                                Última
                            </a>
                        </li>
                    <?php endif; ?>
 
                </ul>
            </nav>
        <?php endif; ?>
        </div>  


<!-- Custom JS -->
<script src="/sibdas/1240811/medinventec/backend/assets/js/1240811.js"></script>

<!-- Datatables -->
<script>
    // tradução para português
    $(document).ready(function() {
        $('#tabelaDocumentos').DataTable({
            ordering: true,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false
        });
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>