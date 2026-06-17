

/* Validação dos separadores */
document.addEventListener("DOMContentLoaded", function () {

    const etapas = [
        {
            painelId: "infoEquipamento",
            btnNextId: "btnSeguinteEquipamento",
            tabNextId: "fornecedor-tab"
        },
        {
            painelId: "infoFornecedores",
            btnNextId: "btnSeguinteFornecedor",
            tabNextId: "localizacao-tab"
        },
        {
            painelId: "infoLocalizacao",
            btnNextId: "btnSeguinteLocalizacao",
            tabNextId: "documentacao-tab"
        },
        {
            painelId: "infoDocumentos",
            btnNextId: "btnSeguinteDocumentos",
            tabNextId: "garantias-tab"
        }
    ];

    function tabEstaValida(painelId) {
        const painel = document.getElementById(painelId);
        const camposObrigatorios = painel.querySelectorAll("[required]");

        return Array.from(camposObrigatorios).every(function (campo) {
            return campo.value.trim() !== "";
        });
    }

    function atualizarEtapa(etapa) {
        const valido = tabEstaValida(etapa.painelId);

        const btnNext = document.getElementById(etapa.btnNextId);
        const tabNext = document.getElementById(etapa.tabNextId);

        btnNext.disabled = !valido;

        if (valido) {
            tabNext.classList.remove("disabled", "pe-none");
        } else {
            tabNext.classList.add("disabled", "pe-none");
        }
    }

    etapas.forEach(function (etapa) {
        const painel = document.getElementById(etapa.painelId);

        painel.addEventListener("input", function () {
            atualizarEtapa(etapa);
        });

        painel.addEventListener("change", function () {
            atualizarEtapa(etapa);
        });

        atualizarEtapa(etapa);
    });

});

/* Localizações nos documentos */
function preencherLocalizacao() {
    const id = document.getElementById('selectLocalizacao').value;
    const painel = document.getElementById('infoLocalizacaoPainel');

    if (!id) {
        painel.classList.add('d-none');
        return;
    }

    const l = localizacoes[id];

    document.getElementById('l-edificio').textContent = l.edificio;
    document.getElementById('l-piso').textContent = l.piso;
    document.getElementById('l-sala').textContent = l.sala;
    document.getElementById('l-servico').textContent = l.servico;

    painel.classList.remove('d-none');
}
document.addEventListener("DOMContentLoaded", function () {
    const selectLocalizacao = document.getElementById("selectLocalizacao");

    if (selectLocalizacao && selectLocalizacao.value) {
        preencherLocalizacao();
    }
});

/* Fornecedores nos equipamentos */

// Como já existe Fornecedor 1 no HTML
let contadorFornecedores = 1;

function preencherFornecedorBloco(select, numero) {
    const id = select.value;
    const f = fornecedores[id];

    document.getElementById(`f-nome-${numero}`).textContent = f.nome;
    document.getElementById(`f-nif-${numero}`).textContent = f.nif;
    document.getElementById(`f-tipo-${numero}`).textContent = f.tipo;
    document.getElementById(`f-morada-${numero}`).textContent = f.morada;
    document.getElementById(`f-telefone-${numero}`).textContent = f.telefone;
    document.getElementById(`f-email-${numero}`).textContent = f.email;
    document.getElementById(`f-website-${numero}`).textContent = f.website;
    document.getElementById(`f-contacto-${numero}`).textContent = f.contacto;
    document.getElementById(`f-tel-contacto-${numero}`).textContent = f.telContacto;

    document.getElementById(`infoFornecedor${numero}`).classList.remove("d-none");
}

document.addEventListener("DOMContentLoaded", function () {
    const selectFornecedor1 = document.querySelector("#blocoFornecedor1 select");

    if (selectFornecedor1 && selectFornecedor1.value) {
        preencherFornecedorBloco(selectFornecedor1, 1);
    }
});

