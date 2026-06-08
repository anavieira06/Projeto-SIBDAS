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
        <div class="container-fluid p-4">
            <div class="d-flex align-items-center mb-3 w-100">
                <h2 class="mb-0" style="color: #680447;">
                    <i class="fa-solid fa-list-check me-2"></i>
                    <strong>Listagem de Equipamentos</strong>
                </h2>
                <a href="novo.html" class="btn ms-auto btn-novo" style="background-color: #680447; color: white;">
                    <i class="fa-solid fa-plus me-1"></i> Novo equipamento
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
                                    placeholder="Código, designação, marca, modelo ...">
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="p-3 rounded-4 bg-white shadow-sm">
                        <h6 class="fw-bold mb-3" style="color:#680447;">
                            <i class="fa-solid fa-sliders me-2"></i>Filtros avançados
                        </h6>
                        <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Estado</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                        <option>Ativo</option>
                                        <option>Inativo</option>
                                        <option>Em calibração</option>
                                        <option>Em quarentena</option>
                                        <option>Abatido</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Categoria</label>
                                    <select class="form-select">
                                        <option selected>Todas</option>
                                        <option>Monitorização</option>
                                        <option>Diagnóstico</option>
                                        <option>Suporte de vida</option>
                                        <option>Terapia</option>
                                        <option>Laboratório</option>
                                        <option>Esterilização</option>
                                        <option>Reabilitação</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Criticidade</label>
                                    <select class="form-select">
                                        <option selected>Todas</option>
                                        <option>Baixa</option>
                                        <option>Média</option>
                                        <option>Alta</option>
                                        <option>Suporte de vida</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Serviço / Departamento</label>
                                    <select class="form-select">
                                        <option selected>Todos</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Fornecedor</label>
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
            
            <p class="text-muted">Consulte a tabela abaixo com os equipamentos registados.</p>
            <div class="card shadow rounded-4 border-0 p-3">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table align-middle text-center" style="color: #fff; background-color: #945880;">
                            <tr>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Código interno
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Designação
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Categoria / Grupo
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Marca
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th> 
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Modelo
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th> 
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Nº de série
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Fornecedor
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Serviço / Departamento
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Estado
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th> 
                                <th>
                                    <a href="#" class="text-decoration-none" style="color: #fff;">
                                        Criticidade
                                        <i class="fa-solid fa-sort ms-1"></i>
                                    </a>
                                </th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>[Código interno]</td> 
                                <td>[Designação]</td> 
                                <td>[Categoria / Grupo]</td> 
                                <td>[Marca]</td> 
                                <td>[Modelo]</td> 
                                <td>[Nº de série]</td> 
                                <td>[NIF fornecedor]</td>  
                                <td>[Serviço/Departamento]</td> 
                                <td>[Estado]</td> 
                                <td>[Criticidade]</td> 
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="detalhes.html"  class="btn-sm btn-acao me-3"><i class="fa-solid fa-eye me-2"></i> Consultar</a>
                                        <a href="editar.html" class="btn-sm btn-acao me-3"><i class="fa-regular fa-pen-to-square me-2"></i> Editar</a>
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
                        <p>Tem a certeza que pretende eliminar este equipamento?</p>

                        <p><strong>Código:</strong> <span id="modalCodigo"></span></p>
                        <p><strong>Designação:</strong> <span id="modalDesignacao"></span></p>
                        <p><strong>Marca:</strong> <span id="modalMarca"></span></p>
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