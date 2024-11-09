<?php
    require ("../Controller/config.php");
    $config= new Usuario();
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $usuario=isset($_POST['usuario']) ? $_POST['usuario'] : "";
        $pass=isset($_POST['pass']) ? $_POST['pass'] : "";

        $config->register($usuario,$pass,$conn);


    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registro de usuarios</h1>
    <form method="post">
    <label for="usuario">Usuario</label><input type="text" placeholder="name" required name="usuario"><br>
    <label for="pass">Password</label><input type="password" name="pass" placeholder="****"><br>
    <input type="submit" value="Registrar"><button><a href="login.php">login</a></button>
    </form>
</body>
</html>