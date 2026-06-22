<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
require_once __DIR__ . '/../../includes/validacoes.php';

// Valores por defeito (para quando a página carrega pela primeira vez)
$erros           = [];
$codigo          = '';
$categoria       = '';
$designacao      = '';
$marca           = '';
$modelo          = '';
$numero_serie    = '';
$fabricante      = '';
$data_aquisicao  = '';
$ano_fabrico     = '';
$custo_aquisicao = '';
$tipo_entrada    = '';
$estado          = '';
$criticidade     = '';
$observacoes     = '';
$fornecedor      = [];
$localizacao     = '';
$tipo_doc        = [];
$nome_doc        = [];
$data_doc        = [];
$data_validade   = [];
$fornecedor_doc  = [];
$ficheiro        = [];
$data_inicio     = '';
$data_fim        = '';
$contrato        = '';
$tipo_contrato   = '';
$periodicidade   = '';
$entidade        = '';
$obs_garantia    = '';
$docs            = [];
$erro_sistema    = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Documentação

    // Garantir que são sempre arrays
    $tipo_doc       = (array)$tipo_doc;
    $nome_doc       = (array)$nome_doc;
    $data_doc       = (array)$data_doc;
    $data_validade  = (array)$data_validade;
    $fornecedor_doc = (array)$fornecedor_doc;

    $temDocumento = false;
    foreach ($tipo_doc as $i => $t) {
        $t = trim($t);
        $n = trim($nome_doc[$i] ?? '');
        $d = trim($data_doc[$i] ?? '');
        $fich = $ficheiro['name'][$i] ?? '';

        if (!empty($t) || !empty($n) || !empty($d) || !empty($fich)) {
            $temDocumento = true;

            if (empty($t)) {
                $erros[] = "O tipo do documento " . ($i + 1) . " é obrigatório.";
            }
            if (empty($n)) {
                $erros[] = "O nome do documento " . ($i + 1) . " é obrigatório.";
            }
            if (empty($d)) {
                $erros[] = "A data do documento " . ($i + 1) . " é obrigatória.";
            } else {
                $partes = explode('-', $d);
                if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
                    $erros[] = "A data do documento " . ($i + 1) . " é inválida.";
                } elseif ($d > date('Y-m-d')) {
                    $erros[] = "A data do documento " . ($i + 1) . " não pode ser superior à data atual.";
                }
            }
            if (empty($fich)) {
                $erros[] = "O ficheiro do documento " . ($i + 1) . " é obrigatório.";
            }
        }
    }

    if (!$temDocumento) {
        $erros[] = "É necessário adicionar pelo menos um documento.";
    }

    // Datas de garantia
    if (empty($data_inicio)) {
        $erros[] = "A data de início de garantia é obrigatória.";
    } else {
        $partes = explode('-', $data_inicio);
        if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
            $erros[] = "A data de início de garantia é inválida.";
        } elseif ($data_inicio > date('Y-m-d')) {
            $erros[] = "A data de início de garantia não pode ser superior à data atual.";
        }
    }
    if (empty($data_fim)) {
        $erros[] = "A data de fim de garantia é obrigatória.";
    }
    if (!empty($data_inicio) && !empty($data_fim) && $data_fim < $data_inicio) {
        $erros[] = "A data de fim de garantia não pode ser anterior à data de início.";
    }

    // Contrato de manutenção
    if (empty($contrato)) {
        $erros[] = "Indique se existe contrato de manutenção.";
    }

    // Entidade responsável
    if (empty($entidade)) {
        $erros[] = "A entidade responsável é obrigatória.";
    }


    // 3. Se não houver erros
    if (empty($erros)) {

        // 4. Normalizar dados
        $designacao = ucwords(strtolower($designacao));
        $marca      = ucwords(strtolower($marca));
        $modelo     = ucwords(strtolower($modelo));
        $fabricante = ucwords(strtolower($fabricante));
        $entidade   = ucwords(strtolower($entidade));

        foreach ($nome_doc as $i => $n) {
            $nome_doc[$i] = ucfirst(strtolower($n));
        }

        // 5. Guardar na base de dados
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Obter IDs das tabelas relacionadas
            $stmtEstado = $ligacao->prepare("SELECT id FROM estado WHERE estado = :estado LIMIT 1");
            $stmtEstado->execute([':estado' => $estado]);
            $estadoId = $stmtEstado->fetchColumn();

            $stmtCategoria = $ligacao->prepare("SELECT id FROM categoria_grupo WHERE categoria_grupo = :cat LIMIT 1");
            $stmtCategoria->execute([':cat' => $categoria]);
            $categoriaId = $stmtCategoria->fetchColumn();

            $stmtTipoEntrada = $ligacao->prepare("SELECT id FROM tipo_entrada WHERE tipo_entrada = :tipo LIMIT 1");
            $stmtTipoEntrada->execute([':tipo' => $tipo_entrada]);
            $tipoEntradaId = $stmtTipoEntrada->fetchColumn();

            // 1. Inserir garantia/contrato primeiro (porque equipamentos tem garantia_contrato_id)
            $sqlGarantia = "INSERT INTO garantias_contratos (
                data_inicio, data_fim, contrato_manutencao,
                tipo_contrato_id, periodicidade_id,
                entidade_responsavel, observacoes_garant
            ) VALUES (
                :data_inicio, :data_fim, :contrato,
                :tipo_contrato, :periodicidade,
                :entidade, :obs
            )";

            // Buscar IDs de tipo_contrato e periodicidade
            $tipoContratoId = null;
            if (!empty($tipo_contrato)) {
                $stmtTC = $ligacao->prepare("SELECT id FROM tipo_contrato WHERE tipo_contrato = :tc LIMIT 1");
                $stmtTC->execute([':tc' => $tipo_contrato]);
                $tipoContratoId = $stmtTC->fetchColumn() ?: null;
            }
 
            $periodicidadeId = null;
            if (!empty($periodicidade)) {
                $stmtP = $ligacao->prepare("SELECT id FROM periodicidade WHERE periodicidade = :p LIMIT 1");
                $stmtP->execute([':p' => $periodicidade]);
                $periodicidadeId = $stmtP->fetchColumn() ?: null;
            }
 
            $stmtG = $ligacao->prepare($sqlGarantia);
            $stmtG->execute([
                ':data_inicio'   => $data_inicio,
                ':data_fim'      => $data_fim,
                ':contrato'      => $contrato === 'Sim' ? 1 : 0,
                ':tipo_contrato' => $tipoContratoId,
                ':periodicidade' => $periodicidadeId,
                ':entidade'      => $entidade,
                ':obs'           => $obs_garantia ?: null,
            ]);

            $garantiaId = $ligacao->lastInsertId();

            // 2. Inserir equipamento
            $sqlEquip = "INSERT INTO equipamentos (
                codigo_inventario, designacao_equipamento, marca, modelo, numero_serie,
                fabricante, data_aquisicao, ano_fabrico, custo_aquisicao, observacoes,
                categoria_grupo_id, estado_id, criticidade_id, tipo_entrada_id,
                localizacao_id, garantia_contrato_id
            ) VALUES (
                :codigo, :designacao, :marca, :modelo, :numero_serie,
                :fabricante, :data_aquisicao, :ano_fabrico, :custo_aquisicao, :observacoes,
                :categoria_id, :estado_id, :criticidade_id, :tipo_entrada_id,
                :localizacao_id, :garantia_id
            )";

            $stmtE = $ligacao->prepare($sqlEquip);
            $stmtE->execute([
                ':codigo'          => $codigo,
                ':designacao'      => $designacao,
                ':marca'           => $marca,
                ':modelo'          => $modelo,
                ':numero_serie'    => $numero_serie,
                ':fabricante'      => $fabricante,
                ':data_aquisicao'  => $data_aquisicao,
                ':ano_fabrico'     => $ano_fabrico,
                ':custo_aquisicao' => $custo_aquisicao,
                ':observacoes'     => $observacoes ?: null,
                ':categoria_id'    => $categoriaId,
                ':estado_id'       => $estadoId,
                ':criticidade_id'  => $criticidade,
                ':tipo_entrada_id' => $tipoEntradaId,
                ':localizacao_id'  => $localizacao,
                ':garantia_id'     => $garantiaId,
            ]);

            $equipamentoId = $ligacao->lastInsertId();

            // 3. Inserir fornecedores do equipamento
            $sqlForn = "INSERT INTO equipamento_fornecedor (equipamento_id, fornecedor_id)
                        VALUES (:equipamento_id, :fornecedor_id)";
            $stmtF = $ligacao->prepare($sqlForn);

            foreach ((array)$fornecedor as $fId) {
                $stmtF->execute([
                    ':equipamento_id' => $equipamentoId,
                    ':fornecedor_id'  => $fId,
                ]);
            }

            // 4. Inserir documentos
            $sqlDoc = "INSERT INTO documentos (
                equipamento_id, fornecedor_id, tipo_doc_id,
                nome_doc, data_doc, data_validade, ficheiro
            ) VALUES (
                :equipamento_id, :fornecedor_id, :tipo_doc_id,
                :nome_doc, :data_doc, :data_validade, :ficheiro
            )";
            $stmtD = $ligacao->prepare($sqlDoc);

            foreach ($tipo_doc as $i => $t) {

                // Obter id do tipo de documento
                $stmtTipoDoc = $ligacao->prepare("SELECT id FROM tipo_doc WHERE tipo_doc = :tipo LIMIT 1");
                $stmtTipoDoc->execute([':tipo' => $t]);
                $tipoDocId = $stmtTipoDoc->fetchColumn();

                // Guardar ficheiro
                $nomeFicheiro = null;
                if (!empty($ficheiro['name'][$i])) {
                    $extensao    = pathinfo($ficheiro['name'][$i], PATHINFO_EXTENSION);
                    $nomeFicheiro = uniqid('doc_') . '.' . $extensao;
                    $destino     = __DIR__ . '/../../uploads/' . $nomeFicheiro;
                    move_uploaded_file($ficheiro['tmp_name'][$i], $destino);
                }

                $stmtD->execute([
                    ':equipamento_id' => $equipamentoId,
                    ':fornecedor_id'  => $fornecedor_doc[$i] ?: null,
                    ':tipo_doc_id'    => $tipoDocId,
                    ':nome_doc'       => $nome_doc[$i],
                    ':data_doc'       => $data_doc[$i],
                    ':data_validade'  => $data_validade[$i] ?: null,
                    ':ficheiro'       => $nomeFicheiro,
                ]);
            }

            $ligacao = null;

            // Redirecionar para a listagem
            header('Location: /sibdas/1240811/projeto-sibdas/medinventec/private/views/equipamentos/lista.php?sucesso=1');
            exit;

        } catch (PDOException $err) {
            $erro_sistema = "Erro ao guardar os dados: " . $err->getMessage();
        }
    }

}
    
