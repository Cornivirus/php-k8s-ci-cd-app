<?php
$mysqli = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME')
);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT id, nombre FROM personas");

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . "<br>";
}
$mysqli->close();
?>
