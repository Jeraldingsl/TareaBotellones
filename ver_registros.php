<?php
// Conecta a la base de datos (ajusta los detalles de conexión según tu configuración)
$conexion = new mysqli("localhost", "root", "", "botellones");

// Verifica la conexión a la base de datos
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Obtiene el historial de registros
$sql = "SELECT fecha, hora, cantidad, zona FROM registros";
$resultado = $conexion->query($sql);

$historial = [];
while ($fila = $resultado->fetch_assoc()) {
    $historial[] = $fila;
}

// Cierra la conexión a la base de datos
$conexion->close();

// Devuelve los registros en formato JSON
header("Content-Type: application/json");
echo json_encode($historial);
?>
