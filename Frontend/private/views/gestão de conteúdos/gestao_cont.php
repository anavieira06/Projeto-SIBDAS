<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
include __DIR__ . '../../includes/header.php'; 
?>

<?php
$pagina = 'normal';
include __DIR__ . '../../includes/nav.php';
include __DIR__ . '../../includes/sidebar.php';
?>

        

        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <strong>Gestão de Conteúdos Públicos</strong>
                </h2>
            </div>
            <p class="text-muted">Gerir textos, contactos e secções apresentados na área pública.</p>

            <div class="card border-0 shadow">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <colgroup> <!-- Definir o tamanho das colunas da tabela -->
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
                                    <td>01/06/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalSobreNos">
                                            <i class="fa-solid fa-pen-to-square m-1"></i> Editar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Problema e Solução</strong></td>
                                    <td>Apresentação do problema e proposta de solução</td>
                                    
                                    <td>01/06/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalProblemaSolucao">
                                            <i class="fa-solid fa-pen-to-square m-1"></i> Editar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Vantagens</strong></td>
                                    <td>Lista de vantagens da plataforma</td>
                                    
                                    <td>01/06/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalVantagens">
                                            <i class="fa-solid fa-pen-to-square m-1"></i> Editar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Funcionalidades</strong></td>
                                    <td>Funcionalidades em cards, com ícone, título e descrição</td>
                                    
                                    <td>01/06/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalFuncionalidades">
                                            <i class="fa-solid fa-pen-to-square m-1"></i> Editar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Contacto</strong></td>
                                    <td>Texto introdutório do formulário</td>
                                    
                                    <td>01/06/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalContacto">
                                            <i class="fa-solid fa-pen-to-square m-1"></i> Editar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Rodapé</strong></td>
                                    <td>Localização, horário e contactos</td>
                                    
                                    <td>01/06/2026</td>
                                    <td>
                                        <button class="btn btn-sm btn-editar" style="background-color: #945880; color: #fff;" data-bs-toggle="modal" data-bs-target="#modalRodape">
                                            <i class="fa-solid fa-pen-to-square m-1"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        
        <!-- Modal Editar Conteúdo "Sobre nós"-->
        <div class="modal fade" id="modalSobreNos" tabindex="-1" aria-labelledby="modalEditarConteudoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarConteudoLabel">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Editar "Sobre Nós"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="menu_sobre_nos" class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_sobre_nos" id="menu_sobre_nos" value="Sobre nós">
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" value="Gestão Inteligente de Equipamentos Médicos">
                            </div>

                            <div class="mb-3">
                                <label for="conteudo" class="form-label">Conteúdo</label>
                                <textarea class="form-control" name="conteudo" id="conteudo" rows="5">Organize, controle e otimize o seu inventário hospitalar.</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="texto_botao" class="form-label">Texto do botão</label>
                                <input type="text" class="form-control" name="texto_botao" id="texto_botao" value="Fale connosco!">
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color: #945880; color: #fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Guardar alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Editar Conteúdo "Problema e Solução" -->
        <div class="modal fade" id="modalProblemaSolucao" tabindex="-1" aria-labelledby="modalProblemaSolucaoLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProblemaSolucaoLabel">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Editar "Problema e Solução"
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="mb-4">
                                <label for="menu_problema_solucao" class="form-label">
                                    Nome no menu/navbar
                                </label>
                                <input type="text"
                                    class="form-control"
                                    id="menu_problema_solucao"
                                    value="Problema e Solução">
                            </div>

                            <!-- O Problema -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>O Problema</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="titulo1" class="form-label">Título</label>
                                        <input type="text" class="form-control" name="titulo1" id="titulo1" value="O Problema">
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrafo1" class="form-label">Parágrafo 1</label>
                                        <textarea class="form-control" name="paragrafo1" id="paragrafo1" rows="3">Em muitas unidades hospitalares, a gestão do inventário de equipamentos médicos é realizada de forma fragmentada, recorrendo a folhas de Excel, documentos isolados, registos em papel e várias bases de dados sem integração.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrafo2" class="form-label">Parágrafo 2</label>
                                        <textarea class="form-control" name="paragrafo2" id="paragrafo2" rows="3">Esta abordagem dificulta a organização da informação, a localização dos equipamentos e o rápido acesso à documentação técnica.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrafo3" class="form-label">Parágrafo 3</label>
                                        <textarea class="form-control" name="paragrafo3" id="paragrafo3" rows="3">Como consequência, surgem problemas como a duplicação de dados, falta de controlo do estado dos equipamentos e dificuldades na gestão de garantias, contratos e fornecedores.</textarea>
                                    </div>

                                </div>
                            </div>

                            <!-- A Nossa Solução -->
                            <div class="card">
                                <div class="card-header">
                                    <strong>A Nossa Solução</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="titulo2" class="form-label">Título</label>
                                        <input type="text" class="form-control" name="titulo2" id="titulo2" value="A Nossa Solução">
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrafo1_vant" class="form-label">Parágrafo 1</label>
                                        <textarea class="form-control" name="paragrafo1_vant" id="paragrafo1_vant" rows="3">A nossa empresa foi desenvolvida com o objetivo de centralizar e organizar toda a informação relativa aos equipamentos médicos, promovendo uma gestão mais eficiente e estruturada do inventário hospitalar.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrafo2_vant" class="form-label">Parágrafo 2</label>
                                        <textarea class="form-control" name="paragrafo2_vant" id="paragrafo2_vant" rows="3">Através de uma plataforma web intuitiva, é possível registar, consultar e atualizar dados em tempo real, garantindo um maior controlo sobre a localização, estado e documentação associada a cada equipamento.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paragrafo3_vant" class="form-label">Parágrafo 3</label>
                                        <textarea class="form-control" name="paragrafo3_vant" id="paragrafo3_vant" rows="3">O sistema permite ainda melhorar a rastreabilidade dos dispositivos médicos e apoiar a tomada de decisões técnicas e administrativas.</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color: #945880; color: #fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Guardar alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Conteúdo "Vantagens" -->
        <div class="modal fade" id="modalVantagens" tabindex="-1" aria-labelledby="modalVantagensLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalVantagensLabel">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Editar "Vantagens"
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="menu_vantagens" class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_vantagens" id="menu_vantagens" value="Vantagens">
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" value="Vantagens">
                            </div> 

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 1</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Centralização de toda a informação num único sistema, evitando dispersão de dados">
                            </div>

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 2</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Acesso rápido e em tempo real à informação dos equipamentos médicos">
                            </div>

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 3</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Melhoria no controlo do estado, localização e histórico de cada equipamento">
                            </div>

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 4</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Facilidade na gestão de garantias, contratos e fornecedores">
                            </div>

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 5</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Melhor rastreabilidade dos dispositivos médicos">
                            </div>

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 6</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Apoio à tomada de decisões técnicas e administrativas com base em dados atualizados">
                            </div>

                            <div class="mb-3">
                                <label for="vantagem" class="form-label">Vantagem 7</label>
                                <input type="text" class="form-control" name="vantagem" id="vantagem" value="Interface intuitiva que facilita a utilização por diferentes profissionais">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color: #945880; color: #fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Guardar alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Conteúdo "Funcionalidades" -->
        <div class="modal fade" id="modalFuncionalidades" tabindex="-1" aria-labelledby="modalFuncionalidadesLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFuncionalidadesLabel">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Editar "Funcionalidades"
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="menu_funcionalidades" class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_funcionalidades" id="menu_funcionalidades" value="Funcionalidades">
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título da secção</label>
                                <input type="text" class="form-control" name="titulo" id="titulo" value="Funcionalidades">
                            </div>

                            <div class="mb-3">
                                <label for="texto_introdutorio" class="form-label">Texto Introdutório</label>
                                <input type="text" class="form-control" name="texto_introdutorio" id="texto_introdutorio" value="Aqui encontram-se as funcionalidades da nossa página.">
                            </div>

                            <!-- Funcionalidade 1 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 1</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="icone" class="form-label">Ícone</label>
                                            <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-laptop">
                                        </div>
                                        <div class="col-md-9">
                                            <label for="titulo_funcionalidade" class="form-label">Título</label>
                                            <input type="text"
                                                class="form-control"
                                                name="titulo_funcionalidade"
                                                id="titulo_funcionalidade"
                                                value="Gestão de Equipamentos">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Registo, edição e consulta detalhada de equipamentos médicos, incluindo estado e criticidade.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 2 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 2</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 3 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 3</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 4 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 4</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 5 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 5</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 6 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 6</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 7 -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <strong>Funcionalidade 7</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Funcionalidade 8 -->
                            <div class="card">
                                <div class="card-header">
                                    <strong>Funcionalidade 8</strong>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                                <label for="icone" class="form-label">Ícone</label>
                                                <input type="text" class="form-control" name="icone" id="icone" value="fa-solid fa-location-dot">
                                        </div>
                                        <label for="titulo_funcionalidade" class="form-label">Título</label>
                                        <input type="text"
                                            class="form-control mb-3"
                                            name="titulo_funcionalidade"
                                            id="titulo_funcionalidade"
                                            value="Gestão de Localizações">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="3">Organização por edifício, serviço e sala, permitindo localizar rapidamente cada equipamento.</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color: #945880; color: #fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Guardar alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Conteúdo "Contacto" -->
        <div class="modal fade" id="modalContacto" tabindex="-1" aria-labelledby="modalContactoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalContactoLabel">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Editar "Contacto"
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="menu_contacto" class="form-label">Nome no menu/navbar</label>
                                <input type="text" class="form-control" name="menu_contacto" id="menu_contacto" value="Contacto">
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título da secção</label>
                                <input type="text"
                                    class="form-control"
                                    name="titulo"
                                    id="titulo"
                                    value="Contacto">
                            </div>

                            <div class="mb-3">
                                <label for="texto_introdutorio" class="form-label">Texto Introdutório</label>
                                <textarea class="form-control" name="texto_introdutorio" id="texto_introdutorio" rows="3">Entre em contacto connosco para tirar todas as suas dúvidas ou obter mais informações sobre a nossa plataforma.</textarea>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Formulário</h6>

                            <div class="mb-3">
                                <label for="etiqueta1" class="form-label">Etiqueta do Campo 1</label>
                                <input type="text"
                                    class="form-control"
                                    name="etiqueta1"
                                    id="etiqueta1"
                                    value="Nome">
                            </div>

                            <div class="mb-3">
                                <label for="etiqueta2" class="form-label">Etiqueta do Campo 2</label>
                                <input type="text"
                                    class="form-control"
                                    for="etiqueta2"
                                    for="etiqueta2"
                                    value="Email">
                            </div>

                            <div class="mb-3">
                                <label for="etiqueta3" class="form-label">Etiqueta do Campo 3</label>
                                <input type="text"
                                    class="form-control"
                                    name="etiqueta3"
                                    id="etiqueta3"
                                    value="Mensagem">
                            </div>

                            <div class="mb-3">
                                <label for="texto_botao" class="form-label">Texto do Botão</label>
                                <input type="text"
                                    class="form-control"
                                    name="texto_botao"
                                    id="texto_botao"
                                    value="Enviar Mensagem">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color: #945880; color: #fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Guardar alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Conteúdo "Rodapé" -->
        <div class="modal fade" id="modalRodape" tabindex="-1" aria-labelledby="modalRodapeLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRodapeLabel">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Editar "Rodapé"
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Fechar">
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <!-- Localização -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Localização</strong>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="localizacao" class="form-label">Título</label>
                                        <input type="text" class="form-control" name="localizacao" id="localizacao" value="LOCALIZAÇÃO">
                                    </div>
                                    <div class="mb-3">
                                        <label for="morada" class="form-label">Morada</label>
                                        <textarea class="form-control" name="morada" id="morada" rows="3">Rua da Inovação, 42
4690-945, Viseu
Portugal</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Horário -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Horário</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="horario" class="form-label">Título</label>
                                        <input type="text" class="form-control" name="horario" id="horario" value="HORÁRIO">
                                    </div>
                                    <div class="mb-3">
                                        <label for="horas" class="form-label">Horário</label>
                                        <textarea class="form-control" name="horas" id="horas" rows="4">2ª a 6ª Feira: 8h - 18h
Sábado e Feriados: 9h - 13h
Domingo: Encerrado
Atendimento online: 24/7</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Contactos -->
                            <div class="card">
                                <div class="card-header">
                                    <strong>Contactos</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="contactos" class="form-label">Título</label>
                                        <input type="text" class="form-control" name="contactos" id="contactos" value="CONTACTOS">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="suporte@MEDInvenTEC.pt">
                                    </div>

                                    <div class="mb-3">
                                        <label for="telefone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control" name="telefone" id="telefone" value="+351 210 759 811">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn" style="background-color: #945880; color: #fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Guardar alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>



<?php include __DIR__ . '../../includes/footer.php'; ?>