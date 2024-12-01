<?php
    require ("../Controller/config.php");
    $config= new Usuario();
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $usuario=isset($_POST['usuario']) ? $_POST['usuario'] : "";
        $pass=isset($_POST['pass']) ? $_POST['pass'] : "";
        $foto;
    if (isset($_FILES['foto'])) {
        $error = $_FILES['foto']['error'];
        if ($error === UPLOAD_ERR_OK) {
            $foto = $_FILES['foto']['tmp_name'];
            $foto = file_get_contents($foto);
            // Aquí puedes proceder con la inserción en la base de datos.
            echo "Imagen subida correctamente.";
        } else {
            // Mostrar un mensaje de error detallado
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "El archivo excede el tamaño máximo permitido por el servidor.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "El archivo excede el tamaño máximo permitido por el formulario.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "El archivo se subió parcialmente.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "No se subió ningún archivo.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Falta una carpeta temporal en el servidor.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Error al escribir el archivo en el disco.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "La subida del archivo fue detenida por una extensión de PHP.";
                    break;
                default:
                    echo "Error desconocido al subir el archivo.";
                    break;
            }
        }
    } else {
        echo "No se seleccionó ninguna imagen.";
        $foto="";
    }

        $config->register($usuario,$pass,$conn,$foto);


    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetMatch - Registro</title>
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
        input[type="text"], input[type="password"], input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .custom-file-input {
            display: none;
        }
        .custom-file-label {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .custom-file-label:hover {
            background-color: #0056b3;
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
    <form method="post" enctype="multipart/form-data">
        <label for="usuario">Usuario:</label>
        <input type="text" placeholder="Nombre" required name="usuario"><br>
        
        <label for="pass">Password:</label>
        <input type="password" name="pass" placeholder="****" required><br>
        
        <label for="file">Foto de perfil:</label>
        <input type="file" id="file" name="foto" class="custom-file-input">
        <label for="file" class="custom-file-label">Seleccionar archivo</label><br>
        
        <input type="submit" value="Registrar">
    </form>
    <button><a href="login.php">Login</a></button>
</body>
</html>
