<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

// 1. Receber e desencriptar o ID
$idEncriptado = $_GET['id'] ?? null;
$id = aes_decrypt($idEncriptado);

// 2. Validar
if (!$id || !is_numeric($id)) {
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php');
    exit;
}

// 3. Buscar dados da BD
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    $stmt = $ligacao->prepare("
        SELECT e.*,
               cg.categoria_grupo,
               est.estado,
               cr.criticidade,
               te.tipo_entrada,
               l.edificio, l.piso, l.servico_depart, l.sala_gabinete,
               gc.data_inicio, gc.data_fim, gc.contrato_manutencao,
               gc.observacoes_garant,
               tc.tipo_contrato,
               p.periodicidade,
               gc.entidade_responsavel
        FROM equipamentos e
        LEFT JOIN categoria_grupo cg     ON e.categoria_grupo_id    = cg.id
        LEFT JOIN estado est             ON e.estado_id             = est.id
        LEFT JOIN criticidade cr         ON e.criticidade_id        = cr.id
        LEFT JOIN tipo_entrada te        ON e.tipo_entrada_id       = te.id
        LEFT JOIN localizacoes l         ON e.localizacao_id        = l.id
        LEFT JOIN garantias_contratos gc ON e.garantia_contrato_id  = gc.id
        LEFT JOIN tipo_contrato tc       ON gc.tipo_contrato_id     = tc.id
        LEFT JOIN periodicidade p        ON gc.periodicidade_id     = p.id
        WHERE e.id = :id
        LIMIT 1
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $equip = $stmt->fetch(PDO::FETCH_OBJ);
 
    if (!$equip) {
        header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php');
        exit;
    }
 
    // Buscar fornecedores associados
    $stmtForn = $ligacao->prepare("
        SELECT f.nome_empresa, f.nif, f.numero_telefonico, f.email,
               f.website, f.morada, f.pessoa_contacto, f.tel_pessoa_contacto,
               f.observacoes, tf.tipo_fornecedor
        FROM fornecedores f
        INNER JOIN equipamento_fornecedor ef ON ef.fornecedor_id = f.id
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        WHERE ef.equipamento_id = :id
    ");
    $stmtForn->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtForn->execute();
    $fornecedores = $stmtForn->fetchAll(PDO::FETCH_OBJ);
 
    // Buscar documentos associados
    $stmtDoc = $ligacao->prepare("
        SELECT d.nome_doc, d.data_doc, d.data_validade, d.ficheiro,
               td.tipo_doc,
               f.nome_empresa AS fornecedor_doc
        FROM documentos d
        LEFT JOIN tipo_doc td   ON d.tipo_doc_id   = td.id
        LEFT JOIN fornecedores f ON d.fornecedor_id = f.id
        WHERE d.equipamento_id = :id
        ORDER BY d.data_doc DESC
    ");
    $stmtDoc->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtDoc->execute();
    $documentos = $stmtDoc->fetchAll(PDO::FETCH_OBJ);
 
    // Buscar histórico de movimentações
    $stmtHist = $ligacao->prepare("
        SELECT h.tipo_alteracao, h.valor_anterior, h.valor_novo, h.data_alteracao,
               u.nome AS utilizador
        FROM historico_movimentacoes h
        LEFT JOIN utilizador u ON h.utilizador_id = u.id
        WHERE h.equipamento_id = :id
        ORDER BY h.data_alteracao DESC
    ");
    $stmtHist->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtHist->execute();
    $historico = $stmtHist->fetchAll(PDO::FETCH_OBJ);

    $ligacao = null;
 
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}

include __DIR__ . '/../../includes/header.php'; 
?>

<?php
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
?>
        

        <div class="container-fluid p-4">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes do Equipamento</strong>
                    <?php if ($equip->ativo == 1): ?>
                        <span class="badge bg-success">Ativo</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inativo</span>
                    <?php endif; ?>
                </h2>
            </div>

            <!-- Separadores -->
            <ul class="nav nav-tabs" id="equipamentoTabs" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#geral">
                        <i class="fa-solid fa-circle-info"></i>
                        Informação Geral
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#fornecedor">
                        <i class="fa-solid fa-building"></i>
                        Fornecedores
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#localizacao">
                        <i class="fa-solid fa-location-dot"></i>
                        Localizações
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#documentacao">
                        <i class="fa-solid fa-folder-open"></i>
                        Documentação
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#garantia">
                        <i class="fa-solid fa-file-signature"></i>
                        Garantia | Contrato
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#historico">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Histórico
                    </button>
                </li>

            </ul>

            <!-- Conteúdo dos separadores -->
            <div class="tab-content border border-top-0 p-4">

                <!-- Informação Geral -->
                <div class="tab-pane fade show active" id="geral">
                    <!-- Card principal -->
                    <div class="card shadow rounded-4 border-0 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <small class="text-muted">Código interno</small>
                                    <h5 class="fw-semibold mb-0"><?= htmlspecialchars($equip->codigo_inventario) ?></h5>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <small class="text-muted">Designação</small>
                                    <h5 class="fw-semibold mb-0"><?= htmlspecialchars($equip->designacao_equipamento) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards -->
                    <div class="row g-4">

                        <!-- Identificação -->
                        <div class="col-lg-6">
                            <div class="card shadow rounded-4 border-0 h-100">
                                <div class="card-body">
                                    <h5 class="mb-4" style="color:#680447;">
                                        <i class="fa-solid fa-barcode me-2"></i>
                                        Identificação
                                    </h5>
                                    <div class="mb-3">
                                        <small class="text-muted">Categoria / Grupo</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->categoria_grupo) ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Marca</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->marca) ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Modelo</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->modelo) ?></p>
                                    </div>
                                    <div>
                                        <small class="text-muted">Nº de série</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->numero_serie) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aquisição -->
                        <div class="col-lg-6">
                            <div class="card shadow rounded-4 border-0 h-100">
                                <div class="card-body">
                                    <h5 class="mb-4" style="color:#680447;">
                                        <i class="fa-solid fa-cart-shopping me-2"></i>
                                        Aquisição
                                    </h5>
                                    <div class="mb-3">
                                        <small class="text-muted">Data de aquisição</small>
                                        <p class="fw-semibold mb-0"><?= date('d/m/Y', strtotime($equip->data_aquisicao)) ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Ano de fabrico</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->ano_fabrico) ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Custo de aquisição</small>
                                        <p class="fw-semibold mb-0"><?= number_format($equip->custo_aquisicao, 2, ',', '.') ?> €</p>
                                    </div>
                                    <div>
                                        <small class="text-muted">Entrada por</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->tipo_entrada) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-lg-6">
                            <div class="card shadow rounded-4 border-0 h-100">
                                <div class="card-body">
                                    <h5 class="mb-4" style="color:#680447;">
                                        <i class="fa-solid fa-circle-check me-2"></i>
                                        Estado operacional
                                    </h5>
                                    <div class="mb-3">
                                        <small class="text-muted">Estado atual</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->estado) ?></p>
                                    </div>
                                    <div>
                                        <small class="text-muted">Criticidade</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->criticidade) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fabricante -->
                        <div class="col-lg-6">
                            <div class="card shadow rounded-4 border-0 h-100">
                                <div class="card-body">
                                    <h5 class="mb-4" style="color:#680447;">
                                        <i class="fa-solid fa-screwdriver-wrench me-2"></i>
                                        Fabricante
                                    </h5>
                                    <div>
                                        <small class="text-muted">Fabricante</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->fabricante) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="col-12">
                            <div class="card shadow rounded-4 border-0">
                                <div class="card-body">
                                    <h5 class="mb-4" style="color:#680447;">
                                        <i class="fa-solid fa-note-sticky me-2"></i>
                                        Observações
                                    </h5>
                                    <p class="mb-0"><?= htmlspecialchars($equip->observacoes ?? '—') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fornecedores -->
                <div class="tab-pane fade" id="fornecedor">
                    <div class="col-12">
                        <?php foreach ($fornecedores as $i => $forn): ?>
                        <?php if ($i > 0): ?><hr class="my-4"><?php endif; ?>
                        <!-- Card principal -->
                        <div class="card shadow rounded-4 border-0 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted">Nome da empresa</small>
                                        <h5 class="fw-semibold mb-0"><?= htmlspecialchars($forn->nome_empresa) ?></h5>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted">NIF</small>
                                        <h5 class="fw-semibold mb-0"><?= htmlspecialchars($forn->nif) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cards -->
                        <div class="row g-4">

                            <!-- Contactos -->
                            <div class="col-lg-6">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-phone me-2"></i>
                                            Contactos
                                        </h5>
                                        <div class="mb-3">
                                            <small class="text-muted">Número telefónico</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->numero_telefonico) ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Email</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->email) ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Website</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->website) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Morada -->
                            <div class="col-lg-6">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-location-dot me-2"></i>
                                            Morada
                                        </h5>
                                        <div>
                                            <small class="text-muted">Morada</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->morada) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pessoa de contacto -->
                            <div class="col-lg-6">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-user-tie me-2"></i>
                                            Pessoa de contacto
                                        </h5>
                                        <div class="mb-3">
                                            <small class="text-muted">Nome</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->pessoa_contacto) ?></p>
                                        </div>
                                        <div>
                                            <small class="text-muted">Telefone</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->tel_pessoa_contacto) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo de fornecedor -->
                            <div class="col-lg-6">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-building me-2"></i>
                                            Tipo de fornecedor
                                        </h5>
                                        <div>
                                            <small class="text-muted">Classificação</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($forn->tipo_fornecedor) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Localizações -->
                <div class="tab-pane fade" id="localizacao">
                    <div class="col-12">
                        <!-- Localização -->
                        <div class="card shadow rounded-4 border-0 mb-4">
                            <div class="card-body">

                                <div class="row g-4">

                                    <div class="col-md-6">
                                        <small class="text-muted">Edifício</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->edificio) ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <small class="text-muted">Piso</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->piso) ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <small class="text-muted">Serviço / Departamento</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->servico_depart) ?></p>
                                    </div>

                                    <div class="col-md-6">
                                        <small class="text-muted">Sala / Gabinete</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->sala_gabinete) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Documentação -->
                <div class="tab-pane fade" id="documentacao">
                    <div class="col-12">
                        <?php foreach ($documentos as $i => $doc): ?>
                        <?php if ($i > 0): ?><hr class="my-4"><?php endif; ?>
                        <!-- Card principal -->
                        <div class="card shadow rounded-4 border-0 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted">Nome do documento</small>
                                        <h5 class="fw-semibold mb-0"><?= htmlspecialchars($doc->nome_doc) ?></h5>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted">Tipo de documento</small>
                                        <h5 class="fw-semibold mb-0"><?= htmlspecialchars($doc->tipo_doc) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cards -->
                        <div class="row g-4">

                            <!-- Datas -->
                            <div class="col-lg-6">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-calendar-days me-2"></i>
                                            Datas
                                        </h5>

                                        <div class="mb-3">
                                            <small class="text-muted">Data do documento</small>
                                            <p class="fw-semibold mb-0"><?= date('d/m/Y', strtotime($doc->data_doc)) ?></p>
                                        </div>

                                        <div>
                                            <small class="text-muted">Data de validade</small>
                                            <p class="fw-semibold mb-0"><?= $doc->data_validade ? date('d/m/Y', strtotime($doc->data_validade)) : '—' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Associações -->
                            <div class="col-lg-6">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-link me-2"></i>
                                            Associações
                                        </h5>

                                        <div class="mb-3">
                                            <small class="text-muted">Equipamento associado</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->codigo_inventario) ?> — <?= htmlspecialchars($equip->designacao_equipamento) ?></p>
                                        </div>

                                        <div>
                                            <small class="text-muted">Fornecedor associado</small>
                                            <p class="fw-semibold mb-0"><?= !empty($fornecedores) ? htmlspecialchars($fornecedores[0]->nome_empresa) : '—' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ficheiro -->
                            <div class="col-lg-6 mx-auto">
                                <div class="card shadow rounded-4 border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="mb-4" style="color:#680447;">
                                            <i class="fa-solid fa-paperclip me-2"></i>
                                            Ficheiro
                                        </h5>
 
                                        <div class="mb-3">
                                            <small class="text-muted">Nome do ficheiro</small>
                                            <p class="fw-semibold mb-0"><?= htmlspecialchars($doc->ficheiro ?? '—') ?></p>
                                        </div>
                                        <?php if ($doc->ficheiro): ?>
                                        <div class="mb-3">
                                            <small class="text-muted">Abrir ficheiro</small>
                                            <p class="fw-semibold mb-0">
                                                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/uploads/<?= htmlspecialchars($doc->ficheiro) ?>" target="_blank" style="color:#680447;">
                                                    <i class="fa-solid fa-download me-1"></i> Abrir / Descarregar
                                                </a>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Garantias -->
                <div class="tab-pane fade" id="garantia">
                    <div class="col-12">
                        <!-- Card principal -->
                        <div class="card shadow rounded-4 border-0 mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted">Data de início de Garantia</small>
                                        <h5 class="fw-semibold mb-0"><?= date('d/m/Y', strtotime($equip->data_inicio))?></h5>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <small class="text-muted">Data de fim de Garantia</small>
                                        <h5 class="fw-semibold mb-0"><?= date('d/m/Y', strtotime($equip->data_fim))?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow rounded-4 border-0 h-100">
                            <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">Contrato de manutenção</small>
                                        <p class="fw-semibold mb-0">
                                            <?php if ($equip->contrato_manutencao): ?>
                                                <span style="font-size:13px; color:#680447; font-weight:500;">✓ Sim</span>
                                            <?php else: ?>
                                                <span style="font-size:13px; color:#888;">✗ Não</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Tipo de contrato</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->tipo_contrato ?? '—') ?></p>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Periodicidade</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->periodicidade ?? '—') ?></p>
                                    </div>

                                    <div>
                                        <small class="text-muted">Entidade responsável</small>
                                        <p class="fw-semibold mb-0"><?= htmlspecialchars($equip->entidade_responsavel ?? '—') ?></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Observações -->
                        <div class="card shadow rounded-4 border-0 mt-4">
                            <div class="card-body">
                                <h5 class="mb-4" style="color:#680447;">
                                    <i class="fa-solid fa-note-sticky me-2"></i>
                                    Observações
                                </h5>
                                <p class="mb-0"><?= htmlspecialchars($equip->observacoes_garant ?? '—') ?></p>
                            </div>
                        </div>
                    </div>
                

                    <!-- Histórico -->
                    <div class="tab-pane fade" id="historico">
                        <?php if (empty($historico)): ?>
                            <p class="text-muted">Nenhuma movimentação registada.</p>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Tipo de alteração</th>
                                        <th>Valor anterior</th>
                                        <th>Novo valor</th>
                                        <th>Data</th>
                                        <th>Utilizador</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historico as $h): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($h->tipo_alteracao) ?></td>
                                        <td><?= htmlspecialchars($h->valor_anterior ?? '—') ?></td>
                                        <td><?= htmlspecialchars($h->valor_novo ?? '—') ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($h->data_alteracao)) ?></td>
                                        <td><?= htmlspecialchars($h->utilizador ?? '—') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Botoão -->
            <div class="d-flex justify-content-end gap-2 mt-4 me-3 mb-3">
                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>



<?php include __DIR__ . '/../../includes/footer.php'; ?>