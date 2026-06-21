<?php
require_once __DIR__ . '/../private/includes/funcoes.php';

// Buscar dados da BD
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sobreNos        = $ligacao->query("SELECT * FROM gestao_sobre_nos WHERE id=1")->fetch(PDO::FETCH_OBJ);
    $problemaSolucao = $ligacao->query("SELECT * FROM gestao_problema_solucao WHERE id=1")->fetch(PDO::FETCH_OBJ);
    $vantagens_hdr   = $ligacao->query("SELECT * FROM gestao_vantagens WHERE id=1")->fetch(PDO::FETCH_OBJ);
    $vantagens       = $ligacao->query("SELECT * FROM vantagens WHERE gestao_vantagens_id=1")->fetchAll(PDO::FETCH_OBJ);
    $func_hdr        = $ligacao->query("SELECT * FROM gestao_funcionalidades WHERE id=1")->fetch(PDO::FETCH_OBJ);
    $funcionalidades = $ligacao->query("SELECT * FROM funcionalidades WHERE gestao_funcionalidades_id=1")->fetchAll(PDO::FETCH_OBJ);
    $contacto        = $ligacao->query("SELECT * FROM gestao_contacto WHERE id=1")->fetch(PDO::FETCH_OBJ);
    $rodape          = $ligacao->query("SELECT * FROM gestao_rodape WHERE id=1")->fetch(PDO::FETCH_OBJ);

    $ligacao = null;

} catch (PDOException $e) {
    // Se falhar a BD, usa valores de fallback
    $sobreNos = $problemaSolucao = $vantagens_hdr = $func_hdr = $contacto = $rodape = null;
    $vantagens = $funcionalidades = [];
}
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MEDInvenTEC</title>
    
        <!-- favicon -->
        <link rel="shortcut icon" href="../assets/img/Icon.png" type="image/png">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Font Awesome (local) -->
        <link rel="stylesheet" href="../assets/fontawesome/all.min.css">

        <!-- Estilos da página -->
        <link rel="stylesheet" href="../assets/css/1240811.css">
    </head>

    <body>
        <!-- Navegação-->
        <nav class="bng-navbar"> 
            <!-- Logo e Nome -->
            <div class="logo-container">
                <img src="../assets/img/Imagem 5.png" alt="Logo da empresa">
            </div>

            <!-- Links centrais -->
            <div class="container-navegacao">
                <a href="#sobre-nos"><?= htmlspecialchars($sobreNos->menu_sobre_nos ?? 'Sobre nós') ?></a>
                <a href="#problema-solucao"><?= htmlspecialchars($problemaSolucao->menu_problema_solucao ?? 'Problema e Solução') ?></a>
                <a href="#vantagens"><?= htmlspecialchars($vantagens_hdr->menu_vantagens ?? 'Vantagens') ?></a>
                <a href="#funcionalidades"><?= htmlspecialchars($func_hdr->menu_funcionalidades ?? 'Funcionalidades') ?></a>
                <a href="#contacto"><?= htmlspecialchars($contacto->menu_contacto ?? 'Contacto') ?></a>
            </div>

            <!-- Área Cliente -->
            <div class="nav-cliente">
                <a href="login.php" target="_blank">Iniciar sessão</a>
            </div>
        </nav>

        <!-- Secção "Sobre nós"-->
        <section class="container-texto-generico" id="sobre-nos">
            <div class="sobre-nos-content">
                <h1><?= htmlspecialchars($sobreNos->titulo ?? 'Gestão Inteligente de Equipamentos Médicos') ?></h1>
                <p><?= htmlspecialchars($sobreNos->conteudo ?? '') ?></p>
                <a href="#contacto" class="button"><?= htmlspecialchars($sobreNos->texto_botao ?? 'Fale connosco!') ?></a>
            </div>
        </section>

        <!-- Secção "Problema e Solução"-->
        <section class="container-texto-generico" id="problema-solucao">
            <div class="problema-solucao-content">
                <h2><?= htmlspecialchars($problemaSolucao->titulo1 ?? 'O Problema') ?></h2>
                <p><?= htmlspecialchars($problemaSolucao->paragrafo1 ?? '') ?></p>
                <p><?= htmlspecialchars($problemaSolucao->paragrafo2 ?? '') ?></p>
                <p><?= htmlspecialchars($problemaSolucao->paragrafo3 ?? '') ?></p>
            </div>
            <div class="problema-solucao-content">
                <h2><?= htmlspecialchars($problemaSolucao->titulo2 ?? 'A Nossa Solução') ?></h2>
                <p><?= htmlspecialchars($problemaSolucao->paragrafo1_vant ?? '') ?></p>
                <p><?= htmlspecialchars($problemaSolucao->paragrafo2_vant ?? '') ?></p>
                <p><?= htmlspecialchars($problemaSolucao->paragrafo3_vant ?? '') ?></p>
            </div>
        </section>
        
        <!-- Secção "Vantagens"-->
        <section class="container-texto-generico" id="vantagens">
            <div class="vantagens-content">
                <h2><?= htmlspecialchars($vantagens_hdr->titulo ?? 'Vantagens') ?></h2>
                <ul>
                    <?php foreach ($vantagens as $v): ?>
                    <li><?= htmlspecialchars($v->vantagem) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <!-- Secção "Funcionalidades"-->
        <section id="funcionalidades">
            <h2><?= htmlspecialchars($func_hdr->titulo ?? 'Funcionalidades') ?></h2>
            <p><?= htmlspecialchars($func_hdr->texto_introdutorio ?? '') ?></p>
            <div class="funcionalidades-container">
                <?php foreach ($funcionalidades as $f): ?>
                <div class="funcionalidades-content">
                    <i class="<?= htmlspecialchars($f->icone) ?>"></i>
                    <h3><?= htmlspecialchars($f->titulo_funcionalidade) ?></h3>
                    <p><?= htmlspecialchars($f->descricao) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!--Secção "Contacto"-->
        <section id="contacto">
            <h2><?= htmlspecialchars($contacto->titulo ?? 'Contacto') ?></h2>
            <p><?= htmlspecialchars($contacto->texto_introdutorio ?? '') ?></p>

            <?php if (isset($_GET['enviado'])): ?>
                <div style="background-color:#d1e7dd; color:#0a3622; padding:12px 16px; border-radius:8px; display:flex; align-items:center; gap:8px; margin-top:12px;">
                    <i class="fa-solid fa-circle-check"></i>
                    Mensagem enviada com sucesso!
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['erro'])): ?>
                <div style="background-color:#f8d7da; color:#842029; padding:12px 16px; border-radius:8px; display:flex; align-items:center; gap:8px; margin-top:12px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Erro ao enviar. Verifique os campos.
                </div>
            <?php endif; ?>

            <form id="contactForm" action="processar_contacto.php" method="POST">
                <label for="nome"><?= htmlspecialchars($contacto->etiqueta1 ?? 'Nome') ?>:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email"><?= htmlspecialchars($contacto->etiqueta2 ?? 'Email') ?>:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensagem"><?= htmlspecialchars($contacto->etiqueta3 ?? 'Mensagem') ?>:</label>
                <textarea id="mensagem" name="mensagem" rows="4" required></textarea>

                <button type="submit"><?= htmlspecialchars($contacto->texto_botao ?? 'Enviar Mensagem') ?></button>
            </form>
        </section>

        <!-- Rodapé -->
        <footer class="footer-container">
            <div class="footer-section">
                <strong><?= htmlspecialchars($rodape->localizacao ?? 'LOCALIZAÇÃO') ?></strong>
                <p><?= nl2br(htmlspecialchars($rodape->morada ?? '')) ?></p>
            </div>
            
            <div class="footer-section">
                <strong><?= htmlspecialchars($rodape->horario ?? 'HORÁRIO') ?></strong>
                <p><?= nl2br(htmlspecialchars($rodape->horas ?? '')) ?></p>
            </div>

            <div class="footer-section">
                <strong><?= htmlspecialchars($rodape->contactos ?? 'CONTACTOS') ?></strong>
                <p><?= htmlspecialchars($rodape->email ?? '') ?></p>
                <p><?= htmlspecialchars($rodape->telefone ?? '') ?></p>
            </div>
        </footer>
    </body>
</html>