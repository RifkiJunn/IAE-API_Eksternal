<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Data Visualization</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Stock Data Visualization</h2>

        <!-- Search Bar Form -->
        <form action="{{ url('/stocks') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="symbol" class="form-control" placeholder="Enter stock symbol (e.g. AAPL)" value="{{ request('symbol') }}" required>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Popular Stock Symbols List -->
        <div class="mb-4">
            <h5>Popular Stock Symbols:</h5>
            <div class="list-group">
                @foreach(['AAPL', 'GOOGL', 'AMZN', 'TSLA', 'MSFT', 'FB', 'NFLX', 'NVDA'] as $stock)
                    <a href="{{ url('/stocks?symbol=' . $stock) }}" class="list-group-item list-group-item-action">{{ $stock }}</a>
                @endforeach
            </div>
        </div>

        <!-- Display Error if No Stock Found -->
        @if(isset($errorMessage))
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ $errorMessage }}
            </div>
        @endif

        <!-- Display Chart if Data Exists -->
        @if(isset($labels) && !empty($labels))
        <div class="card">
            <div class="card-body">
                <canvas id="horizontalBarChart" width="400" height="200"></canvas>
            </div>
        </div>
        @else
            <div class="mt-4 alert alert-info">
                <strong>No Data:</strong> Enter a stock symbol above to see the chart.
            </div>
        @endif
    </div>

    <script>
        // Check if the chart data is available
        @if(isset($labels) && !empty($labels))
        const ctx = document.getElementById('horizontalBarChart').getContext('2d');
        const horizontalBarChart = new Chart(ctx, {
            type: 'bar', // Horizontal bar chart
            data: {
                labels: @json($labels),  // Dates as labels
                datasets: [
                    {
                        label: 'Open Prices',
                        data: @json($openPrices),
                        backgroundColor: '#FF5733',
                        borderColor: '#FF5733',
                        borderWidth: 1
                    },
                    {
                        label: 'High Prices',
                        data: @json($highPrices),
                        backgroundColor: '#33FF57',
                        borderColor: '#33FF57',
                        borderWidth: 1
                    },
                    {
                        label: 'Low Prices',
                        data: @json($lowPrices),
                        backgroundColor: '#3357FF',
                        borderColor: '#3357FF',
                        borderWidth: 1
                    },
                    {
                        label: 'Close Prices',
                        data: @json($closePrices),
                        backgroundColor: '#FF33A6',
                        borderColor: '#FF33A6',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 300  // Adjust as needed
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true,
                        mode: 'nearest',
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
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
