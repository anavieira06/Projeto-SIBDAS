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
    header('Location: /ProjetoSIBDAS/Frontend/private/views/localizações/lista_loc.php');
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
        SELECT * FROM localizacoes WHERE id = :id LIMIT 1
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $loc = $stmt->fetch(PDO::FETCH_OBJ);
 
    if (!$loc) {
        header('Location: /ProjetoSIBDAS/Frontend/private/views/localizações/lista_loc.php');
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
                    <strong>Detalhes da Localização</strong>
                </h2>
            </div>
            
            <!-- Localização -->
            <div class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body">

                    <h5 class="mb-4" style="color:#680447;">
                        <i class="fa-solid fa-location-dot me-2"></i>
                        Localização
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <small class="text-muted">Edifício</small>
                            <p class="fw-semibold mb-0"><?= htmlspecialchars($loc->edificio) ?></p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Piso</small>
                            <p class="fw-semibold mb-0"><?= htmlspecialchars($loc->piso) ?></p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Serviço / Departamento</small>
                            <p class="fw-semibold mb-0"><?= htmlspecialchars($loc->servico_depart) ?></p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Sala / Gabinete</small>
                            <p class="fw-semibold mb-0"><?= htmlspecialchars($loc->sala_gabinete) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botoão -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="/ProjetoSIBDAS/Frontend/private/views/localizações/lista_loc.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>



<?php include __DIR__ . '/../../includes/footer.php'; ?>