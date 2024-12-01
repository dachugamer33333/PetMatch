<?php

session_start();
require "../Controller/config.php";

$config = new Chats();

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Inicia sesión'); window.location.href = 'login.php'</script>";
    exit;
}
$contador=1;
$id_emisor = $_SESSION['id'];
$id_receptor = isset($_POST['idm']) ? $_POST['idm'] : 2;

$fecha = date("Y-m-d H:i:s");
$id_rec = isset($_POST['reca']) ? $_POST['reca'] : (isset($_GET['reca']) ? $_GET['reca'] : 1);;
if($contador == 1)
{
    if($id_receptor != 2)
    {
        $id_rec=$id_receptor;
        echo $id_rec;
        $contador = 2;
       
    }
}


   
    var_dump($id_rec);
    
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : "";
    echo $id_rec;
    if (!is_numeric($id_rec)) {
        die("Error: El ID del receptor no es válido.");
    }

    // Validar si el receptor existe
    $sql = $conn->prepare("SELECT COUNT(*) AS count FROM usuarios WHERE id = ?");
    $sql->bind_param('i', $id_rec);
    $sql->execute();
    $result = $sql->get_result()->fetch_assoc();

    if ($result['count'] == 0) {
        die("Error: El receptor no existe en la tabla usuarios.");
    }
    
    // Insertar el mensaje si el receptor es válido
    if  (isset($_GET['env']) && $mensaje !=0 && !empty($mensaje) && is_numeric($id_rec)) {
    
        $sql3 = $conn->prepare("INSERT INTO mensaje (contenido, fecha, emisor_id, receptor_id) VALUES (?, ?, ?, ?)");
        $sql3->bind_param('ssii', $mensaje, $fecha, $id_emisor, $id_rec);
        $sql3->execute();
        $mensaje=0;
        
    }




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Petmatch Chat</title>
    <style>
        /* General */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa; /* Fondo blanco elegante */
            color: #333; /* Texto en gris oscuro */
            height: 100vh; /* Ocupa toda la pantalla */
        }

        header {
            position: absolute;
            top: 0;
            right: 20px;
            display: flex;
            align-items: center;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }

        header img {
            width: 30px;
            height: 30px;
            margin-left: 10px;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #555; /* Color sutil para encabezados */
        }

        /* Contenedor de la tabla */
        .table-container {
            width: 500px;
            height: 100%; /* Ocupa toda la altura de la pantalla */
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff; /* Fondo blanco */
            margin-right: 10px;
            border-radius: 8px; /* Bordes suaves */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            overflow-y: auto; /* Scroll vertical solo para esta sección */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1; /* Fondo claro para encabezados */
            color: #333; /* Texto oscuro */
            font-weight: bold;
        }

        tr:hover {
            background-color: #f9f9f9; /* Fondo sutil al pasar el cursor */
        }

        /* Contenedor del formulario */
        .form-container {
            flex: 1; /* Ocupa el espacio restante */
            padding: 20px;
            background-color: #fff; /* Fondo blanco */
            border-left: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }

        .messages-box {
            height: 300px; /* Altura fija con scroll */
            border: 1px solid #ddd;
            padding: 10px;
            overflow-y: auto; /* Scroll vertical */
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
            color: #333;
            font-size: 1em;
        }

        button {
            width: 150px;
            padding: 10px;
            background-color: #28a745; /* Verde elegante */
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
        }

        button:hover {
            background-color: #218838; /* Verde más oscuro al pasar el cursor */
        }

        /* Efecto para elementos */
        .rec {
            margin: 5px 0;
            padding: 10px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .emi {
            margin: 5px 0;
            padding: 10px;
            background-color: lightgreen;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <span>Petmatch Chat</span>
        <a href="dashboard.php"><img src="https://img.icons8.com/ios-filled/50/000000/dog.png" alt="Dog Icon"></a>
    </header>

    <!-- Contenedor de la tabla -->
    <div class="table-container">
        <h2>Mis Chats</h2>
        <table>
            <tr>
                <th>boton</th>

                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
            <?php
                // Llamar a la función para mostrar los chats
                $config->ver($conn, $id_emisor, $id_receptor);
            ?>
        </table>
    </div>

    <!-- Contenedor del formulario -->
    <div class="form-container">
        <h2>Mensajes Recibidos</h2>
        <div class="messages-box">
        <?php
        if (!empty($id_rec)) {
            $config->mensajesVer($conn, $id_rec, $id_emisor);
        } else {
            echo "<p>Selecciona un chat para ver los mensajes.</p>";
        }
        ?>
        </div>

        <form method="GET">
        <input type="hidden" name="reca" value="<?php echo htmlspecialchars($id_rec); ?>">
            <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí"></textarea>
            <button name="env" type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
