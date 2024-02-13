<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario para modificar una habitación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar el formulario y actualizar la habitación en la base de datos
    $id_habitacion = $_POST['id_habitacion'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $precio_por_noche = $_POST['precio_por_noche'];
    $capacidad = $_POST['capacidad'];
    $camas = $_POST['camas'];
    $bano = $_POST['bano'];

    $sql = "UPDATE habitaciones SET TIPO='$tipo', DESCRIPCION='$descripcion', PRECIOPORNOCHE='$precio_por_noche', CAPACIDAD='$capacidad', CAMAS='$camas', BANO='$bano' WHERE ID_HABITACION='$id_habitacion'";

    if ($conn->query($sql) === TRUE) {
        echo "Habitación modificada exitosamente.";
    } else {
        echo "Error al modificar la habitación: " . $conn->error;
    }
}

// Obtener habitaciones existentes
$sql_habitaciones = "SELECT * FROM habitaciones";
$result_habitaciones = $conn->query($sql_habitaciones);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Habitación</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <h2>Modificar Habitación</h2>
    <div class="container">
        <form method="post">
            <label for="id_habitacion">ID de Habitación:</label><br>
            <input type="text" id="id_habitacion" name="id_habitacion" required><br><br>
            <label for="tipo">Tipo:</label><br>
            <input type="text" id="tipo" name="tipo"><br><br>
            <label for="descripcion">Descripción:</label><br>
            <input type="text" id="descripcion" name="descripcion"><br><br>
            <label for="precio_por_noche">Precio por Noche:</label><br>
            <input type="text" id="precio_por_noche" name="precio_por_noche"><br><br>
            <label for="capacidad">Capacidad:</label><br>
            <input type="text" id="capacidad" name="capacidad"><br><br>
            <label for="camas">Camas:</label><br>
            <input type="text" id="camas" name="camas"><br><br>
            <label for="bano">Baño:</label><br>
            <input type="text" id="bano" name="bano"><br><br>
            <input type="submit" value="Modificar Habitación">
        </form>

        <!-- Tabla para mostrar las habitaciones existentes -->
        <h2>Habitaciones Existentes</h2>
        <table>
            <tr>
                <th>ID de Habitación</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Precio por Noche</th>
                <th>Capacidad</th>
                <th>Camas</th>
                <th>Baño</th>
                <th>Acción</th>
            </tr>
            <?php
            if ($result_habitaciones->num_rows > 0) {
                while ($row = $result_habitaciones->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_HABITACION"] . "</td>";
                    echo "<td>" . $row["TIPO"] . "</td>";
                    echo "<td>" . $row["DESCRIPCION"] . "</td>";
                    echo "<td>" . $row["PRECIOPORNOCHE"] . "</td>";
                    echo "<td>" . $row["CAPACIDAD"] . "</td>";
                    echo "<td>" . $row["CAMAS"] . "</td>";
                    echo "<td>" . $row["BANO"] . "</td>";
                    echo "<td><button class='select-btn' data-id='" . $row["ID_HABITACION"] . "' data-tipo='" . $row["TIPO"] . "' data-descripcion='" . $row["DESCRIPCION"] . "' data-precio='" . $row["PRECIOPORNOCHE"] . "' data-capacidad='" . $row["CAPACIDAD"] . "' data-camas='" . $row["CAMAS"] . "' data-bano='" . $row["BANO"] . "'>Seleccionar</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay habitaciones.</td></tr>";
            }
            ?>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectButtons = document.querySelectorAll('.select-btn');

            selectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('id_habitacion').value = this.getAttribute('data-id');
                    document.getElementById('tipo').value = this.getAttribute('data-tipo');
                    document.getElementById('descripcion').value = this.getAttribute('data-descripcion');
                    document.getElementById('precio_por_noche').value = this.getAttribute('data-precio');
                    document.getElementById('capacidad').value = this.getAttribute('data-capacidad');
                    document.getElementById('camas').value = this.getAttribute('data-camas');
                    document.getElementById('bano').value = this.getAttribute('data-bano');
                });
            });
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
