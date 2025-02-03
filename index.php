<?php
require_once 'db.php';

// Get distinct machine codes
$stmt = $pdo->query("SELECT DISTINCT machine_code FROM machine_status ORDER BY machine_code");
$machines = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Downtime Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Machine Downtime</h1>

        <form id="analysisForm" class="space-y-4">
            <div class="space-y-2">
                <label class="block font-medium">Time Period:</label>
                <select id="timePeriod" name="timePeriod" class="w-full p-2 border rounded" onchange="toggleCustomDates()">
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="this_week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="custom">Custom Date Range</option>
                </select>
            </div>

            <div id="customDates" class="space-y-2 hidden">
                <div>
                    <label class="block font-medium">From:</label>
                    <input type="date" id="dateFrom" name="dateFrom" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block font-medium">To:</label>
                    <input type="date" id="dateTo" name="dateTo" class="w-full p-2 border rounded">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block font-medium">Select Machines:</label>
                <div class="space-y-1">
                    <label class="flex items-center">
                        <input type="checkbox" id="selectAllMachines" class="mr-2">
                        <strong>Select All</strong>
                    </label>
                    <?php foreach ($machines as $machine): ?>
                        <label class="flex items-center">
                            <input type="checkbox" name="machines[]" value="<?= htmlspecialchars($machine['machine_code']) ?>"
                                class="machine-checkbox mr-2">
                            <?= htmlspecialchars($machine['machine_code']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                Generate Chart
            </button>
        </form>

        <script>
            function toggleCustomDates() {
                const timePeriod = document.getElementById('timePeriod').value;
                const customDates = document.getElementById('customDates');
                customDates.style.display = timePeriod === 'custom' ? 'block' : 'none';
            }

            document.getElementById('selectAllMachines').addEventListener('change', function() {
                const machineCheckboxes = document.querySelectorAll('.machine-checkbox');
                machineCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            document.getElementById('analysisForm').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                const data = {
                    timePeriod: formData.get('timePeriod'),
                    dateFrom: formData.get('dateFrom'),
                    dateTo: formData.get('dateTo'),
                    machines: [...formData.getAll('machines[]')]
                };

                try {
                    const response = await fetch('api.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const chartData = await response.json();
                    window.location.href = `chart.php?data=${encodeURIComponent(JSON.stringify(chartData))}`;
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the data.');
                }
            });
        </script>

</body>

</html>