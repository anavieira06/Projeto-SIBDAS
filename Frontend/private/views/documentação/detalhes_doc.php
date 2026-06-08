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

        <div class="container-fluid p-4" style="background-color: #fff4fb;">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes do Documento</strong>
                </h2>
            </div>

            <!-- Card principal -->
            <div class="card shadow rounded-4 border-0 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <small class="text-muted">Nome do documento</small>
                            <h5 class="fw-semibold mb-0"></h5>
                        </div>
                        <div class="col-md-6 mb-1">
                            <small class="text-muted">Tipo de documento</small>
                            <h5 class="fw-semibold mb-0"></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards -->
            <div class="row g-4">

                <!-- Datas -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-calendar-days me-2"></i>
                                Datas
                            </h5>

                            <div class="mb-3">
                                <small class="text-muted">Data do documento</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>

                            <div>
                                <small class="text-muted">Data de validade</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Associações -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-link me-2"></i>
                                Associações
                            </h5>

                            <div class="mb-3">
                                <small class="text-muted">Equipamento associado</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>

                            <div>
                                <small class="text-muted">Fornecedor associado</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ficheiro -->
                <div class="col-lg-6 mx-auto">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-paperclip me-2"></i>
                                Ficheiro
                            </h5>

                            <div class="mb-3">
                                <small class="text-muted">Nome do ficheiro</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">Localização do ficheiro</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="col-12">
                    <div class="card shadow-sm rounded-4 border-0">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-note-sticky me-2"></i>
                                Observações
                            </h5>

                            <p class="mb-0"></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Botoão -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="lista_doc.html" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>

<?php include 'includes/footer.php'; ?>