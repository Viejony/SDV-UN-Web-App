function checkSession(){
    // Verify if some session is active and change the link and name of the login link
    var loggedin = "<?php echo $_SESSION['loggedin']; ?>";
    if (loggedin == "1") {
        alert("Sesion iniciada");  
        $("#user_login").text("<?php echo $_SESSION['username']; ?>");
        $("#user_login").attr("href", "map_view.php")
    } else {
        $("#user_login").text("Acceder");
    }
}
