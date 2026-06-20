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
$pesquisa          = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';
$filtroEmpresa = isset($_GET['empresa']) ? (int) $_GET['empresa'] : 0;
$filtroTipoForn = isset($_GET['tipo']) ? (int) $_GET['tipo'] : 0;


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
        $condicoes[] = "(f.nome_empresa LIKE :pesquisa
            OR f.nif LIKE :pesquisa
            OR f.numero_telefonico LIKE :pesquisa
            OR f.email LIKE :pesquisa
            OR tf.tipo_fornecedor LIKE :pesquisa)";
        $parametros[':pesquisa'] = '%' . $pesquisa . '%';
    }

    if ($filtroEmpresa > 0) {
        $condicoes[] = "f.id = :empresa";
        $parametros[':empresa'] = $filtroEmpresa;
    }

    if ($filtroTipoForn > 0) {
        $condicoes[] = "f.tipo_fornecedor_id = :tipo_fornecedor";
        $parametros[':tipo_fornecedor'] = $filtroTipoForn;
    }

    $whereSql = '';
    if (!empty($condicoes)) {
        $whereSql = ' WHERE ' . implode(' AND ', $condicoes);
    }

    $sql = "
       SELECT f.*, tf.tipo_fornecedor
        FROM fornecedores f
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        " . $whereSql . "
        ORDER BY f.nome_empresa
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

    // Contar total de fornecedores
    $sqlTotal = "
        SELECT COUNT(DISTINCT f.id) AS total
        FROM fornecedores f
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
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
    $listaNomeEmpresas    = $ligacao->query("SELECT id, nome_empresa FROM fornecedores ORDER BY nome_empresa")->fetchAll(PDO::FETCH_OBJ);
    $listaTipoFornecedores  = $ligacao->query("SELECT id, tipo_fornecedor FROM tipo_fornecedor ORDER BY tipo_fornecedor")->fetchAll(PDO::FETCH_OBJ);
    
    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $totalPaginas = 0;
    $totalRegistos = 0;
    $listaNomeEmpresas = [];
    $listaTipoFornecedores = [];
    
}

