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
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/lista_forn.php');
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
        SELECT f.*, tf.tipo_fornecedor
        FROM fornecedores f
        LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
        WHERE f.id = :id
        LIMIT 1
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $forn = $stmt->fetch(PDO::FETCH_OBJ);
 
    if (!$forn) {
        header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/lista_forn.php');
        exit;
    }
 
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

        

        <div class="container-fluid p-4" style="background-color: #fff4fb; min-height: calc(100vh - 70px);">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes do Fornecedor</strong>
                    <?php if ($forn->ativo == 1): ?>
                        <span class="badge bg-success ms-2">Ativo</span>
                    <?php else: ?>
                        <span class="badge bg-secondary ms-2">Inativo</span>
                    <?php endif; ?>
                </h2>
            </div>

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
                    <div class="card shadow-sm rounded-4 border-0 h-100">
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
                    <div class="card shadow-sm rounded-4 border-0 h-100">
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
                    <div class="card shadow-sm rounded-4 border-0 h-100">
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
                    <div class="card shadow-sm rounded-4 border-0 h-100">
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

                <!-- Observações -->
                <div class="col-12">
                    <div class="card shadow-sm rounded-4 border-0">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-note-sticky me-2"></i>
                                Observações
                            </h5>
                            <p class="mb-0"><?= htmlspecialchars($forn->observacoes ?? '—') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botoão -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/fornecedores/lista_forn.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>



<?php include __DIR__ . '/../../includes/footer.php'; ?>