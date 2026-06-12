<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
include '../../includes/header.php'; 
?>

<?php
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $resultados = $ligacao->query("
    SELECT
        e.*,
        cg.categoria_grupo AS categoria,
        es.estado,
        c.criticidade,
        l.servico_depart AS localizacao,
        GROUP_CONCAT(f.nome_empresa SEPARATOR ', ') AS fornecedores

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

    GROUP BY e.id
")->fetchAll(PDO::FETCH_OBJ);
    $erro ='';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
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
            <div class="alert alert-success text-center d-none" id="mensagemSucesso" role="alert">
                • Operação realizada com sucesso.
            </div>

            <div class="card border-0 shadow mb-4 rounded-4">

                <div class="card-body" style="background-color: #fff4fb;">
                    <!-- Pesquisa -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #680447;"></i>
                                </span>
                                <input type="text"
                                    class="form-control"
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
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                        <option>Ativo</option>
                                        <option>Inativo</option>
                                        <option>Em calibração</option>
                                        <option>Em quarentena</option>
                                        <option>Abatido</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Categoria</label>
                                    <select class="form-select">
                                        <option selected>Todas</option>
                                        <option>Monitorização</option>
                                        <option>Diagnóstico</option>
                                        <option>Suporte de vida</option>
                                        <option>Terapia</option>
                                        <option>Laboratório</option>
                                        <option>Esterilização</option>
                                        <option>Reabilitação</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Criticidade</label>
                                    <select class="form-select">
                                        <option selected>Todas</option>
                                        <option>Baixa</option>
                                        <option>Média</option>
                                        <option>Alta</option>
                                        <option>Suporte de vida</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Serviço / Departamento</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Fornecedor</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-rotate-left me-1"></i> Limpar
                                </button>

                                <button type="button" class="btn text-white" style="background-color:#680447;">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Aplicar filtros
                                </button>
                            </div>
                        </div>
                    </div>
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
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                                <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                                    <tr>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Código interno
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Designação
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Categoria / Grupo
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Marca
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th> 
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Modelo
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th> 
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Nº de série
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Fornecedor
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Serviço / Departamento
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Estado
                                                <i class="fa-solid fa-sort ms-1"></i>
                                            </a>
                                        </th> 
                                        <th>
                                            <a href="#" class="text-decoration-none" style="color: #fff;">
                                                Criticidade
                                                <i class="fa-solid fa-sort ms-1"></i>
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
                                                    <a href="/ProjetoSIBDAS/Frontend/private/views/equipamentos/editar.php?id=<?= $equipamento->id ?>" class="btn-sm btn-acao"><i class="fa-regular fa-pen-to-square me-2"></i></a>
                                                    <span class="mx-2 text-muted">|</span>
                                                    <a href="#" class="btn-sm btn-acao" data-bs-toggle="modal" data-bs-target="#modalEliminar"><i class="fa-solid fa-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                        </table>
                    </div>
                    <div class="alert border-0 shadow-sm py-2 px-3 mb-3"
                        style="background-color:#f8e8f3; color:#680447; width:fit-content;">

                        <i class="fa-solid fa-laptop me-2"></i>

                        <strong><?= count($resultados) ?></strong>
                        equipamentos registados

                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>  
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

                    <!-- Área de erros -->
                    <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                        • Erro
                    </div>
                </div>
            </div>
        </div>



<!-- Custom JS -->
<script src="/ProjetoSIBDAS/Frontend/assets/js/1240811.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>