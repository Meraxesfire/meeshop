<?php
require_once __DIR__ . '/includes/conexion.php';

$conn->query('SELECT 1');
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['status' => 'ok']);
