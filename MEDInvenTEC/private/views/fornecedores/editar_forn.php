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
    header('Location: ' . BASE_URL . '/public/login.php');
    exit;
}

// Recolher o ID do fornecedor da URL
$idFornecedorEncriptado = $_GET['id'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncriptado);
 
if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/fornecedores/lista_forn.php');
    exit;
}

// --------------------------------------------------------------------
// PROCESSAR FORMULÁRIO (POST)
// --------------------------------------------------------------------
$erros        = [];
$erro_sistema = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    // 1. Recolher dados
    $nome_empresa        = $_POST["nome_empresa"]        ?? "";
    $nif                 = $_POST["nif"]                 ?? "";
    $morada              = $_POST["morada"]              ?? "";
    $tipo_fornecedor     = $_POST["tipo_fornecedor"]     ?? "";
    $numero_telefonico   = $_POST["numero_telefonico"]   ?? "";
    $email               = $_POST["email"]               ?? "";
    $website             = $_POST["website"]             ?? "";
    $pessoa_contacto     = $_POST["pessoa_contacto"]     ?? "";
    $tel_pessoa_contacto = $_POST["tel_pessoa_contacto"] ?? "";
    $observacoes         = $_POST["observacoes"]         ?? "";
 
    // 2. Validar
    $erros = validar_fornecedor([
        'nome_empresa'        => $nome_empresa,
        'nif'                 => $nif,
        'morada'              => $morada,
        'tipo_fornecedor'     => $tipo_fornecedor,
        'numero_telefonico'   => $numero_telefonico,
        'email'               => $email,
        'website'             => $website,
        'pessoa_contacto'     => $pessoa_contacto,
        'tel_pessoa_contacto' => $tel_pessoa_contacto,
    ]);

    // 3. Normalizar
    if (empty($erros)) {
        $nome_empresa      = ucwords(strtolower($nome_empresa));
        $morada            = ucwords(strtolower($morada));
        $pessoa_contacto   = ucwords(strtolower($pessoa_contacto));
        $email             = strtolower($email);
        $website           = strtolower($website);
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
 
            // Obter ID do tipo de fornecedor
            $stmtTipo = $ligacao->prepare("SELECT id FROM tipo_fornecedor WHERE tipo_fornecedor = :tipo LIMIT 1");
            $stmtTipo->execute([':tipo' => $tipo_fornecedor]);
            $tipoFornecedorId = $stmtTipo->fetchColumn();
 
            $stmt = $ligacao->prepare("UPDATE fornecedores SET
                nome_empresa        = :nome_empresa,
                nif                 = :nif,
                morada              = :morada,
                numero_telefonico   = :numero_telefonico,
                email               = :email,
                website             = :website,
                pessoa_contacto     = :pessoa_contacto,
                tel_pessoa_contacto = :tel_pessoa_contacto,
                observacoes         = :observacoes,
                tipo_fornecedor_id  = :tipo_fornecedor_id
                WHERE id = :id
            ");
 
            $stmt->execute([
                ':nome_empresa'        => $nome_empresa,
                ':nif'                 => $nif,
                ':morada'              => $morada,
                ':numero_telefonico'   => $numero_telefonico,
                ':email'               => $email,
                ':website'             => $website,
                ':pessoa_contacto'     => $pessoa_contacto,
                ':tel_pessoa_contacto' => $tel_pessoa_contacto,
                ':observacoes'         => $observacoes ?: null,
                ':tipo_fornecedor_id'  => $tipoFornecedorId,
                ':id'                  => $idFornecedor,
            ]);
 
            $ligacao = null;
 
            header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/fornecedores/lista_forn.php?atualizado=1');
            exit;
 
        } catch (PDOException $err) {
            if ($err->getCode() == 23000) {
                $erros[] = "Já existe um fornecedor registado com este NIF.";
            } else {
                $erro_sistema = "Erro ao atualizar os dados: " . $err->getMessage();
            }
        }
    }
}

