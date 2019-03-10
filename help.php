<?php 
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
}
else {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = "";
    $_SESSION['sdv_ip'] = "";
}

?>
<!DOCTYPE html>
<html lang="en">
<title>SDV UN</title>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="ui/w3.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">
<link rel="stylesheet" href="ui/font-awesome.min.css">
<link rel="stylesheet" href="ui/collapsible.css">
<link href="favicon.ico" rel="icon" type="image/x-icon" />

<script src="libs/jquery.min.js"></script>

<style>
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Roboto", sans-serif;
    }

    .w3-sidebar {
        z-index: 3;
        width: 250px;
        top: 43px;
        bottom: 0;
        height: inherit;
    }

</style>

<body onload="init()">

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">SDV UN</a>
            <a href="login.php" class="w3-bar-item w3-button w3-theme-white" id="user_login"></a>
            <a href="help.php" class="w3-bar-item w3-button w3-theme-l1">Ayuda</a>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
            <i class="fa fa-remove"></i>
        </a>
        <h4 class="w3-bar-item"><b>Menu</b></h4>
        <a class="w3-bar-item w3-button w3-hover-black" href="login.php" id="user_login_sidebar">Acceder</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="help.php" id="help_sidebar">Ayuda</a>
        <!-- Here is the Close Session link, that is only visible when there is a session opened -->
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
    <div class="w3-main" style="margin-left:250px">

        <div class="w3-row w3-padding-64">
            
            <div class="w3-container w3-twothird">
                
                <h3 class="w3-text-teal">Ayuda</h3>

                <button class="collapsible">El software no se conecta con el SDV</button>
                <div class="content">
                    <p>Para que el software se conecte al SDV es necesario que esten corriendo en el SDV el siguiente software:</p>
                    <li>agv_nav: archivo .launch que ejecuta todos los nodos de navegación</li>
                    <li>rosbridge_websocket: nodo que permite la conección con aplicaciones remotas.</li>
                    <li>robot_pose_publisher: nodo que permite obtener información del SDV.</li>
                    <p>En este <a href="https://gitlab.com/jfpinedap/Mobile-Robotics-User-Manual">enlace</a> puedes encontrar un tutorial detallado de la puesta en marcha del SDV. El software debe estar en un servidor conectado a la red del LabFabEx.</p>
                </div>
                
                <button class="collapsible">El software no funciona correctamente</button>
                <div class="content">
                    <p>Es necesario que la aplicación se encuentre montada en un servidor Apache con PHP y una bases de datos mySQL. Para pruebas, es recomendable usar la aplicación XAMMP, la cual permite ejecutar el software necesario.</p>

                </div>
                
                <button class="collapsible">No se puede agregar un usuario</button>
                <div class="content">
                    <p>Es necesario montar una base de datos para la gestón de los usuarios. XAMPP tiene la herramienta phpMyAdmin, la cual permite construir y gestionar bases de datos. La base de datos debe tener la siguiente estructura:</p>
                    <ul>
                        <li>Nombre: sdv_un</li>
                        <li>Tabla: users</li>
                        <li>Columnas:
                            <ul>
                                <li>id: int, llave primaria, autoincrementable</li>
                                <li>username: varchar</li>
                                <li>password: varchar</li>
                                <li>ip: varchar</li>
                                <li>status: varchar</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                
                <button class="collapsible">La posición del SDV no es la real</button>
                <div class="content">
                    <p>Puede que el SDV se haya inicializado en una ubicación incorrecta. Es necesario reiniciar los nodos de navegación (agv_nav.launch) desde el home del SDV.</p>
                </div>
                
                <button class="collapsible">El mapa no se visualiza</button>
                <div class="content">
                    <p>Si las condiciones de conección se cumplen, pero el mapa no carga, puede que el topic en el que se gestiona el servicio del mapa tenga un nombre distinto. El topic que usa esta aplicación es /map.</p>
                </div>
                
                <button class="collapsible">El ícono del SDV no se observa</button>
                <div class="content">
                    <p>El topic necesario para la obtensión de la pose es /move_base. Si el nombre es distinto en el SDV, puede que esa sea la causa del problema.</p>
                </div>
                
                <button class="collapsible">El botón de parada no funciona</button>
                <div class="content">
                    <p>El topic para las paradas de emergencia es /move_base/cancel. Si en el SDV este topic tiene otro nombre, es necesario renombar el topic.</p>
                </div>


            </div>
        </div>


        <!-- Footer: this place contains the UNAL logo and name of the department-->
        <footer id="Footer">
            <div class="w3-container w3-theme-l2 w3-padding-16 ">
                <img src="unal_logo_white.png" width=150 />
            </div>

            <div class="w3-container w3-theme-l1 w3-padding-8">
                <p>Departamento de ingeniería mecánica y mecatrónica</p>
            </div>
        </footer>

        <!-- END MAIN -->
    </div>

    <script>
        // Get the Sidebar
        var mySidebar = document.getElementById("mySidebar");

        // Get the DIV with overlay effect
        var overlayBg = document.getElementById("myOverlay");

        // Toggle between showing and hiding the sidebar, and add overlay effect
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }

        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
            overlayBg.style.display = "none";
        }

        // Collapsible tags
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }

        /**
         * Setup all visualization elements when the page is loaded. 
         */
        function init() {

            // Verify if some session is active and change the link and name of the login link
            var loggedin = "<?php echo $_SESSION['loggedin']; ?>";
            if (loggedin == "1") {
                $("#user_login").text("<?php echo $_SESSION['username']; ?>");
                $("#user_login").attr("href", "map_view.php");
                $("#user_login_sidebar").text("<?php echo $_SESSION['username']; ?>");
                $("#user_login_sidebar").attr("href", "map_view.php");
                $("#help_sidebar").after('<a class="w3-bar-item w3-button w3-hover-black" href="logout.php">Cerrar Sesión</a>');
            } else {
                $("#user_login").text("Acceder");
            }

        }

    </script>

</body>

</html>
