<?php

require_once __DIR__ . '/../src/config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$commodityController = new App\Controllers\CommodityController($pdo);
$priceController = new App\Controllers\PriceController($pdo);

$stmt = $pdo->prepare("SELECT * FROM commodities WHERE id = :id");
$stmt->execute(['id' => $id]);
$commodity = $stmt->fetchObject(\App\Models\Commodity::class);

if (!$commodity) {
    header('Location: index.php');
    exit;
}

$prices = $priceController->getByCommodity($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($commodity->name) ?> - Farming-Zonator 22</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-4">
        <a href="index.php" class="text-indigo-600 hover:underline mb-4 block">&larr; Back to all commodities</a>
        <h1 class="text-3xl font-bold mb-4"><?= htmlspecialchars($commodity->name) ?></h1>

        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-2">Add Price</h2>
            <form action="add_price.php" method="post" class="bg-white p-4 rounded shadow-md">
                <input type="hidden" name="commodity_id" value="<?= $commodity->id ?>">
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (€ per 1000L)</label>
                    <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="season" class="block text-sm font-medium text-gray-700">Season</label>
                    <input type="number" name="season" id="season" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Add Price</button>
            </form>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-2">Prices</h2>
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
    </div>

</body>
</html>
