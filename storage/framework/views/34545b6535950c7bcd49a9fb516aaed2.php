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
        <form action="<?php echo e(url('/stocks')); ?>" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="symbol" class="form-control" placeholder="Enter stock symbol (e.g. AAPL)" value="<?php echo e(request('symbol')); ?>" required>
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Popular Stock Symbols List -->
        <div class="mb-4">
            <h5>Popular Stock Symbols:</h5>
            <div class="list-group">
                <?php $__currentLoopData = ['AAPL', 'GOOGL', 'AMZN', 'TSLA', 'MSFT', 'FB', 'NFLX', 'NVDA']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('/stocks?symbol=' . $stock)); ?>" class="list-group-item list-group-item-action"><?php echo e($stock); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Display Error if No Stock Found -->
        <?php if(isset($errorMessage)): ?>
            <div class="alert alert-danger">
                <strong>Error:</strong> <?php echo e($errorMessage); ?>

            </div>
        <?php endif; ?>

        <!-- Display Chart if Data Exists -->
        <?php if(isset($labels) && !empty($labels)): ?>
        <div class="card">
            <div class="card-body">
                <canvas id="horizontalBarChart" width="400" height="200"></canvas>
            </div>
        </div>
        <?php else: ?>
            <div class="mt-4 alert alert-info">
                <strong>No Data:</strong> Enter a stock symbol above to see the chart.
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Check if the chart data is available
        <?php if(isset($labels) && !empty($labels)): ?>
        const ctx = document.getElementById('horizontalBarChart').getContext('2d');
        const horizontalBarChart = new Chart(ctx, {
            type: 'bar', // Horizontal bar chart
            data: {
                labels: <?php echo json_encode($labels, 15, 512) ?>,  // Dates as labels
                datasets: [
                    {
                        label: 'Open Prices',
                        data: <?php echo json_encode($openPrices, 15, 512) ?>,
                        backgroundColor: '#FF5733',
                        borderColor: '#FF5733',
                        borderWidth: 1
                    },
                    {
                        label: 'High Prices',
                        data: <?php echo json_encode($highPrices, 15, 512) ?>,
                        backgroundColor: '#33FF57',
                        borderColor: '#33FF57',
                        borderWidth: 1
                    },
                    {
                        label: 'Low Prices',
                        data: <?php echo json_encode($lowPrices, 15, 512) ?>,
                        backgroundColor: '#3357FF',
                        borderColor: '#3357FF',
                        borderWidth: 1
                    },
                    {
                        label: 'Close Prices',
                        data: <?php echo json_encode($closePrices, 15, 512) ?>,
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
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH D:\Sms 5\IAE\mantau_stock_market\resources\views/welcome.blade.php ENDPATH**/ ?>