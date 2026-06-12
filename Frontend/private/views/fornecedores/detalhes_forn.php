<?php include '../../includes/header.php'; ?>
<?php
$pagina = 'normal';
include '../../includes/nav.php';
include '../../includes/sidebar.php';
?>

        

        <div class="container-fluid p-4" style="background-color: #fff4fb;">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes do Fornecedor</strong>
                </h2>
            </div>

            <!-- Card principal -->
            <div class="card shadow rounded-4 border-0 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <small class="text-muted">Nome da empresa</small>
                            <h5 class="fw-semibold mb-0"></h5>
                        </div>
                        <div class="col-md-6 mb-1">
                            <small class="text-muted">NIF</small>
                            <h5 class="fw-semibold mb-0"></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards -->
            <div class="row g-4">

                <!-- Contactos -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-phone me-2"></i>
                                Contactos
                            </h5>
                            <div class="mb-3">
                                <small class="text-muted">Número telefónico</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Email</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Website</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Morada -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                Morada
                            </h5>
                            <div>
                                <small class="text-muted">Morada</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pessoa de contacto -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-user-tie me-2"></i>
                                Pessoa de contacto
                            </h5>
                            <div class="mb-3">
                                <small class="text-muted">Nome</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                            <div>
                                <small class="text-muted">Telefone</small>
                                <p class="fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tipo de fornecedor -->
                <div class="col-lg-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-building me-2"></i>
                                Tipo de fornecedor
                            </h5>
                            <div>
                                <small class="text-muted">Classificação</small>
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
                <a href="/ProjetoSIBDAS/Frontend/private/views/fornecedores/lista_forn.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>



<?php include '../../includes/footer.php'; ?>