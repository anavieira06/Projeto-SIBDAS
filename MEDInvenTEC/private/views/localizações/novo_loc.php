<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
require_once __DIR__ . '/../../includes/validacoes.php';

// Valores por defeito
$erros          = [];
$edificio       = '';
$piso           = '';
$servico_depart = '';
$sala_gabinete  = '';
$erro_sistema   = '';

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
 
    // 3. Se não houver erros
    if (empty($erros)) {
 
        // 4. Normalizar dados
        $edificio       = ucwords(strtolower($edificio));
        $piso           = ucwords(strtolower($piso));
        $servico_depart = ucwords(strtolower($servico_depart));
        $sala_gabinete  = strtoupper($sala_gabinete);
 
        // 5. Guardar na base de dados
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
            $sql = "INSERT INTO localizacoes (
                    edificio, piso, servico_depart, sala_gabinete
                ) VALUES (
                    :edificio, :piso, :servico_depart, :sala_gabinete
                )";
 
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':edificio'       => $edificio,
                ':piso'           => $piso,
                ':servico_depart' => $servico_depart,
                ':sala_gabinete'  => $sala_gabinete,
            ]);
 
            $ligacao = null;
 
            header('Location: /sibdas/1240811/projeto-sibdas/medinventec/private/views/localizações/lista_loc.php?sucesso=1');
            exit;
 
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao guardar os dados: " . $err->getMessage();
        }
    }
}

include __DIR__ . '/../../includes/header.php'; 
?>

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
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-plus me-2" style="color: #680447;"></i> Inserir nova localização</strong></h2>
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

                            <form id="formLocalizaçao" action="#" method="post">
                                <!-- Campo Edifício --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="edificio" class="form-label">Edifício<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edificio" name="edificio" placeholder="Ex: Edifício Central Hospitalar" value="<?= htmlspecialchars($edificio) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo Piso --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="piso" class="form-label">Piso<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="piso" name="piso" placeholder="Ex: 2" value="<?= htmlspecialchars($piso) ?>" required>
                                    </div>
                                </div>

                                <!-- Campos Serviço/Departamento -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="servico_depart" class="form-label">Seviço / Departamento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="servico_depart" name="servico_depart" placeholder="Ex: Cardiologia" value="<?= htmlspecialchars($servico_depart) ?>" required>
                                    </div>
                                </div>

                                <!-- Campo Sala/Gabinete --> 
                                <div class="row mb-3"> 
                                    <div class="col-12">
                                        <label for="sala_gabinete" class="form-label">Sala / Gabinete <span class="text-danger">*</span></label> 
                                        <input type="text" class="form-control" id="sala_gabinete" name="sala_gabinete" placeholder="Ex: LAB01" value="<?= htmlspecialchars($sala_gabinete) ?>" required>
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
                </div>
            </main>

<!-- Custom JS -->
<script src="/sibdas/1240811/projeto-sibdas/medinventec/assets/js/1240811.js"></script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>