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
$filtroEstado      = isset($_GET['estado']) ? (int) $_GET['estado'] : 0;
$filtroCategoria   = isset($_GET['categoria']) ? (int) $_GET['categoria'] : 0;
$filtroCriticidade = isset($_GET['criticidade']) ? (int) $_GET['criticidade'] : 0;
$filtroLocalizacao = isset($_GET['localizacao']) ? (int) $_GET['localizacao'] : 0;
$filtroFornecedor  = isset($_GET['fornecedor']) ? (int) $_GET['fornecedor'] : 0;

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
        $condicoes[] = "(e.codigo_inventario LIKE :pesquisa
            OR e.designacao_equipamento LIKE :pesquisa
            OR e.marca LIKE :pesquisa
            OR e.modelo LIKE :pesquisa
            OR e.numero_serie LIKE :pesquisa)";
        $parametros[':pesquisa'] = '%' . $pesquisa . '%';
    }

    if ($filtroEstado > 0) {
        $condicoes[] = "e.estado_id = :estado";
        $parametros[':estado'] = $filtroEstado;
    }

    if ($filtroCategoria > 0) {
        $condicoes[] = "e.categoria_grupo_id = :categoria";
        $parametros[':categoria'] = $filtroCategoria;
    }

    if ($filtroCriticidade > 0) {
        $condicoes[] = "e.criticidade_id = :criticidade";
        $parametros[':criticidade'] = $filtroCriticidade;
    }

    if ($filtroLocalizacao > 0) {
        $condicoes[] = "e.localizacao_id = :localizacao";
        $parametros[':localizacao'] = $filtroLocalizacao;
    }

    if ($filtroFornecedor > 0) {
        $condicoes[] = "ef.fornecedor_id = :fornecedor";
        $parametros[':fornecedor'] = $filtroFornecedor;
    }

    $whereSql = '';
    if (!empty($condicoes)) {
        $whereSql = ' WHERE ' . implode(' AND ', $condicoes);
    }

    $sql = "
        SELECT
            e.*,
            cg.categoria_grupo AS categoria,
            es.estado,
            c.criticidade,
            l.servico_depart AS localizacao,
            GROUP_CONCAT(f.nome_empresa SEPARATOR '<br>') AS fornecedores

        FROM equipamentos e

        LEFT JOIN categoria_grupo cg
            ON e.categoria_grupo_id = cg.id

        LEFT JOIN estado es
            ON e.estado_id = es.id

        LEFT JOIN criticidade c
            ON e.criticidade_id = c.id

        LEFT JOIN localizacoes l
            ON e.localizacao_id = l.id

        LEFT JOIN equipamento_fornecedor ef
            ON e.id = ef.equipamento_id

        LEFT JOIN fornecedores f
            ON ef.fornecedor_id = f.id

        " . $whereSql . "

        GROUP BY e.id

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

    // Contar total de equipamentos (respeitando os filtros)
    $sqlTotal = "
        SELECT COUNT(DISTINCT e.id) AS total
        FROM equipamentos e
        LEFT JOIN equipamento_fornecedor ef
            ON e.id = ef.equipamento_id
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
    $listaEstados     = $ligacao->query("SELECT id, estado FROM estado ORDER BY estado")->fetchAll(PDO::FETCH_OBJ);
    $listaCategorias  = $ligacao->query("SELECT id, categoria_grupo FROM categoria_grupo ORDER BY categoria_grupo")->fetchAll(PDO::FETCH_OBJ);
    $listaCriticidade = $ligacao->query("SELECT id, criticidade FROM criticidade ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    $listaLocalizacoes = $ligacao->query("SELECT id, servico_depart FROM localizacoes ORDER BY servico_depart")->fetchAll(PDO::FETCH_OBJ);
    $listaFornecedores = $ligacao->query("SELECT id, nome_empresa FROM fornecedores ORDER BY nome_empresa")->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

} catch (PDOException $err) {

    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $totalPaginas = 0;
    $totalRegistos = 0;
    $listaEstados = [];
    $listaCategorias = [];
    $listaCriticidade = [];
    $listaLocalizacoes = [];
    $listaFornecedores = [];
}


