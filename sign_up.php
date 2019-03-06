<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registro de usuario</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/libs/jquery.min.js"></script>
    <script src="/ui/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">

        <h2>Crea un usuario</h2>
        <form class="form-horizontal" action="create_user.php" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Usuario</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" maxlength="20" placeholder="Ingresa tu usuario" name="username" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="email">IP</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" maxlength="50" id="email" placeholder="Dirección IP" name="ip">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Contraseña:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" maxlength="30" id="pwd" placeholder="Ingresa una Contraseña" name="password" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label><input type="checkbox" name="remember"> Recordarme</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Crear</button>
                    <button type="button" class="btn btn-default" onclick="location.href='login.html'">Login</button>
                </div>
            </div>

        </form>


    </div>

</body>

</html>
