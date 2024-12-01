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
    <title>PetMatch - Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .header h1 {
            font-size: 2rem;
            color: #000;
            margin: 0.5rem 0 0;
        }
        form {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 0.5rem 0;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"], button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 0.7rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 1rem;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover, button:hover {
            background: #218838;
        }
        button a {
            text-decoration: none;
            color: #fff;
        }
        button {
            background: #007bff;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="dog-logo.png" alt="Dog Logo">
        <h1>PetMatch</h1>
    </div>
    <form method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" placeholder="Nombre" required>
        
        <label for="pass">Password:</label>
        <input type="text" name="pass" placeholder="***" required>
        
        <input type="submit" value="Login">
       
    </form>
    <button><a href="register.php">Register</a></button>
</body>
</html>