// Fecha a ligação
$ligacao = null;
?>
        

        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Equipamentos</strong>
                </h2>
                <a href="/ProjetoSIBDAS/Frontend/private/views/equipamentos/novo.php" class="btn ms-auto btn-novo" style="background-color: #680447; color: white;">
                    <i class="fa-solid fa-plus me-1"></i> Novo equipamento
                </a>
            </div>

            <hr>
            <!-- Área de sucesso -->
            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    Equipamento inserido com sucesso!
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['atualizado'])): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mx-4 mt-3" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    Equipamento atualizado com sucesso!
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
                                    placeholder="Código, designação, marca, modelo ...">
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
                                    <label class="form-label fw-semibold">Estado</label>
                                    <select class="form-select" name="estado">
                                        <option value="0">Todos</option>
                                        <?php foreach ($listaEstados as $opcao) : ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroEstado == $opcao->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->estado) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Categoria</label>
                                    <select class="form-select" name="categoria">
                                        <option value="0">Todas</option>
                                        <?php foreach ($listaCategorias as $opcao) : ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroCategoria == $opcao->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->categoria_grupo) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Criticidade</label>
                                    <select class="form-select" name="criticidade">
                                        <option value="0">Todas</option>
                                        <?php foreach ($listaCriticidade as $opcao) : ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroCriticidade == $opcao->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->criticidade) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Serviço / Departamento</label>
                                    <select class="form-select" name="localizacao">
                                        <option value="0">Todos</option>
                                        <?php foreach ($listaLocalizacoes as $opcao) : ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroLocalizacao == $opcao->id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($opcao->servico_depart) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Fornecedor</label>
                                    <select class="form-select" name="fornecedor">
                                        <option value="0">Todos</option>
                                        <?php foreach ($listaFornecedores as $opcao) : ?>
                                            <option value="<?= $opcao->id ?>" <?= ($filtroFornecedor == $opcao->id) ? 'selected' : '' ?>>
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
            
            <?php if (!empty($erro)) : ?>
                <p class="text-center text-danger"><?= $erro ?></p>

            <?php else : ?>
                <?php if (count($resultados) == 0) : ?>
                    <p class="text-muted">Não existem equipamentos registados.</p>
                <?php else : ?>
                    <p class="text-muted">Consulte a tabela abaixo com os equipamentos registados.</p>

                <div class="card shadow rounded-4 border-0 p-3">
                    <div class="alert border-0 shadow-sm py-2 px-3 mb-3"
                        style="background-color:#f8e8f3; color:#680447; width:fit-content;">

                        <i class="fa-solid fa-laptop me-2"></i>

                        <strong><?= $totalRegistos ?></strong>
                        equipamentos registados

                    </div>
                    <div class="table-responsive">
                        <table id="tabelaEquipamentos" class="table table-bordered table-hover align-middle text-center w-100">
                                <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                                    <tr>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Código interno
                                                
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Designação
                                                
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Categoria / Grupo
                                                
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Marca
                                                
                                            </a>
                                        </th> 
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Modelo
                                                
                                            </a>
                                        </th> 
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Nº de série
                                                
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Fornecedor
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Serviço / Departamento
                                                
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Estado
                                                
                                            </a>
                                        </th> 
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Criticidade
                                                
                                            </a>
                                        </th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultados as $equipamento) : ?>

                                        <tr>
                                            <td><?= $equipamento->codigo_inventario ?></td>
                                            <td><?= $equipamento->designacao_equipamento ?></td>
                                            <td><?= $equipamento->categoria ?></td>
                                            <td><?= $equipamento->marca ?></td>
                                            <td><?= $equipamento->modelo ?></td>
                                            <td><?= $equipamento->numero_serie ?></td>
                                            <td><?= $equipamento->fornecedores ?></td>
                                            <td><?= $equipamento->localizacao ?></td>
                                            <td><?= $equipamento->estado ?></td>

                                            <?php
                                            $criticidadeClasse = strtolower($equipamento->criticidade);
                                            $criticidadeClasse = str_replace(' ', '-', $criticidadeClasse);
                                            $criticidadeClasse = str_replace('é', 'e', $criticidadeClasse);
                                            ?>

                                            <td>
                                                <span class="criticidade-badge criticidade-<?= $criticidadeClasse ?>">
                                                    <?= $equipamento->criticidade ?>
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <a href="/ProjetoSIBDAS/Frontend/private/views/equipamentos/detalhes.php?id=<?= $equipamento->id ?>"  class="btn-sm btn-acao"><i class="fa-solid fa-eye me-2"></i></a>
                                                    <span class="mx-2 text-muted">|</span>
                                                    <a href="/ProjetoSIBDAS/Frontend/private/views/equipamentos/editar.php?id=<?= aes_encrypt($equipamento->id) ?>" class="btn-sm btn-acao"><i class="fa-regular fa-pen-to-square me-2"></i></a>
                                                    <span class="mx-2 text-muted">|</span>
                                                    <a href="#" class="btn-sm btn-acao" data-bs-toggle="modal" data-bs-target="#modalEliminar"><i class="fa-solid fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>  
        <?php
        $inicio = max(1, $paginaAtual - 2);
        $fim = min($totalPaginas, $paginaAtual + 2);
        ?>

        <nav class="mt-4">
            <ul class="pagination justify-content-center">

                <?php if ($paginaAtual > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=1#tabelaEquipamentos">
                            Primeira
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $paginaAtual - 1 ?>#tabelaEquipamentos">
                            Anterior
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = $inicio; $i <= $fim; $i++) : ?>
                    <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>#tabelaEquipamentos">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($paginaAtual < $totalPaginas) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $paginaAtual + 1 ?>#tabelaEquipamentos">
                            Seguinte
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $totalPaginas ?>#tabelaEquipamentos">
                            Última
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
        <div class="modal fade" id="modalEliminar" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered"> <!-- Cria uma pequena janela centrada -->
                <div class="modal-content rounded-4">

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#680447;">
                            Confirmar eliminação
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Tem a certeza que pretende eliminar este equipamento?</p>

                        <p><strong>Código:</strong> <span id="modalCodigo"></span></p>
                        <p><strong>Designação:</strong> <span id="modalDesignacao"></span></p>
                        <p><strong>Marca:</strong> <span id="modalMarca"></span></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="button" class="btn btn-danger" id="btnConfirmarEliminar" data-bs-dismiss="modal">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>



<!-- Custom JS -->
<script src="/ProjetoSIBDAS/Frontend/assets/js/1240811.js"></script>

<!-- Datatables -->
<script>
    // tradução para português
    $(document).ready(function() {
        $('#tabelaEquipamentos').DataTable({
            ordering: true,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false
        });
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>