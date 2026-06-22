<?php
require_once __DIR__ . '/includes/funcoes.php';
redirect_if_not_logged();

$erros = [];
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_atual = $_POST['password_atual']       ?? '';
    $password_nova  = $_POST['password_nova']        ?? '';
    $password_conf  = $_POST['password_confirmacao'] ?? '';

    // Validar
    if (empty($password_atual)) {
        $erros[] = 'A password atual é obrigatória.';
    }
    if (strlen($password_nova) < 6 || strlen($password_nova) > 20) {
        $erros[] = 'A nova password deve ter entre 6 e 20 caracteres.';
    }
    if ($password_nova !== $password_conf) {
        $erros[] = 'A confirmação da password não coincide.';
    }

    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Buscar password atual da BD
            $stmt = $ligacao->prepare("SELECT password FROM utilizador WHERE email = :email");
            $stmt->execute([':email' => $_SESSION['email']]);
            $utilizador = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$utilizador || !password_verify($password_atual, $utilizador->password)) {
                $erros[] = 'A password atual está incorreta.';
            } else {
                // Atualizar password
                $novoHash = password_hash($password_nova, PASSWORD_DEFAULT);
                $stmtUpdate = $ligacao->prepare("UPDATE utilizador SET password = :password WHERE email = :email");
                $stmtUpdate->execute([':password' => $novoHash, ':email' => $_SESSION['email']]);
                $sucesso = true;
            }

            $ligacao = null;

        } catch (PDOException $e) {
            $erros[] = 'Erro ao atualizar a password: ' . $e->getMessage();
        }
    }
}

include __DIR__ . '/includes/header.php';
$pagina = 'index';
include __DIR__ . '/includes/nav.php';
?>

<div class="container-fluid" style="background-color: #fff4fb; min-height: calc(100vh - 70px);">
    <div class="row justify-content-center pt-5">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <h4 class="mb-4" style="color:#680447;">
                        <i class="fa-solid fa-key me-2"></i>
                        <strong>Alterar Password</strong>
                    </h4>
                    <hr>

                    <?php if ($sucesso): ?>
                        <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                            <i class="fa-solid fa-circle-check"></i>
                            Password alterada com sucesso!
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Password atual <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_atual" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nova password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_nova" required>
                            <small class="text-muted">Entre 6 e 20 caracteres</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Confirmar nova password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmacao" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/home.php" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-guardar">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>