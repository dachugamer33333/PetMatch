<?php
session_start();
use PSpell\Config;

require "../Controller/config.php";
$config= new Usuario;

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['aceptar']))
    {
        $id_publicacion=$_POST['aceptar'];
        $fecha=date('Y-m-d');

        $sql=$conn->prepare("UPDATE publicacion SET estado = 'publicado',fecha_aceptacion = ? WHERE id = ?");
        $sql->bind_param('si',$fecha,$id_publicacion);

        if($sql->execute())
        {
                echo "<script>alert('se a aceptado correctamente')</script>";
        }
    }
    if(isset($_POST['rechazar']))
    {
        $id_publicacion=$_POST['rechazar'];
        
        $sql=$conn->prepare("UPDATE publicacion SET estado = 'rechazada' WHERE id = ?");
        $sql->bind_param('i',$id_publicacion);

        if($sql->execute())
        {
                echo "<script>alert('se a rechazado correctamente')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="renviar.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table-container {
            width: 80%;
            max-width: 800px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e0e0e0;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        /* Contenedor con scroll */
        .table-container {
            max-height: 300px;
            overflow-y: auto;
        }
        .aceptar{
            background-color: green;
            padding: 5px;
            border-radius: 20px;
            cursor: pointer; /* Cambiar cursor al pasar el mouse */
            border: none;
        }

        .rechazar{
            background-color: red;
            padding: 5px;
            border-radius: 20px;
            cursor: pointer; /* Cambiar cursor al pasar el mouse */
            border: none;
        }

        /* Scroll personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #bbb;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-track {
            background-color: #f0f0f0;
        }
        
    </style>
</head>
<body>
    <h1>Dashboard Admin</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descripción</th>
                    <th>Fecha de Publicación</th>
                    <th>Usuario</th>
                    <th>Edad</th>
                    <th>Clase de Animal</th>
                    <th>Estado</th>
                    <th>Aceptar</th>
                    <th>Rechazar</th>
                </tr>
            </thead>
            <tbody>
                <?php $config->pba($conn); ?>
            </tbody>
        </table>
        
    </div>
    Admin name:<?php echo $_SESSION['usuario']; ?>
    <button class="aceptar"><a href="dashboard.php">Regresar</a></button>
   
</body>
</html>
