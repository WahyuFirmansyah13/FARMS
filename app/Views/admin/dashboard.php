<?= $this->include('layout/header') ?>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Petani</div>
                        <div class="h5 mb-0 font-weight-bold">10</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Tanaman</div>
                        <div class="h5 mb-0 font-weight-bold">10</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-seedling fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Laporan
                        </div>
                        <div class="h5 mb-0 font-weight-bold">5</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Aktivitas Terakhir</div>
                        <div class="h5 mb-0 font-weight-bold">2</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-header">
                Grafik Pertumbuhan Petani
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 320px;">
                    <canvas id="petaniGrowthChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">
                Distribusi Jenis Tanaman
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4" style="height: 320px;">
                    <canvas id="tanamanDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>

<script>
    // Helper to get CSS variables
    const getCSSVar = (variable) => getComputedStyle(document.documentElement).getPropertyValue(variable).trim();

    // --- Petani Growth Chart (Line Chart) ---
    const ctxPetani = document.getElementById("petaniGrowthChart").getContext('2d');
    
    const gradientPetani = ctxPetani.createLinearGradient(0, 0, 0, 320);
    gradientPetani.addColorStop(0, 'rgba(41, 128, 185, 0.6)');
    gradientPetani.addColorStop(1, 'rgba(41, 128, 185, 0)');

    const petaniGrowthChart = new Chart(ctxPetani, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Petani Baru",
                backgroundColor: gradientPetani,
                borderColor: getCSSVar('--primary'),
                data: [0, 1, 1, 2, 3, 3, 4, 5, 6, 8, 9, 10],
                fill: true,
                tension: 0.4,
                pointBackgroundColor: getCSSVar('--primary'),
                pointBorderColor: '#fff',
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: getCSSVar('--primary'),
                pointHoverBorderWidth: 3,
            }],
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false // Hide legend for single dataset
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: getCSSVar('--border-color')
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // --- Tanaman Distribution Chart (Doughnut Chart) ---
    const ctxTanaman = document.getElementById("tanamanDistributionChart").getContext('2d');
    const tanamanDistributionChart = new Chart(ctxTanaman, {
        type: 'doughnut',
        data: {
            labels: ["Padi", "Jagung", "Cabai", "Tomat", "Lainnya"],
            datasets: [{
                data: [30, 15, 25, 10, 20],
                backgroundColor: [
                    getCSSVar('--primary'),
                    getCSSVar('--success'),
                    getCSSVar('--warning'),
                    getCSSVar('--danger'),
                    '#9B59B6'
                ],
                borderColor: getCSSVar('--bg-white'),
                borderWidth: 4,
                hoverBorderColor: getCSSVar('--bg-white'),
            }],
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: getCSSVar('--font-family'),
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + '%';
                            }
                            return label;
                        }
                    }
                }
            }
        },
    });
</script>
