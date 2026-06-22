<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
 
$idEncriptado = $_GET['id'] ?? null;
$id = aes_decrypt($idEncriptado);
 
if (!$id || !is_numeric($id)) {
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php');
    exit;
}
 
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar estado atual antes de abater
    $stmtAtual = $ligacao->prepare("
        SELECT est.estado
        FROM equipamentos e
        INNER JOIN estado est ON e.estado_id = est.id
        WHERE e.id = :id
    ");
    $stmtAtual->execute([':id' => $id]);
    $estadoAtual = $stmtAtual->fetchColumn();

    // Abater equipamento
    $stmt = $ligacao->prepare("
    UPDATE equipamentos 
    SET ativo = 0, 
        estado_id = (SELECT id FROM estado WHERE estado = 'Abatido')
    WHERE id = :id
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Registar no histórico
    $utilizadorId = $_SESSION['perfil_id'] ?? null;
    $stmtHist = $ligacao->prepare("
        INSERT INTO historico_movimentacoes (equipamento_id, utilizador_id, tipo_alteracao, valor_anterior, valor_novo)
        VALUES (:eq_id, :user_id, 'Estado', :anterior, 'Abatido')
    ");
    $stmtHist->execute([
        ':eq_id'    => $id,
        ':user_id'  => $utilizadorId,
        ':anterior' => $estadoAtual
    ]);
 
    $ligacao = null;
 
    header('Location: /sibdas/1240811/ProjetoSIBDAS/MEDInvenTEC/private/views/equipamentos/lista.php?desativado=1');
    exit;
 
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}