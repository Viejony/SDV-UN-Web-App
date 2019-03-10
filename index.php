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
<link href="favicon.png" rel="icon" type="image/x-icon" />

<script src="libs/jquery.min.js"></script>
<script src="libs/check_session.js"></script>

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

    div.polaroid {
        width: 80%;
        background-color: white;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        margin-bottom: 25px;
    }

    div.container {
        text-align: center;
        padding: 10px 20px;
    }

</style>

<body onload="init()">

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="index.php" class="w3-bar-item w3-button w3-theme-l1">SDV UN</a>
            <a href="login.php" class="w3-bar-item w3-button w3-theme-white" id="user_login"></a>
            <a href="help.php" class="w3-bar-item w3-button w3-theme-white">Ayuda</a>
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
            
            <div class="w3-row">
                <div class="w3-twothird w3-container">
                    <h3 class="w3-text-teal">SDV UN</h3>
                </div>  
            </div>

            <div class="w3-row">
                <div class="w3-twothird w3-container">
                    <p>El SDV-UN es un vehículo auto manejado que hace parte del LabFabEx en la Universidad Nacional de Colombia. Usa el software ROS para la navegación junto a múltiples sensores que le permiten posicionarse en su entrono de trabajo con gran precisión. Con este aplicativo, puedes conectarte al software ROS de uno de los SDV y controlarlo de forma remota.</p>

                    <p>Si no sabes como iniciar el SDV, en este <a href="https://gitlab.com/jfpinedap/Mobile-Robotics-User-Manual" target="_blank">enlace</a> puedes encontrar un tutorial detallado de la puesta en marcha del SDV.</p>

                    <p>Debes acceder al servicio usando un usuario y una contraseña. Estas credenciales son las mismas que usan los SDV.</p>
                </div>
                <div class="w3-third w3-container">
                    <div class="polaroid">
                        <img src="pictures/sdv_a.webp" alt="SDV-UN" style="width:100%">
                    </div>
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
