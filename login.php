<?php
// Datos del servidor MySQL de InfinityFree
define('DB_HOST', 'sql.infinityfree.com'); // servidor
define('DB_USER', 'epiz_XXXXXXXX'); // usuario MySQL
define('DB_PASS', 'tu_contrasena_mysql'); // contraseña
define('DB_NAME', 'epiz_XXXXXXXX_farmacia_db'); // nombre BD
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
die('Error de conexion: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>

<?php
session_start();
require 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$correo = trim($_POST['correo']);
$pass = trim($_POST['contrasena']);
$stmt = $conn->prepare(
'SELECT id_usuario, nombre, contrasena, rol
FROM usuarios WHERE correo = ?');
$stmt->bind_param('s', $correo);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
if ($user && password_verify($pass, $user['contrasena'])) {
$_SESSION['id'] = $user['id_usuario'];
$_SESSION['nombre'] = $user['nombre'];
$_SESSION['rol'] = $user['rol'];
header('Location: index.php');
} else {
$error = 'Correo o contraseña incorrectos.';
}
}
?>