// Fecha a ligação
$ligacao = null;
?>

        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Fornecedores</strong>
                </h2>
                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/novo_forn.php" class="btn ms-auto btn-novo" style="background-color: #680447; color: white;">
                    <i class="fa-solid fa-plus me-1"></i> Novo fornecedor
                </a>
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
            <?php if (isset($_GET['desativado'])): ?>
                <div class="alert alert-warning d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Fornecedor desativado com sucesso.
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
                                        placeholder="NIF, contacto, website, pessoa de contacto ...">
                                </div>
                            </div>
                        </div>

                        <!-- Filtros -->
                        <div class="p-3 rounded-4 bg-white shadow-sm">
                            <h6 class="fw-bold mb-3" style="color:#680447;">
                                <i class="fa-solid fa-sliders me-2"></i>Filtros avançados
                            </h6>
                            <div class="row g-3 mb-4">

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nome da empresa</label>
                                        <select class="form-select" name="empresa">
                                            <option value="0">Todos</option>
                                            <?php foreach ($listaNomeEmpresas as $opcao): ?>
                                                <option value="<?= $opcao->id ?>" <?= ($filtroEmpresa == $opcao->id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($opcao->nome_empresa) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tipo de fornecedor</label>
                                        <select class="form-select" name="tipo">
                                            <option value="0">Todos</option>
                                            <?php foreach ($listaTipoFornecedores as $opcao): ?>
                                                <option value="<?= $opcao->id ?>" <?= ($filtroTipoForn == $opcao->id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($opcao->tipo_fornecedor) ?>
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
                <p class="text-muted">Não existem fornecedores registados.</p>
            <?php else: ?>
                <p class="text-muted">Consulte a tabela abaixo com os fornecedores registados.</p>

            <div class="card shadow rounded-4 border-0 p-3">

                <div class="alert border-0 shadow-sm py-2 px-3 mb-3"
                    style="background-color:#f8e8f3; color:#680447; width:fit-content;">
                    <i class="fa-solid fa-building me-2"></i>
                    <strong><?= $totalRegistos ?></strong>
                    fornecedores registados
                </div>

                <div class="table-responsive">
                    <table id="tabelaFornecedores" class="table table-bordered table-hover align-middle text-center w-100">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Empresa
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        NIF
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Contacto telefónico
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Email
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Tipo de fornecedor
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
                            <?php foreach ($resultados as $fornecedor): ?>
                            <tr>
                                <td><?= $fornecedor->nome_empresa ?></td>
                                <td><?= $fornecedor->nif ?></td>
                                <td><?= $fornecedor->numero_telefonico ?></td>
                                <td><?= $fornecedor->email ?></td>
                                <td><?= $fornecedor->tipo_fornecedor ?></td>
                                <td>
                                    <?php if ($fornecedor->ativo == 1): ?>
                                        <span class="ativo-badge ativo-ativo">Ativo</span>
                                    <?php else: ?>
                                        <span class="ativo-badge ativo-inativo">Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/detalhes_forn.php?id=<?= aes_encrypt($fornecedor->id) ?>" class="btn-sm btn-acao"><i class="fa-solid fa-eye me-2"></i></a>
                                        <span class="mx-2 text-muted">|</span>
                                        <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/editar_forn.php?id=<?= aes_encrypt($fornecedor->id) ?>" class="btn-sm btn-acao"><i class="fa-regular fa-pen-to-square me-2"></i></a>
                                        <span class="mx-2 text-muted">|</span>
                                        <a href="#" class="btn-sm btn-acao"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar"
                                        data-id="<?= aes_encrypt($fornecedor->id) ?>"
                                        data-empresa="<?= htmlspecialchars($fornecedor->nome_empresa) ?>"
                                        data-contacto="<?= htmlspecialchars($fornecedor->numero_telefonico) ?>"
                                        data-tipo="<?= htmlspecialchars($fornecedor->tipo_fornecedor) ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
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
                            <a class="page-link" href="?pagina=1#tabelaFornecedores">
                                Primeira
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?>#tabelaFornecedores">
                                Anterior
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $inicio; $i <= $fim; $i++) : ?>
                        <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>#tabelaFornecedores">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($paginaAtual < $totalPaginas) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?>#tabelaFornecedores">
                                Seguinte
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $totalPaginas ?>#tabelaFornecedores">
                                Última
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        <?php endif; ?>

        </div> 

        <div class="modal fade" id="modalEliminar" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4">
 
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#680447;">
                            Confirmar desativação
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
 
                    <div class="modal-body">
                        <p>Tem a certeza que pretende desativar este fornecedor?</p>
 
                        <p><strong>Empresa:</strong> <span id="modalEmpresa"></span></p>
                        <p><strong>Contacto telefónico:</strong> <span id="modalContacto"></span></p>
                        <p><strong>Tipo de fornecedor:</strong> <span id="modalFornecedor"></span></p>
                    </div>
 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
 
                        <a href="#" class="btn btn-danger" id="btnConfirmarEliminar">
                            Desativar
                        </a>
                    </div>
 
                </div>
            </div>
        </div>

<script>
    document.getElementById('modalEliminar').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('modalEmpresa').textContent   = btn.getAttribute('data-empresa');
        document.getElementById('modalContacto').textContent  = btn.getAttribute('data-contacto');
        document.getElementById('modalFornecedor').textContent = btn.getAttribute('data-tipo');
        document.getElementById('btnConfirmarEliminar').href  = '/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/eliminar_forn.php?id=' + btn.getAttribute('data-id');
    });
</script>
        
<!-- Custom JS -->
<script src="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECassets/js/1240811.js"></script>

<!-- Datatables -->
<script>
    // tradução para português
    $(document).ready(function() {
        $('#tabelaFornecedores').DataTable({
            ordering: true,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false
        });
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>