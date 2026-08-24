<?php
echo "Iniciando...\n";

$host = 'altaria.proxy.rlwy.net';
$port = '27140';
$user = 'root';
$pass = 'werJwmWvbPjUgxSZCkbMaodmSxUvVTAT';
$db   = 'railway';

try {
    echo "Conectando...\n";
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado con exito!\n";
} catch (PDOException $e) {
    echo "ERROR DE CONEXION: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Leyendo archivo SQL...\n";
$sql = file_get_contents('restaurante.sql');
echo "Archivo leido, " . strlen($sql) . " bytes\n";

$queries = array_filter(array_map('trim', explode(";\n", $sql)));
echo "Se encontraron " . count($queries) . " consultas\n";

$count = 0;
foreach ($queries as $query) {
    if (trim($query) === '') continue;
    try {
        $pdo->exec($query);
        $count++;
    } catch (PDOException $e) {
        echo "Error en query: " . substr($query, 0, 80) . "...\n";
        echo $e->getMessage() . "\n\n";
    }
}

echo "Listo. $count consultas ejecutadas.\n";