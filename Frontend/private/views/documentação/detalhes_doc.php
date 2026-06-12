<?php 
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página de edição
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

include '../../includes/header.php'; 
?>
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
                <a href="/ProjetoSIBDAS/Frontend/private/views/documentação/lista_doc.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>

<?php include '../../includes/footer.php'; ?>