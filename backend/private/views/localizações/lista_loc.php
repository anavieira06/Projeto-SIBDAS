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
$pesquisa        = isset($_GET['pesquisa'])  ? trim($_GET['pesquisa'])   : '';
$filtroEdificio  = isset($_GET['edificio'])  ? trim($_GET['edificio'])   : '';
$filtroPiso      = isset($_GET['piso'])      ? trim($_GET['piso'])       : '';
$filtroServico   = isset($_GET['servico'])   ? trim($_GET['servico'])    : '';
$filtroSala      = isset($_GET['sala'])      ? trim($_GET['sala'])       : '';

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
        $condicoes[] = "(l.edificio LIKE :pesquisa
            OR l.piso LIKE :pesquisa
            OR l.servico_depart LIKE :pesquisa
            OR l.sala_gabinete LIKE :pesquisa)";
        $parametros[':pesquisa'] = '%' . $pesquisa . '%';
    }

    if ($filtroEdificio !== '') {
        $condicoes[] = "l.edificio = :edificio";
        $parametros[':edificio'] = $filtroEdificio;
    }
 
    if ($filtroPiso !== '') {
        $condicoes[] = "l.piso = :piso";
        $parametros[':piso'] = $filtroPiso;
    }
 
    if ($filtroServico !== '') {
        $condicoes[] = "l.servico_depart = :servico";
        $parametros[':servico'] = $filtroServico;
    }
 
    if ($filtroSala !== '') {
        $condicoes[] = "l.sala_gabinete = :sala";
        $parametros[':sala'] = $filtroSala;
    }

    $whereSql = '';
    if (!empty($condicoes)) {
        $whereSql = ' WHERE ' . implode(' AND ', $condicoes);
    }

    $sql = "
       SELECT l.*
        FROM localizacoes l
        " . $whereSql . "
        ORDER BY l.edificio, l.piso, l.servico_depart, l.sala_gabinete
        LIMIT :limite OFFSET :offset
    ";

    
    $stmt = $ligacao->prepare($sql);

    foreach ($parametros as $chave => $valor) {
        $stmt->bindValue($chave, $valor, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limite', $registosPorPagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Contar total de fornecedores
    $sqlTotal = "
        SELECT COUNT(DISTINCT l.id) AS total
        FROM localizacoes l
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
    $listaEdificios  = $ligacao->query("SELECT DISTINCT edificio      FROM localizacoes ORDER BY edificio")     ->fetchAll(PDO::FETCH_OBJ);
    $listaPisos      = $ligacao->query("SELECT DISTINCT piso          FROM localizacoes ORDER BY piso")         ->fetchAll(PDO::FETCH_OBJ);
    $listaServicos   = $ligacao->query("SELECT DISTINCT servico_depart FROM localizacoes ORDER BY servico_depart")->fetchAll(PDO::FETCH_OBJ);
    $listaSalas      = $ligacao->query("SELECT DISTINCT sala_gabinete  FROM localizacoes ORDER BY sala_gabinete") ->fetchAll(PDO::FETCH_OBJ);
    
    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $totalPaginas = 0;
    $totalRegistos = 0;
    $listaEdificios = [];
    $listaPisos = [];
    $listaServicos = [];
    $listaSalas = [];
}

// Fecha a ligação
$ligacao = null;
?>

        

        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0 titulo-listagem" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Localizações</strong>
                </h2>
                <a href="/sibdas/1240811/medinventec/backend/private/views/localizações/novo_loc.php" class="btn ms-auto btn-novo" style="background-color: #680447; color: white;">
                    <i class="fa-solid fa-plus me-1"></i> Nova localização
                </a>
                <div class="ms-2 d-flex gap-2">
                    <a href="/sibdas/1240811/medinventec/backend/private/includes/exportar.php?tabela=localizacoes&formato=csv" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-file-csv me-1"></i> CSV</a>
                    <a href="/sibdas/1240811/medinventec/backend/private/includes/exportar.php?tabela=localizacoes&formato=json" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-file-code me-1"></i> JSON</a>
                    <a href="/sibdas/1240811/medinventec/backend/private/includes/exportar.php?tabela=localizacoes&formato=pdf" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="fa-solid fa-file-pdf me-1"></i> PDF</a>
                </div>
            </div>

            <hr>
            <!-- Área de sucesso -->
            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    Localização inserida com sucesso!
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['atualizado'])): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    Localização atualizada com sucesso!
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['desativado'])): ?>
                <div class="alert alert-warning d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Localização desativada com sucesso.
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

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Edifício</label>
                                        <select class="form-select" name="edificio">
                                        <option value="">Todos</option>
                                        <?php foreach ($listaEdificios as $opcao): ?>
                                            <option value="<?= htmlspecialchars($opcao->edificio) ?>" <?= ($filtroEdificio === $opcao->edificio) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->edificio) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Piso</label>
                                        <select class="form-select" name="piso">
                                        <option value="">Todos</option>
                                        <?php foreach ($listaPisos as $opcao): ?>
                                            <option value="<?= htmlspecialchars($opcao->piso) ?>" <?= ($filtroPiso === $opcao->piso) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->piso) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Serviço / Departamento</label>
                                        <select class="form-select" name="servico">
                                        <option value="">Todos</option>
                                        <?php foreach ($listaServicos as $opcao): ?>
                                            <option value="<?= htmlspecialchars($opcao->servico_depart) ?>" <?= ($filtroServico === $opcao->servico_depart) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->servico_depart) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Sala / Gabinete</label>
                                        <select class="form-select" name="sala">
                                        <option value="">Todos</option>
                                        <?php foreach ($listaSalas as $opcao): ?>
                                            <option value="<?= htmlspecialchars($opcao->sala_gabinete) ?>" <?= ($filtroSala === $opcao->sala_gabinete) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->sala_gabinete) ?>
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
                <p class="text-muted">Não existem localizações resgistadas.</p>
            <?php else: ?>
                <p class="text-muted">Consulte a tabela abaixo com as localizações resgistadas.</p>

            
            <div class="card shadow rounded-4 border-0 p-3">
                <div class="alert border-0 shadow-sm py-2 px-3 mb-3"
                    style="background-color:#f8e8f3; color:#680447; width:fit-content;">
                    <i class="fa-solid fa-location-dot me-2"></i>
                    <strong><?= $totalRegistos ?></strong>
                    localizações registadas
                </div>

                <div class="table-responsive">
                    <table id="tabelaLocalizacoes" class="table table-bordered table-hover align-middle text-center w-100">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Edifício
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Piso
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Serviço / Departamento
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Sala / Gabinete
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Ativa | Inativa
                                    </a>
                                </th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $localizacao): ?>
                            <tr>
                                <td><?= htmlspecialchars($localizacao->edificio) ?></td>
                                <td><?= htmlspecialchars($localizacao->piso) ?></td>
                                <td><?= htmlspecialchars($localizacao->servico_depart) ?></td>
                                <td><?= htmlspecialchars($localizacao->sala_gabinete) ?></td>
                                <td>
                                    <?php if ($localizacao->ativo == 1): ?>
                                        <span class="ativo-badge ativo-ativo">Ativo</span>
                                    <?php else: ?>
                                        <span class="ativo-badge ativo-inativo">Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="/sibdas/1240811/medinventec/backend/private/views/localizações/detalhes_loc.php?id=<?= aes_encrypt($localizacao->id) ?>" class=" btn-acao"><i class="fa-solid fa-eye me-2"></i></a>
                                        <?php if ($localizacao->ativo == 1): ?>
                                        <span class="mx-2 text-muted">|</span>
                                        <a href="/sibdas/1240811/medinventec/backend/private/views/localizações/editar_loc.php?id=<?= aes_encrypt($localizacao->id) ?>" class=" btn-acao"><i class="fa-regular fa-pen-to-square me-2"></i></a>
                                        <span class="mx-2 text-muted">|</span>
                                        <a href="#" class="btn-acao"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar"
                                        data-id="<?= aes_encrypt($localizacao->id) ?>"
                                        data-edificio="<?= htmlspecialchars($localizacao->edificio) ?>"
                                        data-piso="<?= htmlspecialchars($localizacao->piso) ?>"
                                        data-servico="<?= htmlspecialchars($localizacao->servico_depart) ?>"
                                        data-sala="<?= htmlspecialchars($localizacao->sala_gabinete) ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                        <?php else: ?>
                                        <span class="mx-2 text-muted">|</span>
                                        <a href="/sibdas/1240811/medinventec/backend/private/views/localizações/reativar_loc.php?id=<?= aes_encrypt($localizacao->id) ?>" class="btn-acao" title="Reativar localização">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </a>
                                        <?php endif; ?>
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
                            <a class="page-link" href="?pagina=1#tabelaLocalizacoes">
                                Primeira
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?>#tabelaLocalizacoes">
                                Anterior
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $inicio; $i <= $fim; $i++) : ?>
                        <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>#tabelaLocalizacoes">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($paginaAtual < $totalPaginas) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?>#tabelaLocalizacoes">
                                Seguinte
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $totalPaginas ?>#tabelaLocalizacoes">
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
                        <p>Tem a certeza que pretende desativar esta localização?</p>
 
                        <p><strong>Edifício:</strong> <span id="modalEdificio"></span></p>
                        <p><strong>Piso:</strong> <span id="modalPiso"></span></p>
                        <p><strong>Serviço / Departamento:</strong> <span id="modalServico"></span></p>
                        <p><strong>Sala / Gabinete:</strong> <span id="modalSala"></span></p>
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
        document.getElementById('modalEdificio').textContent = btn.getAttribute('data-edificio');
        document.getElementById('modalPiso').textContent    = btn.getAttribute('data-piso');
        document.getElementById('modalServico').textContent = btn.getAttribute('data-servico');
        document.getElementById('modalSala').textContent    = btn.getAttribute('data-sala');
        document.getElementById('btnConfirmarEliminar').href = '/sibdas/1240811/medinventec/backend/private/views/localizações/eliminar_loc.php?id=' + btn.getAttribute('data-id');
    });
</script>

        
<!-- Custom JS -->
<script src="/sibdas/1240811/medinventec/backend/assets/js/1240811.js"></script>

<!-- Datatables -->
<script>
    // tradução para português
    $(document).ready(function() {
        $('#tabelaLocalizacoes').DataTable({
            ordering: true,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false
        });
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>