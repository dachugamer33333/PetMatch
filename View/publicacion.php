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
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #000;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
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
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .user-info img {
            background-color: #007bff;
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
            color: #333;
        }

        .user-info button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .user-info button:hover {
            background-color: #5a6268;
        }

        .description {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .description p {
            font-size: 18px;
            color: #555;
        }

        .animal-details {
            display: flex;
            justify-content: space-between;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 18px;
            font-weight: bold;
        }

        .animal-details span {
            color: #007bff;
        }

        .image-container {
            text-align: center;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .buttons button:hover {
            background-color: #218838;
        }

        .buttons .secondary {
            background-color: #6c757d;
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
    </div>
    </form>
    <script src="renviar.js"></script>

</body>
</html>
