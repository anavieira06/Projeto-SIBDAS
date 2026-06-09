<?php include 'includes/header.php'; ?>

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
                    <strong>Listagem de Documentos</strong>
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
                                    placeholder="Nome, data ...">
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
                                    <label class="form-label fw-semibold">Tipo de documento</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                        <option>Manual de utilizador</option>
                                        <option>Manual de serviço</option>
                                        <option>Certificado de calibração</option>
                                        <option>Contrato de manutenção</option>
                                        <option>Fatura / Guia de aquisição</option>
                                        <option>Declaração de conformidade</option>
                                        <option>Relatório técnico</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Equipamento associado</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Fornecedor associado</label>
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
            
            <p class="text-muted">Consulte a tabela abaixo com a documentação registada.</p>
            <div class="card shadow rounded-4 border-0 p-3">
                <div class="table-responsive">
                    <table class="table table-bordered able-striped align-middle text-center">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>Tipo de documento</th> 
                                <th>Nome</th>
                                <th>Data</th> 
                                <th>Equipamento associado</th> 
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>[Tipo de documento]</td> 
                                <td>[Nome]</td> 
                                <td>[Data]</td> 
                                <td>[Código]</td> 
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="detalhes_doc.html"  class="btn-sm btn-acao me-3"><i class="fa-solid fa-eye me-2"></i> Consultar</a>
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
<script src="/Projeto SIBDAS/Frontend/private/assets/js/1240811.js"></script>

<?php include 'includes/footer.php'; ?>