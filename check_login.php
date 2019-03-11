<?php
session_start();
?>

<?php

include 'conection.php';

$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
    die("La conexion falló: " . $conexion->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
 
///////////////////////////////////////////
$sql = "SELECT * FROM $tbl_name WHERE username = '$username'";

$result = $conexion->query($sql);


if ($result->num_rows > 0) {
    
}

$row = $result->fetch_array(MYSQLI_ASSOC);

///////////////////////////////////////////////////////
// Variable $hash hold the password hash on database
$hash = $row['password'];

if(password_verify($password, $hash)){
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (2*60*60);  // Duration in seconds: two hours

    // Loading IP from database to session
    $sdv_ip = $row['ip'];
    $_SESSION["sdv_ip"] = $sdv_ip;

    echo "Bienvenido! " . $_SESSION['username'];
    header('Location: map_view.php');

} 
else{
    echo "Usuario o Password incorrectos.";
    echo "<br><a href='login.php'>Volver a Intentarlo</a>";
}
 mysqli_close($conexion); 
?>