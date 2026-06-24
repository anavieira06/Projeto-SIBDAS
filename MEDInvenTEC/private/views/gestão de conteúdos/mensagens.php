<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Só administrador pode ver mensagens
if ($_SESSION['perfil'] !== 'administrador') {
    header('Location: /sibdas/1240811/projeto-sibdas/medinventec/private/home.php');
    exit;
}

try {
    
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    // Marcar como lida se pedido
    if (isset($_GET['ler'])) {
        $id = (int) $_GET['ler'];
        $ligacao->prepare("UPDATE mensagens_contacto SET lida = 1 WHERE id = :id")->execute([':id' => $id]);
        header('Location: mensagens.php');
        exit;
    }

    $mensagens = $ligacao->query("SELECT * FROM mensagens_contacto ORDER BY data_envio DESC")->fetchAll(PDO::FETCH_OBJ);
    $naoLidas  = $ligacao->query("SELECT COUNT(*) FROM mensagens_contacto WHERE lida = 0")->fetchColumn();

    $ligacao = null;

} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}

include __DIR__ . '/../../includes/header.php';
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

        <div class="container-fluid p-4" style="background-color: #fff4fb; min-height: calc(100vh - 70px);">
            <div class="d-flex align-items-center mb-4">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-envelope me-2"></i>
                    <strong>Mensagens de Contacto</strong>
                </h2>
                <?php if ($naoLidas > 0): ?>
                <span class="badge bg-danger ms-3"><?= $naoLidas ?> não lidas</span>
                <?php endif; ?>
            </div>

            <div class="card border-0 shadow rounded-4">
                <div class="card-body">
                    <?php if (empty($mensagens)): ?>
                        <p class="text-muted">Nenhuma mensagem recebida.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Mensagem</th>
                                    <th>Data</th>
                                    <th>Estado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mensagens as $m): ?>
                                <tr class="<?= $m->lida ? '' : 'fw-bold' ?>">
                                    <td><?= htmlspecialchars($m->nome) ?></td>
                                    <td><?= htmlspecialchars($m->email) ?></td>
                                    <td><?= htmlspecialchars(mb_strimwidth($m->mensagem, 0, 60, '...')) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($m->data_envio) + 3600) ?></td>
                                    <td>
                                        <?php if ($m->lida): ?>
                                            <span class="badge bg-secondary">Lida</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Não lida</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalMensagem"
                                                data-nome="<?= htmlspecialchars($m->nome) ?>"
                                                data-email="<?= htmlspecialchars($m->email) ?>"
                                                data-mensagem="<?= htmlspecialchars($m->mensagem) ?>"
                                                data-data="<?= date('d/m/Y H:i', strtotime($m->data_envio) + 3600) ?>"
                                                data-id="<?= $m->id ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modal ver mensagem -->
        <div class="modal fade" id="modalMensagem" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#680447;">
                            <i class="fa-solid fa-envelope me-2"></i>
                            Mensagem de <span id="modalNome"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p><strong>Data:</strong> <span id="modalData"></span></p>
                        <hr>
                        <p id="modalMensagemTexto" style="white-space: pre-wrap;"></p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" id="btnMarcarLida" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-check me-1"></i> Marcar como lida
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    document.getElementById('modalMensagem').addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('modalNome').textContent         = btn.getAttribute('data-nome');
        document.getElementById('modalEmail').textContent        = btn.getAttribute('data-email');
        document.getElementById('modalData').textContent         = btn.getAttribute('data-data');
        document.getElementById('modalMensagemTexto').textContent = btn.getAttribute('data-mensagem');
        document.getElementById('btnMarcarLida').href            = '?ler=' + btn.getAttribute('data-id');
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>