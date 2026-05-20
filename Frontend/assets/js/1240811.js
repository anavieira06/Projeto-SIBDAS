// Simulação de adição de equipamentos
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("formEquipamento");

    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const equipamento = {
                codigo: document.getElementById("codigo_inventario").value,
                categoria: document.getElementById("categoria_grupo").value,
                designacao: document.getElementById("designacao_equipamento").value,
                marca: document.getElementById("marca").value,
                modelo: document.getElementById("modelo").value,
                numeroSerie: document.getElementById("numero_serie").value,
                fabricante: document.getElementById("fabricante").value,
                dataAquisicao: document.getElementById("data_aquisicao").value,
                anoFabrico: document.getElementById("ano_fabrico").value,
                custoAquisicao: document.getElementById("custo_aquisicao").value,
                tipoEntrada: document.getElementById("tipo_entrada").value,
                estado: document.getElementById("estado").value,
                criticidade: document.getElementById("criticidade").value,
                observacoes: document.getElementById("observacoes").value
            };
            let equipamentos = JSON.parse(localStorage.getItem("equipamentos")) || [];

            equipamentos.push(equipamento);

            localStorage.setItem("equipamentos", JSON.stringify(equipamentos));

            const mensagem = document.getElementById("mensagem_sucesso");
            if (mensagem) {
                mensagem.textContent = "Equipamento adicionado com sucesso.";
                mensagem.classList.remove("d-none");
            }

            setTimeout(function () {
                window.location.href = "lista.html";
            }, 3000);
        });
        
    }

    const tabela = document.getElementById("tabelaEquipamentos"); /* Tabela */

    if (tabela) {
        const equipamentos = JSON.parse(localStorage.getItem("equipamentos")) || [];

        equipamentos.forEach(function (equipamento) {
            tabela.innerHTML += `
            <tr>
                <td>${equipamento.codigo}</td>
                <td>${equipamento.designacao}</td>
                <td>${equipamento.categoria}</td>
                <td>${equipamento.marca}</td>
                <td>${equipamento.modelo}</td>
                <td>${equipamento.numeroSerie}</td>
                <td>${equipamento.estado}</td>
                <td>${equipamento.criticidade}</td>

                <td class="text-center d-flex justify-content-center align-items-center gap-2">

                    <a href="detalhes.html"
                    class="btn-sm me-3 btn-acao">
                        <i class="fa-solid fa-eye me-2"></i>
                        Consultar
                    </a>

                    <a href="editar.html"
                    class="btn-sm me-3 btn-acao">
                        <i class="fa-regular fa-pen-to-square me-2"></i>
                        Editar
                    </a>

                    <a href="#"
                    class="btn-sm btn-acao btn-apagar"
                    data-codigo="${equipamento.codigo}"
                    data-designacao="${equipamento.designacao}"
                    data-marca="${equipamento.marca}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEliminar">

                        <i class="fa-solid fa-trash-can me-2"></i>
                        Eliminar
                    </a>

                </td>
            </tr>
            `;
        });
    }

});




// Simulação de eliminação de equipamentos
document.addEventListener("DOMContentLoaded", function () {
    let linhaSelecionada = null;
    document.querySelectorAll(".btn-apagar").forEach(function(botao) {
        botao.addEventListener("click", function() {
            /* Guarda a linha da tabela */
            linhaSelecionada = this.closest("tr");
            /* Coloca os dados no modal */
            document.getElementById("modalCodigo").textContent =
                this.dataset.codigo;
            document.getElementById("modalDesignacao").textContent =
                this.dataset.designacao;
            document.getElementById("modalMarca").textContent =
            this.dataset.marca;
            });
    });

    document.getElementById("confirmarEliminar") .addEventListener("click", function() {
        if (linhaSelecionada) {
            linhaSelecionada.remove();/* Remove a linha da tabela */
            /* Mostra mensagem de sucesso */
            const mensagem =
                document.getElementById("mensagemSucesso");
                mensagem.classList.remove("d-none");
            /* Esconde após 3 segundos */
            setTimeout(function () {
                mensagem.classList.add("d-none");
            }, 3000);
        }
    });
});



