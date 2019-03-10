<?php
// File with database info
include 'conection.php';

$form_pass = $_POST['password'];
$form_username = $_POST['username'];
$form_ip = $_POST['ip'];

$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

//////////////////////////////////////
$buscarUsuario = "SELECT * FROM $tbl_name
WHERE username = '$_POST[username]' ";

$result = $conexion->query($buscarUsuario);

$count = mysqli_num_rows($result);

if ($count == 1) {
    echo "<br />". "Nombre de Usuario ya asignado, ingresa otro." . "<br />";
    echo "<a href='index.html'>Por favor escoga otro Nombre</a>";
}
else{
    // The password_hash() function convert the password in a hash before send it to the database
    $passHash = password_hash($form_pass, PASSWORD_DEFAULT);

    /////////////////////////////////////////////////
    $query = "INSERT INTO users (username, password, ip) VALUES ('$form_username', '$passHash', '$form_ip')";

    if ($conexion->query($query) === TRUE) {
        echo "<br />" . "<h1>" . "Usuario creado" . "</h1>";
        echo "<h3>" . "Iniciar Sesion: " . "<a href='login.php'>Login</a>" . "</h3>"; 
    }

    else {
        echo "Error al crear el usuario." . $query . "<br>" . $conexion->error; 
    }
}
mysqli_close($conexion);
?>