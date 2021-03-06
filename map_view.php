<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  // Continue in the page if the session is active
}

else {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = "";
    $_SESSION['sdv_ip'] = "";
    echo "Inicia Sesion para acceder a este contenido.<br>";
    echo "<br><a href='login.html'>Login</a>";
    echo "<br><br><a href='index.html'>Registrarme</a>";
    header('Location: login.php');
    exit;
}

$now = time();

if($now > $_SESSION['expire']) {
    session_destroy();
    header('Location: login.html');
    echo "Tu sesion a expirado, <a href='login.html'>Inicia Sesion</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<title>SDV UN: Navegación</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="libs/easeljs.js"></script>
<script src="libs/eventemitter2.min.js"></script>
<script src="libs/roslib.js"></script>
<script src="libs/nav2d.js"></script>
<script src="libs/ros2d.js"></script>
<script src="libs/keyboardteleop.js"></script>
<script src="libs/jquery.min.js"></script>
<script src="libs/jquery.animate-colors-min.js"></script>
<script src="libs/animation.js"></script>
<script src="libs/map_view.js"></script>

<link rel="stylesheet" href="ui/icon.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">
<link rel="stylesheet" href="ui/font-awesome.min.css">
<link rel="stylesheet" href="ui/w3.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">

<link href="pictures/favicon.png" rel="icon" type="image/x-icon" />


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

<!-- Body -->

<body onload="init()">

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large" href="javascript:void(0)"
                onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a id="emergency_stop_button" class="w3-bar-item w3-button w3-right">Parar</a>
            <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">SDV UN</a>
            <a href="map_view.php" class="w3-bar-item w3-button w3-theme-l1" id="user_login"></a>
            <a href="help.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Ayuda</a>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large"
            title="Close Menu">
            <i class="fa fa-remove"></i>
        </a>
        <h4 class="w3-bar-item"><b>Menu</b></h4>
        <a class="w3-bar-item w3-button w3-hover-black" href="login.php" id="user_login_sidebar">Acceder</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="help.php" id="help_sidebar">Ayuda</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="docs.php" id="docs_sidebar">Documentación</a>
        <!-- Here is the Close Session link, that is only visible when there is a session opened -->
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
    <div class="w3-main" style="margin-left:250px">

        <!-- Page title-->
        <div class="w3-container" style="margin-top:50px">
            <div class="w3-twothird w3-container">
                <h3 class="w3-text-teal">Navegación por el Laboratorio</h3>
            </div>
        </div>

        <!-- Row of elements: This divdistributes the elements in 2/3 and 1/3 spaces-->
        <div class="w3-row">

            <!-- Map, log and bottom view buttons-->
            <div class="w3-twothird w3-container " style="margin-bottom:16px">
                <div id="card-map" class="w3-card-4">
                    <div id="map"></div>
                </div>
                <!-- Feedback zone of conection events-->
                <div id="feedback_div">
                    <p id=feedback>Esperando conexión</p>
                </div>
                <!-- Zoom and shift buttons of the map-->
                <div class="w3-bar">
                    <button class="w3-bar-item w3-button w3-teal" id="zoom_in" onclick="zoomInMap()">
                        <i class="material-icons">zoom_in</i>
                    </button>
                    <button class="w3-bar-item w3-button w3-teal" id="zoom_out" onclick="zoomOutMap()">
                        <i class="material-icons">zoom_out</i>
                    </button>
                    <button class="w3-bar-item w3-button w3-teal" id="shift_up" onclick="shiftUpMap()">
                        <i class="material-icons">arrow_upward</i>
                    </button>
                    <button class="w3-bar-item w3-button w3-teal" id="shift_down" onclick="shiftDownMap()">
                        <i class="material-icons">arrow_downward</i>
                    </button>
                    <button class="w3-bar-item w3-button w3-teal" id="shift_left" onclick="shiftLeftMap()">
                        <i class="material-icons">arrow_back</i>
                    </button>
                    <button class="w3-bar-item w3-button w3-teal" id="shift_right" onclick="shiftRightMap()">
                        <i class="material-icons">arrow_forward</i>
                    </button>
                </div>

                <!-- TwoThird Container end -->
            </div>

            <!-- Information and comand buttons-->
            <div class="w3-third w3-container">

                <!-- Actual Location Panel-->
                <fieldset id="pred_location" style="margin-bottom:16px">
                    <legend>Posición actual del SDV</legend>
                    <div id="actual_loc"></div>
                </fieldset>

                <!-- Predefined Location Panel-->
                <fieldset id="pred_location" style="margin-bottom:16px">
                    <legend>Enviar SDV a posición predefinida</legend>
                    <div class="controlgroup">
                        <select id="location_select">
                            <option value=1>Celda Industrial</option>
                            <option value=2>Celda de Prototipado</option>
                            <option value=3>Celda Experimental</option>
                            <option value=4>Home</option>
                            <option value=5>Centro de estudio</option>
                        </select>
                        <button id="send_selected_location" type="button">Enviar</button>
                    </div>
                </fieldset>

                <!-- User Defined Location Panel -->
                <fieldset id="user_location" style="margin-bottom:16px">
                    <legend>SDV a posición distinta</legend>
                    <table>
                        <tr>
                            <td>X: </td>
                            <td>
                                <input id="x_position" type="text" size="5"><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Y: </td>
                            <td>
                                <input id="y_position" type="text" size="5"><br>
                            </td>
                        </tr>
                        <tr>
                            <td>W: </td>
                            <td>
                                <input id="w_orientation" type="text" size="5"><br>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button id="send_user_defined_location" type="button">Enviar</button>
                            </td>
                        </tr>
                    </table>

                </fieldset>

                <!-- Manual Operation Panel -->
                <fieldset id="manual_operation" style="margin-bottom:16px">
                    <legend>Operación manual por teclado</legend>
                    <table>
                        <tr>
                            <td></td>
                            <td><button id="key_up"><i class="material-icons">arrow_upward</i></button></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><button id="key_left"><i class="material-icons">arrow_back</i></td>
                            <td><button id="key_down"><i class="material-icons">arrow_downward</i></td>
                            <td><button id="key_right"><i class="material-icons">arrow_forward</i></td>
                        </tr>
                    </table>
                    <input type="checkbox" id="teleop_enable" value="true">Activar teleoperación<br>
                </fieldset>

                <!-- Third Container End-->
            </div>

            <!-- Row End-->
        </div>

        <!-- Footer: this place contains the UNAL logo and name of the department-->
        <footer id="Footer">
            <div class="w3-container w3-theme-l2 w3-padding-16 ">
                <img src="pictures/unal_logo_white.png" width=150 />
            </div>

            <div class="w3-container w3-theme-l1 w3-padding-8">
                <p>Departamento de ingeniería mecánica y mecatrónica</p>
            </div>
        </footer>

        <!-- END MAIN -->
    </div>

    <!--/////////////////////////////////////////////////////////////////////////-->
    <!-- JAVASCRIPT Code-->
    <script>
        ////////////////////////////////////////////////////////////////////////////////
        // GUI and animations

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

        ////////////////////////////////////////////////////////////////////////////////
        // Global Objects requiered for map_view.js

        var viewer;
        var zoomSteps = 0;
        var verticalShiftSteps = 0;
        var horizontalShiftSteps = 0;
        var conectionStatus = 0; // 0: no intentado, 1: exitosa, 2: erronea
        var sdv_ip = "";

        // Loading sdv_ip from PHP session variable
        sdv_ip = "<?php echo $_SESSION['sdv_ip']; ?>";

        /*
          This function contains all the ROS functions used in this page. These functions 
          only works if the page has been loaded.
        */
        function init() {

            // Verify if some session is active and change the link and name of the login link
            var loggedin = "<?php echo $_SESSION['loggedin']; ?>";
            if (loggedin == "1") {
                $("#user_login").text("<?php echo $_SESSION['username']; ?>");
                $("#user_login").attr("href", "map_view.php");
                $("#user_login_sidebar").text("<?php echo $_SESSION['username']; ?>");
                $("#user_login_sidebar").attr("href", "map_view.php");
                $("#docs_sidebar").after(
                    '<a class="w3-bar-item w3-button w3-hover-black" href="logout.php">Cerrar Sesión</a>');
            } else {
                $("#user_login").text("Acceder");
            }

            // Executes setMapView function from map_view.js
            setMapView();
            
        }// Init End
    </script>

</body>

</html>