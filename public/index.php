<?php

require_once __DIR__ . '/../src/config.php';

$commodityController = new App\Controllers\CommodityController($pdo);
$priceController = new App\Controllers\PriceController($pdo);

$commodities = $commodityController->getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farming-Zonator 22</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Farming-Zonator 22</h1>

        <div class="mb-4">
            <a href="statistics.php" class="text-indigo-600 hover:underline">View Statistics</a>
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-2">Add Commodity</h2>
            <form action="add_commodity.php" method="post" class="bg-white p-4 rounded shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Commodity Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Add Commodity</button>
            </form>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-2">Commodities</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($commodities as $commodity): ?>
                    <div class="bg-white p-4 rounded shadow-md">
                        <h3 class="text-xl font-bold"><?= htmlspecialchars($commodity->name) ?></h3>
                        <a href="commodity.php?id=<?= $commodity->id ?>" class="text-indigo-600 hover:underline">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
</html>
