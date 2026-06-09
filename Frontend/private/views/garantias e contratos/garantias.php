<?php include '../../includes/header.php'; ?>
<?php
$pagina = 'normal';
include '../../includes/nav.php';
include '../../includes/sidebar.php';
?>

        

        <!-- Conteúdo Principal -->
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Garantias e Contratos</strong>
                </h2>
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
                                    placeholder="Datas, entidade responsável ...">
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="p-3 rounded-4 bg-white shadow-sm">
                        <h6 class="fw-bold mb-3" style="color:#680447;">
                            <i class="fa-solid fa-sliders me-2"></i>Filtros avançados
                        </h6>
                        <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Contrato de manutenção</label>
                                    <select class="form-select">
                                        <option >Sim</option>
                                        <option >Não</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tipo de contrato</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                        <option >Preventivo</option>
                                        <option >Corretivo</option>
                                        <option >Completo</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Periodicidade</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                        <option>Mensal</option>
                                        <option>Trimestral</option>
                                        <option>Semestral</option>
                                        <option>Anual</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Entidade responsável</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
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
            
            <p class="text-muted">Consulte a tabela abaixo com as garantias e contratos registados.</p>
            <div class="card shadow rounded-4 border-0 p-3">
                <div class="table-responsive">
                    <table class="table table-bordered able-striped align-middle text-center">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>Equipamento</th> 
                                <th>Garantia até</th>
                                <th>Contrato de manutenção</th> 
                                <th>Tipo de contrato</th> 
                                <th>Entidade responsável</th> 
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>[Código]</td> 
                                <td>[Data de fim de garantia]</td> 
                                <td>[Sim/Não]</td> 
                                <td>[Tipo de contrato]</td> 
                                <td>[Entidade responsável]</td> 
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="detalhes_garant.html"  class="btn-sm btn-acao me-3"><i class="fa-solid fa-eye me-2"></i> Consultar</a>
                                        <a href="../equipamentos/editar.html" class="btn-sm btn-acao me-3"><i class="fa-regular fa-pen-to-square me-2"></i> Editar</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
        
<!-- Custom JS -->
<script src="/ProjetoSIBDAS/Frontend/assets/js/1240811.js"></script>

<?php include '../../includes/footer.php'; ?>