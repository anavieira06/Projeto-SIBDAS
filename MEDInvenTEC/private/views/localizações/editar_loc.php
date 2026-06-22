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
    header('Location: ' . '/sibdas/1240811/projeto-sibdas/medinventec/public/login.php');
    exit;
}
 
// Recolher o ID da localização da URL
$idLocalizacaoEncriptado = $_GET['id'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncriptado);
 
if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
    header('Location: /sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php');
    exit;
}

// --------------------------------------------------------------------
// PROCESSAR FORMULÁRIO (POST)
// --------------------------------------------------------------------
$erros        = [];
$erro_sistema = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    // 1. Recolher dados
    $edificio       = $_POST["edificio"]       ?? "";
    $piso           = $_POST["piso"]           ?? "";
    $servico_depart = $_POST["servico_depart"] ?? "";
    $sala_gabinete  = $_POST["sala_gabinete"]  ?? "";
 
    // 2. Validar
    $erros = validar_localizacao([
        'edificio'          => $edificio,
        'piso'              => $piso,
        'servico_depart'    => $servico_depart,
        'sala_gabinete'     => $sala_gabinete,
    ]);
 
    // 3. Normalizar
    if (empty($erros)) {
        $edificio       = ucwords(strtolower($edificio));
        $piso           = ucwords(strtolower($piso));
        $servico_depart = ucwords(strtolower($servico_depart));
        $sala_gabinete  = strtoupper($sala_gabinete);
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
 
            $stmt = $ligacao->prepare("UPDATE localizacoes SET
                edificio       = :edificio,
                piso           = :piso,
                servico_depart = :servico_depart,
                sala_gabinete  = :sala_gabinete
                WHERE id = :id
            ");
 
            $stmt->execute([
                ':edificio'       => $edificio,
                ':piso'           => $piso,
                ':servico_depart' => $servico_depart,
                ':sala_gabinete'  => $sala_gabinete,
                ':id'             => $idLocalizacao,
            ]);
 
            $ligacao = null;
 
            header('Location: /sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php?atualizado=1');
            exit;
 
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao atualizar os dados: " . $err->getMessage();
        }
    }
}

// --------------------------------------------------------------------
// CARREGAR DADOS DA LOCALIZAÇÃO DA BD
// --------------------------------------------------------------------
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    $stmtLoc = $ligacao->prepare("
        SELECT * FROM localizacoes
        WHERE id = :id
        LIMIT 1
    ");
    $stmtLoc->execute([':id' => $idLocalizacao]);
    $localizacao = $stmtLoc->fetch(PDO::FETCH_OBJ);
 
    if (!$localizacao) {
        header('Location: /sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php');
        exit;
    }
 
    // Se veio do GET, preencher com dados da BD
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $edificio       = $localizacao->edificio;
        $piso           = $localizacao->piso;
        $servico_depart = $localizacao->servico_depart;
        $sala_gabinete  = $localizacao->sala_gabinete;
    }
 
    $ligacao = null;
 
} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar os dados: " . $err->getMessage();
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
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-pen-to-square me-2"></i> Atualização de Dados LOCALIZAÇÕES</strong></h2>
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
                                <!-- Campo edifício --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="edificio" class="form-label">Edifício<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edificio" name="edificio" value="<?= htmlspecialchars($edificio) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo piso --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="piso" class="form-label">Piso<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="piso" name="piso" value="<?= htmlspecialchars($piso) ?>" required >
                                    </div>
                                </div>

                                <!-- Campos serviço / departamento -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="servico_depart" class="form-label">Serviço / Departamento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="servico_depart" name="servico_depart" value="<?= htmlspecialchars($servico_depart) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo Sala / Gabinete --> 
                                <div class="row mb-3"> 
                                    <div class="col-12">
                                        <label for="sala_gabinete" class="form-label">Sala / Gabinete <span class="text-danger">*</span></label> 
                                        <input type="text" class="form-control" id="sala_gabinete" name="sala_gabinete" value="<?= htmlspecialchars($sala_gabinete) ?>" required>
                                    </div>
                                </div>                           

                                <!-- Botões -->
                                <div class="d-flex justify-content-end gap-2 mb-4">
                                    <a href="/sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php" class="btn btn-outline-secondary">
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



<?php include __DIR__ . '/../../includes/footer.php'; ?>