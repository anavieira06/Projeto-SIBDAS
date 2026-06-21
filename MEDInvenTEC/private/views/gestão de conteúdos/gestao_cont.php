<?php 
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Ligação à BD
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p class='text-danger'>Erro: " . $e->getMessage() . "</p>");
}

// PROCESSAR POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seccao = $_POST['seccao'] ?? '';

    if ($seccao === 'sobre_nos') {
        $stmt = $ligacao->prepare("UPDATE gestao_sobre_nos SET menu_sobre_nos=:menu, titulo=:titulo, conteudo=:conteudo, texto_botao=:botao, data_ultima_alteracao=NOW() WHERE id=1");
        $stmt->execute([':menu' => $_POST['menu_sobre_nos'], ':titulo' => $_POST['titulo'], ':conteudo' => $_POST['conteudo'], ':botao' => $_POST['texto_botao']]);
    }

    if ($seccao === 'problema_solucao') {
        $stmt = $ligacao->prepare("UPDATE gestao_problema_solucao SET menu_problema_solucao=:menu, titulo1=:t1, paragrafo1=:p1, paragrafo2=:p2, paragrafo3=:p3, titulo2=:t2, paragrafo1_vant=:pv1, paragrafo2_vant=:pv2, paragrafo3_vant=:pv3, data_ultima_alteracao=NOW() WHERE id=1");
        $stmt->execute([':menu' => $_POST['menu_problema_solucao'], ':t1' => $_POST['titulo1'], ':p1' => $_POST['paragrafo1'], ':p2' => $_POST['paragrafo2'], ':p3' => $_POST['paragrafo3'], ':t2' => $_POST['titulo2'], ':pv1' => $_POST['paragrafo1_vant'], ':pv2' => $_POST['paragrafo2_vant'], ':pv3' => $_POST['paragrafo3_vant']]);
    }

    if ($seccao === 'vantagens') {
        $stmt = $ligacao->prepare("UPDATE gestao_vantagens SET menu_vantagens=:menu, titulo=:titulo, data_ultima_alteracao=NOW() WHERE id=1");
        $stmt->execute([':menu' => $_POST['menu_vantagens'], ':titulo' => $_POST['titulo_vantagens']]);
        $vantagens = $_POST['vantagem'] ?? [];
        $ids = $_POST['vantagem_id'] ?? [];
        foreach ($vantagens as $i => $v) {
            $stmtV = $ligacao->prepare("UPDATE vantagens SET vantagem=:v WHERE id=:id");
            $stmtV->execute([':v' => $v, ':id' => $ids[$i]]);
        }
    }

    if ($seccao === 'funcionalidades') {
        $stmt = $ligacao->prepare("UPDATE gestao_funcionalidades SET menu_funcionalidades=:menu, titulo=:titulo, texto_introdutorio=:intro, data_ultima_alteracao=NOW() WHERE id=1");
        $stmt->execute([':menu' => $_POST['menu_funcionalidades'], ':titulo' => $_POST['titulo_func'], ':intro' => $_POST['texto_introdutorio']]);
        $ids     = $_POST['func_id']    ?? [];
        $icones  = $_POST['icone']      ?? [];
        $titulos = $_POST['titulo_funcionalidade'] ?? [];
        $descs   = $_POST['descricao']  ?? [];
        foreach ($ids as $i => $fid) {
            $stmtF = $ligacao->prepare("UPDATE funcionalidades SET icone=:ic, titulo_funcionalidade=:t, descricao=:d WHERE id=:id");
            $stmtF->execute([':ic' => $icones[$i], ':t' => $titulos[$i], ':d' => $descs[$i], ':id' => $fid]);
        }
    }

    if ($seccao === 'contacto') {
        $stmt = $ligacao->prepare("UPDATE gestao_contacto SET menu_contacto=:menu, titulo=:titulo, texto_introdutorio=:intro, etiqueta1=:e1, etiqueta2=:e2, etiqueta3=:e3, texto_botao=:botao, data_ultima_alteracao=NOW() WHERE id=1");
        $stmt->execute([':menu' => $_POST['menu_contacto'], ':titulo' => $_POST['titulo_contacto'], ':intro' => $_POST['texto_introdutorio_contacto'], ':e1' => $_POST['etiqueta1'], ':e2' => $_POST['etiqueta2'], ':e3' => $_POST['etiqueta3'], ':botao' => $_POST['texto_botao_contacto']]);
    }

    if ($seccao === 'rodape') {
        $stmt = $ligacao->prepare("UPDATE gestao_rodape SET localizacao=:loc, morada=:morada, horario=:horario, horas=:horas, contactos=:contactos, email=:email, telefone=:telefone, data_ultima_alteracao=NOW() WHERE id=1");
        $stmt->execute([':loc' => $_POST['localizacao'], ':morada' => $_POST['morada'], ':horario' => $_POST['horario'], ':horas' => $_POST['horas'], ':contactos' => $_POST['contactos'], ':email' => $_POST['email'], ':telefone' => $_POST['telefone']]);
    }

    header('Location: gestao_cont.php?guardado=1');
    exit;
}