// --------------------------------------------------------------------
// CARREGAR DADOS DO FORNECEDOR DA BD
// --------------------------------------------------------------------
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    $stmtForn = $ligacao->prepare("
        SELECT f.*, tf.tipo_fornecedor
        FROM fornecedores f
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        WHERE f.id = :id
        LIMIT 1
    ");
    $stmtForn->execute([':id' => $idFornecedor]);
    $fornecedor = $stmtForn->fetch(PDO::FETCH_OBJ);
 
    if (!$fornecedor) {
        header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/fornecedores/lista_forn.php');
        exit;
    }
 
    // Se veio do GET, preencher com dados da BD
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $nome_empresa        = $fornecedor->nome_empresa;
        $nif                 = $fornecedor->nif;
        $morada              = $fornecedor->morada;
        $tipo_fornecedor     = $fornecedor->tipo_fornecedor;
        $numero_telefonico   = $fornecedor->numero_telefonico;
        $email               = $fornecedor->email;
        $website             = $fornecedor->website;
        $pessoa_contacto     = $fornecedor->pessoa_contacto;
        $tel_pessoa_contacto = $fornecedor->tel_pessoa_contacto;
        $observacoes         = $fornecedor->observacoes ?? '';
    }
 
    $listaTiposFornecedor = $ligacao->query("SELECT id, tipo_fornecedor FROM tipo_fornecedor ORDER BY tipo_fornecedor")->fetchAll(PDO::FETCH_OBJ);
 
    $ligacao = null;
 
} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar os dados: " . $err->getMessage();
    $listaTiposFornecedor = [];
}

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
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-pen-to-square me-2"></i> Atualização de Dados FORNECEDORES</strong></h2>
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

                            <form action="#" method="post">
                                <!-- Campo nome da empresa --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="nome_empresa" class="form-label">Nome da empresa<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" value="<?= htmlspecialchars($nome_empresa) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo NIF --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="nif" class="form-label">NIF<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nif" name="nif" value="<?= htmlspecialchars($nif) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo Morada --> 
                                <div class="row mb-3"> 
                                    <div class="col-12">
                                        <label for="morada" class="form-label">Morada <span class="text-danger">*</span></label> 
                                        <input type="text" class="form-control" id="morada" name="morada" value="<?= htmlspecialchars($morada) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo Tipo de fornecedor -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="tipo_fornecedor" class="form-label">Tipo de fornecedor <span class="text-danger">*</span></label>
                                        <select class="form-control" id="tipo_fornecedor" name="tipo_fornecedor" required>
                                            <option value="" disabled <?= $tipo_fornecedor === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                            <?php foreach ($listaTiposFornecedor as $opcao): ?>
                                                <option value="<?= htmlspecialchars($opcao->tipo_fornecedor) ?>"
                                                    <?= ($tipo_fornecedor === $opcao->tipo_fornecedor) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($opcao->tipo_fornecedor) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>      
                                </div>

                                <!-- Secção: Contactos -->
                                <h5 class="mt-4 mb-3" style="color:#680447;">
                                    <i class="fa-solid fa-phone me-2"></i>
                                    Contactos
                                </h5>

                                <!-- Campos Número telefónico, Email e Website-->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="numero_telefonico" class="form-label">Número telefónico <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="numero_telefonico" name="numero_telefonico" value="<?= htmlspecialchars($numero_telefonico) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website" class="form-label">Website <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="website" name="website" value="<?= htmlspecialchars($website) ?>" required>
                                    </div>
                                </div>

                                <!-- Campos Pessoa de contacto e Telefone da pessoa de contacto -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="pessoa_contacto" class="form-label">Pessoa de contacto <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pessoa_contacto" name="pessoa_contacto" value="<?= htmlspecialchars($pessoa_contacto) ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="tel_pessoa_contacto" class="form-label">Telefone da pessoa de contacto <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tel_pessoa_contacto" name="tel_pessoa_contacto" value="<?= htmlspecialchars($tel_pessoa_contacto) ?>" required>
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
                                        <textarea class="form-control" id="observacoes" name="observacoes" rows="4"><?= htmlspecialchars($observacoes) ?></textarea>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="d-flex justify-content-end gap-2 mb-4">
                                    <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECprivate/views/fornecedores/lista_forn.php" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-xmark me-1"></i> Cancelar 
                                    </a>
                                    <button type="submit" class="btn btn-guardar">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar
                                    </button>
                                </div>
                            </form>
                    </div>
                </div>
            </main>

<!-- Custom JS -->
<script src="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTECassets/js/1240811.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>