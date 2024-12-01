<?php
    require '../Model/conec.php';
    $id=isset($_POST['id']) ? $_POST['id'] : "";
    $result;
    $result2;
    $sql=$conn->prepare("select * from publicacion where id = ?");
    $sql->bind_param('s',$id);
    if($sql->execute())
    {
        $result=$sql->get_result();
        $result=$result->fetch_assoc();
    }

    $usuario_id=$result['usuario_id'];

    $sql2=$conn->prepare("select * from usuarios where id = ?");
    $sql2->bind_param('s',$usuario_id);
    if($sql2->execute())
    {
        $result2=$sql2->get_result();
        $result2=$result2->fetch_assoc();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetMatch - Publicación</title>
    <style>
        /* Variables de color */
        :root {
            --primary-color: #333; /* Gris oscuro */
            --secondary-color: #f9f9f9; /* Fondo claro */
            --highlight-color: #ff6f61; /* Naranja */
            --text-color: #555; /* Texto gris */
            --shadow-color: rgba(0, 0, 0, 0.1);
            --success-color: #28a745; /* Verde */
            --secondary-button-color: #6c757d; /* Gris oscuro botones secundarios */
        }

        /* Estilo general */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: var(--secondary-color);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: var(--primary-color);
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .main-container {
            flex: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px var(--shadow-color);
            position: relative;
        }

        .user-info img {
            background-color: var(--highlight-color);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 36px;
            margin-right: 20px;
        }

        .user-info h2 {
            margin: 0;
            font-size: 24px;
            color: var(--primary-color);
        }

        .user-info button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--secondary-button-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .user-info button:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }

        .description, .animal-details, .image-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .description p, .animal-details div {
            font-size: 18px;
            color: var(--text-color);
        }

        .animal-details {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .animal-details span {
            color: var(--highlight-color);
        }

        .image-container img {
            max-width: 100%;
            border-radius: 8px;
        }

        .buttons {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 20px;
        }

        .buttons button {
            background-color: var(--success-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .buttons button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .buttons .secondary {
            background-color: var(--secondary-button-color);
        }

        .buttons .secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <div class="header">PetMatch</div>

    <div class="main-container">
        <!-- User Info -->
        <div class="user-info">
            <?php
            if (isset($result['foto'])) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($result2['foto']) . '" alt="User Icon">';
            } else {
                echo '<p>No hay imagen disponible.</p>';
            }
            ?>
            <h2>Publicación de <?php echo $result2['name_user']; ?></h2>
            <button class="secondary" onclick="rem()">Regresar</button>
        </div>

        <!-- Description -->
        <div class="description">
            <h3>Descripción:</h3>
            <p><?php echo $result['descripcion']; ?></p>
        </div>

        <!-- Animal Details -->
        <div class="animal-details">
            <div>Clase de animal: <span><?php echo $result['raza']; ?></span></div>
            <div>Edad: <span><?php echo $result['edad']; ?> años</span></div>
        </div>

        <!-- Animal Image -->
        <div class="image-container">
            <h3>Imagen del animal:</h3>
            <?php
            if (isset($result['foto'])) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($result['foto']) . '" alt="Imagen del animal">';
            } else {
                echo '<p>No hay imagen disponible.</p>';
            }
            ?>
        </div>

        <!-- Buttons -->
        <form action="mensajes.php" method="post">
            <div class="buttons">
                <button type="submit" name="idm" value="<?php echo $result2['id'] ?>">Enviar Mensaje</button>
            </div>
        </form>
    </div>

    <script src="renviar.js"></script>

</body>
</html>
