// Simulação de eliminação de equipamentos
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
