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
                            <h2 class="mb-4" style="color: #680447;"><strong><i class="fa-solid fa-pen-to-square me-2"></i> Atualização de Dados FORNECEDORES</strong></h2>
                            <hr>
                            <form action="#" method="post">
                                <!-- Campo nome da empresa --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="nome_empresa" class="form-label">Nome da empresa<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" value="HealthPrime Medical Systems" >
                                    </div>
                                </div>

                                <!-- Campo NIF --> 
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="nif" class="form-label">NIF<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nif" name="nif" value="509876321" >
                                    </div>
                                </div>

                                <!-- Campo Morada --> 
                                <div class="row mb-3"> 
                                    <div class="col-12">
                                        <label for="morada" class="form-label">Morada <span class="text-danger">*</span></label> 
                                        <input type="text" class="form-control" id="morada" name="morada" value="Rua das Flores, nº 28">
                                    </div>
                                </div>

                                <!-- Campo Tipo de fornecedor -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="tipo_fornecedor" class="form-label">Tipo de fornecedor <span class="text-danger">*</span></label>
                                        <select class="form-control" id="tipo_fornecedor" name="tipo_fornecedor" > 
                                            <option selected disabled>Escolha uma opção</option>
                                            <option value="Distribuidor / fornecedor comercial">Distribuidor / fornecedor comercial</option>
                                            <option value="Assistência técnica">Assistência técnica</option>
                                            <option value="Fornecedor de consumíveis">Fornecedor de consumíveis</option>
                                            <option value="Fabricante" selected>Fabricante</option>
                                        </select>
                                    </div>      
                                </div>

                                <!-- Secção: Contactos -->
                                <h5 class="mt-4 mb-3" style="color:#680447;">
                                    <i class="fa-solid fa-phone me-2"></i>
                                    Contactos
                                </h5>

                                <!-- Campos Número telefónico, Email e Website-->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="numero_telefonico" class="form-label">Número telefónico <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="numero_telefonico" name="numero_telefonico" value="+351 212 456 890" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" value="suporte@healthprime-medical.pt" >
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website" class="form-label">Website <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="website" name="website" value="www.healthprime-medical.pt" >
                                    </div>
                                </div>

                                <!-- Campos Pessoa de contacto e Telefone da pessoa de contacto -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="pessoa_contacto" class="form-label">Pessoa de contacto <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pessoa_contacto" name="pessoa_contacto" value="Dr. Ricardo Almeida" >
                                    </div>
                                    <div class="col-6">
                                        <label for="tel_pessoa_contacto" class="form-label">Telefone da pessoa de contacto <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tel_pessoa_contacto" name="tel_pessoa_contacto" value="+351 917 845 320" >
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
                                        <textarea class="form-control" id="observacoes" name="observacoes" rows="4" value="Informações adicionais sobre o fornecedor..."></textarea>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="d-flex justify-content-end gap-2 mb-4">
                                    <a href="lista_forn.html" class="btn btn-outline-secondary">
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



<?php include 'includes/footer.php'; ?>