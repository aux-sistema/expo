<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

if (!isset($_SESSION['loggedin'])) {
    header('Location: /login');
    exit();
}

$allowed_roles = [
    '/admin' => 1, 
    '/vendedor' => 2, 
    '/cliente' => 3, 
];

$request = $_SERVER['REQUEST_URI'];
$base_path = '/expo-joya'; 
$request = str_replace($base_path, '', $request);
$request = explode('?', $request)[0];

if (array_key_exists($request, $allowed_roles)) {
    if ($_SESSION['id_cargo'] !== $allowed_roles[$request]) {
        header('Location: /expo-joya/404');
        exit();
    }
}
?>