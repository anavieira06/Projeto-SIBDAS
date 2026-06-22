<?php
// Inicia a sessão 
session_start();

// Buscar utilizadores de teste da BD
$utilizadores_teste = [];
try {
    require_once __DIR__ . '/../private/includes/funcoes.php';
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $ligacao->query("SELECT nome, email, perfil_id FROM utilizador ORDER BY perfil_id ASC");
    $utilizadores_teste = $stmt->fetchAll(PDO::FETCH_OBJ);
    $ligacao = null;
} catch (PDOException $e) {
    // silencioso — não afeta o login
}

// Inicializa a variável que irá conter os erros de validação
$validation_errors = [];
// Verifica se existem erros de validação guardados na sessão
if (!empty($_SESSION['validation_errors'])) {
    // Se existirem, copia-os para a variável local
    $validation_errors = $_SESSION['validation_errors'];
    // Remove os erros da sessão para que não apareçam novamente numa recarga de página
    unset($_SESSION['validation_errors']);
}
// Inicializa a variável que irá conter erros de servidor
$server_error = [];
// Verifica se existe algum erro de servidor guardado na sessão
if (!empty($_SESSION['server_error'])) {
    // Se existir, copia-o para a variável local
    $server_error = $_SESSION['server_error'];
    // Remove o erro da sessão após ser lido
    unset($_SESSION['server_error']);
}
?>

<?php
$bodyClass = 'bg-login';
include __DIR__ . '/../private/includes/header.php';
?>

        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-sm-8 col-10">
                    <!-- Card e restante conteúdo -->
                    <div class="card p-4" style="min-height: 500px;">
                        <div class="d-flex align-items-center justify-content-center my-4">
                            <!-- Imagem da empresa -->
                            <img src="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/assets/img/Imagem 3.jpeg" width="200">
                        </div>

                        <div class="row">
                            <div class="col">
                                <!-- Formulário -->
                                <form name="formulario" action="../private/processa_login.php" method="post">
                                    <div class="mb-3">
                                        <!-- Utilizador -->
                                        <label for="email" class="form-label">Utilizador</label>
                                        <input type="email" name="text_username" id="" class="form-control" placeholder="Insira o seu email">
                                    </div>

                                    <div class="mb-3">
                                        <!-- Password -->
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="text_password" id="" class="form-control" placeholder="Insira a sua password">
                                    </div>

                                    <div class="mb-3 text-center">
                                        <!-- Submit -->
                                        <button type="submit" class="btn px-4" style="background-color: #945880; color:#fff">
                                            Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i>
                                        </button>
                                    </div>

                                    <!-- Botões de preenchimento automático (Fase de Testes) -->
                                    <?php
                                    $perfil_label = [
                                        1 => 'Administrador',
                                        2 => 'Técnico',
                                        3 => 'Profissional de Saúde'
                                    ];
                                    ?>
                                    <div class="mt-4 d-flex justify-content-center gap-4">
                                        <?php foreach ($utilizadores_teste as $u): ?>
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-teste"
                                                data-email="<?= htmlspecialchars($u->email) ?>"
                                                data-perfil="<?= $u->perfil_id ?>"
                                                title="<?= $perfil_label[$u->perfil_id] ?? '' ?>">
                                            <?= htmlspecialchars($u->nome) ?>
                                        </button>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="text-center mt-4 mb-3">
                                        <a href="/sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/public/index.php"
                                        class="btn btn-sm btn-outline-secondary px-4">
                                            <i class="fa-solid fa-house me-2"></i> Voltar ao início
                                        </a>
                                    </div>

                                    <!-- Apresentação das mensagens de erros -->
                                    <?php if (!empty($validation_errors)) : ?> <!-- Verifica se existem erros de validação -->
                                        <!-- Se existirem, apresenta um alerta de erro (vermelho) usando as classes do Bootstrap -->
                                        <div class="alert alert-danger p-2 text-center">
                                            <!-- Percorre todos os erros de validação -->
                                            <?php foreach ($validation_errors as $error) : ?>
                                                <!-- Mostra cada erro dentro de uma <div>, escapando caracteres especiais para segurança -->
                                                <div><?= htmlspecialchars($error) ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Verifica se existe um erro de servidor -->
                                    <?php if (!empty($server_error)) : ?>
                                        <!-- Apresenta também num alerta de erro (vermelho) -->
                                        <div class="alert alert-danger p-2 text-center">
                                            <!-- Mostra o erro do servidor, também escapado com htmlspecialchars -->
                                            <div><?= htmlspecialchars($server_error) ?></div>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include __DIR__ . '/../private/includes/footer.php'; ?>

<script>
    document.querySelectorAll('.btn-teste').forEach(btn => {
        btn.addEventListener('click', () => {
            const f = document.forms['formulario'];
            const email = btn.getAttribute('data-email');
            f['text_username'].value = email;
            f['text_password'].value = '';
            f['text_password'].focus();
        });
    });
</script>