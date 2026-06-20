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
                <a href="#sobre-nos">Sobre nós</a>
                <a href="#problema-solucao">Problema e Solução</a>
                <a href="#vantagens">Vantagens</a>
                <a href="#funcionalidades">Funcionalidades</a>
                <a href="#contacto">Contacto</a> 
            </div>

            <!-- Área Cliente -->
            <div class="nav-cliente">
                <a href="login.php" target="_blank">Iniciar sessão</a>
            </div>
        </nav>

        <!-- Secção "Sobre nós"-->
        <section class="container-texto-generico" id="sobre-nos">
            <div class="sobre-nos-content">
                <h1>Gestão Inteligente de Equipamentos Médicos</h1>
                <p>Organize, controle e otimize o seu inventário hospitalar.</p>
                <a href="#contacto" class="button">Fale connosco!</a>
            </div>
        </section>

        <!-- Secção "Problema e Solução"-->
        <section class="container-texto-generico" id="problema-solucao">
            <div class="problema-solucao-content">
                <h2>O Problema</h2>
                <p>Em muitas unidades hospitalares, a gestão do inventário de equipamentos médicos é realizada de forma fragmentada, recorrendo a folhas de Excel, 
                documentos isolados, registos em papel e várias bases de dados sem integração.</p>
                <p>Esta abordagem dificulta a organização da informação, a localização dos equipamentos e o rápido acesso à documentação técnica.</p>
                <p>Como consequência, surgem problemas como a duplicação de dados, falta de controlo do estado dos equipamentos e dificuldades na gestão de garantias, contratos e fornecedores.</p>
            </div>
            <div class="problema-solucao-content">
                <h2>A Nossa Solução</h2>
                <p>A nossa empresa foi desenvolvida com o objetivo de centralizar e organizar toda a informação relativa aos equipamentos médicos, 
                promovendo uma gestão mais eficiente e estruturada do inventário hospitalar.</p>
                <p>Através de uma plataforma web intuitiva, é possível registar, consultar e atualizar dados em tempo real, garantindo um maior 
                controlo sobre a localização, estado e documentação associada a cada equipamento.</p>
                <p>O sistema permite ainda melhorar a rastreabilidade dos dispositivos médicos e apoiar a tomada de decisões técnicas e administrativas.</p>
            </div>
        </section>
        
        <!-- Secção "Vantagens"-->
        <section class="container-texto-generico" id="vantagens">
            <div class="vantagens-content">
                <h2>Vantagens</h2>
                <ul>
                    <li>Centralização de toda a informação num único sistema, evitando dispersão de dados</li>
                    <li>Acesso rápido e em tempo real à informação dos equipamentos médicos</li>
                    <li>Melhoria no controlo do estado, localização e histórico de cada equipamento</li>
                    <li>Facilidade na gestão de garantias, contratos e fornecedores</li>
                    <li>Melhor rastreabilidade dos dispositivos médicos</li>
                    <li>Apoio à tomada de decisões técnicas e administrativas com base em dados atualizados</li>
                    <li>Interface intuitiva que facilita a utilização por diferentes profissionais</li>
                </ul>
            </div>
        </section>

        <!-- Secção "Funcionalidades"-->
        <section id="funcionalidades">
            <h2>Funcionalidades</h2>
                <p>Aqui encontram-se as funcionalidades da nossa página.</p>
            <div class="funcionalidades-container">
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-laptop"></i>
                    <h3>Gestão de equipamentos</h3>
                    <p>Registo, edição e consulta detalhada de equipamentos médicos, incluindo estado e criticidade.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-location-dot"></i>
                    <h3>Gestão de localizações</h3>
                    <p>Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-building"></i>
                    <h3>Gestão de fornecedores</h3>
                    <p>Associação de fabricantes, distribuidores e empresas de assistência técnica aos equipamentos.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-folder-open"></i>
                    <h3>Documentação</h3>
                    <p>Upload e organização de manuais, certificados, contratos e relatórios técnicos.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-file-signature"></i>
                    <h3>Garantias e Contratos</h3>
                    <p>Controlo de garantias, contratos de manutenção e datas importantes associadas aos equipamentos.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h3>Pesquisa inteligente</h3>
                    <p>Pesquisa rápida por código, marca, modelo, serviço, estado ou criticidade.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-chart-column"></i>
                    <h3>Dashboard</h3>
                    <p>Indicadores em tempo real sobre equipamentos ativos, manutenção, garantias e estatísticas hospitalares.</p>
                </div>
                <div class="funcionalidades-content">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h3>Segurança</h3>
                    <p>Sistema de autenticação e controlo de acesso para proteção dos dados hospitalares.</p>
                </div>
            </div>
        </section>

        <!--Secção "Contacto"-->
        <section id="contacto">
            <h2>Contacto</h2>
            <p>Entre em contacto conosco para tirar todas as suas dúvidas ou obter mais informações sobre a nossa plataforma.</p> 
            <form id="contactForm">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" rows="4" required></textarea>

                <button type="submit">Enviar Mensagem</button> 
            </form>
        </section>

        <!-- Rodapé -->
        <footer class="footer-container">
            <div class="footer-section">
                <strong>LOCALIZAÇÃO</strong>
                <p> Rua da Inovação, 42 <br> 4690-945, Viseu <br> Portugal</p>
            </div>
            
            <div class="footer-section">
                <strong>HORÁRIO</strong>
                <p>2ª a 6ª Feira: 8h - 18h</p>
                <p>Sábado e Feriados: 9h - 13h</p>
                <p>Domingo: Encerrado</p>
                <p>Atendimento online: 24/7</p>
            </div>

            <div class="footer-section">
                <strong>CONTACTOS</strong>
                <p>Email: suporte@MEDInvenTEC.pt</p>
                <p>Telefone: +351 210 759 811</p>
            </div>
        </footer>
    </body>
</html>
