<?php
// Conecta a la base de datos (ajusta los detalles de conexión según tu configuración)
$conexion = new mysqli("localhost", "root", "", "botellones");

// Verifica la conexión a la base de datos
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Maneja la inserción de registros
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $cantidad = $_POST["cantidad"];
    $zona = $_POST["zona"];

    // Prepara la consulta SQL (usa declaraciones preparadas para mayor seguridad)
    $sql = "INSERT INTO registros (fecha, hora, cantidad, zona) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Vincula los parámetros
    $stmt->bind_param("ssis", $fecha, $hora, $cantidad, $zona);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo "Registro exitoso";
    } else {
        echo "Error en el registro: " . $stmt->error;
    }

    // Cierra la declaración preparada
    $stmt->close();
}

// Obtiene el historial de registros
$sql = "SELECT fecha, hora, cantidad, zona FROM registros";
$resultado = $conexion->query($sql);

$historial = [];
while ($fila = $resultado->fetch_assoc()) {
    $historial[] = $fila;
}

echo json_encode($historial);

// Cierra la conexión a la base de datos
$conexion->close();
?>