// Buscar fornecedores da BD para o select
// Buscar fornecedores e localizações da BD
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $listaFornecedores = $ligacao->query("
        SELECT f.id, f.nome_empresa, f.nif, f.morada, f.numero_telefonico,
               f.email, f.website, f.pessoa_contacto, f.tel_pessoa_contacto,
               tf.tipo_fornecedor
        FROM fornecedores f
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        WHERE f.ativo = 1
        ORDER BY f.nome_empresa
    ")->fetchAll(PDO::FETCH_OBJ);

    $listaLocalizacoes = $ligacao->query("
        SELECT id, servico_depart, edificio, piso, sala_gabinete
        FROM localizacoes
        WHERE ativo = 1
        ORDER BY servico_depart
    ")->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $err) {
    $listaFornecedores = [];
    $listaLocalizacoes = [];
}

include __DIR__ . '/../../includes/header.php'; ?>

<?php if (!empty($erro_sistema)): ?>
    <div class="alert alert-danger mt-3 mx-4" role="alert">
        <strong>Erro:</strong> <?= htmlspecialchars($erro_sistema) ?>
    </div>
<?php endif; ?>


<?php
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

        <!-- Conteúdo Principal -->
            <main class="container-fluid p-4" style="background-color: #fff4fb; min-height:100vh">
                <div class="d-flex justify-content-center mt-4">
                    <div class="card w-100 shadow rounded" style="max-width: 1200px;">
                        <div class="card-body">
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-plus me-2" style="color: #680447;"></i> Inserir novo equipamento</strong></h2>
                            <hr>
                            <!-- Área de erros -->
                            <?php if (!empty($erros)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <strong>Foram encontrados os seguintes erros:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($erros as $erro): ?>
                                        <li><?= htmlspecialchars($erro) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($erro_sistema)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <strong>Erro:</strong> <?= htmlspecialchars($erro_sistema) ?>
                            </div>
                            <?php endif; ?>

                            <form id="formEquipamento" action="#" method="post" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control" id="codigo_inventario" name="codigo_inventario" placeholder="Ex: EQ0001" value="<?= htmlspecialchars($codigo) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campos Categoria/Grupo e Designação -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="categoria_grupo" class="form-label">Categoria / Grupo <span class="text-danger">*</span></label>
                                                <select class="form-control" id="categoria_grupo" name="categoria_grupo" required> 
                                                    <option value="" disabled <?= $categoria === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                    <option value="Monitorização"  <?= $categoria === 'Monitorização'  ? 'selected' : '' ?>>Monitorização</option>
                                                    <option value="Suporte de Vida" <?= $categoria === 'Suporte de Vida' ? 'selected' : '' ?>>Suporte de Vida</option>
                                                    <option value="Terapia"        <?= $categoria === 'Terapia'        ? 'selected' : '' ?>>Terapia</option>
                                                    <option value="Diagnóstico"    <?= $categoria === 'Diagnóstico'    ? 'selected' : '' ?>>Diagnóstico</option>
                                                    <option value="Laboratório"    <?= $categoria === 'Laboratório'    ? 'selected' : '' ?>>Laboratório</option>
                                                    <option value="Esterilização"  <?= $categoria === 'Esterilização'  ? 'selected' : '' ?>>Esterilização</option>
                                                    <option value="Reabilitação"   <?= $categoria === 'Reabilitação'   ? 'selected' : '' ?>>Reabilitação</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designacao_equipamento" class="form-label">Designação <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="designacao_equipamento" name="designacao_equipamento" placeholder="Ex: Monitor cardíaco" value="<?= htmlspecialchars($designacao) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campos Marca, Modelo e Nº série --> 
                                        <div class="row mb-3"> 
                                            <div class="col-md-4">
                                                <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Ex: Zoll" value="<?= htmlspecialchars($marca) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ex: Evita V500" value="<?= htmlspecialchars($modelo) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="numero_serie" class="form-label">Nº de série <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" placeholder="Ex: EV500-2021-9934" value="<?= htmlspecialchars($numero_serie) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campo Fabricante -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="fabricante" class="form-label">Fabricante <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="fabricante" name="fabricante" placeholder="Ex: Philips Healthcare" value="<?= htmlspecialchars($fabricante) ?>" required>
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
                                                <input type="text" class="form-control" id="data_aquisicao" name="data_aquisicao" value="<?= htmlspecialchars($data_aquisicao) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Campos Ano de fabrico e custo de aquisição -->
                                        <div class="row mb-3"> 
                                            <div class="col-md-6">
                                                <label for="ano_fabrico" class="form-label">Ano de fabrico <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" min="1980" max="2026" placeholder="Ex: 2024" value="<?= htmlspecialchars($ano_fabrico) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="custo_aquisicao" class="form-label">Custo de aquisição (€) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="custo_aquisicao" name="custo_aquisicao" placeholder="Ex: 2500" step="0.01" value="<?= htmlspecialchars($custo_aquisicao) ?>"required>
                                            </div>                               
                                        </div>

                                        <!--Campos Tipo de entrada, Estado atual e Criticidade -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tipo_entrada" class="form-label">Entrada por: <span class="text-danger">*</span></label>
                                                <select class="form-control" id="tipo_entrada" name="tipo_entrada" required> 
                                                    <option value="" disabled <?= $tipo_entrada === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                    <option value="Compra"     <?= $tipo_entrada === 'Compra'     ? 'selected' : '' ?>>Compra</option>
                                                    <option value="Doação"     <?= $tipo_entrada === 'Doação'     ? 'selected' : '' ?>>Doação</option>
                                                    <option value="Aluguer"    <?= $tipo_entrada === 'Aluguer'    ? 'selected' : '' ?>>Aluguer</option>
                                                    <option value="Empréstimo" <?= $tipo_entrada === 'Empréstimo' ? 'selected' : '' ?>>Empréstimo</option>
                                                </select>
                                            </div>     
                                            <div class="col-md-4">
                                                <label for="estado" class="form-label">Estado atual <span class="text-danger">*</span></label>
                                                <select class="form-control" id="estado" name="estado" required> 
                                                    <option value="" disabled <?= $estado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                    <option value="Ativo"         <?= $estado === 'Ativo'         ? 'selected' : '' ?>>Ativo</option>
                                                    <option value="Inativo"       <?= $estado === 'Inativo'       ? 'selected' : '' ?>>Inativo</option>
                                                    <option value="Em Manutenção" <?= $estado === 'Em Manutenção' ? 'selected' : '' ?>>Em Manutenção</option>
                                                    <option value="Em Calibração" <?= $estado === 'Em Calibração' ? 'selected' : '' ?>>Em Calibração</option>
                                                    <option value="Em Quarentena" <?= $estado === 'Em Quarentena' ? 'selected' : '' ?>>Em Quarentena</option>
                                                    <option value="Abatido"       <?= $estado === 'Abatido'       ? 'selected' : '' ?>>Abatido</option>
                                                </select>
                                            </div>   
                                            <div class="col-md-4">
                                                <label for="criticidade" class="form-label">Criticidade <span class="text-danger">*</span></label>
                                                <select class="form-control" id="criticidade" name="criticidade_id" required> 
                                                    <option value="" disabled <?= $criticidade === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                    <option value="1" <?= $criticidade === '1' ? 'selected' : '' ?>>Baixa</option>
                                                    <option value="2" <?= $criticidade === '2' ? 'selected' : '' ?>>Média</option>
                                                    <option value="3" <?= $criticidade === '3' ? 'selected' : '' ?>>Alta</option>
                                                    <option value="4" <?= $criticidade === '4' ? 'selected' : '' ?>>Suporte de Vida</option>
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
                                                <textarea class="form-control" id="observacoes" name="observacoes" rows="4" placeholder="Informações adicionais sobre o equipamento..." ><?= htmlspecialchars($observacoes) ?></textarea>
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
                                            <div class="border rounded p-3 mb-4" id="blocoFornecedor1">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0" style="color:#680447;">
                                                        Fornecedor 1
                                                    </h6>
                                                </div>

                                                <!-- Selecionar fornecedor -->
                                                <div class="row mb-4">
                                                    <div class="col-md-6">

                                                        <select class="form-control"
                                                                name="fornecedor_id[]"
                                                                onchange="preencherFornecedorBloco(this,1)"
                                                                required>

                                                            <option value="" selected disabled>Escolha um fornecedor</option>
                                                            <?php foreach ($listaFornecedores as $f): ?>
                                                                <option value="<?= $f->id ?>">
                                                                    <?= htmlspecialchars($f->nome_empresa) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Informação -->
                                                <div id="infoFornecedor1" class="d-none">

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
                                                                <p id="f-nome-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>NIF</strong>
                                                                <p id="f-nif-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Tipo de fornecedor</strong>
                                                                <p id="f-tipo-1">-</p>
                                                            </div>

                                                        </div>

                                                        <!-- Coluna 2 -->
                                                        <div class="col-md-4">

                                                            <div class="mb-4">
                                                                <strong>Morada</strong>
                                                                <p id="f-morada-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Número telefónico</strong>
                                                                <p id="f-telefone-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Email</strong>
                                                                <p id="f-email-1">-</p>
                                                            </div>

                                                        </div>

                                                        <!-- Coluna 3 -->
                                                        <div class="col-md-4">

                                                            <div class="mb-4">
                                                                <strong>Website</strong>
                                                                <p id="f-website-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Pessoa de contacto</strong>
                                                                <p id="f-contacto-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Telefone da pessoa de contacto</strong>
                                                                <p id="f-tel-contacto-1">-</p>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

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
                                                    <option value="" selected disabled>Escolha uma localização</option>
                                                    <?php foreach ($listaLocalizacoes as $l): ?>
                                                        <option value="<?= $l->id ?>">
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

                                            <!-- DOCUMENTO 1 -->
                                            <div class="border rounded p-3 mb-4" id="blocoDocumento1">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0" style="color:#680447;">
                                                        Documento 1
                                                    </h6>

                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm"
                                                            onclick="eliminarBlocoDocumento(1)">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>

                                                <h6 class="mt-3 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-barcode me-2"></i>
                                                    Identificação
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="tipo_doc" class="form-label">Tipo de documento <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="tipo_doc[]" id="tipo_doc" required>
                                                            <option value="" disabled <?= ($docs[0]['tipo'] ?? '') === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                            <option value="Manual de utilizador"       <?= ($docs[0]['tipo'] ?? '') === 'Manual de utilizador'       ? 'selected' : '' ?>>Manual de utilizador</option>
                                                            <option value="Manual de serviço"          <?= ($docs[0]['tipo'] ?? '') === 'Manual de serviço'          ? 'selected' : '' ?>>Manual de serviço</option>
                                                            <option value="Certificado de calibração"  <?= ($docs[0]['tipo'] ?? '') === 'Certificado de calibração'  ? 'selected' : '' ?>>Certificado de calibração</option>
                                                            <option value="Contrato de manutenção"     <?= ($docs[0]['tipo'] ?? '') === 'Contrato de manutenção'     ? 'selected' : '' ?>>Contrato de manutenção</option>
                                                            <option value="Fatura / Guia de aquisição" <?= ($docs[0]['tipo'] ?? '') === 'Fatura / Guia de aquisição' ? 'selected' : '' ?>>Fatura / Guia de aquisição</option>
                                                            <option value="Declaração de conformidade" <?= ($docs[0]['tipo'] ?? '') === 'Declaração de conformidade' ? 'selected' : '' ?>>Declaração de conformidade</option>
                                                            <option value="Relatório técnico"          <?= ($docs[0]['tipo'] ?? '') === 'Relatório técnico'          ? 'selected' : '' ?>>Relatório técnico</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="nome_doc" class="form-label">Nome <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control"
                                                            id="nome_doc"
                                                            name="nome_doc[]"
                                                            placeholder="Ex: Manual de Utilização - Ventilador Evita V500"
                                                            value="<?= htmlspecialchars($docs[0]['nome'] ?? '') ?>" 
                                                            required>
                                                    </div>
                                                </div>

                                                <h6 class="mt-4 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                                    Datas
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="data_doc" class="form-label">Data <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="data_doc[]" id="data_doc" value="<?= htmlspecialchars($docs[0]['data'] ?? '') ?>" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="data_validade" class="form-label">Data de validade</label>
                                                        <input type="text" class="form-control" name="data_validade[]" id="data_validade" value="<?= htmlspecialchars($docs[0]['data_validade'] ?? '') ?>">
                                                    </div>
                                                </div>

                                                <h6 class="mt-4 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-link me-2"></i>
                                                    Associações e ficheiro
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="fornecedor_doc_id" class="form-label">Fornecedor associado</label>
                                                        <select class="form-control" name="fornecedor_doc_id[]" id="fornecedor_id">
                                                            <option value="" disabled <?= ($docs[0]['fornecedor'] ?? '') === '' ? 'selected' : '' ?>>Escolha um fornecedor</option>
                                                            <?php foreach ($listaFornecedores as $f): ?>
                                                                <option value="<?= $f->id ?>" <?= ($docs[0]['fornecedor'] ?? '') == $f->id ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($f->nome_empresa) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="ficheiro" class="form-label">Selecionar ficheiro <span class="text-danger">*</span></label>
                                                        <input type="file"
                                                            class="form-control"
                                                            name="ficheiro[]"
                                                            id="ficheiro"
                                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                            required>
                                                    </div>
                                                </div>

                                            </div>

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
                                                    <input type="text" class="form-control" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($data_inicio) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="data_fim" class="form-label">Data de fim de Garantia <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="data_fim" name="data_fim" value="<?= htmlspecialchars($data_fim) ?>" required>
                                                </div>
                                            </div>

                                            <!--Campo Contrato-->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="contrato_manutencao" class="form-label">
                                                        Contrato de manutenção <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control"
                                                            id="contrato_manutencao"
                                                            name="contrato_manutencao" required>

                                                        <option value="" disabled <?= $contrato === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                        <option value="Sim" <?= $contrato === 'Sim' ? 'selected' : '' ?>>Sim</option>
                                                        <option value="Não" <?= $contrato === 'Não' ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="tipo_contrato" class="form-label">
                                                        Tipo de contrato 
                                                    </label>

                                                    <select class="form-control"
                                                            id="tipo_contrato"
                                                            name="tipo_contrato">

                                                        <option value="" disabled <?= $tipo_contrato === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                        <option value="Preventivo" <?= $tipo_contrato === 'Preventivo' ? 'selected' : '' ?>>Preventivo</option>
                                                        <option value="Corretivo"  <?= $tipo_contrato === 'Corretivo'  ? 'selected' : '' ?>>Corretivo</option>
                                                        <option value="Completo"   <?= $tipo_contrato === 'Completo'   ? 'selected' : '' ?>>Completo</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="periodicidade" class="form-label">
                                                        Periodicidade 
                                                    </label>

                                                    <select class="form-control"
                                                            id="periodicidade"
                                                            name="periodicidade">

                                                        <option value="" disabled <?= $periodicidade === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                                        <option value="Mensal"     <?= $periodicidade === 'Mensal'     ? 'selected' : '' ?>>Mensal</option>
                                                        <option value="Trimestral" <?= $periodicidade === 'Trimestral' ? 'selected' : '' ?>>Trimestral</option>
                                                        <option value="Semestral"  <?= $periodicidade === 'Semestral'  ? 'selected' : '' ?>>Semestral</option>
                                                        <option value="Anual"      <?= $periodicidade === 'Anual'      ? 'selected' : '' ?>>Anual</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="entidade_responsavel" class="form-label">
                                                        Entidade responsável <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="entidade_responsavel"
                                                        name="entidade_responsavel"
                                                        placeholder="Ex: BioTech Portugal" value="<?= htmlspecialchars($entidade) ?>" required>
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
                                                    <textarea class="form-control" id="observacoes_garant" name="observacoes_garant" rows="4" placeholder="Informações adicionais sobre a Garantia/Contrato..." ><?= htmlspecialchars($obs_garantia) ?></textarea>
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
                                                    <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/equipamentos/lista.php" class="btn btn-outline-secondary mb-4">
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

<script>
flatpickr("#data_aquisicao", { dateFormat: "Y-m-d", locale: "pt" });
flatpickr("#data_inicio",    { dateFormat: "Y-m-d", locale: "pt" });
flatpickr("#data_fim",       { dateFormat: "Y-m-d", locale: "pt" });
flatpickr("#data_doc",       { dateFormat: "Y-m-d", locale: "pt" });
flatpickr("#data_validade",  { dateFormat: "Y-m-d", locale: "pt" });
</script>

<!-- Custom JS -->
<script src="/sibdas/1240811/projeto-sibdas/medinventec/assets/js/1240811.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>