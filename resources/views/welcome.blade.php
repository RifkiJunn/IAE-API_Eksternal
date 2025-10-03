<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Data Visualization</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1a1a2e; /* Latar belakang biru gelap */
            color: #e0e0e0;
        }
        .navbar {
            background-color: #162447;
            border-bottom: 1px solid #1f4068;
        }
        .card {
            background-color: #1f4068; /* Warna kartu yang lebih gelap */
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .form-control {
            background-color: #162447;
            border: 1px solid #1f4068;
            color: #e0e0e0;
        }
        .form-control:focus {
            background-color: #162447;
            border-color: #e43f5a;
            box-shadow: 0 0 0 0.2rem rgba(228, 63, 90, 0.25);
            color: #fff;
        }
        .btn-custom {
            background-color: #e43f5a; /* Warna aksen merah muda */
            border-color: #e43f5a;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #b8324f;
            border-color: #b8324f;
        }
        .stock-badge {
            display: inline-block;
            padding: 0.5em 0.9em;
            margin: 0.2em;
            background-color: #162447;
            color: #e0e0e0;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .stock-badge:hover {
            background-color: #e43f5a;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-chart-line me-2"></i> Stock Visualizer
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card p-4">
                    <h4 class="mb-3">Search Stock</h4>
                    <form action="{{ url('/stocks') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="symbol" class="form-control" placeholder="e.g. AAPL" value="{{ request('symbol') }}" required>
                            <button class="btn btn-custom" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <h5 class="mb-3">Popular Stocks:</h5>
                    <div>
                        @foreach(['AAPL', 'GOOGL', 'AMZN', 'TSLA', 'MSFT', 'META', 'NFLX', 'NVDA'] as $stock)
                            <a href="{{ url('/stocks?symbol=' . $stock) }}" class="stock-badge">{{ $stock }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @if(isset($errorMessage))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ $errorMessage }}
                    </div>
                @endif

                @if(isset($labels) && !empty($labels))
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">
                            Showing data for: <span class="fw-bold" style="color: #e43f5a;">{{ request('symbol') }}</span>
                        </h4>
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
                @else
                    <div class="card p-5 text-center">
                        <i class="fas fa-chart-pie fa-3x mb-3 text-muted"></i>
                        <h5 class="text-muted">Enter a stock symbol to see the chart.</h5>
                        <p class="text-muted">Use the search bar on the left.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        @if(isset($labels) && !empty($labels))
        // Ambil data dari Blade dan simpan ke variabel JavaScript
        const labels = @json($labels);
        const openPrices = @json($openPrices);
        const closePrices = @json($closePrices);
        const highPrices = @json($highPrices);
        const lowPrices = @json($lowPrices);

        // --- PERUBAHAN UTAMA: Balik urutan semua array ---
        labels.reverse();
        openPrices.reverse();
        closePrices.reverse();
        highPrices.reverse();
        lowPrices.reverse();
        // ------------------------------------------------

        const ctx = document.getElementById('stockChart').getContext('2d');
        const stockChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Gunakan data yang sudah dibalik
                datasets: [
                    {
                        label: 'Open Price',
                        data: openPrices, // Gunakan data yang sudah dibalik
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Close Price',
                        data: closePrices, // Gunakan data yang sudah dibalik
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'High Price',
                        data: highPrices, // Gunakan data yang sudah dibalik
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Low Price',
                        data: lowPrices, // Gunakan data yang sudah dibalik
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: { color: '#e0e0e0' },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    },
                    y: {
                        beginAtZero: false,
                        ticks: {
                            color: '#e0e0e0',
                            callback: function(value) {
                                return '$' + value;
                            }
                        },
                        grid: { color: 'rgba(255, 255, 255, 0.1)' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#e0e0e0' }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
        @endif
    </script>
</body>
</html>
