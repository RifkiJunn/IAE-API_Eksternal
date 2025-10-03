<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Data Visualization</title>
    <!-- Include Bootstrap for styling (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Stock Data Visualization</h2>

        <!-- Card for displaying the chart -->
        <div class="card">
            <div class="card-body">
                <canvas id="stockBarChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Sample Data or Error Message -->
        <div class="mt-4 alert alert-info">
            <strong>Sample Data:</strong> This is a demo bar chart using static stock data. If you see this, your view is loading!
        </div>
    </div>

    <!-- Example Static Data for Stock Chart -->
    <script>
        // Example block data (replace with dynamic data as needed)
        const labels = ['AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA'];
        const data = [150, 200, 180, 220, 170];

        // Create the bar chart using Chart.js
        const ctx = document.getElementById('stockBarChart').getContext('2d');
        const stockBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stock Price (USD)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Price (USD)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php /**PATH D:\Sms 5\IAE\mantau_stock_market\resources\views/stocks/index.blade.php ENDPATH**/ ?>