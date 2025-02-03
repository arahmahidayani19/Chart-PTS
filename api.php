<?php
require_once 'db.php';

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

function getDateRange($timePeriod, $customFrom = null, $customTo = null)
{
    $now = new DateTime();
    $from = new DateTime();
    $to = new DateTime();

    switch ($timePeriod) {
        case 'today':
            $from->setTime(0, 0, 0);
            $to->setTime(23, 59, 59);
            break;
        case 'yesterday':
            $from->modify('-1 day')->setTime(0, 0, 0);
            $to->modify('-1 day')->setTime(23, 59, 59);
            break;
        case 'this_week':
            $from->modify('monday this week')->setTime(0, 0, 0);
            $to->modify('sunday this week')->setTime(23, 59, 59);
            break;
        case 'last_week':
            $from->modify('monday last week')->setTime(0, 0, 0);
            $to->modify('sunday last week')->setTime(23, 59, 59);
            break;
        case 'this_month':
            $from->modify('first day of this month')->setTime(0, 0, 0);
            $to->modify('last day of this month')->setTime(23, 59, 59);
            break;
        case 'last_month':
            $from->modify('first day of last month')->setTime(0, 0, 0);
            $to->modify('last day of last month')->setTime(23, 59, 59);
            break;
        case 'custom':
            $from = new DateTime($customFrom);
            $to = new DateTime($customTo);
            $to->setTime(23, 59, 59);

            // Validate date range (max 1 month)
            $diff = $from->diff($to);
            if ($diff->days > 31) {
                http_response_code(400);
                echo json_encode(['error' => 'Date range cannot exceed 1 month']);
                exit;
            }
            break;
    }

    return ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s')];
}

try {
    $dateRange = getDateRange(
        $data['timePeriod'],
        $data['dateFrom'] ?? null,
        $data['dateTo'] ?? null
    );

    $machines = $data['machines'];
    $machinesStr = str_repeat('?,', count($machines) - 1) . '?';

    // Simplified query for single table
    $query = "
        SELECT 
            machine_code,
            start_time,
            end_time,
            reason_code as reason
        FROM machine_status
        WHERE machine_code IN ($machinesStr)
        AND start_time <= ?
        AND end_time >= ?
        ORDER BY machine_code, start_time
    ";

    $stmt = $pdo->prepare($query);
    $params = array_merge($machines, [$dateRange['to'], $dateRange['from']]);
    $stmt->execute($params);
    $downtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format data for chart
    $response = [
        'chartDuration' => $dateRange,
        'machines' => []
    ];

    foreach ($machines as $machine) {
        $machineDowntimes = array_filter($downtimes, function ($d) use ($machine) {
            return $d['machine_code'] === $machine;
        });

        $formattedDowntimes = array_map(function ($d) {
            return [
                'start' => $d['start_time'],
                'end' => $d['end_time'],
                'reason' => $d['reason']
            ];
        }, array_values($machineDowntimes));

        $response['machines'][] = [
            'machine_id' => $machine,
            'downtimes' => $formattedDowntimes
        ];
    }

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while processing your request']);
}
