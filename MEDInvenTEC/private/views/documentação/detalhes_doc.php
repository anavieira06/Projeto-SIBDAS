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
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/documentação/lista_doc.php');
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
        SELECT d.*,
               td.tipo_doc,
               e.codigo_inventario, e.designacao_equipamento,
               f.nome_empresa AS fornecedor_doc
        FROM documentos d
        LEFT JOIN tipo_doc td     ON d.tipo_doc_id    = td.id
        LEFT JOIN equipamentos e  ON d.equipamento_id = e.id
        LEFT JOIN fornecedores f  ON d.fornecedor_id  = f.id
        WHERE d.id = :id
        LIMIT 1
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $doc = $stmt->fetch(PDO::FETCH_OBJ);
 
    if (!$doc) {
        header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/documentação/lista_doc.php');
        exit;
    }
 
    $ligacao = null;
 
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}
$bodyClass = 'bg-doc';

include __DIR__ . '/../../includes/header.php'; 
?>
<?php
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
?>


        <div class="container-fluid p-4" style="background-color: #fff4fb;">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes do Documento</strong>
                </h2>
            </div>

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
            <div class="row g-4 mb-4">

                <!-- Datas -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 ">
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
                    <div class="card shadow-sm rounded-4 border-0 ">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-link me-2"></i>
                                Associações
                            </h5>

                            <div class="mb-3">
                                <small class="text-muted">Equipamento associado</small>
                                <p class="fw-semibold mb-0"><?= htmlspecialchars($doc->codigo_inventario) ?> — <?= htmlspecialchars($doc->designacao_equipamento) ?></p>
                            </div>

                            <div>
                                <small class="text-muted">Fornecedor associado</small>
                                <p class="fw-semibold mb-0"><?= htmlspecialchars($doc->fornecedor_doc ?? '—') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ficheiro -->
                <div class="col-lg-6 mx-auto">
                    <div class="card shadow-sm rounded-4 border-0 ">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-paperclip me-2"></i>
                                Ficheiro
                            </h5>

                            <div>
                                <small class="text-muted">Nome do ficheiro</small>
                                <p class="fw-semibold mb-0"><?= htmlspecialchars($doc->ficheiro ?? '—') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Botoão -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/documentação/lista_doc.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>