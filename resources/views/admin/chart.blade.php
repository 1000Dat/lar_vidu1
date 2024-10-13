<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biểu Đồ Doanh Thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Biểu Đồ Doanh Thu</h1>

    <div style="width: 80%; margin: auto;">
        <h2>Doanh Thu Hàng Ngày</h2>
        <canvas id="dailyRevenueChart"></canvas>

        <h2>Doanh Thu Hàng Tháng</h2>
        <canvas id="monthlyRevenueChart"></canvas>

        <h2>Doanh Thu Theo Phương Thức Thanh Toán</h2>
        <canvas id="paymentMethodRevenueChart"></canvas>
    </div>

    <script>
        // Biểu Đồ Doanh Thu Hàng Ngày
        const labelsDaily = {!! json_encode($labelsDaily) !!};
        const revenuesDaily = {!! json_encode($revenuesDaily) !!};
        const dataDaily = {
            labels: labelsDaily,
            datasets: [{
                label: 'Doanh Thu Hàng Ngày',
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: revenuesDaily,
                fill: true,
                borderWidth: 1
            }]
        };
        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'line',
            data: dataDaily,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Doanh Thu Hàng Ngày' }
                }
            }
        });

        // Biểu Đồ Doanh Thu Hàng Tháng
        const labelsMonthly = {!! json_encode($labelsMonthly) !!};
        const revenuesMonthly = {!! json_encode($revenuesMonthly) !!};
        const dataMonthly = {
            labels: labelsMonthly,
            datasets: [{
                label: 'Doanh Thu Theo Tháng',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: revenuesMonthly,
            }]
        };
        new Chart(document.getElementById('monthlyRevenueChart'), {
            type: 'bar',
            data: dataMonthly,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Doanh Thu Theo Tháng' }
                }
            }
        });

        // Biểu Đồ Doanh Thu Theo Phương Thức Thanh Toán
        const labelsPaymentMethod = {!! json_encode($labelsPaymentMethod) !!};
        const revenuesPaymentMethod = {!! json_encode($revenuesPaymentMethod) !!};
        const dataPaymentMethod = {
            labels: labelsPaymentMethod,
            datasets: [{
                label: 'Doanh Thu Theo Phương Thức Thanh Toán',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                ],
                data: revenuesPaymentMethod,
            }]
        };
        new Chart(document.getElementById('paymentMethodRevenueChart'), {
            type: 'pie',
            data: dataPaymentMethod,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Doanh Thu Theo Phương Thức Thanh Toán' }
                }
            }
        });
    </script>
</body>
</html>
