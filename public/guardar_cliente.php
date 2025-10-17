<?php
// public/guardar_cliente.php
session_start();
require_once __DIR__ . '/../db_config.php';

function redirect_with($params) {
    $base = 'index.php';
    $q = http_build_query($params);
    header('Location: ' . $base . ($q ? ('?' . $q) : ''));
    exit;
}

// CSRF
if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    redirect_with(['err' => 'Token inválido. Recarga la página e inténtalo de nuevo.']);
}

$nombre = trim($_POST['nombre'] ?? '');
$domicilio = trim($_POST['domicilio'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');
$comentarios = trim($_POST['comentarios'] ?? '');

// Validaciones del lado del servidor
if ($nombre === '' || $domicilio === '' || $telefono === '' || $email === '') {
    redirect_with(['err' => 'Todos los campos excepto comentarios son obligatorios.']);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with(['err' => 'El correo electrónico no es válido.']);
}
if (!preg_match('/^[+\d][\d\s\-()]{6,}$/', $telefono)) {
    redirect_with(['err' => 'El teléfono no es válido.']);
}

try {
    $pdo = get_pdo();
    $stmt = $pdo->prepare('INSERT INTO Clientes (nombre, domicilio, telefono, email, comentarios) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nombre, $domicilio, $telefono, $email, $comentarios]);
    // Regenerar token para evitar reenvío
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    header('Location: gracias.php');
    exit;
} catch (Throwable $e) {
    redirect_with(['err' => 'Error al guardar: ' . $e->getMessage()]);
}
