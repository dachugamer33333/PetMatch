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
        /* Variables para colores */
        :root {
            --primary-color: #333; /* Gris oscuro */
            --secondary-color: #f9f9f9; /* Fondo claro */
            --highlight-color: #ff6f61; /* Naranja */
            --light-border: #ddd; /* Bordes suaves */
            --box-shadow: rgba(0, 0, 0, 0.1);
            --success-color: #28a745; /* Verde elegante */
        }

        /* General */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            background-color: var(--secondary-color); /* Fondo claro */
            color: var(--primary-color);
            height: 100vh;
        }

        header {
            position: absolute;
            top: 0;
            right: 20px;
            display: flex;
            align-items: center;
            font-size: 1.2em;
            font-weight: bold;
            color: var(--primary-color);
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
            color: var(--primary-color);
            border-bottom: 2px solid var(--highlight-color);
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Contenedor de la tabla */
        .table-container {
            width: 450px;
            height: 100%; /* Ocupa toda la altura de la pantalla */
            border: 1px solid var(--light-border);
            padding: 20px;
            background-color: #fff;
            margin-right: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px var(--box-shadow);
            overflow-y: auto; /* Scroll vertical solo para esta sección */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid var(--light-border);
        }

        th {
            background-color: #f1f1f1; /* Fondo claro para encabezados */
            color: var(--primary-color);
            font-weight: bold;
        }

        tr:hover {
            background-color: #f9f9f9; /* Fondo sutil al pasar el cursor */
        }

        /* Contenedor del formulario */
        .form-container {
            flex: 1; /* Ocupa el espacio restante */
            padding: 20px;
            background-color: #fff;
            border-left: 1px solid var(--light-border);
            border-radius: 8px;
            box-shadow: 0 4px 6px var(--box-shadow);
        }

        .messages-box {
            height: 300px; /* Altura fija con scroll */
            border: 1px solid var(--light-border);
            padding: 10px;
            overflow-y: auto; /* Scroll vertical */
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px var(--box-shadow);
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid var(--light-border);
            border-radius: 8px;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        textarea:focus {
            outline: none;
            border-color: var(--highlight-color);
            box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
        }

        button {
            width: 150px;
            padding: 10px;
            background-color: var(--success-color); /* Verde */
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #218838; /* Verde más oscuro */
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.95);
        }

        /* Mensajes */
        .rec {
            margin: 5px 0;
            padding: 10px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 4px var(--box-shadow);
            animation: fadeInLeft 0.5s ease;
        }

        .emi {
            margin: 5px 0;
            padding: 10px;
            background-color: lightgreen;
            border-radius: 6px;
            box-shadow: 0 2px 4px var(--box-shadow);
            animation: fadeInRight 0.5s ease;
        }

        /* Animaciones */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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
                <th>Botón</th>
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
