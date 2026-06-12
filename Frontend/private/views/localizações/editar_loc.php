<?php include '../../includes/header.php'; ?>
<?php
$pagina = 'normal';
include '../../includes/nav.php';
include '../../includes/sidebar.php';
?>

        

        <!-- Conteúdo Principal -->
            <main class="container-fluid p-4" style="background-color: #fff4fb;">
                <div class="d-flex justify-content-center mt-4">
                    <div class="card w-100 shadow rounded" style="max-width: 1200px;">
                        <div class="card-body">
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-pen-to-square me-2"></i> Atualização de Dados LOCALIZAÇÕES</strong></h2>
                            <hr>
                            <form action="#" method="post">
                                <!-- Campo edifício --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="edificio" class="form-label">Edifício<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edificio" name="edificio" value="Edifício Central Hospitalar" >
                                    </div>
                                </div>

                                <!-- Campo piso --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="piso" class="form-label">Piso<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="piso" name="piso" value="2" >
                                    </div>
                                </div>

                                <!-- Campos serviço / departamento -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="servico_depart" class="form-label">Serviço / Departamento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="servico_depart" name="servico_depart" value="Cardiologia" >
                                    </div>
                                </div>

                                <!-- Campo Sala / Gabinete --> 
                                <div class="row mb-3"> 
                                    <div class="col-12">
                                        <label for="sala_gabinete" class="form-label">Sala / Gabinete <span class="text-danger">*</span></label> 
                                        <input type="text" class="form-control" id="sala_gabinete" name="sala_gabinete" value="LAB01" >
                                    </div>
                                </div>                           

                                <!-- Botões -->
                                <div class="d-flex justify-content-end gap-2 mb-4">
                                    <a href="/ProjetoSIBDAS/Frontend/private/views/localizações/lista_loc.php" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-xmark me-1"></i> Cancelar 
                                    </a>
                                    <button type="submit" class="btn btn-guardar">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar
                                    </button>
                                </div>

                                <!-- Área de erros -->
                                <div class="alert alert-danger text-center d-none" id="mensagemErro" role="alert"> 
                                    • Erro
                                </div>
                
                            </form>
                    </div>
                </div>
            </main>



<?php include '../../includes/footer.php'; ?>