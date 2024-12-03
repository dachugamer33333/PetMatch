<?php

use PSpell\Config;

require '../Controller/config.php';
session_start();
$config=new Usuario;

if(!isset($_SESSION['id']))
{
    echo "<script>alert('Inicia secion para ingresar'); window.location.href = 'login.php' ;</script>";
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $id_usuario=$_SESSION['id'];
    $descripcion=isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $edad=isset($_POST['edad']) ? $_POST['edad'] : '';
    $especie=isset($_POST['especie']) ? $_POST['especie'] : '';
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
    
    
    $config->publicar($conn,$foto,$descripcion,$edad,$especie);
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar</title>
    <style>
        /* Variables para colores */
        :root {
            --primary-color: #333; /* Gris oscuro */
            --secondary-color: #f9f9f9; /* Fondo claro */
            --highlight-color: #ff6f61; /* Naranja */
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        /* Estilo general */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px var(--shadow-color);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: var(--primary-color);
            margin-bottom: 20px;
            border-bottom: 2px solid var(--highlight-color);
            display: inline-block;
            padding-bottom: 5px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--primary-color);
        }

        textarea,
        input[type="number"],
        select,
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid var(--shadow-color);
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input[type="submit"] {
            background-color: var(--highlight-color);
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #e55b54;
        }

        textarea:focus, 
        input:focus, 
        select:focus {
            outline: none;
            border-color: var(--highlight-color);
            box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
        }

        select {
            appearance: none;
            background-color: white;
        }

        .form-title {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .form-title img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            form {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            form {
                padding: 15px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div class="form-title">
            <a href="dashboard.php"><img src="https://img.icons8.com/color/48/pet.png" alt="Pet Icon"></a>
            <h2>Publicar</h2>
        </div>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" placeholder="Escribe una descripción sobre la mascota..." required></textarea>

        <label for="edad">Edad de la mascota (en años):</label>
        <input type="number" name="edad" placeholder="0" required max="70" min="0">

        <label for="especie">Clase de animal:</label>
        <select name="especie" required>
            <option value="canino">Canino</option>
            <option value="felino">Felino</option>
            <option value="roedor">Roedor</option>
            <option value="reptil">Reptil</option>
            <option value="ave">Ave</option>
        </select>

        <label for="foto">Imagen:</label>
        <input type="file" name="foto" accept="image/*">

        <input type="submit" value="Publicar">
    </form>
</body>
</html>
