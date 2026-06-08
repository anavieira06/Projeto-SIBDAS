<?php include 'includes/header.php'; ?>
<?php
$pagina = 'normal';
include '../../includes/nav.php';
?>

        <!-- Sidebar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarMenu">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <a href="../equipamentos/lista.html" class="sidebar-link">
                    <i class="fas fa-laptop"></i> Equipamentos
                </a>
                <a href="../fornecedores/lista_forn.html" class="sidebar-link">
                    <i class="fas fa-building"></i> Fornecedores
                </a>
                <a href="../localizações/lista_loc.html" class="sidebar-link">
                    <i class="fas fa-location-dot"></i> Localizações
                </a>
                <a href="../documentação/lista_doc.html" class="sidebar-link">
                    <i class="fas fa-folder-open"></i> Documentação
                </a>
                <a href="../garantias e contratos/garantias.html" class="sidebar-link">
                    <i class="fas fa-file-signature"></i> Garantias e Contratos
                </a>
                <a href="../dashboard/dashboard.html" class="sidebar-link">
                    <i class="fas fa-chart-column"></i> Dashboard
                </a>
                <a href="../gestão de conteúdos/gestao_cont.html" class="sidebar-link">
                    <i class="fas fa-globe"></i> Gestão de conteúdos públicos
                </a>
            </div>
        </div>

        <!-- Conteúdo Principal -->
            <main class="container-fluid p-4" style="background-color: #fff4fb;">
                <div class="d-flex justify-content-center mt-4">
                    <div class="card w-100 shadow rounded" style="max-width: 1200px;">
                        <div class="card-body">
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-plus me-2" style="color: #680447;"></i> Inserir novo equipamento</strong></h2>
                            <hr>
                            <form id="formEquipamento" action="#" method="post">
                                <ul class="nav nav-tabs mb-4" id="equipamentoTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active"
                                        id="info-tab"
                                        data-bs-toggle="tab"
                                        href="#infoEquipamento"
                                        role="tab">
                                            1. Equipamento
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="fornecedor-tab"
                                        data-bs-toggle="tab"
                                        href="#infoFornecedores"
                                        role="tab">
                                            2. Fornecedores
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="localizacao-tab"
                                        data-bs-toggle="tab"
                                        href="#infoLocalizacao"
                                        role="tab">
                                            3. Localização
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="documentacao-tab"
                                        data-bs-toggle="tab"
                                        href="#infoDocumentos"
                                        role="tab">
                                            4. Documentação
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link disabled pe-none"
                                        id="garantias-tab"
                                        data-bs-toggle="tab"
                                        href="#garantiasContratos"
                                        role="tab">
                                            5. Garantias e Contratos
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="infoEquipamento" role="tabpanel">
                                        <!-- Secção: Identificação -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-barcode me-2"></i>
                                            Identificação
                                        </h5>
                                        <!-- Campo código de inventário --> 
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="codigo_inventario" class="form-label">Código interno <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="codigo_inventario" name="codigo_inventario" placeholder="Ex: EQ0001" required>
                                            </div>
                                        </div>

                                        <!-- Campos Categoria/Grupo e Designação -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="categoria_grupo" class="form-label">Categoria / Grupo <span class="text-danger">*</span></label>
                                                <select class="form-control" id="categoria_grupo" name="categoria_grupo" required> 
                                                    <option value="" selected disabled>Escolha uma opção</option>
                                                    <option value="Monitorização">Monitorização</option>
                                                    <option value="Suporte de vida">Suporte de vida</option>
                                                    <option value="Terapia">Terapia</option>
                                                    <option value="Diagnóstico">Diagnóstico</option>
                                                    <option value="Laboratório">Laboratório</option>
                                                    <option value="Esterilização">Esterilização</option>
                                                    <option value="Reabilitação">Reabilitação</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designacao_equipamento" class="form-label">Designação <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="designacao_equipamento" name="designacao_equipamento" placeholder="Ex: Monitor cardíaco" required>
                                            </div>
                                        </div>

                                        <!-- Campos Marca, Modelo e Nº série --> 
                                        <div class="row mb-3"> 
                                            <div class="col-md-4">
                                                <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Ex: Zoll" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="modelo" class="form-label">Modelo <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ex: Evita V500" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="numero_serie" class="form-label">Nº de série <span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" id="numero_serie" name="numero_serie" placeholder="Ex: EV500-2021-9934" required>
                                            </div>
                                        </div>

                                        <!-- Campo Fabricante -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="fabricante" class="form-label">Fabricante <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="fabricante" name="fabricante" placeholder="Ex: Philips Healthcare" required>
                                            </div>
                                        </div>

                                        <!-- Secção: Aquisição e estado -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-cart-shopping me-2"></i>
                                            Aquisição e estado
                                        </h5>

                                        <!-- Campo Data de aquisição -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="data_aquisicao" class="form-label">Data de aquisição <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="data_aquisicao" name="data_aquisicao" required>
                                            </div>
                                        </div>

                                        <!-- Campos Ano de fabrico e custo de aquisição -->
                                        <div class="row mb-3"> 
                                            <div class="col-md-6">
                                                <label for="ano_fabrico" class="form-label">Ano de fabrico <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" min="1980" max="2026" placeholder="Ex: 2024" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="custo_aquisicao" class="form-label">Custo de aquisição (€) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="custo_aquisicao" name="custo_aquisicao" placeholder="Ex: 2500" step="0.01" required>
                                            </div>                               
                                        </div>

                                        <!--Campos Tipo de entrada, Estado atual e Criticidade -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="tipo_entrada" class="form-label">Entrada por: <span class="text-danger">*</span></label>
                                                <select class="form-control" id="tipo_entrada" name="tipo_entrada" required> 
                                                    <option value="" selected disabled>Escolha uma opção</option>
                                                    <option value="Compra">Compra</option>
                                                    <option value="Doação">Doação</option>
                                                    <option value="Aluguer">Aluguer</option>
                                                    <option value="Empréstimo">Empréstimo</option>
                                                </select>
                                            </div>     
                                            <div class="col-md-4">
                                                <label for="estado" class="form-label">Estado atual <span class="text-danger">*</span></label>
                                                <select class="form-control" id="estado" name="estado" required> 
                                                    <option value="" selected disabled>Escolha uma opção</option>
                                                    <option value="Ativo">Ativo</option>
                                                    <option value="Inativo">Inativo</option>
                                                    <option value="Calibração">Em calibração</option>
                                                    <option value="Quarentena">Em quarentena</option>
                                                    <option value="Abatido">Abatido</option>
                                                </select>
                                            </div>   
                                            <div class="col-md-4">
                                                <label for="criticidade" class="form-label">Criticidade <span class="text-danger">*</span></label>
                                                <select class="form-control" id="criticidade" name="criticidade" required> 
                                                    <option value="" selected disabled>Escolha uma opção</option>
                                                    <option value="Baixa">Baixa</option>
                                                    <option value="Média">Média</option>
                                                    <option value="Alta">Alta</option>
                                                    <option value="Suporte de vida">Suporte de vida</option>
                                                </select>
                                            </div> 
                                        </div>
                                        <!-- Secção: Observações -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-note-sticky me-2"></i>
                                            Observações
                                        </h5>

                                        <!-- Campo Observações -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="observacoes" class="form-label">Observações</label>
                                                <textarea class="form-control" id="observacoes" name="observacoes" rows="4" placeholder="Informações adicionais sobre o equipamento..."></textarea>
                                            </div>
                                        </div> 
                                        <div class="text-end">
                                            <button type="button"
                                                    class="btn btn-guardar mb-4"
                                                    id="btnSeguinteEquipamento"
                                                    onclick="
                                                        document.getElementById('fornecedor-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#fornecedor-tab')).show();
                                                    ">
                                                Seguinte
                                                <i class="fa-solid fa-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                        <!-- Área de erros -->
                                        <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                                            • Erro
                                        </div>
                                    </div> 

                                    <div class="tab-pane fade" id="infoFornecedores" role="tabpanel">

                                        <!-- Título -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-building me-2"></i>
                                            Fornecedores
                                        </h5>

                                        <!-- Área onde ficam os fornecedores -->
                                        <div id="areaFornecedores">

                                            <!-- FORNECEDOR 1 -->
                                            <div class="border rounded p-3 mb-4" id="blocoFornecedor1">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0" style="color:#680447;">
                                                        Fornecedor 1
                                                    </h6>
                                                </div>

                                                <!-- Selecionar fornecedor -->
                                                <div class="row mb-4">
                                                    <div class="col-md-6">

                                                        <select class="form-control"
                                                                name="fornecedor_id[]"
                                                                onchange="preencherFornecedorBloco(this,1)"
                                                                required>

                                                            <option value="" selected disabled>
                                                                Escolha um fornecedor
                                                            </option>

                                                            <option value="1">
                                                                Philips Healthcare Portugal
                                                            </option>

                                                            <option value="2">
                                                                Dräger Portugal
                                                            </option>

                                                            <option value="3">
                                                                B. Braun Portugal
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Informação -->
                                                <div id="infoFornecedor1" class="d-none">

                                                    <hr>

                                                    <h6 class="text-muted mb-4">
                                                        <i class="fa-solid fa-circle-info me-2"></i>
                                                        Informação do fornecedor
                                                    </h6>

                                                    <div class="row">

                                                        <!-- Coluna 1 -->
                                                        <div class="col-md-4">

                                                            <div class="mb-4">
                                                                <strong>Nome da empresa</strong>
                                                                <p id="f-nome-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>NIF</strong>
                                                                <p id="f-nif-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Tipo de fornecedor</strong>
                                                                <p id="f-tipo-1">-</p>
                                                            </div>

                                                        </div>

                                                        <!-- Coluna 2 -->
                                                        <div class="col-md-4">

                                                            <div class="mb-4">
                                                                <strong>Morada</strong>
                                                                <p id="f-morada-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Número telefónico</strong>
                                                                <p id="f-telefone-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Email</strong>
                                                                <p id="f-email-1">-</p>
                                                            </div>

                                                        </div>

                                                        <!-- Coluna 3 -->
                                                        <div class="col-md-4">

                                                            <div class="mb-4">
                                                                <strong>Website</strong>
                                                                <p id="f-website-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Pessoa de contacto</strong>
                                                                <p id="f-contacto-1">-</p>
                                                            </div>

                                                            <div class="mb-4">
                                                                <strong>Telefone da pessoa de contacto</strong>
                                                                <p id="f-tel-contacto-1">-</p>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- Botão adicionar -->
                                        <button type="button"
                                                class="btn btn-outline-secondary mb-4"
                                                onclick="adicionarBlocoFornecedor()">
                                            <i class="fa-solid fa-plus me-1"></i>
                                            Adicionar fornecedor
                                        </button>

                                        <!-- Navegação -->
                                        <div class="d-flex justify-content-between">

                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#info-tab')).show();">
                                                Anterior
                                            </button>

                                            <button type="button"
                                                    id="btnSeguinteFornecedor"
                                                    class="btn btn-guardar"
                                                    onclick="
                                                        document.getElementById('localizacao-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#localizacao-tab')).show();
                                                    ">
                                                Seguinte
                                            </button>

                                        </div>
                                        <!-- Área de erros -->
                                        <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                                            • Erro
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="infoLocalizacao" role="tabpanel">
                                        <!-- Secção: Localizações -->
                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-location-dot me-2"></i>
                                            Localização
                                        </h5>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="selectLocalizacao" class="form-label">
                                                    Selecionar localização
                                                </label>

                                                <select class="form-control"
                                                        id="selectLocalizacao"
                                                        name="localizacao_id"
                                                        onchange="preencherLocalizacao()"
                                                        required>
                                                    <option value="" selected disabled>Escolha uma localização</option>
                                                    <option value="1">Bloco Operatório</option>
                                                    <option value="2">Urgência</option>
                                                    <option value="3">Unidade de Cuidados Intensivos</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="infoLocalizacaoPainel" class="d-none">
                                            <hr>

                                            <h6 class="text-muted mb-3" style="color:#680447;">
                                                <i class="fa-solid fa-circle-info me-2"></i>
                                                Informação da localização
                                            </h6>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <strong>Edifício</strong>
                                                    <p id="l-edificio">-</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>Piso</strong>
                                                    <p id="l-piso">-</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>Sala</strong>
                                                    <p id="l-sala">-</p>
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>Serviço</strong>
                                                    <p id="l-servico">-</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#fornecedor-tab')).show();">
                                                Anterior
                                            </button>

                                            <button type="button"
                                                    class="btn btn-guardar"
                                                    id="btnSeguinteLocalizacao"
                                                    onclick="
                                                        document.getElementById('documentacao-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#documentacao-tab')).show();
                                                    ">
                                                Seguinte
                                            </button>
                                        </div>
                                        <!-- Área de erros -->
                                        <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                                            • Erro
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="infoDocumentos" role="tabpanel">

                                        <h5 class="mt-4 mb-3" style="color:#680447;">
                                            <i class="fa-solid fa-folder-open me-2"></i>
                                            Documentação
                                        </h5>

                                        <div id="areaDocumentos">

                                            <!-- DOCUMENTO 1 -->
                                            <div class="border rounded p-3 mb-4" id="blocoDocumento1">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0" style="color:#680447;">
                                                        Documento 1
                                                    </h6>

                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm"
                                                            onclick="eliminarBlocoDocumento(1)">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>

                                                <h6 class="mt-3 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-barcode me-2"></i>
                                                    Identificação
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="tipo_doc" class="form-label">Tipo de documento <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="tipo_doc" id="tipo_doc" required>
                                                            <option value="" selected disabled>Escolha uma opção</option>
                                                            <option value="Manual de utilização">Manual de utilizador</option>
                                                            <option value="Manual de serviço">Manual de serviço</option>
                                                            <option value="Certificado de calibração">Certificado de calibração</option>
                                                            <option value="Contrato de manutenção">Contrato de manutenção</option>
                                                            <option value="Fatura / Guia de aquisição">Fatura / Guia de aquisição</option>
                                                            <option value="Declaração de conformidade">Declaração de conformidade</option>
                                                            <option value="Relatório técnico">Relatório técnico</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="nome_doc" class="form-label">Nome <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control"
                                                            id="nome_doc"
                                                            name="nome_doc"
                                                            placeholder="Ex: Manual de Utilização - Ventilador Evita V500"
                                                            required>
                                                    </div>
                                                </div>

                                                <h6 class="mt-4 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                                    Datas
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="data_doc" class="form-label">Data <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="data_doc" id="data_doc" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="data_validade" class="form-label">Data de validade</label>
                                                        <input type="date" class="form-control" name="data_validade" id="data_validade">
                                                    </div>
                                                </div>

                                                <h6 class="mt-4 mb-3" style="color:#680447;">
                                                    <i class="fa-solid fa-link me-2"></i>
                                                    Associações e ficheiro
                                                </h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="fornecedor_id" class="form-label">Fornecedor associado</label>
                                                        <select class="form-control" name="fornecedor_id" id="fornecedor_id">
                                                            <option value="" selected disabled>Escolha um fornecedor</option>
                                                            <option value="1">Philips Healthcare Portugal</option>
                                                            <option value="2">Dräger Portugal</option>
                                                            <option value="3">B. Braun Portugal</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="ficheiro" class="form-label">Selecionar ficheiro <span class="text-danger">*</span></label>
                                                        <input type="file"
                                                            class="form-control"
                                                            name="ficheiro"
                                                            id="ficheiro"
                                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                            required>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <button type="button"
                                                class="btn btn-outline-secondary mb-4"
                                                onclick="adicionarBlocoDocumento()">
                                            <i class="fa-solid fa-plus me-1"></i>
                                            Adicionar documento
                                        </button>

                                        <div class="d-flex justify-content-between">
                                            <button type="button"
                                                    class="btn btn-outline-secondary"
                                                    onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#localizacao-tab')).show();">
                                                Anterior
                                            </button>

                                            <button type="button"
                                                    class="btn btn-guardar"
                                                    id="btnSeguinteDocumentos"
                                                    onclick="
                                                        document.getElementById('garantias-tab').classList.remove('disabled','pe-none');
                                                        bootstrap.Tab.getOrCreateInstance(document.querySelector('#garantias-tab')).show();
                                                    ">
                                                Seguinte
                                            </button>
                                        </div>
                                        <!-- Área de erros -->
                                        <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                                            • Erro
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="garantiasContratos" role="tabpanel">
                                            <!-- Secção: Garantias e contratos -->
                                            <h5 class="mt-4 mb-3" style="color:#680447;">
                                                <i class="fa-solid fa-file-signature me-2"></i>
                                                Garantias e contratos
                                            </h5>

                                            <!--Campo Garantia-->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="data_inicio" class="form-label">Data de início de Garantia <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="data_fim" class="form-label">Data de fim de Garantia <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="data_fim" name="data_fim" required>
                                                </div>
                                            </div>

                                            <!--Campo Contrato-->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="contrato_manutencao" class="form-label">
                                                        Contrato de manutenção <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control"
                                                            id="contrato_manutencao"
                                                            name="contrato_manutencao" required>

                                                        <option value="" selected disabled>Escolha uma opção</option>
                                                        <option value="Sim">Sim</option>
                                                        <option value="Não">Não</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="tipo_contrato" class="form-label">
                                                        Tipo de contrato <span class="text-danger">*</span>
                                                    </label>

                                                    <select class="form-control"
                                                            id="tipo_contrato"
                                                            name="tipo_contrato" required>

                                                        <option value="" selected disabled>Escolha uma opção</option>
                                                        <option value="Preventivo">Preventivo</option>
                                                        <option value="Corretivo">Corretivo</option>
                                                        <option value="Completo">Completo</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="periodicidade" class="form-label">
                                                        Periodicidade <span class="text-danger">*</span>
                                                    </label>

                                                    <select class="form-control"
                                                            id="periodicidade"
                                                            name="periodicidade" required>

                                                        <option value="" selected disabled>Escolha uma opção</option>
                                                        <option value="Mensal">Mensal</option>
                                                        <option value="Trimestral">Trimestral</option>
                                                        <option value="Semestral">Semestral</option>
                                                        <option value="Anual">Anual</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="entidade_responsavel" class="form-label">
                                                        Entidade responsável <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="entidade_responsavel"
                                                        name="entidade_responsavel"
                                                        placeholder="Ex: BioTech Portugal" required>
                                                </div>
                                            </div>

                                            <!-- Secção: Observações -->
                                            <h5 class="mt-4 mb-3" style="color:#680447;">
                                                <i class="fa-solid fa-note-sticky me-2"></i>
                                                Observações
                                            </h5>

                                            <!-- Campo Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="observacoes_garant" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="observacoes_garant" name="observacoes_garant" rows="4" placeholder="Informações adicionais sobre o equipamento..."></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
                                                <button type="button"
                                                        class="btn btn-outline-secondary mb-4"
                                                        id="btnAnterior"
                                                        onclick="bootstrap.Tab.getOrCreateInstance(document.querySelector('#documentacao-tab')).show()">
                                                    <i class="fa-solid fa-arrow-left me-1"></i>
                                                    Anterior
                                                </button>

                                                <div>
                                                    <a href="lista.html" class="btn btn-outline-secondary mb-4">
                                                        <i class="fa-solid fa-xmark me-1"></i> Cancelar
                                                    </a>

                                                    <button type="submit" class="btn btn-guardar mb-4">
                                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        <!-- Área de erros -->
                                        <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                                            • Erro
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

<!-- Custom JS -->
<script src="../../../assets/js/1240811.js"></script>

<?php include 'includes/footer.php'; ?>