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
        type: 'doughnut',
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
                backgroundColor: '#d63384'
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
            labels: ['Monitorização', 'Diagnóstico', 'Suporte de Vida', 'Laboratório', 'Terapia'],
            datasets: [{
                data: [35, 25, 18, 12, 10],
                backgroundColor: ['#680447', '#9b0a68', '#d63384', '#f083c3', '#f7c6e0']
            }]
        }
    });