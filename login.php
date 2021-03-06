<?php session_start(); 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('Location: map_view.php');
}
else {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = "";
    $_SESSION['sdv_ip'] = "";
}

?>
<!DOCTYPE html>
<html lang="en">
<title>Acceder</title>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="ui/w3.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">
<link rel="stylesheet" href="ui/font-awesome.min.css">
<link rel="stylesheet" href="ui/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="ui/custom.css">
<link href="pictures/favicon.png" rel="icon" type="image/x-icon" />

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
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)"
                onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">SDV UN</a>
            <a href="login.php" class="w3-bar-item w3-button w3-theme-l1">Acceder</a>
            <a href="help.php" class="w3-bar-item w3-button w3-theme-white">Ayuda</a>
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
    <div class="w3-main" style="margin-left:250px" id="main_content">

        <div class="w3-row w3-padding-64">
            <div class="w3-container">
                <h3 class="w3-text-teal">Acceder</h3>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="loginBox">

                                    <form action="check_login.php" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-lg" name="username"
                                                placeholder="Usuario" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control input-lg" name="password"
                                                placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block">Login</button>
                                    </form>

                                    <hr>
                                    <p><a href="sign_up.php">Crear usuario</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Blank Space, used to adjust the view if screen is taller than the content-->
        <div id="blank_space" style="padding-top:0px;"></div>

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
                $("#docs_sidebar").after(
                    '<a class="w3-bar-item w3-button w3-hover-black" href="logout.php">Cerrar Sesión</a>');
            } else {
                $("#user_login").text("Acceder");
            }

            // Add padding to blanck space, before footer
            function addBlanckSpace() {
                $("#blank_space").css("padding-top", "0px");
                var intViewportHeight = parent.innerHeight;
                var mainContent = $("#main_content").height();
                if (intViewportHeight > mainContent) {
                    var height_css = intViewportHeight - mainContent;
                    height_css = height_css.toString();
                    $("#blank_space").css("padding-top", height_css + "px");
                } else {
                    $("#blank_space").css("padding-top", "0px");
                }
            }
            addBlanckSpace();
            $(window).on('resize', addBlanckSpace);

        }
    </script>

</body>

</html>