<?php
    require ("../Controller/config.php");
    $config=new Usuario();

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $usuario=isset($_POST['usuario']) ? $_POST['usuario'] : "";
        $pass=isset($_POST['pass']) ? $_POST['pass'] : "";

        $config->login($usuario,$pass,$conn);

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
    <form method="POST">
        <label for="usuario">Usuario:</label><input type="text" name="usuario" placeholder="Nombre" required><br>
        <label for="pass">Password</label><input type="text" name="pass" placeholder="***" required><br>
        <input type="submit" value="login"><button><a href="register.php">Register</a></button>

    </form>    
</body>
</html>