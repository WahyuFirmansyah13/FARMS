<?= $this->include('layout/header') ?>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Jenis Tanaman</div>
                        <div class="h5 mb-0 font-weight-bold"><?= esc($total_tanaman) ?></div>
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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Aktivitas Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold"><?= esc($aktivitas_bulan_ini) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Musim Aktif</div>
                        <div class="h5 mb-0 font-weight-bold"><?= esc($musim_aktif) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
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
                            Total Panen</div>
                        <div class="h5 mb-0 font-weight-bold"><?= esc($total_panen) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tractor fa-2x text-gray-300"></i>
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
                Grafik Keuangan (6 Bulan Terakhir)
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 320px;">
                    <canvas id="keuanganChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">
                Komposisi Biaya
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4" style="height: 320px;">
                    <canvas id="biayaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>

<script>
    // Helper to get CSS variables
    const getCSSVar = (variable) => getComputedStyle(document.documentElement).getPropertyValue(variable).trim();

    // --- Keuangan Chart (Line Chart) ---
    const ctxKeuangan = document.getElementById("keuanganChart").getContext('2d');
    
    const gradientPendapatan = ctxKeuangan.createLinearGradient(0, 0, 0, 320);
    gradientPendapatan.addColorStop(0, 'rgba(46, 204, 113, 0.6)');
    gradientPendapatan.addColorStop(1, 'rgba(46, 204, 113, 0)');

    const gradientBiaya = ctxKeuangan.createLinearGradient(0, 0, 0, 320);
    gradientBiaya.addColorStop(0, 'rgba(231, 76, 60, 0.6)');
    gradientBiaya.addColorStop(1, 'rgba(231, 76, 60, 0)');

    const keuanganChart = new Chart(ctxKeuangan, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_keuangan['labels']) ?>,
            datasets: [{
                label: "Pendapatan",
                backgroundColor: gradientPendapatan,
                borderColor: getCSSVar('--success'),
                data: <?= json_encode($chart_keuangan['pendapatan']) ?>,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: getCSSVar('--success'),
                pointBorderColor: '#fff',
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: getCSSVar('--success'),
                pointHoverBorderWidth: 3,
            }, {
                label: "Pengeluaran",
                backgroundColor: gradientBiaya,
                borderColor: getCSSVar('--danger'),
                data: <?= json_encode($chart_keuangan['pengeluaran']) ?>,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: getCSSVar('--danger'),
                pointBorderColor: '#fff',
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: getCSSVar('--danger'),
                pointHoverBorderWidth: 3,
            }],
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: getCSSVar('--font-family'),
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
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
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + value / 1000000 + ' Jt';
                            }
                            if (value >= 1000) {
                                return 'Rp ' + value / 1000 + ' Rb';
                            }
                            return 'Rp ' + value;
                        }
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

    // --- Biaya Chart (Doughnut Chart) ---
    const ctxBiaya = document.getElementById("biayaChart").getContext('2d');
    const biayaChart = new Chart(ctxBiaya, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($chart_biaya['labels']) ?>,
            datasets: [{
                data: <?= json_encode($chart_biaya['data']) ?>,
                backgroundColor: [
                    getCSSVar('--primary'),
                    getCSSVar('--success'),
                    getCSSVar('--warning'),
                    '#E67E22',
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
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        },
    });
</script>
