<?php
require('fpdf182/fpdf.php'); // Ajusta la ruta según la ubicación de la biblioteca FPDF

// Conecta a la base de datos y realiza una consulta
$conexion = new mysqli("localhost", "root", "", "botellones");

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Llenado de Botellones', 0, 1, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Realiza una consulta a la base de datos para obtener los registros
$sql = "SELECT fecha, hora, cantidad, zona FROM registros";
$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    $fecha = $fila['fecha'];
    $hora = $fila['hora'];
    $cantidad = $fila['cantidad'];
    $zona = $fila['zona'];

    // Agrega los datos al PDF
    $pdf->Cell(0, 10, "Fecha: $fecha", 0, 1);
    $pdf->Cell(0, 10, "Hora: $hora", 0, 1);
    $pdf->Cell(0, 10, "Cantidad de Botellas: $cantidad", 0, 1);
    $pdf->Cell(0, 10, "Zona: $zona", 0, 1);
    $pdf->Ln(10); // Espacio entre registros
}

// Genera el PDF
ob_start();
$pdf->Output();
$pdfData = ob_get_clean();

// Crear una página HTML con JavaScript para abrir el PDF en una nueva ventana
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Llenado de Botellones</title>
</head>
<body>
<script type="text/javascript">
    var pdfData = 'data:application/pdf;base64,' + btoa("$pdfData");
    var win = window.open('', '_blank');
    win.document.write('<iframe width="100%" height="100%" src="' + pdfData + '" frameborder="0"></iframe>');
</script>
</body>
</html>
HTML;

// Cierra la conexión a la base de datos
$conexion->close();
?>
