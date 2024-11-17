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
    if(isset($_FILES['foto']))
    {
        $foto=$_FILES['foto']['tpm_name'];
        $foto=file_get_contents($foto);
    }
    else{
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
        /* Estilo general */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #444;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        textarea,
        input[type="number"],
        select,
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input[type="file"] {
            padding: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #43a047;
        }

        textarea:focus, 
        input:focus, 
        select:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
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

        .form-title h2 {
            margin: 0;
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
    <form method="post">
        <div class="form-title">
            <img src="https://img.icons8.com/color/48/pet.png" alt="Pet Icon">
            <h2>Publicar</h2>
        </div>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" placeholder="Escribe una descripción sobre la mascota..." required></textarea>

        <label for="edad">Edad (en años):</label>
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