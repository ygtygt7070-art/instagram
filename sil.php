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
    $file = 'log_' . $users[$u]['code'] . '.json';
    file_put_contents($file, json_encode([]));
    echo json_encode(["success" => true]);
}
?>