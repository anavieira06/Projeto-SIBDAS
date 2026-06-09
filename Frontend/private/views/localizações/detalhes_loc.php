<?php include '../../includes/header.php'; ?>
<?php
$pagina = 'normal';
include '../../includes/nav.php';
include '../../includes/sidebar.php';
?>

        

        <div class="container-fluid p-4 min-vh-100" style="background-color: #fff4fb;">
            <!-- Título -->
            <div class="mb-4">
                <h2 style="color:#680447;">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    <strong>Detalhes da Localização</strong>
                </h2>
            </div>
            
            <!-- Localização -->
            <div class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body">

                    <h5 class="mb-4" style="color:#680447;">
                        <i class="fa-solid fa-location-dot me-2"></i>
                        Localização
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <small class="text-muted">Edifício</small>
                            <p class="fw-semibold mb-0"></p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Piso</small>
                            <p class="fw-semibold mb-0"></p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Serviço / Departamento</small>
                            <p class="fw-semibold mb-0"></p>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Sala / Gabinete</small>
                            <p class="fw-semibold mb-0"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botoão -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="lista_loc.html" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>



<?php include '../../includes/footer.php'; ?>