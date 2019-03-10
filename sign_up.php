<?
php session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
}
else {
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = "";
    $_SESSION['sdv_ip'] = "";
}
?>
<!DOCTYPE html>
<title>SDV UN</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="ui/w3.css">
<link rel="stylesheet" href="ui/w3-theme-black.css">
<link rel="stylesheet" href="ui/Roboto.css">
<link rel="stylesheet" href="ui/font-awesome.min.css">
<link rel="stylesheet" href="ui/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="ui/custom.css">
<link href="favicon.png" rel="icon" type="image/x-icon" />

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

<body>

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)"
                onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="index.php" class="w3-bar-item w3-button w3-theme-white">SDV UN</a>
            <a href="login.php" class="w3-bar-item w3-button w3-theme-white" id="user_login">Acceder</a>
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
        <!-- Here is the Close Session link, that is only visible when there is a session opened -->
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
    <div class="w3-main" style="margin-left:250px">

        <div class="w3-row w3-padding-64">

            <div class="container">

                <h3 class="w3-text-teal">Crea un usuario</h3>

                <form class="form-horizontal" action="create_user.php" method="post">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="20" placeholder="Ingresa tu usuario"
                                name="username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">IP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" id="email" placeholder="Dirección IP"
                                name="ip" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Contraseña:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" maxlength="30" id="pwd" placeholder="Ingresa una Contraseña"
                                name="password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success btn-block">Crear</button>
                        </div>
                    </div>

                </form>

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

</body>

</html>