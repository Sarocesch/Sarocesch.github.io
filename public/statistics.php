<?php

require_once __DIR__ . '/../src/config.php';

$commodityController = new App\Controllers\CommodityController($pdo);
$priceController = new App\Controllers\PriceController($pdo);

$commodities = $commodityController->getAll();

$selectedCommodity = $_GET['commodity_id'] ?? null;
$selectedMonth = $_GET['month'] ?? null;
$prices = [];
$chartData = [];

if ($selectedCommodity) {
    $prices = $priceController->getByCommodity($selectedCommodity);

    if ($selectedMonth) {
        $prices = array_filter($prices, fn($p) => $p->month == $selectedMonth);
    }

    $chartData['labels'] = array_map(fn($p) => "Season " . $p->season . " - " . $p->month, $prices);
    $chartData['datasets'][] = [
        'label' => 'Price',
        'data' => array_map(fn($p) => $p->price, $prices),
        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
        'borderColor' => 'rgba(75, 192, 192, 1)',
        'borderWidth' => 1
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics - Farming Simulator 22</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-4">
        <a href="index.php" class="text-indigo-600 hover:underline mb-4 block">&larr; Back to all commodities</a>
        <h1 class="text-3xl font-bold mb-4">Statistics</h1>

        <div class="mb-8">
            <form action="statistics.php" method="get" class="bg-white p-4 rounded shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="commodity_id" class="block text-sm font-medium text-gray-700">Filter by Commodity</label>
                        <select name="commodity_id" id="commodity_id" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                            <option value="">Select a commodity</option>
                            <?php foreach ($commodities as $commodity): ?>
                                <option value="<?= $commodity->id ?>" <?= $selectedCommodity == $commodity->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($commodity->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Filter by Month</label>
                        <input type="text" name="month" id="month" value="<?= htmlspecialchars($selectedMonth) ?>" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Filter</button>
                </div>
            </form>
        </div>

        <?php if ($selectedCommodity): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-2">Chart</h2>
                <div class="bg-white p-4 rounded shadow-md">
                    <canvas id="priceChart"></canvas>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-2">Price History</h2>
                <div class="bg-white p-4 rounded shadow-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Season</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($prices as $price): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($price->season) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">€ <?= number_format($price->price, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const ctx = document.getElementById('priceChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: <?= json_encode($chartData) ?>,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>

</body>
</html>
