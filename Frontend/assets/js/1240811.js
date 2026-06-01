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