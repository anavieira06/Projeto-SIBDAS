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
    }
});