// BUSCAR DADOS DA BD
$sobreNos        = $ligacao->query("SELECT * FROM gestao_sobre_nos WHERE id=1")->fetch(PDO::FETCH_OBJ);
$problemaSolucao = $ligacao->query("SELECT * FROM gestao_problema_solucao WHERE id=1")->fetch(PDO::FETCH_OBJ);
$vantagens_hdr   = $ligacao->query("SELECT * FROM gestao_vantagens WHERE id=1")->fetch(PDO::FETCH_OBJ);
$vantagens       = $ligacao->query("SELECT * FROM vantagens WHERE gestao_vantagens_id=1")->fetchAll(PDO::FETCH_OBJ);
$funcionalidades_hdr = $ligacao->query("SELECT * FROM gestao_funcionalidades WHERE id=1")->fetch(PDO::FETCH_OBJ);
$funcionalidades = $ligacao->query("SELECT * FROM funcionalidades WHERE gestao_funcionalidades_id=1")->fetchAll(PDO::FETCH_OBJ);
$contacto        = $ligacao->query("SELECT * FROM gestao_contacto WHERE id=1")->fetch(PDO::FETCH_OBJ);
$rodape          = $ligacao->query("SELECT * FROM gestao_rodape WHERE id=1")->fetch(PDO::FETCH_OBJ);

$ligacao = null;

