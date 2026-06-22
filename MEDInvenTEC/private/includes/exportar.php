<?php
require_once __DIR__ . '/funcoes.php';
redirect_if_not_logged();

$tabela  = $_GET['tabela']  ?? '';
$formato = $_GET['formato'] ?? '';

$tabelasPermitidas = ['equipamentos', 'fornecedores', 'localizacoes', 'documentos', 'garantias'];

if (!in_array($tabela, $tabelasPermitidas) || !in_array($formato, ['csv', 'json', 'pdf'])) {
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

    // Queries por tabela
    switch ($tabela) {
        case 'equipamentos':
            $titulo = 'Equipamentos';
            $dados = $ligacao->query("
                SELECT e.codigo_inventario AS 'Código', e.designacao_equipamento AS 'Designação',
                       e.marca AS 'Marca', e.modelo AS 'Modelo', e.numero_serie AS 'Nº Série',
                       e.fabricante AS 'Fabricante', e.data_aquisicao AS 'Data Aquisição',
                       e.ano_fabrico AS 'Ano Fabrico', e.custo_aquisicao AS 'Custo (€)',
                       cg.categoria_grupo AS 'Categoria', est.estado AS 'Estado',
                       c.criticidade AS 'Criticidade', te.tipo_entrada AS 'Tipo Entrada',
                       GROUP_CONCAT(f.nome_empresa ORDER BY f.nome_empresa SEPARATOR ', ') AS 'Fornecedores',
                       l.servico_depart AS 'Serviço/Departamento',
                       IF(e.ativo=1,'Ativo','Inativo') AS 'Registo'
                FROM equipamentos e
                INNER JOIN categoria_grupo cg ON e.categoria_grupo_id = cg.id
                INNER JOIN estado est ON e.estado_id = est.id
                INNER JOIN criticidade c ON e.criticidade_id = c.id
                INNER JOIN tipo_entrada te ON e.tipo_entrada_id = te.id
                LEFT JOIN equipamento_fornecedor ef ON ef.equipamento_id = e.id
                LEFT JOIN fornecedores f ON ef.fornecedor_id = f.id
                INNER JOIN localizacoes l ON e.localizacao_id = l.id
                GROUP BY e.id
                ORDER BY e.codigo_inventario
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'fornecedores':
            $titulo = 'Fornecedores';
            $dados = $ligacao->query("
                SELECT f.nome_empresa AS 'Empresa', f.nif AS 'NIF',
                       tf.tipo_fornecedor AS 'Tipo', f.morada AS 'Morada',
                       f.numero_telefonico AS 'Telefone', f.email AS 'Email',
                       f.website AS 'Website', f.pessoa_contacto AS 'Pessoa Contacto',
                       f.tel_pessoa_contacto AS 'Tel. Contacto',
                       IF(f.ativo=1,'Ativo','Inativo') AS 'Registo'
                FROM fornecedores f
                LEFT JOIN tipo_fornecedor tf ON f.tipo_fornecedor_id = tf.id
                ORDER BY f.nome_empresa
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'localizacoes':
            $titulo = 'Localizações';
            $dados = $ligacao->query("
                SELECT edificio AS 'Edifício', piso AS 'Piso',
                       servico_depart AS 'Serviço/Departamento', sala_gabinete AS 'Sala/Gabinete',
                       IF(ativo=1,'Ativo','Inativo') AS 'Registo'
                FROM localizacoes
                ORDER BY servico_depart
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'documentos':
            $titulo = 'Documentação';
            $dados = $ligacao->query("
                SELECT d.nome_doc AS 'Nome', td.tipo_doc AS 'Tipo',
                       d.data_doc AS 'Data', d.data_validade AS 'Validade',
                       d.ficheiro AS 'Ficheiro',
                       e.codigo_inventario AS 'Equipamento',
                       f.nome_empresa AS 'Fornecedor'
                FROM documentos d
                LEFT JOIN tipo_doc td ON d.tipo_doc_id = td.id
                INNER JOIN equipamentos e ON d.equipamento_id = e.id
                LEFT JOIN fornecedores f ON d.fornecedor_id = f.id
                ORDER BY d.data_doc DESC
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'garantias':
            $titulo = 'Garantias e Contratos';
            $dados = $ligacao->query("
                SELECT e.codigo_inventario AS 'Equipamento',
                       gc.data_inicio AS 'Início Garantia', gc.data_fim AS 'Fim Garantia',
                       IF(gc.contrato_manutencao=1,'Sim','Não') AS 'Contrato Manutenção',
                       tc.tipo_contrato AS 'Tipo Contrato', p.periodicidade AS 'Periodicidade',
                       gc.entidade_responsavel AS 'Entidade Responsável'
                FROM garantias_contratos gc
                INNER JOIN equipamentos e ON e.garantia_contrato_id = gc.id
                LEFT JOIN tipo_contrato tc ON gc.tipo_contrato_id = tc.id
                LEFT JOIN periodicidade p ON gc.periodicidade_id = p.id
                ORDER BY gc.data_fim ASC
            ")->fetchAll(PDO::FETCH_ASSOC);
            break;
    }

    $ligacao = null;

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

$nomeFicheiro = $tabela . '_' . date('Y-m-d');

// CSV
if ($formato === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nomeFicheiro . '.csv"');
    $out = fopen('php://output', 'w');
    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para Excel abrir com acentos
    if (!empty($dados)) {
        fputcsv($out, array_keys($dados[0]), ';');
        foreach ($dados as $linha) {
            fputcsv($out, $linha, ';');
        }
    }
    fclose($out);
    exit;
}

// JSON
if ($formato === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nomeFicheiro . '.json"');
    echo json_encode(['tabela' => $titulo, 'data' => date('Y-m-d H:i:s'), 'total' => count($dados), 'dados' => $dados], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// PDF
if ($formato === 'pdf') {
    // HTML simples convertido para PDF via print CSS
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <!DOCTYPE html>
    <html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($titulo) ?></title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; }
            h1 { color: #680447; font-size: 16px; margin-bottom: 5px; }
            p { color: #666; font-size: 10px; margin-bottom: 15px; }
            table { width: 100%; border-collapse: collapse; }
            th { background-color: #680447; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
            td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 10px; }
            tr:nth-child(even) { background-color: #fff4fb; }
            @media print { button { display: none; } }
        </style>
    </head>
    <body>
        <h1><?= htmlspecialchars($titulo) ?></h1>
        <p>Exportado em <?= date('d/m/Y H:i') ?> — Total: <?= count($dados) ?> registos</p>
        <button onclick="window.print()" style="margin-bottom:15px; padding:8px 16px; background:#680447; color:white; border:none; border-radius:6px; cursor:pointer;">
            Imprimir / Guardar como PDF
        </button>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($dados[0] ?? []) as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $linha): ?>
                <tr>
                    <?php foreach ($linha as $val): ?>
                    <td><?= htmlspecialchars($val ?? '—') ?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
    </html>
    <?php
    exit;
}