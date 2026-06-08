<?php include 'includes/header.php'; ?>
        <!-- Navbar -->
        <header class="container-fluid custom-navbar">
            <div class="row align-items-center h-100">
                <div class="col d-flex align-items-center" >
                    <!-- Logo -->
                    <a href="../../index.html">
                        <img src="../../../assets/img/Imagem 3.jpeg" alt="Logo da empresa" class="logo"> <!-- Clicar no logo vai pro início -->
                    </a>
                </div>

                <!-- Botão para voltar ao menu-->
                <div class="col-auto"> 
                    <button class="custom-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                        <i class="fa-solid fa-bars me-2"></i> Menu
                    </button>
                </div>
            </div>
        </header>

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
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Fornecedores</strong>
                </h2>
                <a href="novo_forn.html" class="btn ms-auto btn-novo" style="background-color: #680447; color: white;">
                    <i class="fa-solid fa-plus me-1"></i> Novo fornecedor
                </a>
            </div>

            <hr>
            <!-- Área de sucesso -->
            <div class="alert alert-success text-center d-none" id="mensagemSucesso" role="alert">
                • Operação realizada com sucesso.
            </div>
            <div class="card border-0 shadow mb-4 rounded-4">

                <div class="card-body" style="background-color: #fff4fb;">
                    <!-- Pesquisa -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #680447;"></i>
                                </span>
                                <input type="text"
                                    class="form-control"
                                    placeholder="NIF, contacto, website, pessoa de contacto ...">
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="p-3 rounded-4 bg-white shadow-sm">
                        <h6 class="fw-bold mb-3" style="color:#680447;">
                            <i class="fa-solid fa-sliders me-2"></i>Filtros avançados
                        </h6>
                        <div class="row g-3 mb-4">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nome da empresa</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tipo de fornecedor</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                        <option>Fabricante</option>
                                        <option>Distribuidor / Fornecedor comercial</option>
                                        <option>Assistência técnica</option>
                                        <option>Fornecedor de consumíveis</option>
                                    </select>
                                </div>

                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-rotate-left me-1"></i> Limpar
                                </button>

                                <button type="button" class="btn text-white" style="background-color:#680447;">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Aplicar filtros
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-muted">Consulte a tabela abaixo com os fornecedores registados.</p>
            <div class="card shadow rounded-4 border-0 p-3">
                <div class="table-responsive">
                    <table class="table table-bordered able-striped align-middle text-center">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>Empresa</th> 
                                <th>NIF</th>
                                <th>Contacto telefónico</th> 
                                <th>Email</th> 
                                <th>Tipo de fornecedor</th> 
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>[Nome empresa]</td> 
                                <td>[NIF]</td> 
                                <td>[Contacto]</td> 
                                <td>[Email]</td> 
                                <td>[Tipo fornecedor]</td> 
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="detalhes_forn.html"  class="btn-sm btn-acao me-3"><i class="fa-solid fa-eye me-2"></i> Consultar</a>
                                        <a href="editar_forn.html" class="btn-sm btn-acao me-3"><i class="fa-regular fa-pen-to-square me-2"></i> Editar</a>
                                        <a href="#" class="btn-sm btn-acao" data-bs-toggle="modal" data-bs-target="#modalEliminar"><i class="fa-solid fa-trash-can me-2"></i> Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
        <div class="modal fade" id="modalEliminar" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered"> <!-- Cria uma pequena janela centrada -->
                <div class="modal-content rounded-4">

                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#680447;">
                            Confirmar eliminação
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Tem a certeza que pretende eliminar este fornecedor?</p>

                        <p><strong>Empresa:</strong> <span id="modalEmpresa"></span></p>
                        <p><strong>Contacto telefónico:</strong> <span id="modalContacto"></span></p>
                        <p><strong>Tipo de fornecedor:</strong> <span id="modalFornecedor"></span></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="button" class="btn btn-danger" id="btnConfirmarEliminar" data-bs-dismiss="modal">
                            Eliminar
                        </button>
                    </div>

                    <!-- Área de erros -->
                    <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                        • Erro
                    </div>
                </div>
            </div>
        </div>
        
<!-- Custom JS -->
<script src="../../../assets/js/1240811.js"></script>

<?php include 'includes/footer.php'; ?>