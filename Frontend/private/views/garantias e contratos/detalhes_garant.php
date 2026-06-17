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

        

        <div class="container-fluid p-4 min-vh-100" style="background-color: #fff4fb;">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes da Garantia | Contrato</strong>
                </h2>
            </div>

            <!-- Card principal -->
            <div class="card shadow rounded-4 border-0 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <small class="text-muted">Data de início de Garantia</small>
                            <h5 class="fw-semibold mb-0"></h5>
                        </div>
                        <div class="col-md-6 mb-1">
                            <small class="text-muted">Data de fim de Garantia</small>
                            <h5 class="fw-semibold mb-0"></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards -->
            <div class="row g-4">

                
                <div class="col-lg-12">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-4" style="color:#680447;">
                                <i class="fa-solid fa-file-signature me-2"></i>
                                Contrato
                            </h5>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <small class="text-muted">Contrato de manutenção</small>
                                    <p class="fw-semibold mb-0"></p>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted">Tipo de contrato</small>
                                    <p class="fw-semibold mb-0"></p>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <small class="text-muted">Periodicidade</small>
                                    <p class="fw-semibold mb-0"></p>
                                </div>

                                <div class="col-md-6">
                                    <small class="text-muted">Entidade responsável</small>
                                    <p class="fw-semibold mb-0"></p>
                                </div>

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
                <a href="/ProjetoSIBDAS/Frontend/private/views/garantias e contratos/garantias.php" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>



<?php include __DIR__ . '../../includes/footer.php'; ?>