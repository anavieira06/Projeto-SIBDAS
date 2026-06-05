/* Criticidade dos equipamentos */
document.querySelectorAll(".criticidade").forEach(function(celula) {
    const valor = celula.textContent.trim();

    celula.classList.add("criticidade-badge");

    if (valor === "Baixa") {
        celula.classList.add("criticidade-baixa");
    } else if (valor === "Média") {
        celula.classList.add("criticidade-media");
    } else if (valor === "Alta") {
        celula.classList.add("criticidade-alta");
    } else if (valor === "Suporte de vida") {
        celula.classList.add("criticidade-suporte-vida");
    }
});

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
// Base de dados local das localizações
const localizacoes = {
    1: {
        edificio: "Hospital Central",
        piso: "Piso 2",
        sala: "BO-204",
        servico: "Bloco Operatório"
    },
    2: {
        edificio: "Hospital Central",
        piso: "Piso 0",
        sala: "URG-12",
        servico: "Urgência"
    },
    3: {
        edificio: "Hospital Central",
        piso: "Piso 3",
        sala: "UCI-301",
        servico: "Unidade de Cuidados Intensivos"
    }
};

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

/* Fornecedores nos documentos */
// Base de dados local dos fornecedores
const fornecedores = {
    1: {
        nome: "Philips Healthcare Portugal",
        nif: "500 123 456",
        morada: "Av. da Liberdade, 110, Lisboa",
        tipo: "Fabricante",
        telefone: "+351 210 000 000",
        email: "geral@philips.pt",
        website: "www.philips.pt",
        contacto: "João Ferreira",
        telContacto: "+351 962 000 000"
    },
    2: {
        nome: "Dräger Portugal",
        nif: "500 234 567",
        morada: "Rua do Ouro, 55, Porto",
        tipo: "Fabricante",
        telefone: "+351 220 000 000",
        email: "geral@draeger.pt",
        website: "www.draeger.com/pt",
        contacto: "Ana Sousa",
        telContacto: "+351 933 000 000"
    },
    3: {
        nome: "B. Braun Portugal",
        nif: "500 345 678",
        morada: "Av. do Brasil, 23, Lisboa",
        tipo: "Distribuidor",
        telefone: "+351 210 111 000",
        email: "geral@bbraun.pt",
        website: "www.bbraun.pt",
        contacto: "Carlos Mendes",
        telContacto: "+351 912 000 000"
    }
};

function preencherFornecedor() {
    const id = document.getElementById("selectFornecedor").value;
    const painel = document.getElementById("infoFornecedor");

    if (!id) {
        painel.classList.add("d-none");
        return;
    }

    const f = fornecedores[id];

    document.getElementById("f-nome").textContent = f.nome;
    document.getElementById("f-nif").textContent = f.nif;
    document.getElementById("f-morada").textContent = f.morada;
    document.getElementById("f-tipo").textContent = f.tipo;
    document.getElementById("f-telefone").textContent = f.telefone;
    document.getElementById("f-email").textContent = f.email;
    document.getElementById("f-website").textContent = f.website;
    document.getElementById("f-contacto").textContent = f.contacto;
    document.getElementById("f-tel-contacto").textContent = f.telContacto;

    painel.classList.remove("d-none");
}


/* Dashboard */
// Gráfico por estado
    new Chart(document.getElementById('estadoChart'), {
        type: 'pie',
        data: {
            labels: ['Ativos', 'Manutenção', 'Inativos'],
            datasets: [{
                data: [1103, 89, 55],
                backgroundColor: ['#680447', '#d63384', '#f4a6d7']
            }]
        }
    });

    // Gráfico por serviço
    new Chart(document.getElementById('servicoChart'), {
        type: 'bar',
        data: {
            labels: ['UCI', 'Urgência', 'Bloco Operatório', 'Imagiologia', 'Laboratório'],
            datasets: [{
                label: 'Equipamentos',
                data: [120, 95, 72, 48, 60],
                backgroundColor: '#bb226f'
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Gráfico por categoria
    new Chart(document.getElementById('categoriaChart'), {
        type: 'pie',
        data: {
            labels: ['Monitorização', 'Diagnóstico', 'Suporte de Vida', 'Laboratório', 'Terapia', 'Esterilização', 'Reabilitação'],
            datasets: [{
                data: [25, 23, 17, 12, 10, 10, 8],
                backgroundColor: ['#680447', '#9b0a68', '#c3186d', '#d24497', '#f083c3', '#f7c6e0', '#fff4fb']
            }]
        }
    });