include __DIR__ . '/../../includes/header.php';
$pagina = 'normal';
include __DIR__ . '/../../includes/nav.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <strong>Gestão de Conteúdos Públicos</strong>
                </h2>
            </div>
            <p class="text-muted">Gerir textos, contactos e secções apresentados na área pública.</p>

            <?php if (isset($_GET['guardado'])): ?>
            <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-circle-check"></i> Alterações guardadas com sucesso!
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <colgroup>
                                <col style="width: 25%;">
                                <col style="width: 45%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Secção</th>
                                    <th>Conteúdo editável</th>
                                    <th>Última alteração</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Sobre nós</strong></td>
                                    <td>Título, subtítulo e botão principal</td>
                                    <td><?= $sobreNos->data_ultima_alteracao ? date('d/m/Y', strtotime($sobreNos->data_ultima_alteracao)) : '—' ?></td>
                                    <td><button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalSobreNos"><i class="fa-solid fa-pen-to-square m-1"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Problema e Solução</strong></td>
                                    <td>Apresentação do problema e proposta de solução</td>
                                    <td><?= $problemaSolucao->data_ultima_alteracao ? date('d/m/Y', strtotime($problemaSolucao->data_ultima_alteracao)) : '—' ?></td>
                                    <td><button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalProblemaSolucao"><i class="fa-solid fa-pen-to-square m-1"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Vantagens</strong></td>
                                    <td>Lista de vantagens da plataforma</td>
                                    <td><?= $vantagens_hdr->data_ultima_alteracao ? date('d/m/Y', strtotime($vantagens_hdr->data_ultima_alteracao)) : '—' ?></td>
                                    <td><button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalVantagens"><i class="fa-solid fa-pen-to-square m-1"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Funcionalidades</strong></td>
                                    <td>Funcionalidades em cards, com ícone, título e descrição</td>
                                    <td><?= $funcionalidades_hdr->data_ultima_alteracao ? date('d/m/Y', strtotime($funcionalidades_hdr->data_ultima_alteracao)) : '—' ?></td>
                                    <td><button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalFuncionalidades"><i class="fa-solid fa-pen-to-square m-1"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Contacto</strong></td>
                                    <td>Texto introdutório do formulário</td>
                                    <td><?= $contacto->data_ultima_alteracao ? date('d/m/Y', strtotime($contacto->data_ultima_alteracao)) : '—' ?></td>
                                    <td><button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalContacto"><i class="fa-solid fa-pen-to-square m-1"></i> Editar</button></td>
                                </tr>
                                <tr>
                                    <td><strong>Rodapé</strong></td>
                                    <td>Localização, horário e contactos</td>
                                    <td><?= $rodape->data_ultima_alteracao ? date('d/m/Y', strtotime($rodape->data_ultima_alteracao)) : '—' ?></td>
                                    <td><button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalRodape"><i class="fa-solid fa-pen-to-square m-1"></i> Editar</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Sobre Nós -->
        <div class="modal fade" id="modalSobreNos" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Editar "Sobre Nós"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="seccao" value="sobre_nos">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_sobre_nos" value="<?= htmlspecialchars($sobreNos->menu_sobre_nos) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($sobreNos->titulo) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Conteúdo</label>
                                <textarea class="form-control" name="conteudo" rows="5"><?= htmlspecialchars($sobreNos->conteudo) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto do botão</label>
                                <input type="text" class="form-control" name="texto_botao" value="<?= htmlspecialchars($sobreNos->texto_botao) ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn" style="background-color: #945880; color: #fff;"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Problema e Solução -->
        <div class="modal fade" id="modalProblemaSolucao" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Editar "Problema e Solução"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="seccao" value="problema_solucao">
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_problema_solucao" value="<?= htmlspecialchars($problemaSolucao->menu_problema_solucao) ?>">
                            </div>
                            <div class="card mb-4">
                                <div class="card-header"><strong>O Problema</strong></div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" name="titulo1" value="<?= htmlspecialchars($problemaSolucao->titulo1) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parágrafo 1</label>
                                        <textarea class="form-control" name="paragrafo1" rows="3"><?= htmlspecialchars($problemaSolucao->paragrafo1) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parágrafo 2</label>
                                        <textarea class="form-control" name="paragrafo2" rows="3"><?= htmlspecialchars($problemaSolucao->paragrafo2) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parágrafo 3</label>
                                        <textarea class="form-control" name="paragrafo3" rows="3"><?= htmlspecialchars($problemaSolucao->paragrafo3) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header"><strong>A Nossa Solução</strong></div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" name="titulo2" value="<?= htmlspecialchars($problemaSolucao->titulo2) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parágrafo 1</label>
                                        <textarea class="form-control" name="paragrafo1_vant" rows="3"><?= htmlspecialchars($problemaSolucao->paragrafo1_vant) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parágrafo 2</label>
                                        <textarea class="form-control" name="paragrafo2_vant" rows="3"><?= htmlspecialchars($problemaSolucao->paragrafo2_vant) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parágrafo 3</label>
                                        <textarea class="form-control" name="paragrafo3_vant" rows="3"><?= htmlspecialchars($problemaSolucao->paragrafo3_vant) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn" style="background-color: #945880; color: #fff;"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Vantagens -->
        <div class="modal fade" id="modalVantagens" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Editar "Vantagens"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="seccao" value="vantagens">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_vantagens" value="<?= htmlspecialchars($vantagens_hdr->menu_vantagens) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo_vantagens" value="<?= htmlspecialchars($vantagens_hdr->titulo) ?>">
                            </div>
                            <?php foreach ($vantagens as $i => $v): ?>
                            <div class="mb-3">
                                <label class="form-label">Vantagem <?= $i + 1 ?></label>
                                <input type="hidden" name="vantagem_id[]" value="<?= $v->id ?>">
                                <input type="text" class="form-control" name="vantagem[]" value="<?= htmlspecialchars($v->vantagem) ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn" style="background-color: #945880; color: #fff;"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Funcionalidades -->
        <div class="modal fade" id="modalFuncionalidades" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Editar "Funcionalidades"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="seccao" value="funcionalidades">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_funcionalidades" value="<?= htmlspecialchars($funcionalidades_hdr->menu_funcionalidades) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo_func" value="<?= htmlspecialchars($funcionalidades_hdr->titulo) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto introdutório</label>
                                <input type="text" class="form-control" name="texto_introdutorio" value="<?= htmlspecialchars($funcionalidades_hdr->texto_introdutorio) ?>">
                            </div>
                            <?php foreach ($funcionalidades as $i => $f): ?>
                            <div class="card mb-3">
                                <div class="card-header"><strong>Funcionalidade <?= $i + 1 ?></strong></div>
                                <div class="card-body">
                                    <input type="hidden" name="func_id[]" value="<?= $f->id ?>">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Ícone</label>
                                            <input type="text" class="form-control" name="icone[]" value="<?= htmlspecialchars($f->icone) ?>">
                                        </div>
                                        <div class="col-md-9">
                                            <label class="form-label">Título</label>
                                            <input type="text" class="form-control" name="titulo_funcionalidade[]" value="<?= htmlspecialchars($f->titulo_funcionalidade) ?>">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao[]" rows="2"><?= htmlspecialchars($f->descricao) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn" style="background-color: #945880; color: #fff;"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Contacto -->
        <div class="modal fade" id="modalContacto" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Editar "Contacto"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="seccao" value="contacto">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_contacto" value="<?= htmlspecialchars($contacto->menu_contacto) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo_contacto" value="<?= htmlspecialchars($contacto->titulo) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto introdutório</label>
                                <textarea class="form-control" name="texto_introdutorio_contacto" rows="3"><?= htmlspecialchars($contacto->texto_introdutorio) ?></textarea>
                            </div>
                            <h6 class="fw-bold mb-3">Formulário</h6>
                            <div class="mb-3">
                                <label class="form-label">Etiqueta Campo 1</label>
                                <input type="text" class="form-control" name="etiqueta1" value="<?= htmlspecialchars($contacto->etiqueta1) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Etiqueta Campo 2</label>
                                <input type="text" class="form-control" name="etiqueta2" value="<?= htmlspecialchars($contacto->etiqueta2) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Etiqueta Campo 3</label>
                                <input type="text" class="form-control" name="etiqueta3" value="<?= htmlspecialchars($contacto->etiqueta3) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto do Botão</label>
                                <input type="text" class="form-control" name="texto_botao_contacto" value="<?= htmlspecialchars($contacto->texto_botao) ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn" style="background-color: #945880; color: #fff;"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Rodapé -->
        <div class="modal fade" id="modalRodape" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Editar "Rodapé"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="seccao" value="rodape">
                        <div class="modal-body">
                            <div class="card mb-4">
                                <div class="card-header"><strong>Localização</strong></div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" name="localizacao" value="<?= htmlspecialchars($rodape->localizacao) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Morada</label>
                                        <textarea class="form-control" name="morada" rows="3"><?= htmlspecialchars($rodape->morada) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header"><strong>Horário</strong></div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" name="horario" value="<?= htmlspecialchars($rodape->horario) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Horário</label>
                                        <textarea class="form-control" name="horas" rows="4"><?= htmlspecialchars($rodape->horas) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header"><strong>Contactos</strong></div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control" name="contactos" value="<?= htmlspecialchars($rodape->contactos) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($rodape->email) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Telefone</label>
                                        <input type="text" class="form-control" name="telefone" value="<?= htmlspecialchars($rodape->telefone) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn" style="background-color: #945880; color: #fff;"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>