function adicionarBlocoFornecedor() {
    contadorFornecedores++;

    const area = document.getElementById("areaFornecedores");

    const bloco = document.createElement("div");
    bloco.className = "border rounded p-3 mb-4";
    bloco.id = `blocoFornecedor${contadorFornecedores}`;

    bloco.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0" style="color:#680447;">
                Fornecedor ${contadorFornecedores}
            </h6>

            <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="eliminarBlocoFornecedor(${contadorFornecedores})">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Selecionar fornecedor</label>

                <select class="form-control"
                        name="fornecedor_id[]"
                        onchange="preencherFornecedorBloco(this, ${contadorFornecedores})"
                        required>
                    <option value="" selected disabled>Escolha um fornecedor</option>
                    ${Object.entries(fornecedores).map(([id, f]) => `<option value="${id}">${f.nome}</option>`).join('')}
                </select>
            </div>
        </div>

        <div id="infoFornecedor${contadorFornecedores}" class="d-none">
            <hr>

            <h6 class="text-muted mb-4">
                <i class="fa-solid fa-circle-info me-2"></i>
                Informação do fornecedor
            </h6>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-4">
                        <strong>Nome da empresa</strong>
                        <p id="f-nome-${contadorFornecedores}">-</p>
                    </div>

                    <div class="mb-4">
                        <strong>NIF</strong>
                        <p id="f-nif-${contadorFornecedores}">-</p>
                    </div>

                    <div class="mb-4">
                        <strong>Tipo de fornecedor</strong>
                        <p id="f-tipo-${contadorFornecedores}">-</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <strong>Morada</strong>
                        <p id="f-morada-${contadorFornecedores}">-</p>
                    </div>

                    <div class="mb-4">
                        <strong>Número telefónico</strong>
                        <p id="f-telefone-${contadorFornecedores}">-</p>
                    </div>

                    <div class="mb-4">
                        <strong>Email</strong>
                        <p id="f-email-${contadorFornecedores}">-</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <strong>Website</strong>
                        <p id="f-website-${contadorFornecedores}">-</p>
                    </div>

                    <div class="mb-4">
                        <strong>Pessoa de contacto</strong>
                        <p id="f-contacto-${contadorFornecedores}">-</p>
                    </div>

                    <div class="mb-4">
                        <strong>Telefone da pessoa de contacto</strong>
                        <p id="f-tel-contacto-${contadorFornecedores}">-</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    area.appendChild(bloco);
}

function eliminarBlocoFornecedor(numero) {
    const bloco = document.getElementById(`blocoFornecedor${numero}`);

    if (bloco) {
        bloco.remove();
    }
}

/* Documentos dos equipamentos */
let contadorDocumentos = 1;

function adicionarBlocoDocumento() {
    contadorDocumentos++;

    const area = document.getElementById("areaDocumentos");

    const bloco = document.createElement("div");
    bloco.className = "border rounded p-3 mb-4";
    bloco.id = `blocoDocumento${contadorDocumentos}`;

    bloco.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0" style="color:#680447;">
                Documento ${contadorDocumentos}
            </h6>
            <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="eliminarBlocoDocumento(${contadorDocumentos})">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        <h6 class="mt-3 mb-3" style="color:#680447;">
            <i class="fa-solid fa-barcode me-2"></i>
            Identificação
        </h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Tipo de documento <span class="text-danger">*</span></label>
                <select class="form-control" name="tipo_doc[]" required>
                    <option value="" selected disabled>Escolha uma opção</option>
                    <option value="Manual de utilizador">Manual de utilizador</option>
                    <option value="Manual de serviço">Manual de serviço</option>
                    <option value="Certificado de calibração">Certificado de calibração</option>
                    <option value="Contrato de manutenção">Contrato de manutenção</option>
                    <option value="Fatura / Guia de aquisição">Fatura / Guia de aquisição</option>
                    <option value="Declaração de conformidade">Declaração de conformidade</option>
                    <option value="Relatório técnico">Relatório técnico</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nome <span class="text-danger">*</span></label>
                <input type="text"
                       class="form-control"
                       name="nome_doc[]"
                       placeholder="Ex: Manual de Utilização - Ventilador Evita V500"
                       required>
            </div>
        </div>
        <h6 class="mt-4 mb-3" style="color:#680447;">
            <i class="fa-solid fa-calendar-days me-2"></i>
            Datas
        </h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Data <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="data_doc[]" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Data de validade</label>
                <input type="text" class="form-control" name="data_validade[]">
            </div>
        </div>
        <h6 class="mt-4 mb-3" style="color:#680447;">
            <i class="fa-solid fa-link me-2"></i>
            Associações e ficheiro
        </h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Fornecedor associado</label>
                <select class="form-control" name="fornecedor_doc_id[]">
                    <option value="" selected disabled>Escolha um fornecedor</option>
                    ${Object.entries(fornecedores).map(([id, f]) => `<option value="${id}">${f.nome}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Selecionar ficheiro <span class="text-danger">*</span></label>
                <input type="file"
                       class="form-control"
                       name="ficheiro[]"
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                       required>
            </div>
        </div>
    `;

    area.appendChild(bloco);
}

function eliminarBlocoDocumento(numero) {
    const bloco = document.getElementById(`blocoDocumento${numero}`);

    if (bloco) {
        bloco.remove();
    }
}






