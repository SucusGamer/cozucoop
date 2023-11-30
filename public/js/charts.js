$.ajax({
    url: "/dashboard/getInfoTurnos",
    type: "GET",
    dataType: "json",
    success: function (data) {
        console.log(data);

        // Organizar datos para el gráfico
        const datasets = [];

        // Filtrar las unidades para cada tipo de turno
        const mananaData = data.filter(item => item.Turno === 'Mañana');
        const tardeData = data.filter(item => item.Turno === 'Tarde');
        const completoData = data.filter(item => item.Turno === 'Completo');

        // Crear dataset para cada tipo de turno
        datasets.push({
            label: 'Mañana',
            data: mananaData.map(item => ({ x: 'Mañana', y: item.Unidad })),
            backgroundColor: 'rgba(255, 99, 132, 0.7)'
        });

        datasets.push({
            label: 'Tarde',
            data: tardeData.map(item => ({ x: 'Tarde', y: item.Unidad })),
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        });

        datasets.push({
            label: 'Completo',
            data: completoData.map(item => ({ x: 'Completo', y: item.Unidad }))
                .concat(completoData.map(item => ({ x: 'Completo', y: item.CambioUnidad }))),
            backgroundColor: 'rgba(75, 192, 192, 0.7)'
        });

        var ctx = document.getElementById('grafico').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mañana', 'Tarde', 'Completo'],
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Unidad'
                        }
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return 'Unidad: ' + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
    }
});

$.ajax({
    url: "/dashboard/getReporteMensual",
    type: "GET",
    dataType: "json",
    success: function (data) {
        console.log(data);
        const reporte = data; // Suponiendo que la respuesta contiene el objeto $reporte con los datos

        const ctx = document.getElementById('grafico2').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mañana', 'Tarde', 'Completo'],
                datasets: [{
                    label: 'Turnos trabajados',
                    data: [
                        reporte['Mensual']['Mañana'],
                        reporte['Mensual']['Tarde'],
                        reporte['Mensual']['Completo']
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    },
    error: function (error) {
        console.error('Error al obtener los datos:', error);
    }
});

//ahora hacemos lo mismo pero para mostrar el total de horas trabajadas
$.ajax({
    url: "/dashboard/getReporteMensual",
    type: "GET",
    dataType: "json",
    success: function (data) {
        const reporte = data; // Suponiendo que la respuesta contiene el objeto $reporte con los datos
        const totalHorasTrabajadas = reporte['Mensual']['TotalHorasTrabajadas'];

        const ctx = document.getElementById('grafico3').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie', // Puedes usar 'pie' si prefieres un gráfico de pastel
            data: {
                labels: ['Total de Horas Trabajadas'],
                datasets: [{
                    label: 'Horas trabajadas',
                    data: [totalHorasTrabajadas],
                }]
            },
            options: {
                cutout: '40%', // Esto es para hacer un gráfico de dona
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Total de Horas Trabajadas'
                    }
                }
            }
        });
    },
    error: function (error) {
        console.error('Error al obtener los datos:', error);
    }
});

$.ajax({
    url: "/dashboard/getUsuariosMasActivos",
    type: "GET",
    dataType: "json",
    success: function (data) {
        const usuarios = Object.keys(data);
        const turnosTrabajados = Object.values(data);

        const ctx = document.getElementById('grafico4').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usuarios,
                datasets: [{
                    label: 'Cantidad de turnos trabajados',
                    data: turnosTrabajados,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', // Rojo
                        'rgba(54, 162, 235, 0.7)', // Azul
                        'rgba(255, 206, 86, 0.7)', // Amarillo
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    }
                },
                cutout: '100%', // Esto es para hacer un gráfico de dona
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Usuarios más activos (Top 3)'
                    }
                }
            }
        });
    },
    error: function (error) {
        console.error('Error al obtener los datos:', error);
    }
});