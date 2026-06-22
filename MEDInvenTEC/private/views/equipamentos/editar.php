<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
require_once __DIR__ . '/../../includes/validacoes.php';

if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . '/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/public/login.php');
    exit;
}

// Recolher o ID do equipamento da URL
$idEquipamentoEncriptado = $_GET['id'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncriptado);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php');
    exit;
}


// --------------------------------------------------------------------
// PROCESSAR FORMULÁRIO (POST)
// --------------------------------------------------------------------
$erro  = "";
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Recolher dados
    $codigo          = $_POST["codigo_inventario"]      ?? "";
    $categoria       = $_POST["categoria_grupo"]        ?? "";
    $designacao      = $_POST["designacao_equipamento"] ?? "";
    $marca           = $_POST["marca"]                  ?? "";
    $modelo          = $_POST["modelo"]                 ?? "";
    $numero_serie    = $_POST["numero_serie"]           ?? "";
    $fabricante      = $_POST["fabricante"]             ?? "";
    $data_aquisicao  = $_POST["data_aquisicao"]         ?? "";
    $ano_fabrico     = $_POST["ano_fabrico"]            ?? "";
    $custo_aquisicao = $_POST["custo_aquisicao"]        ?? "";
    $tipo_entrada    = $_POST["tipo_entrada"]           ?? "";
    $estado          = $_POST["estado"]                 ?? "";
    $criticidade     = $_POST["criticidade_id"]         ?? "";
    $observacoes     = $_POST["observacoes"]            ?? "";
    $fornecedor      = $_POST["fornecedor_id"]          ?? [];
    $localizacao     = $_POST["localizacao_id"]         ?? "";
    $tipo_doc        = $_POST["tipo_doc"]               ?? [];
    $nome_doc        = $_POST["nome_doc"]               ?? [];
    $data_doc        = $_POST["data_doc"]               ?? [];
    $data_validade   = $_POST["data_validade"]          ?? [];
    $fornecedor_doc  = $_POST["fornecedor_doc_id"]      ?? [];
    $ficheiro        = $_FILES["ficheiro"]              ?? [];
    $data_inicio     = $_POST["data_inicio"]            ?? "";
    $data_fim        = $_POST["data_fim"]               ?? "";
    $contrato        = $_POST["contrato_manutencao"]    ?? "";
    $tipo_contrato   = $_POST["tipo_contrato"]          ?? "";
    $periodicidade   = $_POST["periodicidade"]          ?? "";
    $entidade        = $_POST["entidade_responsavel"]   ?? "";
    $obs_garantia    = $_POST["observacoes_garant"]     ?? "";

    $docs = [];
        if (!empty($tipo_doc)) {
            foreach ($tipo_doc as $i => $t) {
                $docs[] = [
                    'tipo'          => $t,
                    'nome'          => $nome_doc[$i]      ?? '',
                    'data'          => $data_doc[$i]       ?? '',
                    'data_validade' => $data_validade[$i]  ?? '',
                    'fornecedor'    => $fornecedor_doc[$i] ?? '',
                ];
            }
        }

    // 2. Validar os dados
    $erros = validar_equipamento([
        'codigo'          => $codigo,
        'categoria'       => $categoria,
        'designacao'      => $designacao,
        'marca'           => $marca,
        'modelo'          => $modelo,
        'numero_serie'    => $numero_serie,
        'fabricante'      => $fabricante,
        'data_aquisicao'  => $data_aquisicao,
        'ano_fabrico'     => $ano_fabrico,
        'custo_aquisicao' => $custo_aquisicao,
        'tipo_entrada'    => $tipo_entrada,
        'estado'          => $estado,
        'criticidade'     => $criticidade,
        'fornecedor'      => $fornecedor,
        'localizacao'     => $localizacao,
        'tipo_doc'        => $tipo_doc,
        'nome_doc'        => $nome_doc,
        'data_doc'        => $data_doc,
        'fornecedor_doc'  => $fornecedor_doc,
        'ficheiro'        => $ficheiro,
        'data_inicio'     => $data_inicio,
        'data_fim'        => $data_fim,
        'contrato'        => $contrato,
        'entidade'        => $entidade,
    ]);

    // 3. Normalizar
    if (empty($erros)) {
        $designacao = ucwords(strtolower($designacao));
        $marca      = ucwords(strtolower($marca));
        $modelo     = ucwords(strtolower($modelo));
        $fabricante = ucwords(strtolower($fabricante));
        $entidade   = ucwords(strtolower($entidade));
    }

    // 4. Atualizar na BD
    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Obter IDs
            $stmtEstado = $ligacao->prepare("SELECT id FROM estado WHERE estado = :estado LIMIT 1");
            $stmtEstado->execute([':estado' => $estado]);
            $estadoId = $stmtEstado->fetchColumn();

            $stmtCategoria = $ligacao->prepare("SELECT id FROM categoria_grupo WHERE categoria_grupo = :cat LIMIT 1");
            $stmtCategoria->execute([':cat' => $categoria]);
            $categoriaId = $stmtCategoria->fetchColumn();

            $stmtTipoEntrada = $ligacao->prepare("SELECT id FROM tipo_entrada WHERE tipo_entrada = :tipo LIMIT 1");
            $stmtTipoEntrada->execute([':tipo' => $tipo_entrada]);
            $tipoEntradaId = $stmtTipoEntrada->fetchColumn();

            // Buscar dados atuais para comparar
            $stmtAtual = $ligacao->prepare("
                SELECT e.estado_id, e.localizacao_id, e.criticidade_id,
                       est.estado, l.servico_depart, c.criticidade
                FROM equipamentos e
                INNER JOIN estado est ON e.estado_id = est.id
                INNER JOIN localizacoes l ON e.localizacao_id = l.id
                INNER JOIN criticidade c ON e.criticidade_id = c.id
                WHERE e.id = :id
            ");
            $stmtAtual->execute([':id' => $idEquipamento]);
            $atual = $stmtAtual->fetch(PDO::FETCH_OBJ);
 
            $utilizadorId = $_SESSION['perfil_id'] ?? null;
 
            // Buscar nome da nova localização
            $stmtNovaLoc = $ligacao->prepare("SELECT servico_depart FROM localizacoes WHERE id = :id");
            $stmtNovaLoc->execute([':id' => $localizacao]);
            $novaLoc = $stmtNovaLoc->fetchColumn();
 
            // Buscar nome da nova criticidade
            $stmtNovaCrit = $ligacao->prepare("SELECT criticidade FROM criticidade WHERE id = :id");
            $stmtNovaCrit->execute([':id' => $criticidade]);
            $novaCrit = $stmtNovaCrit->fetchColumn();
 
            $stmtHist = $ligacao->prepare("INSERT INTO historico_movimentacoes (equipamento_id, utilizador_id, tipo_alteracao, valor_anterior, valor_novo) VALUES (:eq_id, :user_id, :tipo, :anterior, :novo)");
 
            // Registar alteração de estado
            if ($atual->estado !== $estado) {
                $stmtHist->execute([':eq_id' => $idEquipamento, ':user_id' => $utilizadorId, ':tipo' => 'Estado', ':anterior' => $atual->estado, ':novo' => $estado]);
            }
 
            // Registar alteração de localização
            if ((int)$atual->localizacao_id !== (int)$localizacao) {
                $stmtHist->execute([':eq_id' => $idEquipamento, ':user_id' => $utilizadorId, ':tipo' => 'Localização', ':anterior' => $atual->servico_depart, ':novo' => $novaLoc]);
            }
 
            // Registar alteração de criticidade
            if ((int)$atual->criticidade_id !== (int)$criticidade) {
                $stmtHist->execute([':eq_id' => $idEquipamento, ':user_id' => $utilizadorId, ':tipo' => 'Criticidade', ':anterior' => $atual->criticidade, ':novo' => $novaCrit]);
            }

            // UPDATE equipamento
            $stmtE = $ligacao->prepare("UPDATE equipamentos SET
            codigo_inventario      = :codigo,
            designacao_equipamento = :designacao,
            marca                  = :marca,
            modelo                 = :modelo,
            numero_serie           = :numero_serie,
            fabricante             = :fabricante,
            data_aquisicao         = :data_aquisicao,
            ano_fabrico            = :ano_fabrico,
            custo_aquisicao        = :custo_aquisicao,
            observacoes            = :observacoes,
            categoria_grupo_id     = :categoria_id,
            estado_id              = :estado_id,
            criticidade_id         = :criticidade_id,
            tipo_entrada_id        = :tipo_entrada_id,
            localizacao_id         = :localizacao_id
            WHERE id = :id");

            $stmtE->bindParam(':codigo',          $codigo,          PDO::PARAM_STR);
            $stmtE->bindParam(':designacao',      $designacao,      PDO::PARAM_STR);
            $stmtE->bindParam(':marca',           $marca,           PDO::PARAM_STR);
            $stmtE->bindParam(':modelo',          $modelo,          PDO::PARAM_STR);
            $stmtE->bindParam(':numero_serie',    $numero_serie,    PDO::PARAM_STR);
            $stmtE->bindParam(':fabricante',      $fabricante,      PDO::PARAM_STR);
            $stmtE->bindParam(':data_aquisicao',  $data_aquisicao,  PDO::PARAM_STR);
            $stmtE->bindParam(':ano_fabrico',     $ano_fabrico,     PDO::PARAM_INT);
            $stmtE->bindParam(':custo_aquisicao', $custo_aquisicao, PDO::PARAM_STR);
            $stmtE->bindParam(':observacoes',     $observacoes,     PDO::PARAM_STR);
            $stmtE->bindParam(':categoria_id',    $categoriaId,     PDO::PARAM_INT);
            $stmtE->bindParam(':estado_id',       $estadoId,        PDO::PARAM_INT);
            $stmtE->bindParam(':criticidade_id',  $criticidade,     PDO::PARAM_INT);
            $stmtE->bindParam(':tipo_entrada_id', $tipoEntradaId,   PDO::PARAM_INT);
            $stmtE->bindParam(':localizacao_id',  $localizacao,     PDO::PARAM_INT);
            $stmtE->bindParam(':id',              $idEquipamento,   PDO::PARAM_INT);
            $stmtE->execute();

            // UPDATE garantia
            $stmtG = $ligacao->prepare("UPDATE garantias_contratos SET
            data_inicio          = :data_inicio,
            data_fim             = :data_fim,
            contrato_manutencao  = :contrato,
            entidade_responsavel = :entidade,
            observacoes_garant   = :obs
            WHERE id = (SELECT garantia_contrato_id FROM equipamentos WHERE id = :eq_id)");

            $stmtG->bindParam(':data_inicio', $data_inicio, PDO::PARAM_STR);
            $stmtG->bindParam(':data_fim',    $data_fim,    PDO::PARAM_STR);
            $contratoValor = $contrato === 'Sim' ? 1 : 0;
            $stmtG->bindParam(':contrato',    $contratoValor, PDO::PARAM_INT);
            $stmtG->bindParam(':entidade',    $entidade,    PDO::PARAM_STR);
            $stmtG->bindParam(':obs',         $obs_garantia, PDO::PARAM_STR);
            $stmtG->bindParam(':eq_id',       $idEquipamento, PDO::PARAM_INT);
            $stmtG->execute();

            $ligacao = null;

            header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php?atualizado=1');
            exit;

        } catch (PDOException $err) {
            if ($err->getCode() == 23000) {
                if (strpos($err->getMessage(), 'codigo_inventario') !== false) {
                    $erro = "Já existe um equipamento com este código de inventário.";
                } elseif (strpos($err->getMessage(), 'numero_serie') !== false) {
                    $erro = "Já existe um equipamento com este número de série.";
                } else {
                    $erro = "Erro de duplicação: " . $err->getMessage();
                }
            } else {
                $erro = "Erro ao guardar os dados: " . $err->getMessage();
            }
        }
    }
}
// --------------------------------------------------------------------
// BUSCAR DADOS DO EQUIPAMENTO NA BD
// --------------------------------------------------------------------
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $ligacao->prepare("
    SELECT e.*,
           cg.categoria_grupo AS categoria,
           es.estado,
           c.criticidade,
           te.tipo_entrada,
           l.servico_depart AS localizacao,
           l.edificio, l.piso, l.sala_gabinete,
           gc.data_inicio, gc.data_fim, gc.contrato_manutencao,
           gc.entidade_responsavel, gc.observacoes_garant,
           gc.tipo_contrato_id, gc.periodicidade_id
    FROM equipamentos e
    LEFT JOIN categoria_grupo cg ON e.categoria_grupo_id = cg.id
    LEFT JOIN estado es ON e.estado_id = es.id
    LEFT JOIN criticidade c ON e.criticidade_id = c.id
    LEFT JOIN tipo_entrada te ON e.tipo_entrada_id = te.id
    LEFT JOIN localizacoes l ON e.localizacao_id = l.id
    LEFT JOIN garantias_contratos gc ON e.garantia_contrato_id = gc.id
    WHERE e.id = :id
");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();

    $equipamento = $stmt->fetch(PDO::FETCH_OBJ);

    // Buscar todos os fornecedores para o select
    $listaFornecedores = $ligacao->query("
        SELECT f.id, f.nome_empresa, f.nif, f.morada, f.numero_telefonico,
            f.email, f.website, f.pessoa_contacto, f.tel_pessoa_contacto,
            tf.tipo_fornecedor
        FROM fornecedores f
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        WHERE f.ativo = 1
        ORDER BY f.nome_empresa
    ")->fetchAll(PDO::FETCH_OBJ);

    // Buscar fornecedores associados ao equipamento (dados completos)
    $stmtFornEq = $ligacao->prepare("
        SELECT f.id, f.nome_empresa, f.nif, f.morada, f.numero_telefonico,
               f.email, f.website, f.pessoa_contacto, f.tel_pessoa_contacto,
               tf.tipo_fornecedor
        FROM fornecedores f
        INNER JOIN equipamento_fornecedor ef ON ef.fornecedor_id = f.id
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        WHERE ef.equipamento_id = :id
        ORDER BY f.nome_empresa
    ");
    $stmtFornEq->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtFornEq->execute();
    $fornecedoresEquipamento = $stmtFornEq->fetchAll(PDO::FETCH_OBJ);

    // Buscar localizações para o select
    $listaLocalizacoes = $ligacao->query("
        SELECT id, servico_depart, edificio, piso, sala_gabinete
        FROM localizacoes
        WHERE ativo = 1
        ORDER BY servico_depart
    ")->fetchAll(PDO::FETCH_OBJ);

    // Buscar documentos associados ao equipamento
    $stmtDocs = $ligacao->prepare("
        SELECT d.*, td.tipo_doc
        FROM documentos d
        LEFT JOIN tipo_doc td ON d.tipo_doc_id = td.id
        WHERE d.equipamento_id = :id
    ");
    $stmtDocs->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtDocs->execute();
    $documentosEquipamento = $stmtDocs->fetchAll(PDO::FETCH_OBJ);

    if (!$equipamento) {
        header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php');
        exit;
    }

} catch (PDOException $err) {
    $erro = "Erro na ligação à base de dados.";
    $equipamento = null;
    $listaFornecedores = [];
    $listaLocalizacoes = [];
    $fornecedoresEquipamento = [];
    $documentosEquipamento = [];
}

$ligacao = null;


include __DIR__ . '/../../includes/header.php'; 
?>
<?php
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
?>
        

        <!-- Conteúdo Principal -->
            <main class="container-fluid p-4" style="background-color: #fff4fb;">
                <div class="d-flex justify-content-center mt-4">
                    <div class="card w-100 shadow rounded" style="max-width: 1200px;">
                        <div class="card-body">
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-plus me-2" style="color: #680447;"></i> Atualização de Dados EQUIPAMENTO</strong></h2>
                            <hr>
                            <!-- Área de erros -->
                            <?php if (!empty($erros)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <strong>Foram encontrados os seguintes erros:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($erros as $e): ?>
                                        <li><?= htmlspecialchars($e) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($erro)): ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
                                </div>
                            <?php endif; ?>

                            <form id="formEquipamento" action="editar.php?id=<?= $idEquipamentoEncriptado ?>" method="post" enctype="multipart/form-data">
                                <ul class="nav nav-tabs mb-4" id="equipamentoTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active"
                                        id="info-tab"
                                        data-bs-toggle="tab"
                                        href="#infoEquipamento"
                                        role="tab">
                                            1. Equipamento
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="fornecedor-tab"
                                        data-bs-toggle="tab"
                                        href="#infoFornecedores"
                                        role="tab">
                                            2. Fornecedores
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="localizacao-tab"
                                        data-bs-toggle="tab"
                                        href="#infoLocalizacao"
                                        role="tab">
                                            3. Localização
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="documentacao-tab"
                                        data-bs-toggle="tab"
                                        href="#infoDocumentos"
                                        role="tab">
                                            4. Documentação
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="garantias-tab"
                                        data-bs-toggle="tab"
                                        href="#garantiasContratos"
                                        role="tab">
                                            5. Garantias e Contratos
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="infoEquipamento" role="tabpanel">
                                        <!-- Secção: Identificação -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-barcode me-2"></i>
                                            Identificação
                                        </h5>
                                        <!-- Campo código de inventário --> 
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="codigo_inventario" class="form-label">Código interno <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="codigo_inventario" name="codigo_inventario" value="<?= htmlspecialchars($equipamento->codigo_inventario) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campos Categoria/Grupo e Designação -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="categoria_grupo" class="form-label">Categoria / Grupo <span class="text-danger">*</span></label>
                                                <select class="form-control" id="categoria_grupo" name="categoria_grupo" required> 
                                                    <option value="" disabled>Escolha uma opção</option>
                                                    <option value="Monitorização"  <?= ($equipamento->categoria ?? '') === 'Monitorização'  ? 'selected' : '' ?>>Monitorização</option>
                                                    <option value="Suporte de vida" <?= ($equipamento->categoria ?? '') === 'Suporte de vida' ? 'selected' : '' ?>>Suporte de vida</option>
                                                    <option value="Terapia"        <?= ($equipamento->categoria ?? '') === 'Terapia'        ? 'selected' : '' ?>>Terapia</option>
                                                    <option value="Diagnóstico"    <?= ($equipamento->categoria ?? '') === 'Diagnóstico'    ? 'selected' : '' ?>>Diagnóstico</option>
                                                    <option value="Laboratório"    <?= ($equipamento->categoria ?? '') === 'Laboratório'    ? 'selected' : '' ?>>Laboratório</option>
                                                    <option value="Esterilização"  <?= ($equipamento->categoria ?? '') === 'Esterilização'  ? 'selected' : '' ?>>Esterilização</option>
                                                    <option value="Reabilitação"   <?= ($equipamento->categoria ?? '') === 'Reabilitação'   ? 'selected' : '' ?>>Reabilitação</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designacao_equipamento" class="form-label">Designação <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="designacao_equipamento" name="designacao_equipamento" value="<?= htmlspecialchars($equipamento->designacao_equipamento) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campos Marca, Modelo e Nº série --> 
                                        <div class="row mb-3"> 
                                            <div class="col-md-4">
                                                <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="marca" name="marca" value="<?= htmlspecialchars($equipamento->marca) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="modelo" name="modelo" value="<?= htmlspecialchars($equipamento->modelo) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="numero_serie" class="form-label">Nº de série <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="<?= htmlspecialchars($equipamento->numero_serie) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campo Fabricante -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="fabricante" class="form-label">Fabricante <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="fabricante" name="fabricante" value="<?= htmlspecialchars($equipamento->fabricante) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Secção: Aquisição e estado -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-cart-shopping me-2"></i>
                                            Aquisição e estado
                                        </h5>

                                        <!-- Campo Data de aquisição -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="data_aquisicao" class="form-label">Data de aquisição <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="data_aquisicao" name="data_aquisicao" value="<?= htmlspecialchars($equipamento->data_aquisicao) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campos Ano de fabrico e custo de aquisição -->
                                        <div class="row mb-3"> 
                                            <div class="col-md-6">
                                                <label for="ano_fabrico" class="form-label">Ano de fabrico <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" min="1980" max="2026" value="<?= htmlspecialchars($equipamento->ano_fabrico) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="custo_aquisicao" class="form-label">Custo de aquisição (€) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="custo_aquisicao" name="custo_aquisicao" step="0.01" value="<?= htmlspecialchars($equipamento->custo_aquisicao) ?>" required>
                                            </div>
                                        </div>

                                        <!--Campos Tipo de entrada, Estado atual e Criticidade -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tipo_entrada" class="form-label">Entrada por: <span class="text-danger">*</span></label>
                                                <select class="form-control" id="tipo_entrada" name="tipo_entrada" required>
                                                    <option value="" disabled>Escolha uma opção</option>
                                                    <option value="Compra"     <?= $equipamento->tipo_entrada === 'Compra'     ? 'selected' : '' ?>>Compra</option>
                                                    <option value="Doação"     <?= $equipamento->tipo_entrada === 'Doação'     ? 'selected' : '' ?>>Doação</option>
                                                    <option value="Aluguer"    <?= $equipamento->tipo_entrada === 'Aluguer'    ? 'selected' : '' ?>>Aluguer</option>
                                                    <option value="Empréstimo" <?= $equipamento->tipo_entrada === 'Empréstimo' ? 'selected' : '' ?>>Empréstimo</option>
                                                </select>
                                            </div>     
                                            <div class="col-md-4">
                                                <label for="estado" class="form-label">Estado atual <span class="text-danger">*</span></label>
                                                <select class="form-control" id="estado" name="estado" required>
                                                    <option value="" disabled>Escolha uma opção</option>
                                                    <option value="Ativo"      <?= $equipamento->estado === 'Ativo'      ? 'selected' : '' ?>>Ativo</option>
                                                    <option value="Inativo"    <?= $equipamento->estado === 'Inativo'    ? 'selected' : '' ?>>Inativo</option>
                                                    <option value="Calibração" <?= $equipamento->estado === 'Calibração' ? 'selected' : '' ?>>Em calibração</option>
                                                    <option value="Quarentena" <?= $equipamento->estado === 'Quarentena' ? 'selected' : '' ?>>Em quarentena</option>
                                                    <option value="Abatido"    <?= $equipamento->estado === 'Abatido'    ? 'selected' : '' ?>>Abatido</option>
                                                </select>
                                            </div>   
                                            <div class="col-md-4">
                                                <label for="criticidade" class="form-label">Criticidade <span class="text-danger">*</span></label>
                                                <select class="form-control" id="criticidade" name="criticidade_id" required>
                                                    <option value="" disabled>Escolha uma opção</option>
                                                    <option value="1" <?= $equipamento->criticidade_id == 1 ? 'selected' : '' ?>>Baixa</option>
                                                    <option value="2" <?= $equipamento->criticidade_id == 2 ? 'selected' : '' ?>>Média</option>
                                                    <option value="3" <?= $equipamento->criticidade_id == 3 ? 'selected' : '' ?>>Alta</option>
                                                    <option value="4" <?= $equipamento->criticidade_id == 4 ? 'selected' : '' ?>>Suporte de Vida</option>
                                                </select>
                                            </div> 
                                        </div>
                                        <!-- Secção: Observações -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-note-sticky me-2"></i>
                                            Observações
                                        </h5>

                                        <!-- Campo Observações -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="observacoes" class="form-label">Observações</label>
                                                <textarea class="form-control" id="observacoes" name="observacoes" rows="4" placeholder="Informações adicionais sobre o equipamento..."><?= htmlspecialchars($equipamento->observacoes ?? '') ?></textarea>
                                            </div>
                                        </div> 
                                        <div class="text-end">
                                            <button type="button"
                                                    class="btn btn-guardar mb-4"
                                                    id="btnSeguinteEquipamento"
                                                    onclick="
                                                        document.getElementById('fornecedor-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#fornecedor-tab')).show();
                                                    ">
                                                Seguinte
                                                <i class="fa-solid fa-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                        
                                    </div> 

                                    <div class="tab-pane fade" id="infoFornecedores" role="tabpanel">

                                        <!-- Título -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-building me-2"></i>
                                            Fornecedores
                                        </h5>

                                        <!-- Área onde ficam os fornecedores -->
                                        <div id="areaFornecedores">

                                            <!-- FORNECEDOR 1 -->
                                            <?php foreach ($fornecedoresEquipamento as $i => $forn): ?>
                                            <div class="border rounded p-3 mb-4" id="blocoFornecedor<?= $i + 1 ?>">
 
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0" style="color:#680447;">
                                                        Fornecedor <?= $i + 1 ?>
                                                    </h6>
                                                    <?php if ($i > 0): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="this.closest('.border').remove()">
                                                        <i class="fa-solid fa-trash-can me-1"></i> Remover
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
 
                                                <!-- Selecionar fornecedor -->
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <select class="form-control"
                                                                name="fornecedor_id[]"
                                                                onchange="preencherFornecedorBloco(this,<?= $i + 1 ?>)"
                                                                required>
                                                            <option value="" disabled>Escolha um fornecedor</option>
                                                            <?php foreach ($listaFornecedores as $f): ?>
                                                                <option value="<?= $f->id ?>" <?= $f->id == $forn->id ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($f->nome_empresa) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
 
                                                <!-- Informação pré-preenchida -->
                                                <div id="infoFornecedor<?= $i + 1 ?>">
 
                                                    <hr>
 
                                                    <h6 class="text-muted mb-4">
                                                        <i class="fa-solid fa-circle-info me-2"></i>
                                                        Informação do fornecedor
                                                    </h6>
 
                                                    <div class="row">
 
                                                        <!-- Coluna 1 -->
                                                        <div class="col-md-4">
 
                                                            <div class="mb-4">
                                                                <strong>Nome da empresa</strong>
                                                                <p id="f-nome-<?= $i + 1 ?>"><?= htmlspecialchars($forn->nome_empresa) ?></p>
                                                            </div>
 
                                                            <div class="mb-4">
                                                                <strong>NIF</strong>
                                                                <p id="f-nif-<?= $i + 1 ?>"><?= htmlspecialchars($forn->nif) ?></p>
                                                            </div>
 
                                                            <div class="mb-4">
                                                                <strong>Tipo de fornecedor</strong>
                                                                <p id="f-tipo-<?= $i + 1 ?>"><?= htmlspecialchars($forn->tipo_fornecedor ?? '—') ?></p>
                                                            </div>
 
                                                        </div>
 
                                                        <!-- Coluna 2 -->
                                                        <div class="col-md-4">
 
                                                            <div class="mb-4">
                                                                <strong>Morada</strong>
                                                                <p id="f-morada-<?= $i + 1 ?>"><?= htmlspecialchars($forn->morada) ?></p>
                                                            </div>
 
                                                            <div class="mb-4">
                                                                <strong>Número telefónico</strong>
                                                                <p id="f-telefone-<?= $i + 1 ?>"><?= htmlspecialchars($forn->numero_telefonico) ?></p>
                                                            </div>
 
                                                            <div class="mb-4">
                                                                <strong>Email</strong>
                                                                <p id="f-email-<?= $i + 1 ?>"><?= htmlspecialchars($forn->email) ?></p>
                                                            </div>
 
                                                        </div>
 
                                                        <!-- Coluna 3 -->
                                                        <div class="col-md-4">
 
                                                            <div class="mb-4">
                                                                <strong>Website</strong>
                                                                <p id="f-website-<?= $i + 1 ?>"><?= htmlspecialchars($forn->website) ?></p>
                                                            </div>
 
                                                            <div class="mb-4">
                                                                <strong>Pessoa de contacto</strong>
                                                                <p id="f-contacto-<?= $i + 1 ?>"><?= htmlspecialchars($forn->pessoa_contacto) ?></p>
                                                            </div>
 
                                                            <div class="mb-4">
                                                                <strong>Telefone da pessoa de contacto</strong>
                                                                <p id="f-tel-contacto-<?= $i + 1 ?>"><?= htmlspecialchars($forn->tel_pessoa_contacto) ?></p>
                                                            </div>
 
                                                        </div>
 
                                                    </div>
 
                                                </div>
 
                                            </div>
                                            <?php endforeach; ?>
 
                                        </div>
 
                                        <!-- Botão adicionar -->
                                        <button type="button"
                                                class="btn btn-outline-secondary mb-4"
                                                onclick="adicionarBlocoFornecedor()">
                                            <i class="fa-solid fa-plus me-1"></i>
                                            Adicionar fornecedor
                                        </button>
 
                                        <!-- Navegação -->
                                        <div class="d-flex justify-content-between">
 
                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#info-tab')).show();">
                                                Anterior
                                            </button>
 
                                            <button type="button"
                                                    id="btnSeguinteFornecedor"
                                                    class="btn btn-guardar"
                                                    onclick="
                                                        document.getElementById('localizacao-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#localizacao-tab')).show();
                                                    ">
                                                Seguinte
                                            </button>
 
                                        </div>
 
                                    </div>
 
                                    <div class="tab-pane fade" id="infoLocalizacao" role="tabpanel">
                                        <!-- Secção: Localizações -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-location-dot me-2"></i>
                                            Localização
                                        </h5>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="selectLocalizacao" class="form-label">
                                                    Selecionar localização
                                                </label>

                                                <select class="form-control"
                                                        id="selectLocalizacao"
                                                        name="localizacao_id"
                                                        onchange="preencherLocalizacao()"
                                                        required>
                                                    <option value="" disabled>Escolha uma localização</option>
                                                    <?php foreach ($listaLocalizacoes as $l): ?>
                                                        <option value="<?= $l->id ?>" <?= $equipamento->localizacao_id == $l->id ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($l->servico_depart) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="infoLocalizacaoPainel" class="d-none">
                                            <hr>

                                            <h6 class="text-muted mb-3" style="color:#680447;">
                                                <i class="fa-solid fa-circle-info me-2"></i>
                                                Informação da localização
                                            </h6>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <strong>Edifício</strong>
                                                    <p id="l-edificio">-</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>Piso</strong>
                                                    <p id="l-piso">-</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>Sala</strong>
                                                    <p id="l-sala">-</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>Serviço</strong>
                                                    <p id="l-servico">-</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#fornecedor-tab')).show();">
                                                Anterior
                                            </button>

                                            <button type="button"
                                                    class="btn btn-guardar"
                                                    id="btnSeguinteLocalizacao"
                                                    onclick="
                                                        document.getElementById('documentacao-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#documentacao-tab')).show();
                                                    ">
                                                Seguinte
                                            </button>
                                        </div>
                                        
                                    </div>

                                    <div class="tab-pane fade" id="infoDocumentos" role="tabpanel">

                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-folder-open me-2"></i>
                                            Documentação
                                        </h5>

                                        <div id="areaDocumentos">
                                            <?php foreach ($documentosEquipamento as $i => $doc): ?>
                                            <div class="border rounded p-3 mb-4" id="blocoDocumento<?= $i + 1 ?>">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0" style="color:#680447;">
                                                        Documento <?= $i + 1 ?>
                                                    </h6>
                                                </div>

                                                <h6 class="mt-3 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-barcode me-2"></i>
                                                    Identificação
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tipo de documento <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="tipo_doc[]" required>
                                                            <option value="" disabled>Escolha uma opção</option>
                                                            <option value="Manual de utilizador"       <?= $doc->tipo_doc === 'Manual de utilizador'       ? 'selected' : '' ?>>Manual de utilizador</option>
                                                            <option value="Manual de serviço"          <?= $doc->tipo_doc === 'Manual de serviço'          ? 'selected' : '' ?>>Manual de serviço</option>
                                                            <option value="Certificado de calibração"  <?= $doc->tipo_doc === 'Certificado de calibração'  ? 'selected' : '' ?>>Certificado de calibração</option>
                                                            <option value="Contrato de manutenção"     <?= $doc->tipo_doc === 'Contrato de manutenção'     ? 'selected' : '' ?>>Contrato de manutenção</option>
                                                            <option value="Fatura / Guia de aquisição" <?= $doc->tipo_doc === 'Fatura / Guia de aquisição' ? 'selected' : '' ?>>Fatura / Guia de aquisição</option>
                                                            <option value="Declaração de conformidade" <?= $doc->tipo_doc === 'Declaração de conformidade' ? 'selected' : '' ?>>Declaração de conformidade</option>
                                                            <option value="Relatório técnico"          <?= $doc->tipo_doc === 'Relatório técnico'          ? 'selected' : '' ?>>Relatório técnico</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nome <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="nome_doc[]" value="<?= htmlspecialchars($doc->nome_doc) ?>" required>
                                                    </div>
                                                </div>

                                                    <h6 class="mt-4 mb-3" style="color:#680447;">
                                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                                        Datas
                                                    </h6>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Data <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="data_doc[]" value="<?= htmlspecialchars($doc->data_doc) ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Data de validade</label>
                                                            <input type="text" class="form-control" name="data_validade[]" value="<?= htmlspecialchars($doc->data_validade ?? '') ?>">
                                                        </div>
                                                    </div>

                                                    <h6 class="mt-4 mb-3" style="color:#680447;">
                                                        <i class="fa-solid fa-link me-2"></i>
                                                        Associações e ficheiro
                                                    </h6>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                        <label class="form-label">Fornecedor associado</label>
                                                        <select class="form-control" name="fornecedor_doc_id[]">
                                                            <option value="" disabled>Escolha um fornecedor</option>
                                                            <?php foreach ($listaFornecedores as $f): ?>
                                                                <option value="<?= $f->id ?>" <?= $doc->fornecedor_id == $f->id ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($f->nome_empresa) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Ficheiro atual</label>
                                                        <p class="form-control-plaintext"><?= htmlspecialchars($doc->ficheiro ?? 'Sem ficheiro') ?></p>
                                                        <label class="form-label">Substituir ficheiro</label>
                                                        <input type="file" class="form-control" name="ficheiro[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                        <input type="hidden" name="ficheiro_atual[]" value="<?= htmlspecialchars($doc->ficheiro ?? '') ?>">
                                                        <input type="hidden" name="doc_id[]" value="<?= $doc->id ?>">
                                                    </div>
                                                </div>

                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                                

                                        
                                        <button type="button"
                                                class="btn btn-outline-secondary mb-4"
                                                onclick="adicionarBlocoDocumento()">
                                            <i class="fa-solid fa-plus me-1"></i>
                                            Adicionar documento
                                        </button>

                                        <div class="d-flex justify-content-between">
                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#localizacao-tab')).show();">
                                                Anterior
                                            </button>

                                            <button type="button"
                                                    class="btn btn-guardar"
                                                    id="btnSeguinteDocumentos"
                                                    onclick="
                                                        document.getElementById('garantias-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#garantias-tab')).show();
                                                    ">
                                                Seguinte
                                            </button>
                                        </div>
                                        
                                    </div>

                                    <div class="tab-pane fade" id="garantiasContratos" role="tabpanel">
                                            <!-- Secção: Garantias e contratos -->
                                            <h5 class="mt-4 mb-3" style="color:#680447;">
                                                <i class="fa-solid fa-file-signature me-2"></i>
                                                Garantias e contratos
                                            </h5>

                                            <!--Campo Garantia-->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="data_inicio" class="form-label">Data de início de Garantia <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($equipamento->data_inicio ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="data_fim" class="form-label">Data de fim de Garantia <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="data_fim" name="data_fim" value="<?= htmlspecialchars($equipamento->data_fim ?? '') ?>" required>
                                                </div>
                                            </div>

                                            <!--Campo Contrato-->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="contrato_manutencao" class="form-label">
                                                        Contrato de manutenção <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control" id="contrato_manutencao" name="contrato_manutencao" required>
                                                        <option value="" disabled>Escolha uma opção</option>
                                                        <option value="Sim" <?= $equipamento->contrato_manutencao == 1 ? 'selected' : '' ?>>Sim</option>
                                                        <option value="Não" <?= $equipamento->contrato_manutencao == 0 ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="tipo_contrato" class="form-label">
                                                        Tipo de contrato 
                                                    </label>

                                                    <select class="form-control" id="tipo_contrato" name="tipo_contrato">
                                                        <option value="" disabled>Escolha uma opção</option>
                                                        <option value="Preventivo" <?= ($equipamento->tipo_contrato_id ?? '') == 1 ? 'selected' : '' ?>>Preventivo</option>
                                                        <option value="Corretivo"  <?= ($equipamento->tipo_contrato_id ?? '') == 2 ? 'selected' : '' ?>>Corretivo</option>
                                                        <option value="Completo"   <?= ($equipamento->tipo_contrato_id ?? '') == 3 ? 'selected' : '' ?>>Completo</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="periodicidade" class="form-label">
                                                        Periodicidade 
                                                    </label>

                                                    <select class="form-control" id="periodicidade" name="periodicidade">
                                                        <option value="" disabled>Escolha uma opção</option>
                                                        <option value="Mensal"     <?= ($equipamento->periodicidade_id ?? '') == 1 ? 'selected' : '' ?>>Mensal</option>
                                                        <option value="Trimestral" <?= ($equipamento->periodicidade_id ?? '') == 2 ? 'selected' : '' ?>>Trimestral</option>
                                                        <option value="Semestral"  <?= ($equipamento->periodicidade_id ?? '') == 3 ? 'selected' : '' ?>>Semestral</option>
                                                        <option value="Anual"      <?= ($equipamento->periodicidade_id ?? '') == 4 ? 'selected' : '' ?>>Anual</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="entidade_responsavel" class="form-label">
                                                        Entidade responsável <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" id="entidade_responsavel" name="entidade_responsavel" value="<?= htmlspecialchars($equipamento->entidade_responsavel ?? '') ?>" required>
                                                </div>
                                            </div>

                                            <!-- Secção: Observações -->
                                            <h5 class="mt-4 mb-3" style="color:#680447;">
                                                <i class="fa-solid fa-note-sticky me-2"></i>
                                                Observações
                                            </h5>

                                            <!-- Campo Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="observacoes_garant" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="observacoes_garant" name="observacoes_garant" rows="4" placeholder="Informações adicionais sobre o equipamento..."><?= htmlspecialchars($equipamento->observacoes_garant ?? '') ?></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
                                                <button type="button"
                                                        class="btn btn-outline-secondary mb-4"
                                                        id="btnAnterior"
                                                        onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#documentacao-tab')).show()">
                                                    <i class="fa-solid fa-arrow-left me-1"></i>
                                                    Anterior
                                                </button>

                                                <div>
                                                    <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php" class="btn btn-outline-secondary mb-4">
                                                        <i class="fa-solid fa-xmark me-1"></i> Cancelar
                                                    </a>

                                                    <button type="submit" class="btn btn-guardar mb-4">
                                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>    

<script>
const fornecedores = {
    <?php foreach ($listaFornecedores as $f): ?>
    <?= $f->id ?>: {
        nome: "<?= addslashes($f->nome_empresa) ?>",
        nif: "<?= addslashes($f->nif) ?>",
        morada: "<?= addslashes($f->morada) ?>",
        tipo: "<?= addslashes($f->tipo_fornecedor) ?>",
        telefone: "<?= addslashes($f->numero_telefonico) ?>",
        email: "<?= addslashes($f->email) ?>",
        website: "<?= addslashes($f->website) ?>",
        contacto: "<?= addslashes($f->pessoa_contacto) ?>",
        telContacto: "<?= addslashes($f->tel_pessoa_contacto) ?>"
    },
    <?php endforeach; ?>
};

const localizacoes = {
    <?php foreach ($listaLocalizacoes as $l): ?>
    <?= $l->id ?>: {
        edificio: "<?= addslashes($l->edificio) ?>",
        piso: "<?= addslashes($l->piso) ?>",
        sala: "<?= addslashes($l->sala_gabinete) ?>",
        servico: "<?= addslashes($l->servico_depart) ?>"
    },
    <?php endforeach; ?>
};
</script>

<!-- Custom JS -->
<script src="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/assets/js/1240811.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>